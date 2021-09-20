<?php

class WarehouseApplicationsPanel extends Model
{
    public $table = 'warehouses';
    public $_item_names = 'warehouse_item_names';
    public $_applications = 'warehouse_applications';
    public $_item_suppliers = 'warehouse_item_suppliers';
    public $_item_manufacturers = 'warehouse_item_manufacturers';

    public function get_or_404(int $pk)
    {
        /**
         * Данные о записи!
         * если не найдёт запись то выдаст 404 
         */
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('404');
            exit;
        }

    }

    public function form($pk = null)
    {
        global $db, $classes;
        ?>
        <div class="<?= $classes['card'] ?>">

            <div class="<?= $classes['card-header'] ?>">
                <h5 class="card-title">Заявки</h5>
            </div>

            <div class="card-body">

                <?php
                $tb = new Table($db, $this->_applications);
                $search = $tb->get_serch();
                $tb->set_data('DISTINCT  item_name_id, item_manufacturer_id, item_supplier_id');
                $tb->where("warehouse_id = $pk AND status = 2")->order_by("item_manufacturer_id DESC, item_supplier_id DESC")->set_limit();
                ?>
                
                <div class="table-responsive card">
                    <table class="table table-hover">
                        <thead>
                            <tr class="<?= $classes['table-thead'] ?>">
                                <th style="width: 50px">#</th>
                                <th>Наименование</th>
                                <th style="width:250px">Производитель</th>
                                <th style="width:250px">Поставщик</th>
                                <th class="text-right" style="width:100px">Кол-во</th>
                                <th class="text-right" style="width: 100px">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tb->get_table(1) as $row): ?>
                                <tr>
                                    <td><?= $row->count ?></td>
                                    <td><?= $db->query("SELECT name FROM $this->_item_names WHERE id = $row->item_name_id")->fetchColumn() ?></td>
                                    <td><?= ($row->item_manufacturer_id) ? $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?></td>
                                    <td><?= ($row->item_supplier_id) ? $db->query("SELECT supplier FROM $this->_item_suppliers WHERE id = $row->item_supplier_id")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?></td>
                                    <td class="text-right"> 
                                        <?php
                                        $m = ($row->item_manufacturer_id) ? "AND item_manufacturer_id = $row->item_manufacturer_id" : null;
                                        $s = ($row->item_supplier_id) ? "AND item_supplier_id = $row->item_supplier_id" : null;
                                        echo $db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE warehouse_id = $pk AND status = 2 AND item_name_id = $row->item_name_id $m $s")->fetchColumn();
                                        ?>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

}

        
?>