<?php
require_once '../../tools/warframe.php';
is_auth(3);
if ($_GET['pk']) {
    $pk = $_GET['pk'];
    if($_GET['mod']){
        ?>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><em><?= get_full_name($pk) ?></em></h5>
                <div class="header-elements">
                    <div class="list-icons">

                    </div>
                </div>
            </div>

            <div class="card-body">

                <?php
                $serv_id = $db->query("SELECT id FROM visit WHERE user_id = $pk AND service_id != 1")->fetchAll();
                $sql = "SELECT
                            vs.id,
                            SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer) 'balance',
                            ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) 'bed_days',
                            bdt.name 'bed_type',
                            bdt.price 'bed_price',
                            ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) * bdt.price 'cost_bed',
                            (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type = 1) 'cost_service',
                            (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,4)) 'cost_item_2',
                            (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type = 3) 'cost_item_3'
                            -- vs.add_date
                        FROM users us
                            LEFT JOIN investment iv ON(iv.user_id = us.id)
                            LEFT JOIN beds bd ON(bd.user_id = us.id)
                            LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                            LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id)
                        WHERE us.id = $pk";
                $price = $db->query($sql)->fetch();
                foreach ($serv_id as $value) {
                    $item_service = $db->query("SELECT SUM(item_cost) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type = 1")->fetchAll();
                    foreach ($item_service as $pri_ze) {
                        $price['cost_service'] += $pri_ze['price'];
                    }
                }
                // prit($price);

                $price_cost -= $price['cost_service'] + $price['cost_bed'] + $price['cost_item_2'] + $price['cost_item_3'];
                ?>
                <table class="table table-hover">
                    <tbody>
                        <tr class="table-secondary">
                            <td>Баланс</td>
                            <td class="text-right text-success"><?= number_format($price['balance']) ?></td>
                        </tr>
                        <tr class="table-secondary">
                            <td>Сумма к оплате</td>
                            <td class="text-right text-danger"><?= number_format($price_cost) ?></td>
                        </tr>
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
                    </tbody>
                </table>

                <div class="text-right mt-3">
                    <button onclick="Invest(1)" data-name="Разница" data-balance="<?= number_format($price['balance'] + $price_cost) ?>" class="btn btn-outline-success btn-sm">Предоплата</button>
                    <button onclick="Invest(0)" data-name="Баланс" data-balance="<?= number_format($price['balance']) ?>" class="btn btn-outline-danger btn-sm">Возврат</button>
                    <button onclick="Detail('<?= viv('cashbox/get_detail')."?pk=".$pk?>')" class="btn btn-outline-primary btn-sm" data-show="1">Детально</button>
                </div>

                <div id="detail_div"></div>

            </div>
        </div>
        <?php
    }else {
        ?>
        <div class="card">

            <div class="card-header header-elements-inline">
                <h5 class="card-title"><em><?= get_full_name($pk); ?></em></h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-blue">
                                <th class="text-left">Дата и время</th>
                                <th>Мед услуги</th>
                                <th class="text-right">Сумма</th>
                                <th class="text-center" style="width: 150px">Отменить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($db->query("SELECT vs.id, vs.parent_id, vs.add_date, sc.name, sc.price FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = $pk AND vs.priced_date IS NULL") as $row) {
                                ?>
                                    <tr id="tr_VisitModel_<?= $row['id'] ?>">
                                        <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>">
                                        <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td class="text-right total_cost"><?= $row['price'] ?></td>
                                        <th class="text-center">
                                            <button onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', 'tr_VisitModel_<?= $row['id'] ?>')" class="btn btn-outline-danger btn-sm"><i class="icon-minus2"></i></button>
                                        </th>
                                    </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                    <br>
                    <div class="text-left">
                        <strong>Итого: </strong><strong id="total_title"></strong>
                    </div>
                    <div class="text-right">
                        <button onclick="$('#total_price').val($('#total_title').text());$('#user_amb_id').val('<?= $pk ?>');" type="button" class="btn btn-outline-primary border-transparent legitRipple" data-toggle="modal" data-target="#modal_default">Оплата</button>
                    </div>
                </div>
            </div>

        </div>
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
