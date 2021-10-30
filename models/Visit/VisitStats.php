<?php

class VisitStatsModel extends Model
{
    public $table = 'visit_stats';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db, $session;
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object and ( permission(7) or (config('constant_card_stationar_condition_button') and $session->session_id == $object['grant_id']) ) ){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
        }
    }

    public function form($pk = null)
    {
        global $classes, $session;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Добавить иформацию о показателях</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $pk ?>">
            <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Состояние:</label>
                        <select placeholder="Введите состояние" name="stat" class="form-control form-control-select2">
                            <option value="">Актив</option>
                            <option value="1">Пассив</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Давление:</label>
                        <input type="text" class="form-control" name="pressure" placeholder="Введите давление">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-4">
                        <label>Пульс:</label>
                        <input type="number" class="form-control" name="pulse" min="40" step="1" max="150" value="85" placeholder="Введите пульс" required>
                    </div>

                    <div class="col-md-4">
                        <label>Температура:</label>
                        <input type="number" class="form-control" name="temperature" min="35" step="0.1" max="42" value="36.6" placeholder="Введите температура" required>
                    </div>

                    <div class="col-md-4">
                        <label>Сатурация:</label>
                        <input type="number" class="form-control" name="saturation" min="25" max="100" placeholder="Введите cатурация" required>
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Дыхание:</label>
                        <input type="number" class="form-control" name="breath" min="10" step="1" max="50" placeholder="Введите дыхание">
                    </div>

                    <div class="col-md-6">
                        <label>Моча:</label>
                        <input type="number" class="form-control" name="urine" min="0" step="0.1" max="5">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label">Примечание:</label>
                        <textarea rows="3" cols="3" name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
        $this->jquery_init();
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