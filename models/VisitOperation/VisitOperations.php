<?php

class VisitOperationsModel extends Model
{
    public $table = 'visit_operations';
    public $_prices = 'visit_prices';
    public $_services = 'services';
    public $_user = 'users';

    public function get_or_404(int $pk)
    {
        global $db, $session;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object and $session->session_id == $object['grant_id']){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
            exit;
        }

    }

    public function form($pk = null)
    {
        global $db, $classes;
        $patient = json_decode($_GET['patient']);
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Назначить операцию</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Отдел:</label>
                        <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 5") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Дата:</label>
                        <input type="date" class="form-control" name="operation_date">
                    </div>

                    <div class="col-md-2">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="operation_time">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label>Услуга:</label>
                        <select data-placeholder="Выберите услугу" name="operation_id" id="operation_id" class="<?= $classes['form-select_price'] ?>" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM services WHERE user_level = 5 AND type = 3") as $row): ?>
                                <option class="text-danger" value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= number_format(($patient->is_foreigner) ? $row['price_foreigner'] : $row['price']) ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Назначить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#operation_id").chained("#division_id");
            });
        </script>
        <?php
        $this->jquery_init();
    }

    public function form_operation_date($pk = null)
    {
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h5 class="modal-title">Переназначить дату операций</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Дата:</label>
                        <input type="date" class="form-control" name="operation_date" value="<?= $this->value('operation_date') ?>">
                    </div>

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="operation_time" value="<?= $this->value('operation_time') ?>">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }
    
    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        global $db;
        $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_user WHERE id = {$this->post['user_id']}")->fetchColumn();
        if($this->clean()){
            $db->beginTransaction();

            // Visit Operation
            $service = $db->query("SELECT * FROM $this->_services WHERE id = {$this->post['operation_id']}")->fetch();
            $this->post['operation_name'] = $service['name'];
            $this->post['operation_cost'] = ($this->is_foreigner) ? $service['price_foreigner'] : $service['price'];
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
                exit;
            }

            // Visit price
            $post_price['visit_id'] = $this->post['visit_id'];
            $post_price['visit_service_id'] = $object;
            $post_price['user_id'] = $this->post['user_id'];
            $post_price['item_type'] = 3;
            $post_price['item_id'] = $service['id'];
            $post_price['item_cost'] = ($this->is_foreigner) ? $service['price_foreigner'] : $service['price'];
            $post_price['item_name'] = $service['name'];
            $post_price['is_visibility'] =  null;
            $object = Mixin\insert($this->_prices, $post_price);
            if (!intval($object)){
                $this->error($object);
                $db->rollBack();
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