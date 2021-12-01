<?php

class WarehouseStorageTransactionModel extends Model
{
    public $table = 'warehouse_storage_transactions';
    public $storage = 'warehouse_storage';

    public function form($pk = null)
    {
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Обработать заявку</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">

            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            
            <div class="modal-body">
    
                <div class="card card-body border-top-1 border-top-<?= $indicator ?>" id="indicator-card">
                    <div class="list-feed list-feed-rhombus list-feed-solid">
                        <div class="list-feed-item border-<?= $indicator_feed ?>">
                            <strong>Препарат: </strong>
                            <span><?= $name = $db->query("SELECT name FROM $this->_item_names WHERE id = {$this->post['item_name_id']}")->fetchColumn() ?></span>
                        </div>
    
                        <div class="list-feed-item border-<?= $indicator_feed ?>">
                            <strong>Данные: </strong><br>
                            Производитель - <?= $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = {$this->post['item_manufacturer_id']}")->fetchColumn() ?><br>
                            Цена - <?= number_format($this->post['item_price']) ?><br>
                        </div>
    
                        <div class="list-feed-item border-<?= $indicator ?>" id="indicator-feed">
                            <strong>Требуемое кол-во: </strong>
                            <span id="item_qty_required" style="font-size:15px;" class="ml-1">
                                <?= number_format($db->query("SELECT SUM(item_qty) FROM $this->table WHERE warehouse_id_from = {$this->post['warehouse_id_from']} AND warehouse_id_in = {$this->post['warehouse_id_in']} AND status = 2 AND item_name_id = {$this->post['item_name_id']} AND item_manufacturer_id = {$this->post['item_manufacturer_id']} AND item_price = {$this->post['item_price']}")->fetchColumn());
                                ?>
                            </span> / <span id="item_qty_count">0</span>
                        </div>

                    </div>
                </div>
    
                <?php if($products): ?>

                    <?php foreach ($db->query("SELECT id FROM $this->table WHERE warehouse_id_from = {$this->post['warehouse_id_from']} AND warehouse_id_in = {$this->post['warehouse_id_in']} AND status = 2 AND item_name_id = {$this->post['item_name_id']} AND item_manufacturer_id = {$this->post['item_manufacturer_id']} AND item_price = {$this->post['item_price']}")->fetchAll() as $app): ?>
                        <input type="hidden" name="applications[]" value="<?= $app['id'] ?>">
                    <?php endforeach; ?>

                    <h4 class="text-center"><?= $name ?></h4>
        
                    <div class="table-responsive card">
                        <table class="table table-hover">
                            <thead>
                                <tr class="<?= $classes['table-thead'] ?>">
                                    <th style="width:150px">Срок годности</th>
                                    <th>Производитель</th>
                                    <th>Цена</th>
                                    <th class="text-right" style="width:100px">Кол-во</th>
                                    <th class="text-right" style="width:100px">Расход</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $row): ?>
                                    <tr>
                                        <td><?= ($row->item_die_date) ? date_f($row->item_die_date) : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td><?= ($row->item_manufacturer_id) ? $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td><?= ($row->item_price) ? number_format($this->post['item_price']) : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td class="text-right"><?= number_format($row->item_qty) ?></td>
                                        <td>
                                            <input type="number" class="form-control text-right input_count-qty" name="item[<?= $row->id ?>]" min="0" max="<?= $row->item_qty ?>" style="border-width: 0px 0; padding: 0.2rem 0;">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
    
            </div>
    
            <div class="modal-footer">
                <button type="submit" id="indicator-btn" class="btn btn-outline-secondary btn-sm legitRipple" disabled>Принять</button>
                <input type="submit" name="rejection" value="Отказать" class="btn btn-outline-danger btn-sm legitRipple">
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>