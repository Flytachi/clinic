<?php

class VisitBypassEventsPanel extends Model
{
    public $table = 'visit_bypass_events';
    public $_visit_bypass = 'visit_bypass';
    public $_warehouse_custom = 'warehouse_custom';
    public $_bypass_transactions = 'visit_bypass_transactions';
    public $_event_applications = 'visit_bypass_event_applications';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            $this->bypass = $db->query("SELECT * FROM $this->_visit_bypass WHERE id = {$this->post['visit_bypass_id']}")->fetch();
            
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
            exit;
        }

    }

    public function card($pk = null)
    {
        global $classes, $db, $methods, $session;

        $today = date('Ymd');
        $start = date_f($this->post['event_start'], 'Ymd');
        if ($this->post['event_end']) $end = date_f($this->post['event_end'], 'Ymd');
        if (permission(5)) {

            if ($this->post['event_completed']) $color = "success";
            else{
                if ( $today <= $start ){
                    if ($this->post['responsible_id'] == $session->session_id) $color = "primary";
                    else $color = "indigo";
                }
                else $color = "secondary";
            }

        }else{
            
            if ($this->post['event_completed']) $color = "success";
            else {
                if ( (isset($end) and $start <= $today && $today <= $end) || ( $start == $today ) ) $color = "danger";
                else $color = "secondary";
            }

        }
        ?>
        <div class="modal-header bg-<?= $color ?>">
            <h6 class="modal-title">Назначение <?= date_f($this->post['event_start']) ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <h3 class="text-center"><?= $this->post['event_title'] ?></h3>
            <div class="card card-body border-top-1 border-top-<?= $color ?>">


                <div class="list-feed list-feed-rhombus list-feed-solid row">

                    <div class="col-6">
                        <div class="list-feed-item border-<?= $color ?>">
                            <strong>Препараты:</strong>
                            <?php foreach (json_decode($this->bypass['items']) as $item): ?>
                                <?php if ( isset($item->item_name_id) and $item->item_name_id ): ?>
                                    <li><span class="text-primary"><?= $item->item_qty ?> шт.</span> <?= (new Table($db, "warehouse_item_names"))->where("id = $item->item_name_id")->get_row()->name ?> <span class="text-muted">(склад <?= (new Table($db, "warehouses"))->where("id = $item->warehouse_id")->get_row()->name ?>)</span></li>
                                <?php else: ?>
                                    <li><span class="text-primary"><?= $item->item_qty ?> шт.</span> <?= $item->item_name ?> <span class="text-warning">(Сторонний)</span></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="list-feed-item border-<?= $color ?>">
                            <strong>Метод: </strong><?= ($this->bypass['method']) ? $methods[$this->bypass['method']] : '<span class="text-muted">Нет данных</span>' ?>
                            <br>
                            <strong>Описание: </strong>
                            <?= ($this->bypass['description']) ? "<br>".preg_replace("#\r?\n#", "<br />", $this->bypass['description']) : '<span class="text-muted">Нет данных</span>' ?>
                        </div>
                    </div>

                    <div class="col-6">

                        <div class="list-feed-item border-<?= $color ?>">
                            <strong>Статус: </strong>
                            <?php if($db->query("SELECT id FROM visit_bypass_event_applications WHERE visit_bypass_event_id = $pk")->rowCount()): ?>
                                <span class="text-primary">Есть забронированные препараты.</span>
                                <?php if($color == "secondary"): ?>
                                    <br><a onclick="CalendarEventApplicationDelete('<?= del_url($pk, 'VisitBypassEventsApplication') ?>')" class="text-danger">Отменить бронь</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">Нет забронированных препаратов.</span>
                            <?php endif; ?>
                        </div>

                        <div class="list-feed-item border-<?= $color ?>">
                            <strong>Время: </strong>
                            <?php
                            if ($this->post['event_end']) echo "от ".date_f($this->post['event_start'], "H:i")." до ".date_f($this->post['event_end'], "H:i");
                            else echo date_f($this->post['event_start'], "H:i");
                            ?>
                            <?php if($this->post['event_completed']): ?>
                                <br><strong>Выполнено:</strong> <?= date_f($this->post['completed_date'], 1) ?>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>

                <div class="text-right">
                    <strong>Назначил:</strong> <?= get_full_name($this->post['responsible_id']) ?>
                    <?php if($this->post['event_completed']): ?>
                        <br><strong>Исполнитель:</strong> <?= get_full_name($this->post['completed_responsible_id']) ?>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <?php if(permission(5)): ?>
            <?php if($session->session_id == $this->post['responsible_id'] and $color != "secondary" and !$this->post['event_completed']): ?>
                <div class="modal-footer">
                    <button onclick="CalendarEventDelete(<?= $pk ?>, '<?= $_GET['calendar_ID'] ?>')" class="btn btn-outline-danger btn-sm legitRipple">Отменить</button>
                </div>
            <?php endif; ?>
        <?php elseif(permission(7)): ?>
            <div class="modal-footer">
                <!-- <button onclick="CalendarEventFailure(<?= $pk ?>, '<?= $_GET['calendar_ID'] ?>')" class="btn btn-outline-danger btn-sm legitRipple">Отменить</button> -->
                <?php if($color == "danger"): ?>
                    <button onclick="CalendarEventComplete(<?= $pk ?>, '<?= $_GET['calendar_ID'] ?>')" class="btn btn-outline-success btn-sm legitRipple">Выполнить</button>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
    }

    public function clean()
    {
        global $session;
        $this->post['completed_responsible_id'] = $session->session_id;
        $this->post['completed_date'] = date("Y-m-d H:i:s");
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function update()
    {
        global $db;
        if($this->clean()){
            $this->pk = $this->post['id'];
            unset($this->post['id']);
            $db->beginTransaction();

            // Applications
            $applications = (new Table($db, $this->_event_applications))->where("visit_bypass_event_id = $this->pk");
            if ($data = $applications->get_row()) {

                $this->visit = $data->visit_id;
                $this->user = $data->user_id;
                foreach ($applications->get_table() as $app) {
                    $this->where = "item_die_date > CURRENT_DATE() AND item_name_id = $app->item_name_id AND item_manufacturer_id = $app->item_manufacturer_id AND item_supplier_id = $app->item_supplier_id";
                    $max_qty = $db->query("SELECT SUM(item_qty) FROM $this->_warehouse_custom WHERE $this->where")->fetchColumn();
                    if ($app->item_qty <= $max_qty) {
                        // Взятие со склада
                        $this->transaction($app);

                    }else {
                        echo "доработать";
                        $this->stop();
                    }
                }
                // $this->stop();
            }

            $object = Mixin\update($this->table, $this->post, $this->pk);
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
            }

            $db->commit();
            $this->success("success");
        }
    }

    public function transaction($app)
    {
        global $db, $session;
        $item = $db->query("SELECT * FROM $this->_warehouse_custom WHERE $this->where ORDER BY item_die_date, item_price")->fetch();
        $qty_sold = $item['item_qty'] - $app->item_qty;
        if ($qty_sold > 0) {
            // Update
            Mixin\update($this->_warehouse_custom, array('item_qty' => $qty_sold), $item['id']);
            Mixin\insert($this->_bypass_transactions, array(
                'visit_id' => $this->visit,
                'visit_bypass_event_id' => $this->pk,
                'responsible_id' => $session->session_id,
                'user_id' => $this->user,
                'item_name' => $db->query("SELECT name FROM warehouse_item_names WHERE id = $app->item_name_id")->fetchColumn(),
                'item_manufacturer' => $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $app->item_manufacturer_id")->fetchColumn(),
                'item_supplier' => $db->query("SELECT supplier FROM warehouse_item_suppliers WHERE id = $app->item_supplier_id")->fetchColumn(),
                'item_qty' => $app->item_qty,
                'item_cost' => $item['item_price'],
                'price' => $item['item_price'] * $app->item_qty,
            ));

        }elseif ($qty_sold == 0) {
            // Delete
            Mixin\delete($this->_warehouse_custom, $item['id']);
            Mixin\insert($this->_bypass_transactions, array(
                'visit_id' => $this->visit,
                'visit_bypass_event_id' => $this->pk,
                'user_id' => $this->user,
                'item_name' => $db->query("SELECT name FROM warehouse_item_names WHERE id = $app->item_name_id")->fetchColumn(),
                'item_manufacturer' => $db->query("SELECT manufacturer FROM warehouse_item_manufacturers WHERE id = $app->item_manufacturer_id")->fetchColumn(),
                'item_supplier' => $db->query("SELECT supplier FROM warehouse_item_suppliers WHERE id = $app->item_supplier_id")->fetchColumn(),
                'item_qty' => $app->item_qty,
                'item_cost' => $item['item_price'],
                'price' => $item['item_price'] * $app->item_qty,
            ));

        }else{
            // Convert
            dd("convert");
            exit;

        }
        // Удаляем бронь
        Mixin\delete($this->_event_applications, $app->id);
        
    }

    public function success($pk = null)
    {
        echo $pk;
    }

    public function error($message)
    {
        echo $message;
    }
    
}
        
?>