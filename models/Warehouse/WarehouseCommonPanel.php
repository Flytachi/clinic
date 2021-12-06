<?php

use Mixin\HellCrud;
use Mixin\Model;

class WarehouseCommonPanel extends Model
{
    public $table = 'warehouse_common';
    public $_name = 'warehouse_item_names';
    public $_suppliers = 'warehouse_item_suppliers';
    public $_applications = 'warehouse_applications';
    public $_manufacturers = 'warehouse_item_manufacturers';
    public $i = 0;

    public function get_or_404(int $pk)
    {
        global $db;
        if ( isset($_GET) and $_GET['id'] == 1 and isset($_POST) ) {
            $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->set_post($_POST);
            unset($_POST);
            if ( isset($this->post['search']) and $this->post['search'] ) {
                if($_GET['form'] == "form") $_GET['form'] = "table";
                $this->{$_GET['form']}();

            }else {
                $this->empty_result();
            }
        }elseif (isset($_GET) and $_GET['id'] == 2 and isset($_POST)) {
            $this->ajax_control($_POST);
        }

    }

    public function table()
    {
        global $db, $classes, $session;
        $search = HellCrud::clean($this->post['search']);
        foreach ($db->query("SELECT DISTINCT wc.item_name_id, win.name FROM $this->table wc LEFT JOIN $this->_name win ON (win.id=wc.item_name_id) WHERE wc.branch_id = {$this->post['branch_id']} AND wc.item_die_date > CURRENT_DATE() AND LOWER(win.name) LIKE LOWER('%$search%')") as $row){
            $this->i++;
            ?>
            <tr id="Item_<?= $this->i ?>">

                <!-- Name -->
                <td>
                    <span id="name_input_<?= $this->i ?>"><?= $row->name ?></span>
                    <input type="hidden" id="name_id_input_<?= $this->i ?>" value="<?= $row->item_name_id ?>">
                </td>

                <!-- Manufacturer -->
                <td>
                    <select id="manufacturer_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> manufacturers" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <option value="" >Производитель будет выбран автоматически</option>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.branch_id = {$this->post['branch_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date, wc.item_price") as $manufacturer): ?>
                            <option value="<?= $manufacturer->id ?>" ><?= $manufacturer->manufacturer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Max qty -->
                <td class="text-center">
                    <span id="max_qty_input_<?= $this->i ?>">
                        <?php
                        $max_qty = $applications = 0;
                        $max_qty += $db->query("SELECT SUM(item_qty) FROM $this->table WHERE branch_id = {$this->post['branch_id']} AND item_die_date > CURRENT_DATE() AND item_name_id = $row->item_name_id")->fetchColumn();
                        $applications += $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE branch_id = {$this->post['branch_id']} AND item_name_id = $row->item_name_id AND status IN(1,2)")->fetchColumn();
                        echo $max_qty - $applications;
                        ?>
                    </span>
                </td>

                <!-- Qty -->
                <td style="width:70px;">
                    <input type="number" id="qty_input_<?= $this->i ?>" class="form-control counts" value="1" min="1" max="<?= $max_qty ?>">
                </td>

                <!-- Buttons -->
                <td>
                    <button onclick="SendProduct(this, <?= $this->i ?>)" type="button" class="btn btn-sm btn-outline bg-teal border-teal text-teal btn-icon rounded-round legitRipple">
                        <!-- <i class="icon-plus2"></i> -->
                        <?php if($this->post['status'] == 2): ?>
                            <i class="icon-checkmark-circle"></i>
                        <?php else: ?>
                            <i class="icon-radio-unchecked"></i>
                        <?php endif; ?>
                    </button>
                </td>

            </tr>
            <?php
        }

        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
            });

            function SendProduct(btn, index) {
                btn.disabled = true;
                $.ajax({
                    type: "POST",
                    url: "<?= add_url() ?>",
                    data: { 
                        model: "WarehouseApplication",
                        branch_id: <?= $this->post['branch_id'] ?>,
                        warehouse_id: <?= $this->post['warehouse_id'] ?>,
                        responsible_id: <?= $session->session_id ?>,
                        item_name_id: document.querySelector('#name_id_input_'+index).value,
                        item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_qty: document.querySelector('#qty_input_'+index).value,
                        status: <?= $this->post['status'] ?>,
                    },
                    success: function (data) {

                        if (data == "success") {
                            
                            new Noty({
                                text: "Успешно сохранено!",
                                type: "success",
                            }).show();

                            $(`#Item_${index}`).css("background-color", "rgb(70, 200, 150)");
                            $(`#Item_${index}`).css("color", "black");
                            $(`#Item_${index}`).fadeOut(900, function() {
                                $(this).remove();
                            });
                            $("#search_input").keyup();

                        } else {

                            new Noty({
                                text: data,
                                type: "error",
                            }).show();
                            btn.disabled = false;

                        }
                    },
                });
            }

            $(".manufacturers").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: {
                        branch_id: <?= $this->post['branch_id'] ?>,
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        document.querySelector('#max_qty_input_'+index).innerHTML = data.max_qty;
                    },
                });
            });

        </script>
        <?php
    }

    public function change_table()
    {
        global $db, $classes, $session;
        $search = HellCrud::clean($this->post['search']);
        /*
        foreach ($db->query("SELECT DISTINCT wc.item_name_id, win.name FROM $this->table wc LEFT JOIN $this->_name win ON (win.id=wc.item_name_id) WHERE wc.item_die_date > CURRENT_DATE() AND LOWER(win.name) LIKE LOWER('%$search%')") as $row){
            $this->i++;
            ?>
            <tr id="Item_<?= $this->i ?>">

                <!-- Name -->
                <td>
                    <span id="name_input_<?= $this->i ?>"><?= $row->name ?></span>
                    <input type="hidden" id="name_id_input_<?= $this->i ?>" value="<?= $row->item_name_id ?>">
                </td>

                <!-- Manufacturer -->
                <td>
                    <select id="manufacturer_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> manufacturers" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <option value="" >Производитель будет выбран автоматически</option>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date, wc.item_price") as $manufacturer): ?>
                            <option value="<?= $manufacturer->id ?>" ><?= $manufacturer->manufacturer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Supplier -->
                <td>
                    <select id="supplier_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> suppliers" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <option value="" >Поставщик будет выбран автоматически</option>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.supplier FROM $this->table wc LEFT JOIN $this->_suppliers wis ON (wis.id=wc.item_supplier_id) WHERE wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date, wc.item_price") as $supplier): ?>
                            <option value="<?= $supplier->id ?>" ><?= $supplier->supplier ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Max qty -->
                <td class="text-center">
                    <span id="max_qty_input_<?= $this->i ?>">
                        <?php
                        $max_qty = $applications = 0;
                        $max_qty += $db->query("SELECT SUM(item_qty) FROM $this->table WHERE item_die_date > CURRENT_DATE() AND item_name_id = $row->item_name_id")->fetchColumn();
                        $applications += $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE item_name_id = $row->item_name_id AND IN(1,2)")->fetchColumn();
                        echo $max_qty - $applications;
                        ?>
                    </span>
                </td>

                <!-- Qty -->
                <td style="width:70px;">
                    <input type="number" id="qty_input_<?= $this->i ?>" class="form-control counts" value="1" min="1" max="<?= $max_qty ?>">
                </td>

                <!-- Buttons -->
                <td>
                    <button onclick="SelectProduct(this, <?= $this->i ?>)" type="button" class="btn btn-sm btn-outline bg-teal border-teal text-teal btn-icon rounded-round legitRipple">
                        <i class="icon-plus2"></i>
                    </button>
                </td>

            </tr>
            <?php
        }
        */
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
            });

            function SelectProduct(btn, index) {
                btn.disabled = true;
                var data = {
                    item_name: document.querySelector('#name_input_'+index).innerHTML,
                    item_name_id: document.querySelector('#name_id_input_'+index).value,
                    item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                    item_supplier_id: document.querySelector('#supplier_id_input_'+index).value,
                    item_qty: document.querySelector('#qty_input_'+index).value,
                };

                AddPreparat(data);

                $(`#Item_${index}`).css("background-color", "rgb(70, 200, 150)");
                $(`#Item_${index}`).css("color", "black");
                $(`#Item_${index}`).fadeOut(900, function() {
                    $(this).remove();
                });
            }

            $(".manufacturers").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: { 
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        var options = `<option value="" >Поставщик будет выбран автоматически</option>`;

                        for (let i = 0; i < data.supplier.length; i++) {
                            var element = data.supplier[i];
                            options += `<option value="${element.id}" >${element.supplier}</option>`;
                        }
                        document.querySelector('#supplier_id_input_'+index).innerHTML = options;
                        document.querySelector('#max_qty_input_'+index).innerHTML = data.max_qty;

                    },
                });
            });

            $(".suppliers").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: { 
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        supplier_id: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        document.querySelector('#max_qty_input_'+index).innerHTML = data.max_qty;
                    },
                });
            });

        </script>
        <?php
    }

    public function ajax_control(array $data)
    {
        global $db;
        $m = ( isset($data['manufacturer_id']) and $data['manufacturer_id'] ) ? " AND wc.item_manufacturer_id = ".$data['manufacturer_id'] : null;
        $qty_max = $db->query("SELECT SUM(wc.item_qty) FROM $this->table wc WHERE wc.branch_id = {$data['branch_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m")->fetchColumn(); 
        $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM $this->_applications wc WHERE wc.branch_id = {$data['branch_id']} AND  wc.item_name_id = {$data['item_name_id']} AND wc.status IN(1,2) $m")->fetchColumn();
        $qty = $qty_max - $qty_applications;
        echo json_encode(array('max_qty' => $qty));
    }

    public function empty_result()
    {
        ?>
        <tr class="table-secondary">
            <th class="text-center" colspan="6">Нет данных</th>
        </tr>
        <?php
    }
}
        
?>