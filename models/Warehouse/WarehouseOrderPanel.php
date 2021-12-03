<?php

use Warframe\Model;

class WarehouseOrderPanel extends Model
{
    public $table = 'warehouse_orders';
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
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.branch_id = {$this->post['branch_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ") as $manufacturer): ?>
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
                        $applications += $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE branch_id = {$this->post['branch_id']} AND item_name_id = $row->item_name_id")->fetchColumn();
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

    public function ajax_control(array $data)
    {
        global $db;
        $m = ( isset($data['manufacturer_id']) and $data['manufacturer_id'] ) ? " AND wc.item_manufacturer_id = ".$data['manufacturer_id'] : null;

        $qty_max = $db->query("SELECT SUM(wc.item_qty) FROM $this->table wc WHERE wc.branch_id = {$data['branch_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m")->fetchColumn(); 
        $qty_applications = $db->query("SELECT SUM(wc.item_qty) FROM $this->_applications wc WHERE wc.branch_id = {$data['branch_id']} AND wc.item_name_id = {$data['item_name_id']} $m")->fetchColumn();
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