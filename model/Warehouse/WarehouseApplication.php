<?php

use Mixin\Model;

class WarehouseApplication extends Model
{
    public $table = 'warehouse_storage_applications';
    public $_event_applications = 'visit_bypass_event_applications';
    public $_item_manufacturers = 'warehouse_item_manufacturers';
    public $_item_names = 'warehouse_item_names';
    public $storage = 'warehouse_storage';
    public $warehouses = 'warehouses';

    public function get_or_404(int $pk)
    {
        $this->set_post($_POST);
        if($pk == 1) $this->frame();
        if($pk == 2) $this->application_all();
        if($pk == 3) $this->application();
    }

    public function panel($storage_from = null, $storage_in = null, $status = 1)
    {
        global $classes, $db;
        ?>
        <div class="row">
            <div class="col-md-4 offset-md-2">
                <label>Склад (с):</label>
                <select data-placeholder="Выберите склад" id="storege_from" class="<?= $classes['form-select'] ?>" onchange="CheckPks()" required <?= ($storage_from) ? 'disabled': ''; ?>>
                    <option></option>
                    <?php foreach($db->query("SELECT * FROM $this->warehouses WHERE is_active IS NOT NULL") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($storage_in == $row['id']) ? 'disabled' : '' ?> <?= ($storage_from == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Склад (на):</label>
                <select data-placeholder="Выберите склад" id="storege_in" class="<?= $classes['form-select'] ?>" onchange="CheckPks()" required <?= ($storage_in) ? 'disabled': ''; ?>>
                    <option></option>
                    <?php foreach($db->query("SELECT * FROM $this->warehouses WHERE is_active IS NOT NULL") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($storage_from == $row['id']) ? 'disabled' : '' ?> <?= ($storage_in == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="panel-frame" class="mt-4"></div>
        <script type="text/javascript">

            function CheckPks(){
                var sFrom = document.querySelector("#storege_from");
                var sIn = document.querySelector("#storege_in");

                if(sFrom.value && !sIn.disabled){
                    for (let i = 0; i < sIn.options.length; i++) {
                        if(sIn.options[i].value == sFrom.value) sIn.options[i].disabled = true;
                        else if(sIn.options[i].disabled) sIn.options[i].disabled = false;
                    }
                }
                if(sIn.value && !sFrom.disabled){
                    for (let i = 0; i < sFrom.options.length; i++) {
                        if(sFrom.options[i].value == sIn.value) sFrom.options[i].disabled = true;
                        else if(sFrom.options[i].disabled) sFrom.options[i].disabled = false;
                    }
                }
                FormLayouts.init();

                if (sFrom.value && sIn.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= up_url(1, __CLASS__) ?>",
                        data: {
                            warehouse_id_from: sFrom.value,
                            warehouse_id_in: sIn.value,
                            status: <?= $status ?>,
                            scripts: true,
                        },
                        success: function (result) {
                            $('#panel-frame').html(result);
                        },
                    });
                }
            }
            <?php if($storage_from and $storage_in) echo "CheckPks()"; ?>

        </script>
        <?php
    }

    public function frame()
    {
        global $session, $classes;
        ?>
        <div class="form-group-feedback form-group-feedback-right">

            <input type="text" class="<?= $classes['input-product_search'] ?>" onkeyup="__<?= __CLASS__ ?>__search(this)" id="panel-search_input_product" placeholder="Поиск..." title="Введите название препарата">
            <div class="form-control-feedback">
                <i class="icon-search4 font-size-base text-muted"></i>
            </div>

        </div>

        <div class="form-group">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-dark">
                            <th>Наименование</th>
                            <th style="width:370px">Производитель</th>
                            <th style="width:370px">Стоимость</th>
                            <th class="text-center" style="width:150px">На складе</th>
                            <th style="width:100px">Кол-во</th>
                            <th class="text-center" style="width:50px">#</th>
                        </tr>
                    </thead>
                    <tbody id="panel-items">

                    </tbody>
                </table>
            </div>

        </div>
        <?php if(isset($this->post['scripts']) and $this->post['scripts']): ?>
            <script type="text/javascript">

                function __<?= __CLASS__ ?>__search(input){
                    $.ajax({
                        type: "POST",
                        url: "<?= up_url(1, 'WarehouseStoragePanel') ?>",
                        data: {
                            warehouse_id_from: <?= $this->post['warehouse_id_from'] ?>,
                            warehouse_id_in: <?= $this->post['warehouse_id_in'] ?>,
                            default: true,
                            search: input.value, 
                        },
                        success: function (result) {
                            $('#panel-items').html(result);
                        },
                    });
                }

                function __WarehouseStoragePanel__select(btn, index) {
                    btn.disabled = true;
                    
                    if (Number(document.querySelector('#max_qty_input_'+index).innerHTML) < Number(document.querySelector('#qty_input_'+index).value)) {
                        new Noty({
                            text: "Введено недопустимое количество!",
                            type: "error"
                        }).show();
                        btn.disabled = false;
                    }else{
                        var data = {
                            model: "<?= __CLASS__ ?>",
                            warehouse_id_from: <?= $this->post['warehouse_id_from'] ?>,
                            warehouse_id_in: <?= $this->post['warehouse_id_in'] ?>,
                            responsible_id: <?= $session->session_id ?>,
                            item_name_id: document.querySelector('#name_id_input_'+index).value,
                            item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                            item_price: document.querySelector('#price_id_input_'+index).value,
                            item_qty: document.querySelector('#qty_input_'+index).value,
                            status: <?= $this->post['status'] ?>,
                        };

                        $.ajax({
                            type: "POST",
                            url: "<?= add_url() ?>",
                            data: data,
                            success: function (result) {
                                console.log(result);
                                var data = JSON.parse(result);
                                if (data.status == "success") {
                                    $(`#Item_${index}`).css("background-color", "rgb(70, 200, 150)");
                                    $(`#Item_${index}`).css("color", "black");
                                    $(`#Item_${index}`).fadeOut(900, function() {
                                        $(this).remove();
                                    });
                                    $("#search_input").keyup();
                                } else {
                                    new Noty({
                                        text: data.message,
                                        type: data.status
                                    }).show();
                                    btn.disabled = false;
                                }
                            },
                        });
                    }

                }

            </script>
        <?php endif; ?>
        <?php
    }

    public function application_all()
    {
        global $db, $classes;
        ?>
        <div class="<?= $classes['card'] ?>">

            <div class="<?= $classes['card-header'] ?>">
                <h5 class="card-title">Заявки cо склада "<?= (new Table($db, $this->warehouses))->where("id = {$this->post['warehouse_id_in']}")->get_row()->name ?>"</h5>
            </div>

            <div class="card-body">

                
                <?php
                $tb = new Table($db, $this->table);
                $tb->set_data('DISTINCT  item_name_id, item_manufacturer_id, item_price');
                $tb->where("warehouse_id_from = {$this->post['warehouse_id_from']} AND warehouse_id_in = {$this->post['warehouse_id_in']} AND status = 2")->order_by("item_manufacturer_id DESC");
                ?>
                
                <div class="table-responsive card">
                    <table class="table table-hover">
                        <thead>
                            <tr class="<?= $classes['table-thead'] ?>">
                                <th style="width: 50px">#</th>
                                <th>Наименование</th>
                                <th style="width:250px">Производитель</th>
                                <th style="width:250px">Цена</th>
                                <th class="text-right" style="width:100px">Кол-во</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tb->get_table(1) as $row): ?>
                                <tr onclick="ApplicationShow(<?= $this->post['warehouse_id_from'] ?>, <?= $this->post['warehouse_id_in'] ?>, <?= $row->item_name_id ?>, <?= $row->item_manufacturer_id ?>, <?= $row->item_price ?>)">
                                    <td><?= $row->count ?></td>
                                    <td><?= $db->query("SELECT name FROM $this->_item_names WHERE id = $row->item_name_id")->fetchColumn() ?></td>
                                    <td><?= ($row->item_manufacturer_id) ? $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = $row->item_manufacturer_id")->fetchColumn() : '<span class="text-muted">Нет данных</span>' ?></td>
                                    <td><?= number_format($row->item_price) ?></td>
                                    <td class="text-right"> 
                                        <?= number_format($db->query("SELECT SUM(item_qty) FROM $this->table WHERE warehouse_id_from = {$this->post['warehouse_id_from']} AND warehouse_id_in = {$this->post['warehouse_id_in']} AND status = 2 AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id AND item_price = $row->item_price")->fetchColumn());?>
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

    public function application()
    {
        global $db, $classes;
        $tb = new Table($db, $this->storage);
        $tb->where("warehouse_id = {$this->post['warehouse_id_from']} AND item_name_id = {$this->post['item_name_id']} AND item_manufacturer_id = {$this->post['item_manufacturer_id']} AND item_price = {$this->post['item_price']}")->order_by("item_die_date ASC");
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

            <input type="hidden" name="model" value="WarehouseApplicationComplete">
            <input type="hidden" name="warehouse_id_from" value="<?= $this->post['warehouse_id_from'] ?>">
            <input type="hidden" name="warehouse_id_in" value="<?= $this->post['warehouse_id_in'] ?>">
            
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
        global $db;
        if ( empty($this->post['id']) ) {
            $db->beginTransaction();
            $m = ($this->post['item_manufacturer_id']) ? "AND item_manufacturer_id = {$this->post['item_manufacturer_id']}" : null;
            $s = ($this->post['item_price']) ? "AND item_price = {$this->post['item_price']}" : null;
            $qty = $this->post['item_qty'];
            foreach ($db->query("SELECT DISTINCT item_manufacturer_id, item_price FROM warehouse_storage WHERE warehouse_id = {$this->post['warehouse_id_from']} AND item_name_id = {$this->post['item_name_id']} AND item_die_date > CURRENT_DATE() $m $s ORDER BY item_die_date ASC, item_price ASC") as $param) {
                $item_qty = $db->query("SELECT SUM(item_qty) FROM warehouse_storage WHERE warehouse_id = {$this->post['warehouse_id_from']} AND item_name_id = {$this->post['item_name_id']} AND item_die_date > CURRENT_DATE() AND item_manufacturer_id = {$param['item_manufacturer_id']} AND item_price = {$param['item_price']} ORDER BY item_die_date ASC, item_price ASC")->fetchColumn();
                $item_qty -= $db->query("SELECT SUM(item_qty) FROM $this->table WHERE status IN (1,2) AND warehouse_id_from = {$this->post['warehouse_id_from']} AND item_name_id = {$this->post['item_name_id']} AND item_manufacturer_id = {$param['item_manufacturer_id']} AND item_price = {$param['item_price']}")->fetchColumn();
                $item_qty -= $db->query("SELECT SUM(item_qty) FROM $this->_event_applications WHERE warehouse_id = {$this->post['warehouse_id_from']} AND item_name_id = {$this->post['item_name_id']} AND item_manufacturer_id = {$param['item_manufacturer_id']} AND item_price = {$param['item_price']}")->fetchColumn();

                if ($item_qty > 0) {
                    $post = array(
                        'warehouse_id_from' => $this->post['warehouse_id_from'],
                        'warehouse_id_in' => $this->post['warehouse_id_in'],
                        'responsible_id' => $this->post['responsible_id'],
                        'item_name_id' => $this->post['item_name_id'],
                        'item_manufacturer_id' => $param['item_manufacturer_id'],
                        'item_price' => $param['item_price'],
                        'item_qty' => ($qty > $item_qty) ? $item_qty : $qty,
                        'status' => $this->post['status']
                    );
                    
                    $object = Mixin\insert($this->table, $post);
                    if (!intval($object)){
                        $this->error($object);
                        exit;
                    }
    
                    if ($qty > $item_qty) {
                        $qty -= $item_qty;
                    }else break;
                }

            }
            $db->commit();
            $this->success();
            
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo json_encode(array(
            'status' => 'success', 
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => "error", 
            'message' => $message
        ));
        exit;
    }
}

class WarehouseApplicationComplete extends WarehouseApplication
{
    public $transactions = 'warehouse_storage_transactions';

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        global $db, $session;
        if($this->clean()){
            $db->beginTransaction();

            foreach ($this->post['applications'] as $appl) if ($db->query("SELECT status FROM $this->table WHERE id = $appl")->fetchColumn() != 2) $this->error("Заявка уже обработана!");

            if ( isset($this->post['rejection']) ) {
                // Application rejection
                $object = Mixin\update($this->table, array('status' => 4), array('id' => $this->post['applications']));
                if (!intval($object)) {
                    $db->rollBack();
                }

            } else {
                // Application complete
                $object = Mixin\update($this->table, array('status' => 3), array('id' => $this->post['applications']));
                if (!intval($object)) {
                    $db->rollBack();
                }
    
                $this->template();
    
                foreach ($this->post['item'] as $id => $qty) {
                    if ($qty > 0) {
                        if ( $item = $db->query("SELECT * FROM $this->storage WHERE id = $id")->fetch() ) {
    
                            // Warehouse old delete
                            if ($item['item_qty']-$qty == 0) Mixin\delete($this->storage, $id);
                            else Mixin\update($this->storage, array('item_qty' => ($item['item_qty']-$qty)), $id);
    
                            // Create transaction
                            $transaction_post = array(
                                'warehouse_id_from' => $this->post['warehouse_id_from'],
                                'warehouse_id_in' => $this->post['warehouse_id_in'],
                                'item_id' => $id,
                                'item_name' => $this->names[$item['item_name_id']],
                                'item_manufacturer' => $this->manufacturers[$item['item_manufacturer_id']],
                                'item_qty' => $qty,
                                'item_price' => $item['item_price'],
                                'is_moving' => 1,
                                'responsible_id' => $session->session_id,
                                'cost' => $qty*$item['item_price'],
                            );
                            Mixin\insert($this->transactions, $transaction_post);
    
                            // Warehouse new add
                            $where = "warehouse_id = {$this->post['warehouse_id_in']} AND item_name_id = {$item['item_name_id']} AND item_manufacturer_id = {$item['item_manufacturer_id']}";
                            $where .= " AND item_price = {$item['item_price']} AND DATE(item_die_date) = DATE('".$item['item_die_date']."')";
                            $obj = $db->query("SELECT id, item_qty FROM $this->storage WHERE $where")->fetch();
                            if ($obj) Mixin\update($this->storage, array('item_qty' => $obj['item_qty']+$qty), $obj['id']);
                            else{
                                $custom_post = array(
                                    'warehouse_id' => $this->post['warehouse_id_in'],
                                    'item_name_id' => $item['item_name_id'],
                                    'item_manufacturer_id' => $item['item_manufacturer_id'],
                                    'item_qty' => $qty,
                                    'item_price' => $item['item_price'],
                                    'item_die_date' => $item['item_die_date'],
                                );
                                Mixin\insert($this->storage, $custom_post);
                                unset($custom_post);
                            }
                            unset($transaction_post);
                            
                        }else {
                            $db->rollBack();
                        }
                    }
                }
                
            }
            
            $db->commit();
            $this->success();
        }
    }

    public function template()
    {
        global $db;
        $this->names = $this->manufacturers = $this->suppliers = [];
        foreach ($db->query("SELECT id, name FROM $this->_item_names")->fetchAll() as $n) $this->names[$n['id']] = $n['name'];
        foreach ($db->query("SELECT id, manufacturer FROM $this->_item_manufacturers")->fetchAll() as $n) $this->manufacturers[$n['id']] = $n['manufacturer'];
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