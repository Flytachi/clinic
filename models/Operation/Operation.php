<?php

class OperationModel extends Model
{
    public $table = 'operation';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * from division WHERE level = 5") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Дата:</label>
                    <input type="date" class="form-control" name="oper_date">
                </div>

                <div class="col-md-2">
                    <label>Время:</label>
                    <input type="time" class="form-control" name="oper_time">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="item_id" id="item_id" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * from service WHERE user_level = 5 AND type = 3") as $row): ?>
                            <option class="text-danger" value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#item_id").chained("#division_id");
            });
        </script>
        <?php
    }

    public function form_oper_update($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" id="oper_id">

            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Дата:</label>
                        <input type="date" class="form-control" name="oper_date" id="oper_date">
                    </div>

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="oper_time" id="oper_time">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form_finish($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="Chek_fin_date()" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" id="finish_id">
            <input type="hidden" name="visit_id" id="visit_id">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Дата завершения операции</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Дата:</label>
                        <input type="date" class="form-control" name="finish_date" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="finish_time">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            function Chek_fin_date() {
                if (event.target.dataset.c_date > event.target.finish_date.value +" "+ event.target.finish_time.value) {
                    event.preventDefault();
                    new Noty({
                        text: 'Дата завершения не может быть меньше даты операции!',
                        type: 'error'
                    }).show();
                }
            }
        </script>
        <?php
    }

    public function clean()
    {
        if ($this->post['finish_date']) {
            $this->post['completed'] = $this->post['finish_date']." ".$this->post['finish_time'];
            unset($this->post['finish_date']);
            unset($this->post['finish_time']);
        }elseif ($this->post['oper_date']){
            $this->post['oper_date'] .= " ".$this->post['oper_time'];
            unset($this->post['oper_time']);
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
            $db->beginTransaction();

            if ($this->post['completed']) {
                $post_price = $db->query("SELECT id, item_cost FROM visit_price WHERE operation_id = {$pk} AND visit_id = {$this->post['visit_id']}")->fetch();
                unset($this->post['visit_id']);
                $post_price_pk = $post_price['id']; unset($post_price['id']);
                $post_price['item_cost'] = $db->query("SELECT SUM(item_cost) FROM operation WHERE id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(price) FROM operation_member WHERE operation_id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(item_cost) FROM operation_service WHERE operation_id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(item_cost*item_qty) FROM operation_preparat WHERE operation_id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(item_cost) FROM operation_consumables WHERE operation_id = {$pk}")->fetchColumn();
                $this->storage_sales($pk);
                // обновление цены
                $object = Mixin\update('visit_price', $post_price, $post_price_pk);
                if (!intval($object)){
                    $this->error($object);
                }
            }

            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }
            $db->commit();
            $this->success();

        }
    }

    public function storage_sales($pk)
    {
        global $db;
        $sql = "SELECT st.id, st.code,
                    st.name, st.supplier,
                    opp.item_qty 'qty',
                    (st.qty - opp.item_qty) 'storage_qty',
                    (st.qty_sold + opp.item_qty) 'storage_qty_sold',
                    (st.price * opp.item_qty) 'amount',
                    st.price, $pk 'operation_id'
                FROM operation_preparat opp
                    LEFT JOIN storage st ON(st.id=opp.item_id)
                WHERE opp.operation_id = $pk";
        foreach ($db->query($sql) as $post) {
            $object = Mixin\update('storage', array('qty' => $post['storage_qty'], 'qty_sold' => $post['storage_qty_sold']), $post['id']);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
            unset($post['id'], $post['storage_qty'], $post['storage_qty_sold']);
            $this->add_sales($post);
        }
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

    public function save()
    {
        global $db;
        if($this->clean()){
            $db->beginTransaction();
            $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['item_id']}")->fetch();
            $this->post['item_name'] = $service['name'];
            $this->post['item_cost'] = $service['price'];
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
            }
            $post['visit_id'] = $this->post['visit_id'];
            $post['operation_id'] = $object;
            $post['user_id'] = $this->post['user_id'];
            $post['item_type'] = 5;
            $post['item_id'] = $this->post['item_id'];
            $post['item_cost'] = $service['price'];
            $post['item_name'] = $service['name'];
            $object = Mixin\insert('visit_price', $post);
            if (!intval($object)){
                $this->error($object);
            }
            $db->commit();
            $this->success();
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
