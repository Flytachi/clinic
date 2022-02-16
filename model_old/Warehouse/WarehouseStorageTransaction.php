<?php

use Mixin\ModelOld;

class WarehouseStorageTransactionModel extends ModelOld
{
    public $table = 'warehouse_storage_transactions';
    public $_item_manufacturers = 'warehouse_item_manufacturers';
    public $_item_names = 'warehouse_item_names';
    public $storage = 'warehouse_storage';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->storage WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        $price = ($object['item_price']) ? "AND item_price = {$object['item_price']}" : null;
        $object['item_qty'] -= $db->query("SELECT SUM(item_qty) FROM warehouse_storage_applications WHERE status IN(1,2) AND warehouse_id_from = {$object['warehouse_id']} AND item_name_id = {$object['item_name_id']} AND item_manufacturer_id = {$object['item_manufacturer_id']} $price")->fetchColumn();
		$object['item_qty'] -= $db->query("SELECT SUM(item_qty) FROM visit_bypass_event_applications WHERE warehouse_id = {$object['warehouse_id']} AND item_name_id = {$object['item_name_id']} AND item_manufacturer_id = {$object['item_name_id']} $price")->fetchColumn();
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
            exit;
        }
    }

    public function form($pk = null)
    {
        global $classes, $db, $session;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Списать препарат</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">

            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="item_id" value="<?= $this->value('id') ?>">
            <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">
            
            <div class="modal-body">

                <div class="card card-body border-top-1 border-top-danger">
                    <div class="list-feed list-feed-rhombus list-feed-solid">
                        <div class="list-feed-item border-danger">
                            <strong>Препарат: </strong>
                            <span><?= $db->query("SELECT name FROM $this->_item_names WHERE id = {$this->post['item_name_id']}")->fetchColumn() ?></span>
                        </div>
    
                        <div class="list-feed-item border-danger">
                            <strong>Данные: </strong><br>
                            Производитель - <?= $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = {$this->post['item_manufacturer_id']}")->fetchColumn() ?><br>
                            Цена - <?= number_format($this->post['item_price']) ?><br>
                            Срок годности - <?= date_f($this->post['item_die_date']) ?><br>
                        </div>
    
                        <div class="list-feed-item border-danger">
                            <strong>Имеющиеся кол-во: </strong>
                            <span id="item_qty_required" style="font-size:15px;" class="ml-1">
                                <?= number_format($this->post['item_qty']);
                                ?>
                            </span> / <span id="item_qty_count">0</span>
                        </div>

                    </div>
                </div>
    
                <div class="form-group row">
                    <label class="col-md-3">Списать (кол-во): </label>
                    <input type="number" name="item_qty" step="1" min="1" max="<?= $this->post['item_qty'] ?>" class="form-control col-md-8" id="input_count-qty" placeholder="Введите кол-во списываемого препарата">
                </div>
    
            </div>
    
            <div class="modal-footer">
                <button type="submit" id="indicator-btn" class="btn btn-outline-secondary btn-sm legitRipple" disabled>Списать</button>
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
            </div>

        </form>
        <script  type="text/javascript">

            var qty_required = document.querySelector("#item_qty_required");
            
            $("#input_count-qty").on("input", function (event) {
                var qty_count = document.querySelector("#item_qty_count");
                
                if ( Number(event.target.max) >= Number(event.target.value) ) {
                    event.target.className = "form-control col-md-8";
                    var qty = Number(event.target.value);
                    qty_count.className = "text-success";
                    document.querySelector("#indicator-btn").className = "btn btn-outline-danger btn-sm legitRipple";
                    document.querySelector("#indicator-btn").disabled = false;
                }else{
                    qty_count.className = "text-danger";
                    event.target.className = "form-control col-md-8 text-danger";
                    document.querySelector("#indicator-btn").className = "btn btn-outline-secondary btn-sm legitRipple";
                    document.querySelector("#indicator-btn").disabled = true;
                }
                
                qty_count.innerHTML = number_format(qty);

            });

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        $db->beginTransaction();
        $object = $db->query("SELECT * FROM $this->storage WHERE id = {$this->post['item_id']}")->fetch();
        
        // Update vs Delete storages
        if ($object['item_qty'] != $this->post['item_qty']) $q = Mixin\update($this->storage, array('item_qty' => $object['item_qty']-$this->post['item_qty']), $object['id']);
        else $q = Mixin\delete($this->storage, $object['id']);
        if (!intval($q)) $db->rollBack();

        // Create transaction
        $transaction_post = array(
            'warehouse_id_from' => $object['warehouse_id'],
            'item_id' => $object['id'],
            'item_name' => $db->query("SELECT name FROM $this->_item_names WHERE id = {$object['item_name_id']}")->fetchColumn(),
            'item_manufacturer' => $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = {$object['item_manufacturer_id']}")->fetchColumn(),
            'item_qty' => $this->post['item_qty'],
            'item_price' => $object['item_price'],
            'is_written_off' => 1,
            'responsible_id' => $this->post['responsible_id'],
            'cost' => $this->post['item_qty']*$object['item_price'],
        );
        Mixin\insert($this->table, $transaction_post);

        $db->commit();
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}
        
?>