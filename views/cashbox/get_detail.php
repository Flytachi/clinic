<?php
require_once '../../tools/warframe.php';
is_auth(3);
if ($_GET['pk']) {
    $pk = $_GET['pk'];
    $sql = "SELECT
                SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer) 'balance',
                ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) 'bed_days',
                bdt.name 'bed_type',
                bdt.price 'bed_price',
                ROUND(DATE_FORMAT(TIMEDIFF(CURRENT_TIMESTAMP(), vs.add_date), '%H') / 24) * bdt.price 'cost_bed',
                (SELECT SUM(sc.price) FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.user_id = $pk AND vs.priced_date IS NULL) 'cost_service',
                (SELECT SUM(price) FROM sales_order WHERE user_id = us.id AND amount = 0 AND profit = 0) 'cost_preparat'
                -- vs.add_date
            FROM users us
                LEFT JOIN investment iv ON(iv.user_id = us.id)
                LEFT JOIN beds bd ON(bd.user_id = us.id)
                LEFT JOIN bed_type bdt ON(bdt.id = bd.types)
                LEFT JOIN visit vs ON(vs.user_id = us.id AND vs.grant_id = vs.parent_id)
            WHERE us.id = $pk";
    $price = $db->query($sql)->fetch();
    // prit($price);
    ?>
    <div class="table-responsive mt-3">
        <table class="table table-hover">
            <thead>
                <tr class="bg-blue">
                    <th class="text-left">Дата и время</th>
                    <th>Наименование</th>
                    <th class="text-right">Сумма</th>
                    <!-- <th class="text-center" style="width: 150px">Оплатить</th> -->
                </tr>
            </thead>
            <tbody>
                <tr class="table-warning">
                    <td>Койка (<?= $price['bed_days'] ?> дней)</td>
                    <td><?= $price['bed_type'] ?> (<?= number_format($price['bed_price']) ?>)</td>
                    <td class="text-right"><?= number_format($price['cost_bed']) ?></td>
                </tr>

                <tr class="text-center table-primary">
                    <td colspan="2">Мед услуги</td>
                    <td class="text-right"><?= number_format($price['cost_service']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT vs.id, vs.parent_id, vs.add_date, sc.name, sc.price FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = $pk AND vs.priced_date IS NULL AND vs.service_id != 1") as $row): ?>
                    <tr>
                        <!-- <input type="hidden" class="parent_class" value="<?= $row['parent_id'] ?>"> -->
                        <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                        <td><?= $row['name'] ?></td>
                        <td class="text-right total_cost"><?= number_format($row['price']) ?></td>
                        <!-- <td class="text-center">
                            <button onclick="alert('в разработке')" class="btn btn-outline-success"><i class="icon"></i></button>
                        </td> -->
                    </tr>
                <?php endforeach; ?>

                <tr class="text-center table-primary">
                    <td colspan="2">Препараты</td>
                    <td class="text-right"><?= number_format($price['cost_preparat']) ?></td>
                </tr>
                <?php foreach ($db->query("SELECT DISTINCT so.product, so.product_code, (SELECT COUNT(product) FROM sales_order so2 WHERE so2.product = so.product AND so2.user_id = $pk AND so2.amount = 0 AND so2.profit = 0) 'count', so.price FROM sales_order so WHERE so.user_id = $pk AND so.amount = 0 AND so.profit = 0") as $row): ?>
                    <tr>
                        <td><?= $row['product_code'] ?></td>
                        <td><?= $row['count'] ?></td>
                        <td class="text-right"><?= number_format($row['count'] * $row['price']) ?></td>
                    </tr>
                <?php endforeach; ?>

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
