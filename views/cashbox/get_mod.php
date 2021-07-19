<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
if ($_GET['pk']) {
    $pk = $_GET['pk'];

    if( isset($_GET['mod']) and $_GET['mod'] == "st"){
        $data = $db->query("SELECT * FROM visits WHERE id = $pk AND completed IS NULL")->fetch();
        // $pk_visit = $ps['id'];
        // $completed = $ps['completed'];
        ?>
        <div class="card border-1 border-dark">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($data['user_id']) ?> - <em><?= get_full_name($data['user_id']) ?></em></b></h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="<?= viv('card/content_1')."?pk=$pk" ?>" class="btn btn-outline-info btn-sm">Перейти к визиту</a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-calculator3 mr-2"></i>Информация
                </legend>

                <?php
                $visit_price_status = (new VisitModel)->price_status($pk);
                dd($data);
                ?>
                <table class="table table-hover">
                    <tbody>
                        <tr class="table-secondary">
                            <td>Баланс</td>
                            <td class="text-right text-success"><?= number_format($visit_price_status['balance']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Сумма к оплате</td>
                            <td class="text-right text-danger"><?= number_format(round($visit_price_status['cost_services'] + $visit_price_status['cost_beds'])) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Скидка</td>
                            <td class="text-right"><?= 0// number_format( ($price['cost_service'] - $price['amount_service']) + (($price['cost_bed'] + $price['cost_beds']) - $price['amount_bed']) ) ?></td>
                        </tr>
                        <?php /*if(module('module_pharmacy')): ?>
                            <tr class="table-secondary">
                                <td>Сумма к оплате(лекарства)</td>
                                <td class="text-right text-danger"><?= number_format(round($price['cost_item_2'])) ?></td>
                            </tr>
                        <?php endif;*/ ?>
                        <tr class="table-secondary">
                            <td>Разница</td>
                            <?php /*if (($price['balance'] + $price_cost) > 0): ?>
                                <td class="text-right text-success"><?= number_format($price['balance'] + $price_cost) ?></td>
                            <?php elseif(($price['balance'] + $price_cost) < 0): ?>
                                <td class="text-right text-danger"><?= number_format($price['balance'] + $price_cost) ?></td>
                            <?php else: ?>
                                <td class="text-right text-dark"><?= number_format($price['balance'] + $price_cost) ?></td>
                            <?php endif;*/ ?>
                        </tr>
                        <input type="hidden" id="prot_item" value="<?= 0//$price['balance'] + $price_cost ?>">
                    </tbody>
                </table>

                <div class="text-right mt-3">

                    <?php (new VisitPricesModel)->form_button($pk) ?>

                </div>

                <div id="detail_div"></div>

            </div>
        </div>
        <?php
    }elseif ( isset($_GET['mod']) and $_GET['mod'] == "rf"){
        $data = $db->query("SELECT * FROM visits WHERE id = $pk AND completed IS NULL")->fetch();
        ?>
        <div class="card border-1 border-dark">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($data['user_id']) ?> - <em><?= get_full_name($data['user_id']) ?></em></b></h5>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-bag mr-2"></i>Услуги
                </legend>

                <div class="table-responsive card">
                    <table class="table table-hover table-sm">
                        <thead class="<?= $classes['table-thead'] ?>">
                            <tr>
                                <th class="text-left">Дата назначения</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Дата оплаты</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT vss.id, vss.parent_id, vss.add_date, vss.service_name, (vp.price_cash + vp.price_card + vp.price_transfer) 'item_cost', vp.price_date FROM visit_services vss LEFT JOIN visit_prices vp ON(vp.visit_service_id=vss.id) WHERE vss.visit_id = $pk AND vss.status = 5") as $row): ?>
                                <tr id="tr_VisitServicesModel_<?= $row['id'] ?>">
                                    <input type="hidden" class="prices_class" value="<?= $row['id'] ?>">
                                    <td><?= date_f($row['add_date'], 1) ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td class="text-right total_cost"><?= $row['item_cost'] ?></td>
                                    <td><?= date_f($row['price_date'], 1) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-left">
                    <strong>Итого: </strong><strong id="total_title"></strong>
                </div>
                <div class="text-right">
                    <button onclick="CardFuncCheck('<?= $pk ?>')" type="button" class="<?= $classes['btn-price'] ?>" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

        </div>
        <script type="text/javascript">
            function CardFuncCheck(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPricesModel') ?>",
                    data: {
                        visit_pk: pk,
                        refund: 1,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#form_card").html(result);
                        Swit.init();
                    },
                });
            }
        </script>
        <?php
    }else {
        $data = $db->query("SELECT * FROM visits WHERE id = $pk AND completed IS NULL")->fetch();
        ?>
        <div class="card border-1 border-dark">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($data['user_id']) ?> - <em><?= get_full_name($data['user_id']) ?></em></b></h5>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-bag mr-2"></i>Услуги
                </legend>

                <div class="table-responsive card">
                    <table class="table table-hover table-sm">
                        <thead class="<?= $classes['table-thead'] ?>">
                            <tr>
                                <th class="text-left">Дата назначения</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($db->query("SELECT vss.id, vss.parent_id, vss.add_date, vss.service_name, vp.item_cost FROM visit_services vss LEFT JOIN visit_prices vp ON(vp.visit_service_id=vss.id) WHERE vss.visit_id = $pk AND vss.status = 1") as $row): ?>
                                <tr id="tr_VisitServicesModel_<?= $row['id'] ?>">
                                    <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>">
                                    <input type="hidden" class="prices_class" value="<?= $row['id'] ?>">
                                    <td><?= date($row['add_date'], 1) ?></td>
                                    <td><?= $row['service_name'] ?></td>
                                    <td class="text-right total_cost"><?= $row['item_cost'] ?></td>
                                    <th class="text-center">
                                        <div class="list-icons">
                                            <button onclick="Delete('<?= del_url($row['id'], 'VisitServicesModel') ?>', 'tr_VisitServicesModel_<?= $row['id'] ?>')" class="btn btn-outline-danger btn-sm"><i class="icon-minus2"></i></button>
                                        </div>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-left">
                    <strong>Итого: </strong><strong id="total_title"></strong>
                </div>
                <div class="text-right">
                    <button onclick="CardFuncCheck('<?= $pk ?>')" type="button" class="<?= $classes['btn-price'] ?>" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

        </div>
        <script type="text/javascript">

            function CardFuncCheck(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPricesModel') ?>",
                    data: {
                        visit_pk: pk,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#form_card").html(result);
                        Swit.init();
                    },
                });
            }
        </script>
        <?php
    }

}else {
    ?>
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold">Нет данных!</span>
    </div>
    <?php
}
?>
