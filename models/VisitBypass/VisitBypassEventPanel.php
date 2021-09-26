<?php

class VisitBypassEventsPanel extends Model
{
    public $table = 'visit_bypass_events';
    public $_visit_bypass = 'visit_bypass';
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
            
            if ( (isset($end) and $start <= $today && $today <= $end) || ( $start == $today ) ) $color = "danger";
            else $color = "secondary";

        }
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Назначение <?= date_f($this->post['event_start']) ?></h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <h3 class="text-center"><?= $this->post['event_title'] ?></h3>
            <div class="card card-body border-top-1 border-top-<?= $color ?>">

                <div class="list-feed list-feed-rhombus list-feed-solid">
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
                    </div>

                    <div class="list-feed-item border-<?= $color ?>">
                        <strong>Описание: </strong>
                        <?= ($this->bypass['description']) ? "<br>".preg_replace("#\r?\n#", "<br />", $this->bypass['description']) : '<span class="text-muted">Нет данных</span>' ?>
                    </div>

                    <div class="list-feed-item border-<?= $color ?>">
                        <strong>Время: </strong>
                        <?php
                        if ($this->post['event_end']) echo "от ".date_f($this->post['event_start'], "H:i")." до ".date_f($this->post['event_end'], "H:i");
                        else echo date_f($this->post['event_start'], "H:i");
                        ?>
                    </div>

                </div>

                <div class="text-right">
                    <strong>Назначил:</strong> <?= get_full_name($this->post['responsible_id']) ?>
                </div>

            </div>

        </div>

        <?php if($session->session_id == $this->post['responsible_id'] and $color != "secondary"): ?>
            <div class="modal-footer">
                <button onclick="CalendarEventDelete(<?= $pk ?>, '<?= $_GET['calendar_ID'] ?>')" class="btn btn-outline-danger btn-sm legitRipple">Отменить</button>
            </div>
        <?php endif; ?>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    // public function update()
    // {
    //     if($this->clean()){
    //         $pk = $this->post['id'];
    //         $this->post['last_update'] = date("Y-m-d H:i:s");
    //         unset($this->post['id']);
    //         $object = Mixin\update($this->table, $this->post, $pk);
    //         if (!intval($object)){
    //             $this->error($object);
    //             exit;
    //         }
    //         $this->success("success");
    //     }
    // }

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