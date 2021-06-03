<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
if ($_GET['pk']) {
    $pk = $_GET['pk'];

    if( isset($_GET['mod']) and $_GET['mod'] == "st"){
        $ps = $db->query("SELECT id, bed_id, completed FROM visit WHERE user_id = $pk AND service_id = 1 AND priced_date IS NULL")->fetch();
        $pk_visit = $ps['id'];
        $completed = $ps['completed'];
        ?>
        <div class="card border-1 border-dark">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b><?= addZero($pk) ?> - <em><?= get_full_name($pk) ?></em></b></h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="<?= viv('card/content_1')."?pk=$pk_visit" ?>" class="btn btn-outline-info btn-sm">Перейти к визиту</a>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-calculator3 mr-2"></i>Информация
                </legend>

                <?php
                // Скрипт подсчёта средств -----
                $sql = "SELECT
                            vs.id,
                            IFNULL(SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer), 0) 'balance',
                            @date_start := IFNULL((SELECT add_date FROM visit_price WHERE visit_id = vs.id AND item_type IN (101) ORDER BY add_date DESC LIMIT 1), vs.add_date) 'date_start',
                            @date_end := IFNULL(vs.completed, CURRENT_TIMESTAMP()) 'date_end',
                            @bed_hours := ROUND(DATE_FORMAT(TIMEDIFF(@date_end, @date_start), '%H')) 'bed_hours',
                            bdt.name 'bed_type',
                            bdt.price 'bed_price',
                            @cost_bed := @bed_hours * (bdt.price / 24) 'cost_bed',
                            @cost_service := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (1,5) AND price_date IS NULL), 0) 'cost_service',
                            @cost_item_2 := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,3,4) AND price_date IS NULL), 0) 'cost_item_2',
                            @cost_beds := IFNULL((SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (101) AND price_date IS NULL), 0) 'cost_beds',
                            IFNULL(vss.sale_bed_unit, 0) 'sale_bed',
                            IFNULL(vss.sale_service_unit, 0) 'sale_service'
                            -- ((@cost_bed + @cost_beds) - ((@cost_bed + @cost_beds) * (@sale_bed / 100)) ) 'amount_bed'
                            -- vs.add_date
                        FROM users us
                            LEFT JOIN investment iv ON(iv.user_id = us.id AND iv.status IS NOT NULL)
                            LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id AND priced_date IS NULL)
                            LEFT JOIN visit_sale vss ON(vss.visit_id = vs.id)
                            LEFT JOIN beds bd ON(bd.id = vs.bed_id)
                            LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                        WHERE us.id = $pk";
                $price = $db->query($sql)->fetch();
                $serv_id = $db->query("SELECT id FROM visit WHERE user_id = $pk AND service_id != 1 AND priced_date IS NULL")->fetchAll();
                foreach ($serv_id as $value) {
                    $item_service = $db->query("SELECT SUM(item_cost) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type = 1")->fetchAll();
                    foreach ($item_service as $pri_ze) {
                        $price['cost_service'] += $pri_ze['price'];
                    }
                }
                $price['amount_bed'] = ($price['cost_bed'] + $price['cost_beds']) - $price['sale_bed'];
                $price['amount_service'] = $price['cost_service'] - $price['sale_service'];
                // dd($price);
                // Скрипт -----
                $price_cost = -round($price['amount_service'] + $price['amount_bed']);
                ?>
                <table class="table table-hover">
                    <tbody>
                        <tr class="table-secondary">
                            <td>Баланс</td>
                            <td class="text-right text-success"><?= number_format($price['balance']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Сумма к оплате</td>
                            <td class="text-right text-danger"><?= number_format(round($price['cost_service'] + $price['cost_bed'] + $price['cost_beds'])) ?></td> <!--  + $price['cost_item_2'] -->
                        </tr>
                        <tr class="table-secondary">
                            <td>Скидка</td>
                            <td class="text-right"><?= number_format( ($price['cost_service'] - $price['amount_service']) + (($price['cost_bed'] + $price['cost_beds']) - $price['amount_bed']) ) ?></td>
                        </tr>
                        <?php if(module('module_pharmacy')): ?>
                            <tr class="table-secondary">
                                <td>Сумма к оплате(лекарства)</td>
                                <td class="text-right text-danger"><?= number_format(round($price['cost_item_2'])) ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr class="table-secondary">
                            <td>Разница</td>
                            <?php if (($price['balance'] + $price_cost) > 0): ?>
                                <td class="text-right text-success"><?= number_format($price['balance'] + $price_cost) ?></td>
                            <?php elseif(($price['balance'] + $price_cost) < 0): ?>
                                <td class="text-right text-danger"><?= number_format($price['balance'] + $price_cost) ?></td>
                            <?php else: ?>
                                <td class="text-right text-dark"><?= number_format($price['balance'] + $price_cost) ?></td>
                            <?php endif; ?>
                        </tr>
                        <input type="hidden" id="prot_item" value="<?= $price['balance'] + $price_cost ?>">
                    </tbody>
                </table>

                <div class="text-right mt-3">

                    <?php (new VisitPriceModel)->form_button($pk) ?>

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
                    <button onclick="Get_Mod('<?= $pk ?>')" type="button" class="btn btn-sm btn-outline-primary legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

        </div>
        <script type="text/javascript">
            function Get_Mod(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPriceModel') ?>",
                    data: {
                        visit_pk: pk,
                        refund: 1,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#div_modal_price").html(result);
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
                    <button onclick="Get_Mod('<?= $pk ?>')" type="button" class="btn btn-sm btn-outline-primary legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
                </div>

            </div>

        </div>
        <script type="text/javascript">
            function Get_Mod(pk) {
                var array_services = [];

                Array.prototype.slice.call(document.querySelectorAll('.prices_class')).forEach(function(item) {
                    array_services.push(item.value);
                });

                $.ajax({
                    type: "GET",
                    url: "<?= up_url(null, 'VisitPriceModel') ?>",
                    data: {
                        visit_pk: pk,
                        service_pks: array_services,
                    },
                    success: function (result) {
                        $("#div_modal_price").html(result);
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
