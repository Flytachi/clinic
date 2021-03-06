<?php

class Storage extends Model
{
    public $table = 'storage';
    public $table_label = array(
        'id' => 'id',
        'code' => 'Код',
        'name' => 'Препарат',
        'supplier' => 'Поставщик',
        'category' => 'Категория(2,3,4)',
        'qty' => 'Кол-во',
        'qty_limit' => 'Лимит',
        'cost' => 'Цена прихода',
        'price' => 'Цена расхода',
        'faktura' => 'Счёт фактура',
        'shtrih' => 'Штрих код',
        'add_date' => 'Дата поставки',
        'die_date' => 'Срок годности',
    );

    public function form_template($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="form-group">
                <label>Шаблон:</label>
                <input type="file" class="form-control" name="template" accept="application/vnd.ms-excel" required>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form($pk = null)
    {
        global $CATEGORY;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group">
               <label>Препарат:</label>
               <input type="text" class="form-control" name="name" placeholder="Введите название препарата" required value="<?= $post['name'] ?>">
            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Код:</label>
                    <input type="text" class="form-control" name="code" placeholder="Введите код" required value="<?= $post['code'] ?>">
                </div>

                <div class="col-md-9">
                    <label>Поставщик:</label>
                    <input type="text" class="form-control" name="supplier" placeholder="Введите поставщик" required value="<?= $post['supplier'] ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Кол-во:</label>
                    <input type="text" class="form-control" name="qty" placeholder="Введите колличество" required value="<?= $post['qty'] ?>">
                </div>

                <div class="col-md-4">
                    <label>Цена прихода:</label>
                    <input type="text" class="form-control" name="cost" placeholder="Введите цену" required value="<?= $post['cost'] ?>">
                </div>

                <div class="col-md-4">
                    <label>Цена расхода:</label>
                    <input type="text" class="form-control" name="price" placeholder="Введите цену" required value="<?= $post['price'] ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Категория:</label>
                    <select data-placeholder="Выбрать этаж" name="category" class="form-control form-control-select2" required>
                        <option></option>
                        <?php
                        foreach ($CATEGORY as $key => $value) {
                            ?>
                            <option value="<?= $key ?>" <?= ($post['category'] == $key) ? 'selected': '' ?>><?= $value ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Дата прихода:</label>
                    <input type="date" class="form-control" name="add_date" placeholder="Введите дату" required value="<?= $post['add_date'] ?>">
                </div>

                <div class="col-md-3">
                    <label>Срок годности:</label>
                    <input type="date" class="form-control" name="die_date" placeholder="Введите дату" required value="<?= $post['die_date'] ?>">
                </div>

            </div>

            <div class="form-group">
               <label>Счёт фактура:</label>
               <input type="text" class="form-control" name="faktura" placeholder="Введите счёт" required value="<?= $post['faktura'] ?>">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-success btn-sm">Добавить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        if($_FILES['template']){
            // prit('temlate');
            $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
            $this->save_excel();
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function clean_excel()
    {
        if ($this->table_label) {
            foreach ($this->table_label as $key => $value) {
                $post[$key] = $this->post[$value];
            }
            $this->post = $post;
        }
        $this->post['parent_id'] = $_SESSION['session_id'];
        $this->post['cost'] = preg_replace("/,+/", "", $this->post['cost']);
        $this->post['price'] = preg_replace("/,+/", "", $this->post['price']);
        return True;
    }

    public function save_excel()
    {
        global $db;
        $db->beginTransaction();
        foreach ($this->post['template'] as $key_p => $value_p) {
            if ($key_p) {
                foreach ($value_p as $key => $value) {
                    $pick = $pirst[$key];
                    $this->post[$pick] = $value;
                }
                if($this->clean_excel()){
                    $object = Mixin\insert_or_update($this->table, $this->post);
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
            }else {
                $pirst = $value_p;
                unset($this->post['template']);
            }
        }
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}

class StorageOrdersModel extends Model
{
    public $table = 'storage_orders';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="preparat_id" class="form-control select-price" required <?= ($pk) ? "disabled" : "data-fouc" ?>>
                            <option></option>
                            <?php if (permission(11)): ?>
                                <?php $sql = "SELECT st.id, st.price, st.name, st.supplier, st.die_date,
                                    (
                                        st.qty -
                                        IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) -
                                        IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)
                                    ) 'qty'
                                    FROM storage st WHERE st.category = 4 AND st.qty != 0"; ?>
                            <?php else: ?>
                                <?php $sql = "SELECT st.id, st.price, st.name, st.supplier, st.die_date,
                                                (
                                                    st.qty -
                                                    IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) -
                                                    IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)
                                                ) 'qty'
                                                FROM storage st WHERE st.category IN (2, 3) AND st.qty != 0"; ?>
                            <?php endif; ?>
                            <?php foreach ($db->query($sql) as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" <?= ($post['preparat_id'] == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Количество:</label>
                        <input type="number" name="qty" value="<?= $post['qty'] ?>" class="form-control">
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        $this->post['date'] = date('Y-m-d');
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if (!$this->post['id']) {
            $inf = $db->query("SELECT id, qty FROM storage_orders WHERE preparat_id = {$this->post['preparat_id']} AND parent_id = {$this->post['parent_id']}")->fetch();
            if ($inf) {
                $this->post['id'] = $inf['id'];
                $this->post['qty'] = $inf['qty'] + $this->post['qty'];
                $this->update();
            }
            return True;
        }
        return true;

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

class StorageHomeModel extends Model
{
    public $table = 'storage_home';

    public function form($pk = null)
    {
        global $db, $pk;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="card border-1 border-info">

                <div class="card-header text-dark header-elements-inline alpha-info">
                    <h5 class="card-title">Список лекарств пациента</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <select data-placeholder="Выберите специалиста" name="parent_id" onchange="CallMed(this.value)" class="form-control form-control-select2" required>
                                <option></option>
                                <?php
                                foreach($db->query("SELECT * from users WHERE user_level = 7") as $row) {
                                    ?>
                                    <option value="<?= $row['id'] ?>" ><?= get_full_name($row['id']) ?></option>
                                    <?php
                                }
                                ?>
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
                                <?php $total_cost=0;$i=1; foreach ($db->query("SELECT sr.id, st.name, sr.qty, st.price, sr.qty*st.price 'total_price', st.qty 'qty_have' FROM storage_orders sr LEFT JOIN storage st ON(st.id=sr.preparat_id) WHERE sr.date = CURRENT_DATE() AND sr.user_id = $pk ORDER BY sr.preparat_id") as $row): ?>
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
                                            <input type="number" class="form-control" name="orders[<?= $row['id'] ?>]" value="<?= ($row['qty_have'] < $row['qty']) ? $row['qty_have'] : $row['qty'] ?>" style="border-width: 0px 0; padding: 0.2rem 0;">
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
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-secondary">
                                    <td colspan="6" class="text-right"><b>Итого:</b></td>
                                    <td class="text-right"><b><?= number_format($total_cost) ?></b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-success btn-sm">Отправить</button>
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
        </script>
        <?php
    }

    public function form_order($pk = null)
    {
        global $db, $pk;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="parent_id" value="<?= $pk ?>">

            <div class="card border-1 border-info">

                <div class="card-header text-dark header-elements-inline alpha-info">
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
                                            <input type="number" class="form-control" name="orders[<?= $row['id'] ?>]" value="<?= ($row['qty_have'] < $row['qty']) ? $row['qty_have'] : $row['qty'] ?>" style="border-width: 0px 0; padding: 0.2rem 0;">
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
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-secondary">
                                    <td colspan="6" class="text-right"><b>Итого:</b></td>
                                    <td class="text-right"><b><?= number_format($total_cost) ?></b></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-success btn-sm">Отправить</button>
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
        </script>
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
        $this->mod('test');
        // $db->commit();
        // $this->success();
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
        $db->beginTransaction();

        $info = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch();
        if ($info2 = $db->query("SELECT * FROM storage WHERE id = {$info['preparat_id']}")->fetch()) {
            $object = Mixin\update('storage', array('qty' => $info2['qty']+$info['qty'], 'qty_sold' => $info2['qty_sold']-$info['qty']), $info['preparat_id']);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
        }else {
            $info['id'] = $info['preparat_id']; unset($info['preparat_id']); unset($info['status']); unset($info['qty_sold']);
            $info['add_date'] = date("Y-m-d");
            $object = Mixin\insert('storage', $info);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
        }

        $arr = array(
            'code' => $info['code'], 'name' => $info['name'],
            'supplier' => $info['supplier'], 'qty' => -$info['qty'],
            'price' => $info['price'], 'amount' => -$info['qty'] * $info['price'],
            'parent_id' => $info['parent_id']);
        $this->add_sales($arr);

        $object = Mixin\delete($this->table, $pk);
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

class StorageHomeForm extends Model
{
    public $table = 'storage_home';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="product" class="form-control select-price" required data-fouc>
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM storage_home WHERE status = 7") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <label>Количество:</label>
                            <input type="number" name="qty" value="1" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        $order = $db->query("SELECT * FROM $this->table WHERE id={$this->post['product']}")->fetch();
        $post['visit_id'] = $this->post['visit_id'];
        $post['user_id'] = $this->post['user_id'];
        $post['item_id'] = $order['preparat_id'];
        $post['item_type'] = 3;
        $post['item_cost'] = $order['price'];
        $post['item_name'] = $order['name'];
        if ($order['qty'] > $this->post['qty']) {
            $object = Mixin\update($this->table, array('qty' => $order['qty']-$this->post['qty'], 'qty_sold' => $order['qty_sold']+$this->post['qty']), $this->post['product']);
        }elseif ($order['qty'] == $this->post['qty']) {
            $object = Mixin\delete($this->table, $this->post['product']);
        }else {
            $this->error('Нехватает препарата на складе');
        }
        if (!intval($object)) {
            $this->error('storage_preparat: '.$object);
        }
        for ($i=0; $i < $this->post['qty']; $i++) {
            $object = Mixin\insert('visit_price', $post);
            if (!intval($object)) {
                $this->error('visit_price: '.$object);
            }
        }
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}

class StorageSale extends Model
{
    public $table = 'storage';

    public function form()
    {
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="table-responsive card">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-info">
                            <th style="width:55%">Препарат</th>
                            <th class="text-right" style="width: 100px">Кол-во</th>
                            <th class="text-right">Цена ед.</th>
                            <th class="text-right" style="width:50px">Действия</th>
                        </tr>
                    </thead>
                    <tbody id="sale_items">

                    </tbody>
                    <tbody>
                        <tr class="table-secondary">
                            <th colspan="2" class="text-right">Итого:</th>
                            <th class="text-right" id="total_cost">0</th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-right">
                <input type="submit" name="btn_type" value="Возврат" class="btn btn-outline-danger btn-sm">
                <input type="submit" name="btn_type" value="Продажа" class="btn btn-outline-success btn-sm">
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        // $this->mod('test');
        $db->beginTransaction();
        if (!$this->post['preparat']) {
            $this->error('Пустой запрос!');
        }
        foreach ($this->post['preparat'] as $key => $value) {
            if ($this->post['btn_type'] == "Продажа") {
                $qty = $this->post['qty'][$key];
                if ($qty > $value) {
                    $this->error('Ошибка в колличестве!');
                }
            }else {
                $qty = -$this->post['qty'][$key];
            }
            $post = $db->query("SELECT * FROM storage WHERE id = $key")->fetch();
            unset($post['add_date']);
            $post['parent_id'] = $this->post['parent_id'];
            // расход препеарата
            $object = Mixin\update('storage', array('qty' => $post['qty']-$qty, 'qty_sold' => $post['qty_sold']+$qty), $key);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
            $arr = array(
                'code' => $post['code'], 'name' => $post['name'],
                'supplier' => $post['supplier'], 'qty' => $qty,
                'price' => $post['price'], 'amount' => $qty * $post['price']);
            $this->add_sales($arr);
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
