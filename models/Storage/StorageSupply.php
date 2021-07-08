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
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">


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

                            <!-- test -->
                            <tr id="table_tr-0">
                                <td>
                                    <select name="0[item_key]" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Ключ">
                                        <option></option>
                                        <option value="key-60e6f3e706171">key-60e6f3e706171</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="0[item_name_id]" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Препарат">
                                        <option></option>
                                        <option value="1">Мой первый препарат</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="0[item_supplier_id]" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Поставщика">
                                        <option></option>
                                        <option value="1">Поставщик</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="0[item_manufacturer_id]" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Производителя">
                                        <option></option>
                                        <option value="1">Узбекистан</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="0[item_qty]" class="form-control" min="1" placeholder="№">
                                </td>
                                <td>
                                    <input type="number" name="0[item_cost]" class="form-control" min="0" placeholder="Введите цену">
                                </td>
                                <td>
                                    <input type="number" name="0[item_price]" class="form-control" min="0" placeholder="Введите цену">
                                </td>
                                <td>
                                    <input type="text" name="0[item_faktura]" class="form-control" placeholder="Введите № фактуры">
                                </td>
                                <td>
                                    <input type="text" name="0[item_shtrih]" class="form-control" placeholder="Введите штрих">
                                </td>
                                <td>
                                    <input type="date" name="0[item_die_date]" class="form-control daterange-single">
                                </td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <a href="#" onclick="DeleteRowArea(null, 0)" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                    </div>
                                </td>

                            </tr>
                            <!-- test -->
                            
                            <?php
                            $tb = new Table($db, "storage_supply_items");
                            $tb->where("uniq_key = '{$this->value('uniq_key')}'");
                            ?>
                            <?php foreach ($tb->get_table(1) as $row): ?>
                                <tr>
                                    <td><?= $row->item_key ?></td>
                                    <td><?= $row->item_name ?></td>
                                    <td><?= $row->item_supplier ?></td>
                                    <td><?= $row->item_qty ?></td>
                                    <td><?= $row->item_cost ?></td>
                                    <td><?= $row->item_price ?></td>
                                    <td><?= $row->item_faktura ?></td>
                                    <td><?= $row->item_shtrih ?></td>
                                    <td><?= $row->item_die_date ?></td>
                                    <td class="text-right">
                                        <div class="list-icons">
                                            <a href="#" type="button" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-right">
                    <button type="button" onclick="AddRowArea()" class="btn btn-sm btn-outline-success legitRipple">Добавить</button>
                </div>
            </div>

        </form>

        <script type="text/javascript">

            var i = 0;
            
            function AddRowArea() {
                $('#table_body').append(`
                    <h1>${i}</h1>
                `);
                i++;
            }

            function DeleteRowArea(pk = null, tr) {
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