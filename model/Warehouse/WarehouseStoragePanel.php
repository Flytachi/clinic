<?php

use Mixin\HellCrud;
use Mixin\Model;

class WarehouseStoragePanel extends Model
{
    public $table = 'warehouse_storage';
    public $_name = 'warehouse_item_names';
    public $_suppliers = 'warehouse_item_suppliers';
    public $_manufacturers = 'warehouse_item_manufacturers';
    public $_applications = 'warehouse_storage_applications';
    public $_event_applications = 'visit_bypass_event_applications';
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
                $this->select_items();
            }
        }elseif (isset($_GET) and $_GET['id'] == 2 and isset($_POST)) {
            $this->ajax_control($_POST);
        }
        // elseif(isset($_GET) and $_GET['id'] == 3 and isset($_POST)){
        //     $this->transaction((object) $_POST);
        // }

    }

    public function select_items()
    {
        global $db, $classes;
        $search = HellCrud::clean($this->post['search']);
        $ware_pk = $this->post['warehouse_id_from'];

        foreach ($db->query("SELECT DISTINCT wc.item_name_id, win.name FROM $this->table wc LEFT JOIN $this->_name win ON (win.id=wc.item_name_id) WHERE wc.warehouse_id = $ware_pk AND wc.item_die_date > CURRENT_DATE() AND LOWER(win.name) LIKE LOWER('%$search%')") as $row){
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
                        <?php if($this->post['default']): ?>
                            <option value="" >Производитель будет выбран автоматически</option>
                        <?php endif; ?>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.warehouse_id = $ware_pk AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wis.manufacturer ASC") as $manufacturer): ?>
                            <?php // if(empty($the_manufacturer)) $the_manufacturer = $manufacturer->id; ?>
                            <option value="<?= $manufacturer->id ?>" ><?= $manufacturer->manufacturer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Cost -->
                <td>
                    <select id="price_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> costs" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                        <?php if($this->post['default']): ?>
                            <option value="" >Стоимость будет выбрана автоматически</option>
                        <?php endif; ?>
                        <?php foreach ($db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.warehouse_id = $ware_pk AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_price ASC") as $price): ?>
                            <?php // if(empty($the_cost)) $the_cost = $price->item_price; ?>
                            <option value="<?= $price->item_price ?>" ><?= number_format($price->item_price) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <!-- Max qty -->
                <td class="text-center">
                    <span id="max_qty_input_<?= $this->i ?>">
                        <?php
                        $the_where = "item_name_id = $row->item_name_id";
                        $max_qty = $db->query("SELECT SUM(item_qty) FROM $this->table WHERE warehouse_id = $ware_pk AND item_die_date > CURRENT_DATE() AND $the_where")->fetchColumn();
                        $applications = $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE status IN (1,2) AND warehouse_id_from = $ware_pk AND $the_where")->fetchColumn();
                        $applications += $db->query("SELECT SUM(item_qty) FROM $this->_event_applications WHERE warehouse_id = $ware_pk AND $the_where")->fetchColumn();
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
                    <button onclick="__<?= __CLASS__ ?>__select(this, <?= $this->i ?>)" type="button" class="btn btn-sm btn-outline bg-teal border-teal text-teal btn-icon rounded-round legitRipple">
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

            $(".manufacturers").change(function() {
                var index = this.dataset.i;
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(2, __CLASS__) ?>",
                    data: { 
                        warehouse_id: <?= $ware_pk ?>,
                        item_name_id: this.dataset.item_name,
                        manufacturer_id: this.value,
                    },
                    success: function (result) {
                        var data = JSON.parse(result);
                        var options = `
                        <?php if($this->post['default']): ?>
                            <option value="">Стоимость будет выбрана автоматически</option>
                        <?php endif; ?>
                        `;

                        for (let i = 0; i < data.price.length; i++) {
                            var element = data.price[i];
                            options += `<option value="${element.item_price}">${number_format(element.item_price)}</option>`;
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
                        warehouse_id: <?= $ware_pk ?>,
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

        $price_result = $db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s ORDER BY wc.item_price ASC")->fetchAll();
        $qty_max = $db->query("SELECT SUM(wc.item_qty) FROM $this->table wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn(); 
        $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM $this->_applications wc WHERE wc.status IN (1,2) AND wc.warehouse_id_from = {$data['warehouse_id']} AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn();
        $qty_applications += $db->query("SELECT SUM(wc.item_qty) FROM $this->_event_applications wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn();
        $qty = $qty_max - $qty_applications;
        echo json_encode(array('price' => $price_result, 'max_qty' => $qty));
    }
    
}

?>