<?php

class Collection extends Model
{
    public $table = 'collection';

    public function form($pk = null)
    {
        global $db, $session;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="level" value="<?= $session->get_level(); ?>">
            <input type="hidden" name="parent_id" value="<?= $session->session_id; ?>">

            <?php
            $inc = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (1) AND DATE_FORMAT(price_date, '%Y-%m-%d') = CURRENT_DATE()")->fetch();
            $activity = $db->query("SELECT id FROM collection WHERE level IN (4) AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->fetchColumn();
            ?>


            <table class="table table-hover">
                <tbody>
                    <?php if($activity): ?>
                        <tr class="bg-success text-center">
                            <td>Инкассация проведенна</td>
                        </tr>
                    <?php else: ?>
                        <tr class="bg-danger text-center">
                            <td>Инкассация не проведенна</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <table class="table table-hover">
                <tbody>
                    <tr class="table-secondary">
                        <td>Наличные</td>
                        <td class="text-right <?= ($inc['price_cash'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_cash']) ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Пластик</td>
                        <td class="text-right <?= ($inc['price_card'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_card']) ?></td>
                    </tr>
                    <tr class="table-secondary">
                        <td>Перечисление</td>
                        <td class="text-right <?= ($inc['price_transfer'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_transfer']) ?></td>
                    </tr>
                </tbody>
            </table>


            <div class="row">

                <div class="col-8">
                    <div class="form-group">
                        <label class="col-form-label">Сумма инкассации:</label>
                        <input type="number" name="amount_bank" step="0.5" class="form-control" placeholder="Введите сумму инкассации" value="<?= (!$activity) ? $inc : '' ?>">
                    </div>
                </div>

                <div class="col-4 text-right">
                    <button type="submit" class="mt-5 btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Оплатить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>

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