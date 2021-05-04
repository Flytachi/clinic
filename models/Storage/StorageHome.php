<?php

class StorageHomeModel extends Model
{
    public $table = 'storage_home';

    public function form($pk = null)
    {
        global $db, $classes;
        ?>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="<?= $classes['card'] ?>">

                <div class="<?= $classes['card-header'] ?>">
                    <h5 class="card-title">Список лекарств пациента</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <select data-placeholder="Выберите специалиста" name="parent_id" onchange="CallMed(this.value)" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach ($db->query("SELECT * from users WHERE user_level = 7") as $row): ?>
                                    <option value="<?= $row['id'] ?>" ><?= get_full_name($row['id']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive card">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width: 70px">№</th>
                                    <th style="width: 10%">Дата</th>
                                    <th style="width: 40%">Препарат</th>
                                    <th class="text-center">На складе</th>
                                    <th class="text-center">Ко-во (требуется)</th>
                                    <th class="text-center" style="width: 100px">Ко-во</th>
                                    <th class="text-right">Цена ед.</th>
                                    <th class="text-right">Сумма</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php # $total_cost=0;$i=1; foreach ($db->query("SELECT sr.id, st.name, sr.qty, st.price, sr.qty*st.price 'total_price', st.qty 'qty_have' FROM storage_orders sr LEFT JOIN storage st ON(st.id=sr.preparat_id) WHERE sr.date = CURRENT_DATE() AND sr.user_id = $pk ORDER BY sr.preparat_id") as $row): ?>
                                <?php $i=1; foreach ($db->query("SELECT sr.id, st.name, sr.date, sr.qty, st.price, sr.qty*st.price 'total_price', st.qty 'qty_have' FROM storage_orders sr LEFT JOIN storage st ON(st.id=sr.preparat_id) WHERE sr.user_id = $pk ORDER BY sr.preparat_id") as $row): ?>
                                    <tr id="TR_<?= $row['id'] ?>">
                                        <td><?= $i++ ?></td>
                                        <td><?= date('d.m.Y', strtotime($row['date'])) ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['qty_have'] > $row['qty']): ?>
                                                <span class="text-success"><?= $row['qty_have'] ?></span>
                                            <?php else: ?>
                                                <span class="text-danger"><?= $row['qty_have'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= $row['qty'] ?></td>
                                        <td class="text-center table-primary">
                                            <input type="number" id="input_count-<?= $row['id'] ?>"
                                                data-price="<?= $row['price'] ?>" class="form-control counts"
                                                min="1" max="<?= $row['qty_have'] ?>"
                                                name="orders[<?= $row['id'] ?>]" value="<?= ($row['qty_have'] < $row['qty']) ? $row['qty_have'] : $row['qty'] ?>"
                                                style="border-width: 0px 0; padding: 0.2rem 0;" disabled>
                                        </td>
                                        <td class="text-right"><?= number_format($row['price']) ?></td>
                                        <td class="text-right"><?= number_format($row['total_price']); ?></td>
                                        <td class="text-right">
                                            <div class="list-icons">
                                                <a onclick="Delete('<?= del_url($row['id'], 'StorageOrdersModel') ?>', '#TR_<?= $row['id'] ?>')" href="#" class="list-icons-item text-danger-600"><i class="icon-x"></i></a>
                                                <input type="checkbox" class="swit" value="input_count-<?= $row['id'] ?>" onchange="On_check(this)">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-secondary">
                                    <th colspan="7" class="text-right">Итого:</th>
                                    <th class="text-right" id="total_cost">0</th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" id="btn_send" class="btn btn-outline-success btn-sm">Отправить</button>
                    </div>

                </div>

            </div>
        </form>
        <script type="text/javascript">
            function Delete(url, tr) {
                event.preventDefault();
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (data) {
                        $(tr).css("background-color", "rgb(244, 67, 54)");
                        $(tr).css("color", "white");
                        $(tr).fadeOut(900, function() {
                            $(tr).remove();
                        });
                    },
                });
            };

            function SendVerification(){
                var btn = document.getElementById('btn_send');
                var total_cost = document.getElementById('total_cost');
                var sum = Number(total_cost.textContent.replace(/,/g,''));
                if (sum > 0) {
                    btn.disabled = false;
                }else {
                    btn.disabled = true;
                }
            }

            $(".counts").keyup(function() {
                var total_cost = document.getElementById('total_cost');
                var sum = Number(total_cost.textContent.replace(/,/g,''));
                var inputs = document.getElementsByClassName('counts');
                var new_sum = 0;

                for (var input of inputs) {
                    if (!input.disabled) {
                        new_sum += Number(input.value * input.dataset.price);
                    }
                }
                total_cost.textContent = number_format(new_sum, 1);
                SendVerification();
            });

            function On_check(check) {
                var input = $('#'+check.value);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
                SendVerification();
            }

            function Downsum(input) {
                var input_total = $('#total_cost');
                var total = Number(input_total.text().replace(/,/g,''));
                var new_total = number_format(total - Number(input.val() * input.data().price), 1);
                input_total.text(new_total);
            }

