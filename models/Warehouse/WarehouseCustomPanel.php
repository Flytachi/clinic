<?php

class WarehouseCustomPanel extends Model
{
    public $table = 'warehouse_custom';
    public $_name = 'warehouse_item_names';
    public $_suppliers = 'warehouse_item_suppliers';
    public $_manufacturers = 'warehouse_item_manufacturers';
    public $_applications = 'visit_bypass_event_applications';
    public $i = 0;
    public $cost = 0;

    public function get_or_404(int $pk)
    {
        global $db;
        if ( isset($_GET) and $_GET['id'] == 1 and isset($_POST) ) {
            $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->set_post($_POST);
            unset($_POST);
            if ( isset($this->post['search']) and $this->post['search'] ) {
                $this->{$_GET['form']}();

            }else {
                $this->empty_result();
            }
        }elseif (isset($_GET) and $_GET['id'] == 2 and isset($_POST)) {
            $this->ajax_control($_POST);
        }

    }

    public function form($pk = null)
    {
        dd($this);
    }

    public function change_table()
    {
        global $db, $classes;
        $search = Mixin\clean($this->post['search']);

        foreach ($db->query("SELECT DISTINCT wc.item_name_id, win.name FROM $this->table wc LEFT JOIN $this->_name win ON (win.id=wc.item_name_id) WHERE wc.warehouse_id = {$this->post['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND LOWER(win.name) LIKE LOWER('%$search%')") as $row){
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
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.warehouse_id = {$this->post['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date ASC, wc.item_price ASC") as $manufacturer): ?>
                            <option value="<?= $manufacturer->id ?>" ><?= $manufacturer->manufacturer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Cost -->
                <td>
                    <select id="price_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> costs" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <option value="" >Стоимость будет выбрана автоматически</option>
                        <?php foreach ($db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.warehouse_id = {$this->post['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date ASC, wc.item_price ASC") as $price): ?>
                            <option value="<?= $price->item_price ?>" ><?= number_format($price->item_price) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Max qty -->
                <td class="text-center">
                    <span id="max_qty_input_<?= $this->i ?>">
                        <?php
                        $max_qty = $applications = 0;
                        $max_qty += $db->query("SELECT SUM(item_qty) FROM $this->table WHERE warehouse_id = {$this->post['warehouse_id']} AND item_die_date > CURRENT_DATE() AND item_name_id = $row->item_name_id")->fetchColumn();
                        $applications += $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE item_name_id = $row->item_name_id")->fetchColumn();
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

        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
            });

            function SelectProduct(btn, index) {
                btn.disabled = true;
                var data = {
                    warehouse_id: <?= $this->post['warehouse_id'] ?>,
                    item_name: document.querySelector('#name_input_'+index).innerHTML,
                    item_name_id: document.querySelector('#name_id_input_'+index).value,
                    item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                    item_price: document.querySelector('#price_id_input_'+index).value,
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
                        warehouse_id: <?= $this->post['warehouse_id'] ?>,
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        var options = `<option value="" >Стоимость будет выбрана автоматически</option>`;

                        for (let i = 0; i < data.price.length; i++) {
                            var element = data.price[i];
                            options += `<option value="${element.item_price}" >${number_format(element.item_price)}</option>`;
                        }
                        document.querySelector('#price_id_input_'+index).innerHTML = options;
                        document.querySelector('#max_qty_input_'+index).innerHTML = data.max_qty;
                    },
                });
            });

            $(".costs").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: { 
                        warehouse_id: <?= $this->post['warehouse_id'] ?>,
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                        item_price: this.value,
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
        $s = ( isset($data['item_price']) and $data['item_price'] ) ? " AND wc.item_price = ".$data['item_price'] : null;

        $price_result = $db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s ORDER BY wc.item_die_date ASC, wc.item_price ASC")->fetchAll();
        $qty_max = $db->query("SELECT SUM(wc.item_qty) FROM $this->table wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn(); 
        $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM $this->_applications wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn();
        $qty = $qty_max - $qty_applications;
        echo json_encode(array('price' => $price_result, 'max_qty' => $qty));
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