<?php

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

?>