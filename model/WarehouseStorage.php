<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class WarehouseStorage extends Model
{
    public $table = 'warehouse_storage';
    public $_warehouses = 'warehouses';
    public $_applications = 'warehouse_storage_applications';
    public $_event_applications = 'visit_bypass_event_applications';
    public $_item_manufacturers = 'warehouse_item_manufacturers';
    public $_item_suppliers = 'warehouse_item_suppliers';
    public $_item_names = 'warehouse_item_names';
    public $i = 0;
    public $cost = 0;

    private function applicationAdd()
    {
        $this->saveBefore();
        $m = ($this->getPost('item_manufacturer_id')) ? "AND item_manufacturer_id = " . $this->getPost('item_manufacturer_id') : null;
        $s = ($this->getPost('item_price')) ? "AND item_price = " . $this->getPost('item_price') : null;
        $qty = $this->getPost('item_qty');

        foreach ($this->Data('DISTINCT item_manufacturer_id, item_price')->Where("warehouse_id = " . $this->getPost('warehouse_id_from') . " AND item_name_id = " . $this->getPost('item_name_id') . " AND item_die_date > CURRENT_DATE() $m $s")->Order("item_die_date ASC, item_price ASC")->list() as $param) {
            
            $item_qty = $this->db->query("SELECT SUM(item_qty) FROM $this->table WHERE warehouse_id = " . $this->getPost('warehouse_id_from') . " AND item_name_id = " . $this->getPost('item_name_id') . " AND item_die_date > CURRENT_DATE() AND item_manufacturer_id = $param->item_manufacturer_id AND item_price = $param->item_price ORDER BY item_die_date ASC, item_price ASC")->fetchColumn();
            $item_qty -= $this->db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE status IN (1,2) AND warehouse_id_from = " . $this->getPost('warehouse_id_from') . " AND item_name_id = " . $this->getPost('item_name_id') . " AND item_manufacturer_id = $param->item_manufacturer_id AND item_price = $param->item_price")->fetchColumn();
            $item_qty -= $this->db->query("SELECT SUM(item_qty) FROM $this->_event_applications WHERE warehouse_id = " . $this->getPost('warehouse_id_from') . " AND item_name_id = " . $this->getPost('item_name_id') . " AND item_manufacturer_id = $param->item_manufacturer_id AND item_price = $param->item_price")->fetchColumn();

            if ($item_qty > 0) {
                
                $obj = HellCrud::insert($this->_applications, array(
                    'warehouse_id_from' => $this->getPost('warehouse_id_from'),
                    'warehouse_id_in' => $this->getPost('warehouse_id_in'),
                    'responsible_id' => $this->getPost('responsible_id'),
                    'item_name_id' => $this->getPost('item_name_id'),
                    'item_manufacturer_id' => $param->item_manufacturer_id,
                    'item_price' => $param->item_price,
                    'item_qty' => ($qty > $item_qty) ? $item_qty : $qty,
                    'status' => $this->getPost('status')
                ));

                if (!is_numeric($obj)) $this->error($obj);
                if ($qty > $item_qty) $qty -= $item_qty;
                else break;
            }

        }
        $this->saveAfter();
    }

    public function warehousesPanel($storage_from = null, $storage_in = null, $status = 1)
    {
        global $classes;
        ?>
        <div class="row">
            <div class="col-md-4 offset-md-2">
                <label>Склад (с):</label>
                <select data-placeholder="Выберите склад" id="storege_from" class="<?= $classes['form-select'] ?>" onchange="CheckPks()" required <?= ($storage_from) ? 'disabled': ''; ?>>
                    <option value=""></option>
                    <?php foreach($this->db->query("SELECT * FROM $this->_warehouses WHERE is_active IS NOT NULL AND is_external IS NOT NULL") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($storage_in == $row['id']) ? 'disabled' : '' ?> <?= ($storage_from == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Склад (на):</label>
                <select data-placeholder="Выберите склад" id="storege_in" class="<?= $classes['form-select'] ?>" onchange="CheckPks()" required <?= ($storage_in) ? 'disabled': ''; ?>>
                    <option></option>
                    <?php foreach($this->db->query("SELECT * FROM $this->_warehouses WHERE is_active IS NOT NULL") as $row): ?>
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
                        url: "<?= Hell::apiAxe(__CLASS__, array('form' => 'frame')) ?>",
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

    public function Axe()
    {
        $this->{$this->getGet('form')}();
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
        <?php if($this->getPost('scripts')): ?>
            <script type="text/javascript">

                function __<?= __CLASS__ ?>__search(input){
                    $.ajax({
                        type: "POST",
                        url: "<?= Hell::apiAxe(__CLASS__, array('form' => 'itemSearch')) ?>",
                        data: {
                            warehouse_id_from: <?= $this->getPost('warehouse_id_from') ?>,
                            warehouse_id_in: <?= $this->getPost('warehouse_id_in') ?>,
                            default: true,
                            search: input.value, 
                        },
                        success: function (result) {
                            $('#panel-items').html(result);
                        },
                    });
                }

                function __<?= __CLASS__ ?>__select(btn, index) {
                    btn.disabled = true;
                    
                    if (Number(document.querySelector('#max_qty_input_'+index).innerHTML) < Number(document.querySelector('#qty_input_'+index).value)) {
                        new Noty({
                            text: "Введено недопустимое количество!",
                            type: "error"
                        }).show();
                        btn.disabled = false;
                    }else{
                        var data = {
                            warehouse_id_from: <?= $this->getPost('warehouse_id_from') ?>,
                            warehouse_id_in: <?= $this->getPost('warehouse_id_in') ?>,
                            responsible_id: <?= $session->session_id ?>,
                            item_name_id: document.querySelector('#name_id_input_'+index).value,
                            item_manufacturer_id: document.querySelector('#manufacturer_id_input_'+index).value,
                            item_price: document.querySelector('#price_id_input_'+index).value,
                            item_qty: document.querySelector('#qty_input_'+index).value,
                            status: <?= $this->getPost('status') ?>,
                        };

                        $.ajax({
                            type: "POST",
                            url: "<?= Hell::apiAxe(__CLASS__, array('form' => 'applicationAdd')) ?>",
                            data: data,
                            success: function (res) {
                                if (res.status == "success") {
                                    $(`#Item_${index}`).css("background-color", "rgb(70, 200, 150)");
                                    $(`#Item_${index}`).css("color", "black");
                                    $(`#Item_${index}`).fadeOut(900, function() {
                                        $(this).remove();
                                    });
                                    $("#search_input").keyup();
                                } else {
                                    new Noty({
                                        text: res.message,
                                        type: res.status
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

    public function itemOption()
    {
        $data = $this->getPost();
        $m = ( isset($data['manufacturer_id']) and $data['manufacturer_id'] ) ? " AND wc.item_manufacturer_id = ".$data['manufacturer_id'] : null;
        $s = ( isset($data['item_price']) and $data['item_price'] ) ? " AND wc.item_price = ".$data['item_price'] : null;

        $price_result = $this->db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s ORDER BY wc.item_price ASC")->fetchAll();
        $qty_max = $this->db->query("SELECT SUM(wc.item_qty) FROM $this->table wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn(); 
        $qty_applications = $this->db->query("SELECT SUM(wc.item_qty) FROM $this->_applications wc WHERE wc.status IN (1,2) AND wc.warehouse_id_from = {$data['warehouse_id']} AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn();
        $qty_applications += $this->db->query("SELECT SUM(wc.item_qty) FROM $this->_event_applications wc WHERE wc.warehouse_id = {$data['warehouse_id']} AND wc.item_name_id = {$data['item_name_id']} $m $s")->fetchColumn();
        $qty = $qty_max - $qty_applications;
        echo json_encode(array('price' => $price_result, 'max_qty' => $qty));
    }

    public function itemSearch(){
        global $classes;
        if ($search = $this->getPost('search')) {
            $ware_pk = $this->getPost('warehouse_id_from');

            foreach ($this->as('wc')->Data('DISTINCT wc.item_name_id, win.name')->JoinLEFT("$this->_item_names win", "win.id=wc.item_name_id")->Where("wc.warehouse_id = $ware_pk AND wc.item_die_date > CURRENT_DATE() AND LOWER(win.name) LIKE LOWER('%$search%')")->list() as $row){
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
                            <?php if($this->getPost('default')): ?>
                                <option value="" >Производитель будет выбран автоматически</option>
                            <?php endif; ?>
                            <?php foreach ($this->db->query("SELECT DISTINCT wis.id, wis.manufacturer FROM $this->table wc LEFT JOIN $this->_item_manufacturers wis ON (wis.id=wc.item_manufacturer_id) WHERE wc.warehouse_id = $ware_pk AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wis.manufacturer ASC") as $manufacturer): ?>
                                <?php // if(empty($the_manufacturer)) $the_manufacturer = $manufacturer->id; ?>
                                <option value="<?= $manufacturer['id'] ?>" ><?= $manufacturer['manufacturer'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <!-- Cost -->
                    <td>
                        <select id="price_id_input_<?= $this->i ?>" class="<?= $classes['form-select'] ?> costs" data-i="<?= $this->i ?>" data-item_name="<?= $row->item_name_id ?>">
                            <?php if($this->getPost('default')): ?>
                                <option value="" >Стоимость будет выбрана автоматически</option>
                            <?php endif; ?>
                            <?php foreach ($this->db->query("SELECT DISTINCT wc.item_price FROM $this->table wc WHERE wc.warehouse_id = $ware_pk AND wc.item_die_date > CURRENT_DATE() AND wc.item_name_id = $row->item_name_id ORDER BY wc.item_price ASC") as $price): ?>
                                <?php // if(empty($the_cost)) $the_cost = $price->item_price; ?>
                                <option value="<?= $price['item_price'] ?>" ><?= number_format($price['item_price']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <!-- Max qty -->
                    <td class="text-center">
                        <span id="max_qty_input_<?= $this->i ?>">
                            <?php
                            $the_where = "item_name_id = $row->item_name_id";
                            $max_qty = $this->db->query("SELECT SUM(item_qty) FROM $this->table WHERE warehouse_id = $ware_pk AND item_die_date > CURRENT_DATE() AND $the_where")->fetchColumn();
                            $applications = $this->db->query("SELECT SUM(item_qty) FROM $this->_applications WHERE status IN (1,2) AND warehouse_id_from = $ware_pk AND $the_where")->fetchColumn();
                            $applications += $this->db->query("SELECT SUM(item_qty) FROM $this->_event_applications WHERE warehouse_id = $ware_pk AND $the_where")->fetchColumn();
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
                        url: "<?= Hell::apiAxe(__CLASS__, array('form' => 'itemOption')) ?>",
                        data: { 
                            warehouse_id: <?= $ware_pk ?>,
                            item_name_id: this.dataset.item_name,
                            manufacturer_id: this.value,
                        },
                        success: function (result) {
                            var data = JSON.parse(result);
                            var options = `
                            <?php if($this->getPost('default')): ?>
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
                        url: "<?= Hell::apiAxe(__CLASS__, array('form' => 'itemOption')) ?>",
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
        
    }

    public function listAplications()
    {
        global $classes, $db;
        $item = $this->byId($this->getGet('id'));
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Оформленные заявки</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
            
        <div class="modal-body">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="<?= $classes['table-thead'] ?>">
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th class="text-right" style="width:210px">Кол-во</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($db->query("SELECT p.id, wc.visit_id, p.first_name, p.last_name, p.father_name, SUM(wc.item_qty) 'qty' FROM visit_bypass_event_applications wc LEFT JOIN patients p ON(p.id=wc.patient_id) WHERE wc.warehouse_id = $item->warehouse_id AND wc.item_name_id = $item->item_name_id AND wc.item_manufacturer_id = $item->item_manufacturer_id AND wc.item_price = $item->item_price GROUP BY p.id") as $row): ?>
                            <tr>
                                <td><a href="<?= viv('card/content-9') . "?pk=" . $row['visit_id'] ?>"><?= addZero($row['id']) ?></a></td>
                                <td><?= patient_name($row) ?></td>
                                <td class="text-right"><?= number_format($row['qty']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
        </div>
        <?php
    }

    public function refundItem()
    {
        global $classes, $db, $session;
        $this->setPost($this->byId($this->getGet('id')));
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Возврат препарат</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook('WarehouseStorageTransaction') ?>" onsubmit="submitForm()">

            <?php $this->csrfToken(); ?>
            <input type="hidden" name="item_id" value="<?= $this->value('id') ?>">
            <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">
            
            <div class="modal-body">

                <div class="card card-body border-top-1 border-top-warning">
                    <div class="list-feed list-feed-rhombus list-feed-solid">
                        <div class="list-feed-item border-warning">
                            <strong>Препарат: </strong>
                            <span><?= $db->query("SELECT name FROM $this->_item_names WHERE id = " . $this->value('item_name_id'))->fetchColumn() ?></span>
                        </div>
    
                        <div class="list-feed-item border-warning">
                            <strong>Данные: </strong><br>
                            Производитель - <?= $db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = " . $this->value('item_manufacturer_id'))->fetchColumn() ?><br>
                            Цена - <?= number_format($this->value('item_price')) ?><br>
                            Срок годности - <?= date_f($this->value('item_die_date')) ?><br>
                        </div>
    
                        <div class="list-feed-item border-warning">
                            <strong>Имеющиеся кол-во: </strong>
                            <span id="item_qty_required" style="font-size:15px;" class="ml-1">
                                <?= number_format($this->value('item_qty')); ?>
                            </span> / <span id="item_qty_count">0</span>
                        </div>

                    </div>
                </div>

                <?php
                importModel('WarehouseStorageApplication');
                $warehouses = (new WarehouseStorageApplication('wp'))->Data('w.id, w.name');
                $warehouses->Where("wp.warehouse_id_in=" . $this->value('warehouse_id') . " AND wp.item_name_id=". $this->value('item_name_id') . " AND wp.item_manufacturer_id=" . $this->value('item_manufacturer_id') . " AND wp.item_price=" . $this->value('item_price') . " AND wp.status = 3");
                $warehouses->JoinRIGHT('warehouses w', 'w.id=wp.warehouse_id_from')->Group('w.id');
                ?>

                <div class="form-group">
                    <label>Выбирите склад:</label>
                    <select data-placeholder="Выбрать склад" name="warehouse_id_in" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($warehouses->list() as $row): ?>
                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">Вернуть (кол-во):</label>
                    <input type="number" name="item_qty" step="1" min="1" max="<?= $this->value('item_qty') ?>" class="form-control col-md-8" required id="input_count-qty" placeholder="Введите кол-во списываемого препарата">
                </div>

                <div class="form-group row">
                    <label class="col-3">Комметарий:</label>
                    <input type="text" name="comment" class="form-control col-md-8" placeholder="Комментарий">
                </div>
    
            </div>
    
            <div class="modal-footer">
                <button type="submit" id="indicator-btn" class="btn btn-outline-secondary btn-sm legitRipple" disabled>Возврат</button>
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
            </div>

        </form>
        <script  type="text/javascript">

            var qty_required = document.querySelector("#item_qty_required");
            
            $("#input_count-qty").on("input", function (event) {
                var qty_count = document.querySelector("#item_qty_count");
                
                if ( Number(event.target.max) >= Number(event.target.value) && Number(event.target.value) > 0 ) {
                    event.target.className = "form-control col-md-8";
                    var qty = Number(event.target.value);
                    qty_count.className = "text-success";
                    document.querySelector("#indicator-btn").className = "btn btn-outline-warning btn-sm legitRipple";
                    document.querySelector("#indicator-btn").disabled = false;
                }else{
                    qty_count.className = "text-danger";
                    event.target.className = "form-control col-md-8 text-danger";
                    document.querySelector("#indicator-btn").className = "btn btn-outline-secondary btn-sm legitRipple";
                    document.querySelector("#indicator-btn").disabled = true;
                }
                
                qty_count.innerHTML = number_format(qty);

            });

            FormLayouts.init();

        </script>
        <?php
    }

    public function writtenOffItem()
    {
        global $classes, $session;
        $this->setPost($this->byId($this->getGet('id')));
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Списать препарат</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= $this->urlHook('WarehouseStorageTransaction') ?>" onsubmit="submitForm()">

            <?php $this->csrfToken(); ?>

            <input type="hidden" name="item_id" value="<?= $this->value('id') ?>">
            <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">
            
            <div class="modal-body">

                <div class="card card-body border-top-1 border-top-danger">
                    <div class="list-feed list-feed-rhombus list-feed-solid">
                        <div class="list-feed-item border-danger">
                            <strong>Препарат: </strong>
                            <span><?= $this->db->query("SELECT name FROM $this->_item_names WHERE id = " . $this->value('item_name_id'))->fetchColumn() ?></span>
                        </div>
    
                        <div class="list-feed-item border-danger">
                            <strong>Данные: </strong><br>
                            Производитель - <?= $this->db->query("SELECT manufacturer FROM $this->_item_manufacturers WHERE id = " . $this->value('item_manufacturer_id'))->fetchColumn() ?><br>
                            Цена - <?= number_format($this->value('item_price')) ?><br>
                            Срок годности - <?= date_f($this->value('item_die_date')) ?><br>
                        </div>
    
                        <div class="list-feed-item border-danger">
                            <strong>Имеющиеся кол-во: </strong>
                            <span id="item_qty_required" style="font-size:15px;" class="ml-1">
                                <?= number_format($this->value('item_qty')); ?>
                            </span> / <span id="item_qty_count">0</span>
                        </div>

                    </div>
                </div>
    
                <div class="form-group row">
                    <label class="col-md-3">Списать (кол-во):</label>
                    <input type="number" name="item_qty" step="1" min="1" max="<?= $this->value('item_qty') ?>" class="form-control col-md-8" required id="input_count-qty" placeholder="Введите кол-во списываемого препарата">
                </div>

                <div class="form-group row">
                    <label class="col-3">Комметарий:</label>
                    <input type="text" name="comment" class="form-control col-md-8" placeholder="Комментарий">
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
                
                if ( Number(event.target.max) >= Number(event.target.value) && Number(event.target.value) > 0 ) {
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

}

?>