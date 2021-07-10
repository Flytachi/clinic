<?php

class StorageSupplyModel extends Model
{
    public $table = 'storage_supply';
    public $_storage = 'storages';
    public $_storage_item = 'storage_supply_items';


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
                <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">

                <div class="form-group">
                    <label>Дата рождение:</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                        </span>
                        <input type="date" name="supply_date" class="form-control daterange-single" value="<?= $this->value('supply_date') ?>" required>
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
        $is_active = (!$this->value('completed') and $session->session_id == $this->value('parent_id')) ? true : false;
        ?>
        <div class="<?= $classes['card-header'] ?>">
            <h5 class="card-title"><b>Поставка:</b> <?= date_f($this->value('supply_date')) ?></h5>
            <span class="text-right"><b>Ответственный:</b> <?= get_full_name($this->value('parent_id')) ?></span>
        </div>

        <div class="card-body">
            <div class="table-responsive card">
                <table class="table table-hover">
                    <thead>
                        <tr class="<?= $classes['table-thead'] ?>">
                            <th style="width:190px">Ключ</th>
                            <th>Препарат</th>
                            <th style="width:200px">Поставщик</th>
                            <th style="width:200px">Производитель</th>
                            <th style="width:90px">Кол-во</th>
                            <th style="width:170px">Цена прихода</th>
                            <th style="width:170px">Цена расхода</th>
                            <th style="width:100px">Счёт фактура</th>
                            <th style="width:140px">Штрих код</th>
                            <th style="width: 150px">Срок годности</th>
                            <?php if($is_active): ?>
                                <th class="text-center" style="width: 10px">Действия</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        
                        <?php
                        $rosh = new StorageSupplyItemsModel();
                        $rosh->uniq_key = $this->value('uniq_key');
                        $rosh->is_active = $is_active;
                        
                        // Table
                        $tb = new Table($db, $rosh->table);
                        $tb->set_data("id");
                        $tb->where("uniq_key = '{$this->value('uniq_key')}'");

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

        <?php if($is_active): ?>
            <script type="text/javascript">
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
                        url: "<?= ajax("storage_add") ?>",
                        data: { number: i, uniq_key: "<?= $this->value('uniq_key') ?>" },
                        success: function (result) {
                            $('#table_body').append(result);
                            FormLayouts.init();
                            i++;
                        },
                    });
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

                                $.ajax({
                                    type: "GET",
                                    url: "<?= ajax("storage_add") ?>",
                                    data: { number: tr, uniq_key: "<?= $this->value('uniq_key') ?>", id: data.pk },
                                    success: function (result) {
                                        $(`#table_tr-${tr}`).html(result);
                                        FormLayouts.init();
                                    },
                                });

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
                            data: { model:"StorageSupplyItemsModel", id: pk },
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
        if (!$this->post['id']) {
            $this->post['uniq_key'] = uniqid('supply-');
        }
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

                $this->storage_change($pk);

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

    public function storage_change($pk)
    {
        global $db;
        $uniq = $db->query("SELECT uniq_key FROM $this->table WHERE id = $pk")->fetchColumn();
        foreach ($db->query("SELECT * FROM $this->_storage_item WHERE uniq_key = '$uniq'") as $item) {
            unset($item['uniq_key']);
            $object = Mixin\insert($this->_storage, $item);
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
        render("admin/storage_supply");
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render("admin/storage_supply");
    }
}
        
?>