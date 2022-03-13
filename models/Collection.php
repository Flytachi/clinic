<?php

class Collection extends Model
{
    public $table = 'collection';

    public function form($pk = null)
    {
        global $session;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="level" value="<?= $session->get_level(); ?>">
            <input type="hidden" name="parent_id" value="<?= $session->session_id; ?>">


            <div class="form-group row">
                <div class="col-md-8">
                    <label class="col-form-label">Сумма инкассации:</label>
                    <input type="number" name="amount_bank" step="0.5" class="form-control" placeholder="Введите сумму инкассации">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Сумма инкассации:</label>
                    <input type="text" name="comment" class="form-control" placeholder="Введите комментарий">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Оплатить</span>
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