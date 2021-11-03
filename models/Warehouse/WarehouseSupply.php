<?php

class WarehouseSupplyModel extends Model
{
    public $table = 'warehouse_supply';
    public $_order = 'warehouse_orders';
    public $_common = 'warehouse_common';
    public $_warehouse_item = 'warehouse_supply_items';
    public $_item_names = 'warehouse_item_names';

    public function form($pk = null)
    {
        global $session, $classes;
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <?php if($pk): ?>
                    <h5 class="modal-title">Поставка: <?= $this->value('uniq_key') ?></h5>
                <?php else: ?>
                    <h5 class="modal-title">Новая поставка:</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">

                <div class="form-group">
                    <label>Дата поставки:</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="date" name="supply_date" class="form-control daterange-single" value="<?= $this->value('supply_date') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="custo" name="is_order" <?= ($this->value('is_order')) ? "checked" : "" ?>>
                        <label class="custom-control-label" for="custo">Скдлад бесплатных препаратов</label>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" id="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function table($pk = null)
    {
        global $db, $session, $classes;
        $is_active = (!$this->value('completed') and $session->session_id == $this->value('responsible_id')) ? true : false;
        ?>
        <div class="<?= $classes['card-header'] ?>">
            <h5 class="card-title"><b>Поставка:</b> <?= date_f($this->value('supply_date')) ?></h5>
            <div class="header-elements">

                <span class="text-right"><b>Ответственный:</b> <?= get_full_name($this->value('responsible_id')) ?></span>
                <?php if($is_active): ?>
                    <div class="form-group-feedback form-group-feedback-right ml-3" style="width:70px;">
                        <input type="number" class="form-control border-indigo" value="<?= config('constant_pharmacy_percent') ?>" max="999" id="percent_input" placeholder="%" title="Введите процент">
                        <div class="form-control-feedback">
                            <i class="icon-percent font-size-base text-muted"></i>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="card-body">

            <?php if($is_active): ?>
                <div class="text-right mb-1">
                    <button type="button" onclick="AddItemName('<?= up_url(null, 'WarehouseItemManufacturerModel') ?>')" class="btn btn-sm btn-outline-primary legitRipple"><i class="icon-plus22 mr-1"></i>Производитель</button>
                    <button type="button" onclick="AddItemName('<?= up_url(null, 'WarehouseItemSupplierModel') ?>')" class="btn btn-sm btn-outline-primary legitRipple"><i class="icon-plus22 mr-1"></i>Поставщик</button>
                    <button type="button" onclick="AddItemName('<?= up_url(null, 'WarehouseItemNameModel') ?>')" class="btn btn-sm btn-outline-primary legitRipple"><i class="icon-plus22 mr-1"></i>Препарат</button>
                </div>
            <?php endif; ?>

            <div class="table-responsive card">
                <table class="table table-hover">
                    <thead>
                        <tr class="<?= $classes['table-thead'] ?>">
                            <th style="width:400px">Препарат</th>
                            <th>Производитель</th>
                            <th style="width:200px">Поставщик</th>
                            <th style="width:90px">Кол-во</th>
                            <?php if(!$this->value('is_order')): ?>
                                <th style="width:100px">Ц.приход</th>
                                <th style="width:100px">Ц.расход</th>
                            <?php endif; ?>
                            <th style="width:125px">Счёт фактура</th>
                            <th style="width: 150px">Срок годности</th>
                            <?php if($is_active): ?>
                                <th class="text-center" style="width: 10px">Действия</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        
                        <?php
                        $rosh = new WarehouseSupplyItemModel();
                        $rosh->uniq_key = $this->value('uniq_key');
                        $rosh->branch_id = $session->branch;
                        $rosh->is_order = $this->value('is_order');
                        $rosh->is_active = $is_active;
                        
                        // Table
                        $tb = new Table($db, $rosh->table." wsi ");
                        $tb->set_data("wsi.id")->additions("LEFT JOIN warehouse_item_names win ON (wsi.item_name_id=win.id)");
                        $tb->where("wsi.uniq_key = '{$this->value('uniq_key')}'")->order_by("win.name ASC, wsi.item_manufacturer_id ASC, wsi.item_supplier_id ASC");

                        foreach ($tb->get_table(1) as $row) {
                            $rosh->number = $row->count;
                            $rosh->get_or_404($row->id);
                            $rosh->clear_post();
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <?php if($this->value('completed')): ?>
                <div class="text-left">
                    <span style="font-size: 14px"><b>Склад:</b></span>
                    <span class="text-primary"><?= ( $this->value('is_order') ) ? "Бесплатный" : "Главный" ?></span><br>
                    <span style="font-size: 14px"><b>Внесено:</b></span>
                    <span class="text-primary"><?= date_f($this->value('completed_date'), 1) ?></span>
                </div>
            <?php endif; ?>

            <?php if($is_active): ?>
                <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
                    <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                    <input type="hidden" name="id" value="<?= $pk ?>">
                    <input type="hidden" name="completed" value="1">

                    <div class="row">
                        <div class="col-6 text-left">
                            <span style="font-size: 14px"><b>Status:</b></span>
                            <span class="text-secondary" id="status_display">Не проверен</span>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit" onclick="CheckSupply()" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span id="btn_text" class="ladda-label">Проверить</span>
                                <span class="ladda-spinner"></span>
                            </button>
                            <button type="button" onclick="AddRowArea()" class="btn btn-sm btn-outline-success legitRipple"><i class="icon-plus22 mr-1"></i>Добавить</button>
                        </div>
                    </div>
    
                </form>
            <?php endif; ?>

        </div>

        <div id="modal_default" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
            </div>
        </div>

        <?php if($is_active): ?>
            <script type="text/javascript">

                $("#percent_input").keyup(function() {
                    $.ajax({
                        type: "POST",
                        url: "<?= ajax('controller_constant') ?>",
                        data: {
                            constant_pharmacy_percent: $("#percent_input").val(),
                        },
                    });
                });

                $(".input-price").on("input", function (event) {
                    if (isNaN(Number(event.target.value.replace(/,/g, "")))) {
                        try {
                            event.target.value = event.target.value.replace(
                                new RegExp(event.originalEvent.data, "g"),
                                ""
                            );
                        } catch (e) {
                            event.target.value = event.target.value.replace(
                                event.originalEvent.data,
                                ""
                            );
                        }
                    } else {
                        event.target.value = number_with(
                            event.target.value.replace(/,/g, "")
                        );
                    }
                });

                function AddItemName(events) {
                    $.ajax({
                        type: "GET",
                        url: events,
                        success: function (result) {
                            $('#modal_default').modal('show');
                            $('#form_card').html(result);
                        },
                    });
                };

                var i = Number("<?= $rosh->number ?>");
                var warning = false;

                function DefaulStat() {
                    var objText = document.querySelector("#btn_text");
                    var objStatus = document.querySelector("#status_display");

                    objText.innerHTML = "Проверить";
                    objStatus.innerHTML = "Не проверен";
                    objStatus.className = "text-secondary";
                }

                function AddRowArea() {
                    DefaulStat();
                    $.ajax({
                        type: "GET",
                        url: "<?= ajax("warehouse/add_item") ?>",
                        data: { number: i, uniq_key: "<?= $this->value('uniq_key') ?>", is_order: "<?= $this->value('is_order') ?>" },
                        success: function (result) {
                            $('#table_body').append(result);
                            FormLayouts.init();
                            i++;
                        },
                    });
                }

                function UpBtnPrice(id) {

                    if (isNaN(Number(event.target.value.replace(/,/g, "")))) {
                        try {
                            event.target.value = event.target.value.replace(
                                new RegExp(event.originalEvent.data, "g"),
                                ""
                            );
                        } catch (e) {
                            event.target.value = event.target.value.replace(
                                event.originalEvent.data,
                                ""
                            );
                        }
                    } else {
                        event.target.value = number_with(
                            event.target.value.replace(/,/g, "")
                        );
                    }
                    
                    var input_cost = event.target;
                    var input_price = document.querySelector("#item_price-"+(input_cost.id).replace("item_cost-", ''));
                    var input_percent = Number(document.querySelector("#percent_input").value);
                    var input_cost_value = Number(input_cost.value.replace(/,/g,''));
                    
                    input_price.value = number_format( input_cost_value + (input_cost_value * (input_percent / 100)) );
                    UpBtn(id);
                }

                function UpBtn(id) {
                    DefaulStat();
                    var btn = document.querySelector(`#${id}`);
                    btn.disabled = false;
                    btn.className = "btn list-icons-item text-success-600";
                }

                function SaveRowArea(tr) {
                    DefaulStat();
                    var btn = event.target;
                    btn.disabled = true;
                    btn.className = "btn list-icons-item text-gray-600";

                    $.ajax({
                        type: "POST",
                        url: "<?= add_url() ?>",
                        data: $(`#table_tr-${tr}`).find('select, input').serializeArray(),
                        success: function (result) {
                            var data = JSON.parse(result);

                            if (data.status == "success") {
                                
                                new Noty({
                                    text: "Успешно сохранено!",
                                    type: "success",
                                }).show();
                                document.querySelector(`#table_id-${tr}`).value = data.pk;
                                

                            } else {

                                btn.disabled = false;
                                btn.className = "btn list-icons-item text-success-600";
                                new Noty({
                                    text: data.message,
                                    type: "error",
                                }).show();

                            }
                        },
                    });

                }

                function DeleteRowArea(tr) {
                    DefaulStat();
                    var pk = $(`#table_tr-${tr}`).find('input[name="id"]')[0].value;
                    var btn = event.target;
                    btn.disabled = true;
                    btn.className = "btn list-icons-item text-gray-600";

                    if (pk) {

                        $.ajax({
                            type: "GET",
                            url: "<?= del_url() ?>",
                            data: { model:"WarehouseSupplyItemModel", id: pk },
                            success: function (result) {
                                var data = JSON.parse(result);

                                if (data.status == "success") {
                                    
                                    new Noty({
                                        text: "Удаление прошло успешно!",
                                        type: "success",
                                    }).show();

                                    $(`#table_tr-${tr}`).css("background-color", "rgb(244, 67, 54)");
                                    $(`#table_tr-${tr}`).css("color", "white");
                                    $(`#table_tr-${tr}`).fadeOut(900, function() {
                                        $(`#table_tr-${tr}`).remove();
                                    });

                                } else {

                                    new Noty({
                                        text: data.message,
                                        type: "error",
                                    }).show();
                                    btn.disabled = false;
                                    btn.className = "btn list-icons-item text-danger-600";

                                }
                            },
                        });

                    } else {

                        $(`#table_tr-${tr}`).css("background-color", "rgb(244, 67, 54)");
                        $(`#table_tr-${tr}`).css("color", "white");
                        $(`#table_tr-${tr}`).fadeOut(900, function() {
                            $(`#table_tr-${tr}`).remove();
                        });

                    }
                }

                function CheckSupply() {
                    event.preventDefault();
                    var objText = document.querySelector("#btn_text");
                    var objStatus = document.querySelector("#status_display");

                    if (objText.innerHTML == "Проверить") {
                        
                        if (VerificationSupply()) {

                            objText.innerHTML = "Отправить на склад";
                            objStatus.innerHTML = "Проверен";
                            objStatus.className = "text-success";

                        } else {

                            objStatus.innerHTML = "Проверка не пройдена";
                            objStatus.className = "text-danger";

                        }
                        

                    } else {

                        if (warning) {
                            swal({
                                position: 'top',
                                title: `Информация о некоторых препаратах, занесена не полностью!`,
                                text: `Поля в которых нет данных, выделены синим цветом.`,
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Отправить'
                            }).then(function(ivi) {
                                if (ivi.value) {
                                    SubmitSupply();
                                }
                            });
                        }else{
                            SubmitSupply();
                        }

                    }

                };

                function SubmitSupply() {
                    swal({
                        position: 'top',
                        title: `Отправить препараты на склад`,
                        text: `Вы точно хотите отправить препараты на склад?`,
                        type: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Да'
                    }).then(function(ivi) {
                        if (ivi.value) {
                            document.querySelector("#<?= __CLASS__ ?>_form").submit();
                        }
                    });
                }

                function VerificationSupply() {
                    var status = true;
                    var inputs = document.querySelectorAll(".verification_input");
                    
                    for (let key = 0; key < inputs.length; key++) {
                        const element = inputs[key];
                        if (!element.value) {
                            
                            if ( ["item_name_id","item_supplier_id"].includes(element.name) ) {
                                $(element).next().css({"border-bottom": "2px solid red"});
                                status = false;
                            }if ( ["item_qty","item_cost","item_price","item_die_date"].includes(element.name) ) {
                                element.className += " border-danger";
                                status = false;
                            }else{
                                element.className += " border-primary";
                                warning = true;
                            }
                        }else{
                            if ( ["item_name_id","item_supplier_id"].includes(element.name) ) {
                                $(element).next().css({"border-bottom": ""});
                            }
                        }
                    }

                    return status;
                }

            </script>
        <?php endif; ?>
        <?php
    }

    public function clean()
    {
        if (!$this->post['id']) $this->post['uniq_key'] = uniqid('supply-');
        if ( isset($this->post['is_order']) and $this->post['is_order'] == 'on' ) $this->post['is_order'] = 1;
        else $this->post['is_order'] = null;
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function update()
    {
        global $db;

        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);

            if ($this->post['completed']) {

                // Storage Update
                $this->post['completed_date'] = date("Y-m-d H:i:s");
                $db->beginTransaction();

                $this->warehouse_change($pk);

                $object = Mixin\update($this->table, $this->post, $pk);
                if (!intval($object)){
                    $this->error($object);
                    exit;
                }

                $db->commit();
                $this->success();

            } else {

                // Default Update
                $object = Mixin\update($this->table, $this->post, $pk);
                if (!intval($object)){
                    $this->error($object);
                    exit;
                }
                $this->success();
                    
            }
        }
    }

    public function warehouse_change($pk)
    {
        global $db;
        unset($this->post['is_order']);
        $data = $db->query("SELECT uniq_key, is_order FROM $this->table WHERE id = $pk")->fetch();
        foreach ($db->query("SELECT * FROM $this->_warehouse_item WHERE uniq_key = '{$data['uniq_key']}'") as $item) {
            $where = "item_name_id = {$item['item_name_id']} AND item_manufacturer_id = {$item['item_manufacturer_id']}";
            unset($item['id']);
            unset($item['uniq_key']);
            unset($item['item_cost']);
            unset($item['item_faktura']);
            unset($item['item_supplier_id']);
            if ($data['is_order']) {
                unset($item['item_price']);
                $where .= " AND DATE(item_die_date) = DATE('".$item['item_die_date']."')";
                $obj = $db->query("SELECT id, item_qty FROM $this->_order WHERE $where")->fetch();
                if ($obj) $object = Mixin\update($this->_order, array('item_qty' => $obj['item_qty']+$item['item_qty']), $obj['id']);
                else $object = Mixin\insert($this->_order, $item);
            } else {
                $where .= " AND item_price = {$item['item_price']} AND DATE(item_die_date) = DATE('".$item['item_die_date']."')";
                $obj = $db->query("SELECT id, item_qty FROM $this->_common WHERE $where")->fetch();
                if ($obj) $object = Mixin\update($this->_common, array('item_qty' => $obj['item_qty']+$item['item_qty']), $obj['id']);
                else $object = Mixin\insert($this->_common, $item);
            }
            
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
            }
        }
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render("pharmacy/supply");
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render("pharmacy/supply");
    }
}
        
?>