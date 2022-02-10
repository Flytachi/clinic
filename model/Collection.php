<?php

use Mixin\Model;

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

            <?php if(permission(4)): ?>

                <?php
                $inc = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (2,3,4) AND DATE_FORMAT(price_date, '%Y-%m-%d') = CURRENT_DATE()")->fetch();
                $pharm = $db->query("SELECT SUM(amount_cash) 'price_cash', SUM(amount_card) 'price_card', SUM(amount_transfer) 'price_transfer' FROM storage_sales WHERE DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->fetch();
                $value = round($inc['price_cash'] + $pharm['price_cash']);
                $activity = $db->query("SELECT id FROM collection WHERE level IN (4) AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->fetchColumn();
                ?>

                <div class="row">

                    <div class="col-12">
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
                    </div>

                    <div class="col-6">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="table-secondary">
                                    <td>Наличные</td>
                                    <td class="text-right <?= ($value > 0) ? 'text-success' : '' ?>"><?= number_format($value) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Пластик</td>
                                    <td class="text-right <?= ($inc['price_card'] + $pharm['price_card'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_card'] + $pharm['price_card']) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Перечисление</td>
                                    <td class="text-right <?= ($inc['price_transfer'] + $pharm['price_transfer'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_transfer'] + $pharm['price_transfer']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-3">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="table-secondary">
                                    <td>Наличные (внутренняя)</td>
                                    <td class="text-right <?= ($inc['price_cash'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_cash']) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Пластик (внутренняя)</td>
                                    <td class="text-right <?= ($inc['price_card'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_card']) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Перечисление (внутренняя)</td>
                                    <td class="text-right <?= ($inc['price_transfer'] > 0) ? 'text-success' : '' ?>"><?= number_format($inc['price_transfer']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-3">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="table-secondary">
                                    <td>Наличные (внешняя)</td>
                                    <td class="text-right <?= ($pharm['price_cash'] > 0) ? 'text-success' : '' ?>"><?= number_format($pharm['price_cash']) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Пластик (внешняя)</td>
                                    <td class="text-right <?= ($pharm['price_card'] > 0) ? 'text-success' : '' ?>"><?= number_format($pharm['price_card']) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Перечисление (внешняя)</td>
                                    <td class="text-right <?= ($pharm['price_transfer'] > 0) ? 'text-success' : '' ?>"><?= number_format($pharm['price_transfer']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            <?php else: ?>

                <?php
                $amount = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (1,5,101) AND DATE_FORMAT(price_date, '%Y-%m-%d') = CURRENT_DATE()")->fetch();
                $pharm = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (2,3,4) AND DATE_FORMAT(price_date, '%Y-%m-%d') = CURRENT_DATE()")->fetch();
                $invest = $db->query("SELECT SUM(balance_cash) 'balance_cash', SUM(balance_card) 'balance_card', SUM(balance_transfer) 'balance_transfer' FROM investment WHERE status IS NOT NULL AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->fetch();
                $value = round($amount['price_cash'] + $invest['balance_cash']);
                $activity = $db->query("SELECT id FROM collection WHERE level IN (3,32) AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->fetchColumn();
                ?>

                <div class="row">

                    <div class="col-12">
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
                    </div>

                    <div class="<?= (module('module_pharmacy')) ? 'col-md-6' : 'col-md-12' ?>">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="table-secondary">
                                    <td>Наличные</td>
                                    <td class="text-right <?= ($value > 0) ? 'text-success' : '' ?>"><?= number_format($value) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Пластик</td>
                                    <td class="text-right <?= ($amount['price_card'] + $invest['balance_card'] > 0) ? 'text-success' : '' ?>"><?= number_format($amount['price_card'] + $invest['balance_card']) ?></td>
                                </tr>
                                <tr class="table-secondary">
                                    <td>Перечисление</td>
                                    <td class="text-right <?= ($amount['price_transfer'] + $invest['balance_transfer'] > 0) ? 'text-success' : '' ?>"><?= number_format($amount['price_transfer'] + $invest['balance_transfer']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php if(module('module_pharmacy')): ?>
                        <div class="col-md-6">
                            <table class="table table-hover">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td>Наличные (аптека)</td>
                                        <td class="text-right <?= ($pharm['price_cash'] > 0) ? 'text-success' : '' ?>"><?= number_format($pharm['price_cash']) ?></td>
                                    </tr>
                                    <tr class="table-secondary">
                                        <td>Пластик (аптека)</td>
                                        <td class="text-right <?= ($pharm['price_card'] > 0) ? 'text-success' : '' ?>"><?= number_format($pharm['price_card']) ?></td>
                                    </tr>
                                    <tr class="table-secondary">
                                        <td>Перечисление (аптека)</td>
                                        <td class="text-right <?= ($pharm['price_transfer'] > 0) ? 'text-success' : '' ?>"><?= number_format($pharm['price_transfer']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>

            <?php endif; ?>

            <div class="row">

                <div class="col-8">
                    <div class="form-group">
                        <label class="col-form-label">Сумма инкассации:</label>
                        <input type="number" name="amount_bank" step="0.5" class="form-control" placeholder="Введите сумму инкассации" value="<?= (!$activity) ? $value : '' ?>">
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