<?php
require_once '../../tools/warframe.php';
is_auth([3, 32]);
if ($_GET['pk']) {
    $pk = $_GET['pk'];
    
    // Скрипт подсчёта средств -----
    $sql = "SELECT
                vs.id,
                IFNULL(SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer), 0) 'balance',
                @date_start := IFNULL((SELECT add_date FROM visit_price WHERE visit_id = vs.id AND item_type IN (101) ORDER BY add_date DESC LIMIT 1), vs.add_date) 'date_start',
                @date_end := IFNULL(vs.completed, CURRENT_TIMESTAMP()) 'date_end',
                @bed_hours := ROUND(DATE_FORMAT(TIMEDIFF(@date_end, @date_start), '%H')) 'bed_hours',
                bdt.name 'bed_type',
                bdt.price 'bed_price',
                @bed_hours * (bdt.price / 24) 'cost_bed',
                (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (1,5)) 'cost_service',
                (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (2,3,4)) 'cost_item_2',
                (SELECT SUM(item_cost) FROM visit_price WHERE visit_id = vs.id AND item_type IN (101)) 'cost_beds'
                -- vs.add_date
            FROM users us
                LEFT JOIN investment iv ON(iv.user_id = us.id AND iv.status IS NOT NULL)
                LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id AND priced_date IS NULL)
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
    // prit($price);
    // Скрипт -----
    ?>

    <legend class="font-weight-semibold text-uppercase font-size-sm">
        <i class="icon-cogs mr-2"></i>Детально
        <a class="float-right text-dark mr-1" onclick="printdiv('check_detail')">
            <i class="icon-printer2"></i>
        </a>
    </legend>

    <div class="table-responsive mt-3 card" id="check_detail">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="bg-dark">
                    <th class="text-left" colspan="2">Наименование</th>
                    <th>Дата и время</th>
                    <th class="text-right">Сумма</th>
                    <!-- <th class="text-center" style="width: 150px">Оплатить</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($db->query("SELECT id FROM visit WHERE user_id = $pk AND priced_date IS NULL") as $val): ?>
                    <?php foreach ($db->query("SELECT vp.*, bdt.name, bdt.price FROM visit_price vp LEFT JOIN beds bd ON(bd.id=vp.item_id) LEFT JOIN bed_type bdt ON(bdt.id=bd.types) WHERE vp.visit_id = {$val['id']} AND vp.item_type IN (101)") as $row): ?>
                        <tr class="table-warning">
                            <td><?= $row['item_name'] ?></td>
                            <td colspan="2"><?= $row['name'] ?> (<?= number_format($row['price']) ?>/день)</td>
                            <td class="text-right"><?= number_format($row['item_cost']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <tr class="table-warning">
                    <td>
                        Койка (<?= $price['bed_hours'] ?> часов)
                        <?php if ($price['bed_hours'] > 24): ?>
                            &#8776;
                            (<?= round($price['bed_hours'] / 24, 0, PHP_ROUND_HALF_DOWN) ?> дней и <?= $price['bed_hours'] % 24 ?> часов)
                        <?php endif; ?>
                    </td>
                    <td colspan="2"><?= $price['bed_type'] ?> (<?= number_format($price['bed_price']) ?>/день)</td>
                    <td class="text-right"><?= number_format($price['cost_bed']) ?></td>
                </tr>

                <tr class="text-center table-secondary">
                    <td colspan="3" class="text-left">Мед услуги / Операции</td>
                    <td class="text-right"><?= number_format($price['cost_service']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT id FROM visit WHERE user_id = $pk AND priced_date IS NULL") as $val): ?>
                    <?php foreach ($db->query("SELECT * FROM visit_price WHERE visit_id = {$val['id']} AND item_type IN (1,5)") as $row): ?>
                        <tr>
                            <!-- <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>"> -->
                            <td colspan="2"><?= $row['item_name'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                            <td class="text-right total_cost"><?= number_format($row['item_cost']) ?></td>
                            <!-- <td class="text-center">
                                <button onclick="alert('в разработке')" class="btn btn-outline-success"><i class="icon"></i></button>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <tr class="table-secondary">
                    <td>Препараты/Расходные материалы</td>
                    <td>Количество</td>
                    <td>Цена ед.</td>
                    <td class="text-right"><?= number_format($price['cost_item_2']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT DISTINCT vp.item_name, vp.item_cost, (SELECT COUNT(*) FROM visit_price WHERE visit_id = {$price['id']} AND item_type IN (2,3,4) AND item_id=vp.item_id) 'count' FROM visit_price vp WHERE vp.visit_id = {$price['id']} AND vp.item_type IN (2,3,4)") as $row): ?>
                    <tr>
                        <td><?= $row['item_name'] ?></td>
                        <td><?= $row['count'] ?></td>
                        <td><?= number_format($row['item_cost']) ?></td>
                        <td class="text-right"><?= number_format($row['count'] * $row['item_cost']) ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr class="table-primary">
                    <td colspan="3" class="text-right">Итого:</td>
                    <td><?= number_format($price['cost_beds'] + $price['cost_bed'] + $price['cost_service'] + $price['cost_item_2']) ?></td>
                </tr>

            </tbody>
        </table>
    </div>
    <?php
}else {
    ?>
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold">Нет данных!</span>
    </div>
    <?php
}
?>
