<?php

class WarehouseCustomPanel extends Model
{
    public $table = 'warehouse_custom';
    public $_name = 'warehouse_item_names';
    public $_suppliers = 'warehouse_item_suppliers';
    public $_manufacturers = 'warehouse_item_manufacturers';
    public $i = 0;
    public $cost = 0;

    public function get_or_404(int $pk)
    {
        global $db;
        if ( isset($_GET) and $_GET['id'] == 1 and isset($_POST) ) {
            $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->post = $_POST;
            unset($_POST);
            if ( isset($this->post['search']) and $this->post['search'] ) {

                $this->table();

            }else {
                $this->empty_result();
            }
        }

    }

    public function table()
    {
        global $db, $classes;

        foreach ($db->query("SELECT DISTINCT item_name_id FROM $this->table WHERE item_die_date > CURRENT_DATE()") as $row){
            $this->result = ""; 
            $this->i++;
            if ( isset($this->post['selected']) and in_array($row->id, array_keys($this->post['selected'])) ) {
                $this->result = "checked";
                $this->cost += ($row->price * $this->post['selected'][$row->id]['count']);
            }

            ?>
            <tr>
                
                <td>
                    <input type="checkbox" name="product[<?= $this->i ?>]" value="<?= $row->id ?>" class="form-input-styled" onchange="tot_sum(this)" <?= $this->result ?>>
                </td>

                <td><?= $db->query("SELECT name FROM $this->_name WHERE id = $row->item_name_id")->fetchColumn() ?></td>

                <td>
                    <select name="supplier_id[<?= $this->i ?>]" id="supplier_id_input_<?= $row->id ?>" class="<?= $classes['form-select'] ?>" data-id="<?= $row->id ?>">
                        <option value="" >Поставщик будет выбран автоматически</option>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.supplier FROM $this->table wc LEFT JOIN $this->_suppliers wis ON (wis.id=wc.item_supplier_id) WHERE wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date, wc.item_price") as $supplier): ?>
                            <option value="<?= $supplier->id ?>" ><?= $supplier->supplier ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <td>
                    <select name="manufacturer_id[<?= $this->i ?>]" id="manufacturer_id_input_<?= $row->id ?>" class="<?= $classes['form-select'] ?>" data-id="<?= $row->id ?>">
                        <option value="" >Производитель будет выбран автоматически</option>
                        <?php foreach ($db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.item_name_id = $row->item_name_id ORDER BY wc.item_die_date, wc.item_price") as $manufacturer): ?>
                            <option value="<?= $manufacturer->id ?>" ><?= $manufacturer->manufacturer ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                

            </tr>
            <?php
        }

        ?>
        <tr class="table-secondary">
            <th class="text-right" colspan="<?= 6-$this->post['cols'] ?>">Итого:</th>
            <th class="text-right" id="total_price"><?= number_format($this->cost) ?></th>
        </tr>
        <?php
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