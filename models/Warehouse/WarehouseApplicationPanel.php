<?php

class WarehouseApplicationPanel extends Model
{
    public $table = 'warehouses';
    public $_common = 'warehouse_common';
    public $_item_names = 'warehouse_item_names';
    public $_applications = 'warehouse_applications';
    public $_item_suppliers = 'warehouse_item_suppliers';
    public $_item_manufacturers = 'warehouse_item_manufacturers';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk AND is_active IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('cash_permissions_false');
            exit;
        }
    }

    public function form($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <div class="<?= $classes['card'] ?>">

            <div class="<?= $classes['card-header'] ?>">
                <h5 class="card-title">Заявки</h5>
            </div>

            <div class="card-body">

                <?php
                $tb = new Table($db, $this->_applications);
                $tb->set_data('DISTINCT  item_name_id, item_manufacturer_id');
                $tb->where("branch_id = $session->branch AND warehouse_id = $pk AND status = 2")->order_by("item_manufacturer_id DESC");
                ?>
                
                <div class="table-responsive card">
                    <table class="table table-hover">
                        <thead>
                            <tr class="<?= $classes['table-thead'] ?>">
                                <th style="width: 50px">#</th>
                                <th>Наименование</th>
                                <th style="width:250px">Производитель</th>
                                <th class="text-right" style="width:100px">Кол-во</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tb->get_table(1) as $row): ?>
                                <tr onclick="ApplicationShow(<?= $pk ?>, <?= $row->item_name_id ?>, <?= ($row->item_manufacturer_id) ? $row->item_manufacturer_id : '\'\''; ?>)">
                                    <td><?= $row->count ?></td>
                                    <td><?= $db->query("SELECT name FROM $this->_item_names WHERE id = $row->item_name_id")->fetchColumn() ?></td>
                                    <td><?= ($row->item_manufacturer_id) ? $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?></td>
                                    <td class="text-right"> 
                                        <?php
                                        $m = ($row->item_manufacturer_id) ? "AND item_manufacturer_id = $row->item_manufacturer_id" : "AND item_manufacturer_id IS NULL";
                                        echo number_format($db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE branch_id = $session->branch AND warehouse_id = $pk AND status = 2 AND item_name_id = $row->item_name_id $m")->fetchColumn());
                                        ?>
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

    public function application($pk = null)
    {
        global $db, $classes, $session;

        if ($_GET['item_manufacturer_id']) {
            $m_first = "AND item_manufacturer_id = {$_GET['item_manufacturer_id']}";
            $m_second = "AND item_manufacturer_id = {$_GET['item_manufacturer_id']}";
        }else {
            $m_first = "AND item_manufacturer_id IS NULL";
            $m_second = null;
        }

        $tb = new Table($db, $this->_common);
        $tb->where("branch_id = $session->branch AND item_name_id = {$_GET['item_name_id']} $m_second")->order_by("item_die_date ASC");
        if ($products = $tb->get_table()) {
            $indicator = "secondary";
            $indicator_feed = "success";
        }else {
            $indicator = "danger";
            $indicator_feed = "danger";
        }

        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Обработать заявку</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">

            <input type="hidden" name="model" value="WarehouseApplicationCompleted">
            <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
            <input type="hidden" name="warehouse_id" value="<?= $pk ?>">
            
            <div class="modal-body">
    
                <div class="card card-body border-top-1 border-top-<?= $indicator ?>" id="indicator-card">
                    <div class="list-feed list-feed-rhombus list-feed-solid">
                        <div class="list-feed-item border-<?= $indicator_feed ?>">
                            <strong>Препарат: </strong>
                            <span><?= $name = $db->query("SELECT name FROM $this->_item_names WHERE id = {$_GET['item_name_id']}")->fetchColumn() ?></span>
                        </div>
    
                        <div class="list-feed-item border-<?= $indicator_feed ?>">
                            <strong>Данные: </strong><br>
                            Производитель - <?= ($_GET['item_manufacturer_id']) ? $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = {$_GET['item_manufacturer_id']}")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?><br>
                        </div>
    
                        <div class="list-feed-item border-<?= $indicator ?>" id="indicator-feed">
                            <strong>Требуемое кол-во: </strong>
                            <span id="item_qty_required" style="font-size:15px;" class="ml-1">
                                <?= number_format($db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE warehouse_id = $pk AND status = 2 AND item_name_id = {$_GET['item_name_id']} $m_first")->fetchColumn());
                                ?>
                            </span> / <span id="item_qty_count">0</span>
                        </div>

                    </div>
                </div>
    
                <?php if($products): ?>

                    <?php foreach ($db->query("SELECT id FROM $this->_applications WHERE branch_id = $session->branch AND warehouse_id = $pk AND status = 2 AND item_name_id = {$_GET['item_name_id']} $m_first")->fetchAll() as $app): ?>
                        <input type="hidden" name="applications[]" value="<?= $app['id'] ?>">
                    <?php endforeach; ?>

                    <h4 class="text-center"><?= $name ?></h4>
        
                    <div class="table-responsive card">
                        <table class="table table-hover">
                            <thead>
                                <tr class="<?= $classes['table-thead'] ?>">
                                    <th style="width:150px">Срок годности</th>
                                    <th>Производитель</th>
                                    <th class="text-right" style="width:100px">Кол-во</th>
                                    <th class="text-right" style="width:100px">Расход</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $row): ?>
                                    <tr>
                                        <td><?= ($row->item_die_date) ? date_f($row->item_die_date) : '<span class="text-muted">Нет данных</span>' ?></td>
                                        <td><?= ($row->item_manufacturer_id) ? $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?></td>
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
                <input type="submit" name="rejection" value="Отказать" class="btn btn-outline-danger btn-sm legitRipple">
                <button type="submit" id="indicator-btn" class="btn btn-outline-secondary btn-sm legitRipple" disabled>Принять</button>
            </div>

        </form>

        <script  type="text/javascript">

            var qty_required = document.querySelector("#item_qty_required");
            var inputs = document.querySelectorAll(".input_count-qty");
            
            $(".input_count-qty").on("input", function (event) {
                var qty_count = document.querySelector("#item_qty_count");
                var qty = 0;

                if ( Number(event.target.max) >= Number(event.target.value) ) {
                    event.target.className = "form-control text-right input_count-qty";
                    for (let i = 0; i < inputs.length; i++) {
                        qty += Number(inputs[i].value);
                    }

                    if ( Number(qty_required.innerHTML.replace(/,/g, "")) == qty ) {
                        qty_count.className = "text-success";
                        document.querySelector("#indicator-card").className = "card card-body border-top-1 border-top-success";
                        document.querySelector("#indicator-feed").className = "list-feed-item border-success";
                        document.querySelector("#indicator-btn").className = "btn btn-outline-success btn-sm legitRipple";
                        document.querySelector("#indicator-btn").disabled = false;
                    }else if ( Number(qty_required.innerHTML.replace(/,/g, "")) < qty) {
                        qty_count.className = "text-danger";
                        document.querySelector("#indicator-card").className = "card card-body border-top-1 border-top-danger";
                        document.querySelector("#indicator-feed").className = "list-feed-item border-danger";
                        document.querySelector("#indicator-btn").className = "btn btn-outline-secondary btn-sm legitRipple";
                        document.querySelector("#indicator-btn").disabled = true;
                    } else {
                        qty_count.className = "";
                        document.querySelector("#indicator-card").className = "card card-body border-top-1 border-top-secondary";
                        document.querySelector("#indicator-feed").className = "list-feed-item border-secondary";
                        document.querySelector("#indicator-btn").className = "btn btn-outline-secondary btn-sm legitRipple";
                        document.querySelector("#indicator-btn").disabled = true;
                    }
                }else{
                    event.target.className = "form-control text-right input_count-qty text-danger";
                }
                
                qty_count.innerHTML = number_format(qty);

            });

        </script>
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