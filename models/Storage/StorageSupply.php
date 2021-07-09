<?php

class StorageSupplyModel extends Model
{
    public $table = 'storage_supply';


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
        ?>
        <!-- <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form"> -->
            <!-- <input type="hidden" name="model" value="<?= __CLASS__ ?>"> -->
            <!-- <input type="hidden" name="id" value="<?= $pk ?>"> -->


            <div class="<?= $classes['card-header'] ?>">
                <h5 class="card-title"><b>Поставка:</b> <?= date_f($this->value('supply_date')) ?></h5>
                <span class="text-right"><b>Ответственный:</b> <?= get_full_name($this->value('parent_id')) ?></span>
            </div>

            <div class="card-body">
                <div class="table-responsive card">
                    <table class="table table-hover table-bordered">
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
                                <th class="text-right" style="width: 10px">#</th>
                            </tr>
                        </thead>
                        <tbody id="table_body">
                            
                            <?php
                            $rosh = new StorageSupplyItemsModel();
                            $rosh->uniq_key = $this->value('uniq_key');
                            
                            // table
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

                <div class="text-right">
                    <button type="button" onclick="AddRowArea()" class="btn btn-sm btn-outline-success legitRipple">Добавить</button>
                </div>
            </div>

        <!-- </form> -->

        <script type="text/javascript">
            var i = Number("<?= $rosh->number ?>");

            function AddRowArea() {
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
                var btn = document.querySelector(`#${id}`);
                btn.disabled = false;
                btn.className = "btn list-icons-item text-success-600";
            }

            function SaveRowArea(tr) {
                var btn = event.target;
                btn.disabled = true;
                btn.className = "btn list-icons-item text-gray-600";
                
                console.log($(`#table_tr-${tr}`).find('select, input').serializeArray());

                $.ajax({
                    type: "POST",
                    url: "<?= add_url() ?>",
                    data: $(`#table_tr-${tr}`).find('select, input').serializeArray(),
                    success: function (result) {
                        console.log(result);
                        var data = JSON.parse(result);

                        if (data.status == "success") {
                            
                            new Noty({
                                text: "Успешно!",
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
                if (pk) {
                    console.log("delete");
                } else {
                    $(`#table_tr-${tr}`).css("background-color", "rgb(244, 67, 54)");
                    $(`#table_tr-${tr}`).css("color", "white");
                    $(`#table_tr-${tr}`).fadeOut(900, function() {
                        $(`#table_tr-${tr}`).remove();
                    });
                }
            }

        </script>
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}
        
?>