            function Upsum(input) {
                var input_total = $('#total_cost');
                var total = Number(input_total.text().replace(/,/g,''));
                var new_total = number_format(total + Number(input.val() * input.data().price), 1);
                input_total.text(new_total);
            }

            function tot_sum(the, price) {
                var total = $('#total_price');
                var cost = total.text().replace(/,/g,'');
                if (the.checked) {
                    service[the.value] = $("#count_input_"+the.value).val();
                    total.text( number_format(Number(cost) + (Number(price) * service[the.value]), '.', ',') );
                }else {
                    total.text( number_format(Number(cost) - (Number(price) * service[the.value]), '.', ',') );
                    delete service[the.value];
                }
                // console.log(service);
            }
            $('.swit').click();
        </script>
        <?php
    }

    public function form_order($pk = null)
    {
        global $db, $classes;
        ?>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="parent_id" value="<?= $pk ?>">

            <div class="<?= $classes['card'] ?>">

                <div class="<?= $classes['card-header'] ?>">
                    <h5 class="card-title">Список препаратов</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <button type="button" class="btn list-icons-item text-danger" onclick="CallMed(<?= $pk ?>)">Вызвать</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive card">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width: 70px">№</th>
                                    <th style="width: 50%">Препарат</th>
                                    <th class="text-center">На складе</th>
                                    <th class="text-center">Ко-во (требуется)</th>
                                    <th class="text-center" style="width: 100px">Ко-во</th>
                                    <th class="text-right">Цена ед.</th>
                                    <th class="text-right">Сумма</th>
                                    <th class="text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_cost=0;$i=1; foreach ($db->query("SELECT sr.id, st.name, sr.qty, st.price, sr.qty*st.price 'total_price', st.qty 'qty_have' FROM storage_orders sr LEFT JOIN storage st ON(st.id=sr.preparat_id) WHERE sr.date = CURRENT_DATE() AND sr.parent_id = $pk ORDER BY st.name ASC") as $row): ?>
                                    <tr id="TR_<?= $row['id'] ?>">
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['qty_have'] > $row['qty']): ?>
                                                <span class="text-success"><?= $row['qty_have'] ?></span>
                                            <?php else: ?>
                                                <span class="text-danger"><?= $row['qty_have'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= $row['qty'] ?></td>
                                        <td class="text-center table-primary">
                                            <input type="number" id="input_count-<?= $row['id'] ?>"
                                                data-price="<?= $row['price'] ?>" class="form-control counts"
                                                min="1" max="<?= $row['qty_have'] ?>"
                                                name="orders[<?= $row['id'] ?>]" value="<?= ($row['qty_have'] < $row['qty']) ? $row['qty_have'] : $row['qty'] ?>"
                                                style="border-width: 0px 0; padding: 0.2rem 0;" disabled>
                                        </td>
                                        <td class="text-right"><?= number_format($row['price']) ?></td>
                                        <td class="text-right">
                                            <?php
                                            $total_cost += $row['total_price'];
                                            echo number_format($row['total_price']);
                                            ?>
                                        </td>
                                        <td class="text-right">
                                            <div class="list-icons">
                                                <a onclick="Delete('<?= del_url($row['id'], 'StorageOrdersModel') ?>', '#TR_<?= $row['id'] ?>')" href="#" class="list-icons-item text-danger-600"><i class="icon-x"></i></a>
                                                <input type="checkbox" class="swit" value="input_count-<?= $row['id'] ?>" onchange="On_check(this)">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-secondary">
                                    <th colspan="6" class="text-right">Итого:</th>
                                    <th class="text-right" id="total_cost"></th>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" id="btn_send" class="btn btn-outline-success btn-sm">Отправить</button>
                    </div>

                </div>

            </div>

        </form>
        <script type="text/javascript">
            function Delete(url, tr) {
                event.preventDefault();
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (data) {
                        $(tr).css("background-color", "rgb(244, 67, 54)");
                        $(tr).css("color", "white");
                        $(tr).fadeOut(900, function() {
                            $(tr).remove();
                        });
                    },
                });
            };

            function SendVerification(){
                var btn = document.getElementById('btn_send');
                var total_cost = document.getElementById('total_cost');
                var sum = Number(total_cost.textContent.replace(/,/g,''));
                if (sum > 0) {
                    btn.disabled = false;
                }else {
                    btn.disabled = true;
                }
            }

            $(".counts").keyup(function() {
                var total_cost = document.getElementById('total_cost');
                var sum = Number(total_cost.textContent.replace(/,/g,''));
                var inputs = document.getElementsByClassName('counts');
                var new_sum = 0;

                for (var input of inputs) {
                    if (!input.disabled) {
                        new_sum += Number(input.value * input.dataset.price);
                    }
                }
                total_cost.textContent = number_format(new_sum, 1);
                SendVerification();
            });

            function On_check(check) {
                var input = $('#'+check.value);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
                SendVerification();
            }

            function Downsum(input) {
                var input_total = $('#total_cost');
                var total = Number(input_total.text().replace(/,/g,''));
                var new_total = number_format(total - Number(input.val() * input.data().price), 1);
                input_total.text(new_total);
            }

            function Upsum(input) {
                var input_total = $('#total_cost');
                var total = Number(input_total.text().replace(/,/g,''));
                var new_total = number_format(total + Number(input.val() * input.data().price), 1);
                input_total.text(new_total);
            }

            function tot_sum(the, price) {
                var total = $('#total_price');
                var cost = total.text().replace(/,/g,'');
                if (the.checked) {
                    service[the.value] = $("#count_input_"+the.value).val();
                    total.text( number_format(Number(cost) + (Number(price) * service[the.value]), '.', ',') );
                }else {
                    total.text( number_format(Number(cost) - (Number(price) * service[the.value]), '.', ',') );
                    delete service[the.value];
                }
                // console.log(service);
            }
            $('.swit').click();
        </script>
        <?php
    }

    public function form_refund()
    {
        global $db;
        ?>
        <form method="get" action="<?= del_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" id="input_id">

            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="input_name" disabled>
                </div>
                <div class="form-group">
                    <label>Кол-во:</label>
                    <input type="number" class="form-control" id="input_qty" name="qty" placeholder="Введите колличество" min="1" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Отправить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        $db->beginTransaction();
        foreach ($this->post['orders'] as $order_pk => $qty) {
            $order = $db->query("SELECT * FROM storage_orders WHERE id=$order_pk")->fetch();
            $post = $db->query("SELECT * FROM storage WHERE id = {$order['preparat_id']}")->fetch();
            if($post['qty'] < $qty){
                $this->error("В аптеке не хватает \"{$post['name']}\"!");
            }
            unset($post['add_date']);
            $post['parent_id'] = $this->post['parent_id'];
            $post['status'] = level($post['parent_id']);
            // расход препеарата
            $object = Mixin\update('storage', array('qty' => $post['qty']-$qty, 'qty_sold' => $post['qty_sold']+$qty), $order['preparat_id']);

            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
            $arr = array(
                'code' => $post['code'], 'name' => $post['name'],
                'supplier' => $post['supplier'], 'qty' => $qty,
                'price' => $post['price'], 'amount' => $qty * $post['price'],
                'parent_id' => $post['parent_id']);
            $this->add_sales($arr);
            unset($post['qty_sold']);
            $post['qty'] = $qty;
            $this->storage_home($post);
            $object = Mixin\delete('storage_orders', $order_pk);
        }
        $db->commit();
        $this->success();
    }

    public function add_sales($arr)
    {
        global $db;
        $object = Mixin\insert('storage_sales', $arr);
        if (!intval($object)) {
            $this->error('storage_sales '.$object);
            $db->rollBack();
        }
    }

    public function storage_home($post)
    {
        global $db;
        $post['preparat_id'] = $post['id']; unset($post['id']);
        unset($post['qty_limit']);
        if ($pk = $db->query("SELECT id, qty FROM storage_home WHERE preparat_id = {$post['preparat_id']} AND status = {$post['status']} AND category = {$post['category']}")->fetch()) {
            $object = Mixin\update('storage_home', array('qty' => $pk['qty']+$post['qty']), $pk['id']);
            if (!intval($object)) {
                $this->error('storage_home '.$object);
                $db->rollBack();
            }
        }else {
            $object = Mixin\insert('storage_home', $post);
            if (!intval($object)) {
                $this->error('storage_home '.$object);
                $db->rollBack();
            }
        }

    }

    public function delete(int $pk)
    {
        global $db;
        $qty = $_GET['qty'];
        $db->beginTransaction();

        $info = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch();
        $qty_original = $info['qty'];
        if ($info2 = $db->query("SELECT * FROM storage WHERE id = {$info['preparat_id']}")->fetch()) {
            $object = Mixin\update('storage', array('qty' => $info2['qty']+$qty, 'qty_sold' => $info2['qty_sold']-$qty), $info['preparat_id']);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
        }else {
            $info['id'] = $info['preparat_id']; unset($info['preparat_id']); unset($info['status']); unset($info['qty_sold']);
            $info['add_date'] = date("Y-m-d");
            $info['qty'] = $qty;
            $object = Mixin\insert('storage', $info);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
        }

        $arr = array(
            'code' => $info['code'], 'name' => $info['name'],
            'supplier' => $info['supplier'], 'qty' => -$qty,
            'price' => $info['price'], 'amount' => -$qty * $info['price'],
            'parent_id' => $info['parent_id']);
        $this->add_sales($arr);
        if ($qty == $qty_original) {
            $object = Mixin\delete($this->table, $pk);
        }else {
            $object = Mixin\update($this->table, array('qty' => $qty_original - $qty), $pk);
        }
        if ($object) {
            $db->commit();
            $this->success();
        } else {
            Mixin\error('404');
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