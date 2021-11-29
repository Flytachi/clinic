<?php

class VisitInitialModel extends Model
{
    public $table = 'visit_initial';
    public $_visits = "visits";

    public function form($pk = null)
    {
        global $classes, $session;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Задать начальные параметры</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="visit_id" value="<?= $_GET['visit_id'] ?>">
            <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <label>Вес:</label>
                        <div class="form-group form-group-feedback form-group-feedback-right">
                            <input type="number" name="weight" value="<?= $this->value('weight') ?>" class="form-control" placeholder="Введите вес" step="0.1" min="0" max="300">
                            <div class="form-control-feedback">Кг</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Рост:</label>
                        <div class="form-group form-group-feedback form-group-feedback-right">
                            <input type="number" name="height" value="<?= $this->value('height') ?>" class="form-control" placeholder="Введите рост" step="0.1" min="0" max="500">
                            <div class="form-control-feedback">См</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Температура:</label>
                        <div class="form-group form-group-feedback form-group-feedback-right">
                            <input type="number" name="temperature" value="<?= $this->value('temperature') ?>" class="form-control" placeholder="Введите температуру" step="0.1" min="30" max="45">
                        </div>
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
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success($stat=null)
    {   
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message, $stat=null)
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