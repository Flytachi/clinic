<?php
require_once '../../../tools/warframe.php';

$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));

$sql = "SELECT vs.accept_date, vs.user_id, ds.title, (vp.price_cash + vp.price_card + vp.price_transfer) 'price',
            bdt.price 'bed_price',
            ROUND(DATE_FORMAT(TIMEDIFF(vs.completed, vs.add_date), '%H')) 'bed_hours'
        FROM visit vs 
            LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
            LEFT JOIN division ds ON(ds.id=vs.division_id)
            LEFT JOIN beds bd ON(bd.id=vp.item_id)
            LEFT JOIN bed_type bdt ON(bdt.id=bd.types)
        WHERE vp.item_type IN (101) AND vs.direction IS NOT NULL 
            AND vs.grant_id={$_POST['parent_id']} 
            AND vs.priced_date IS NOT NULL 
            AND (DATE_FORMAT(vs.completed, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")";
// $detail = $db->query($sql)->fetchAll(PDO::FETCH_OBJ);
// dd($detail);
$total_price = 0; $i = 1;
?>
<div class="text-right">
    <button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
</div>
<table class="table table-hover table-sm table-bordered" id="table">
    <thead>
        <tr class="<?= $classes['table-thead'] ?>">
            <th style="width: 50px">№</th>
            <th style="width: 11%">Дата приёма</th>
            <th>Пациент</th>
            <th>Отдел</th>
            <th>Прибывание</th>
            <th class="text-right">Цена (койка.день)</th>
            <th class="text-right">Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($db->query($sql) as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= ($row['accept_date']) ? date('d.m.y H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
                <td><?= get_full_name($row['user_id']) ?></td>
                <td><?= $row['title'] ?></td>
                <td>
                    <?= floor($row['bed_hours'] / 24) ?> дней и <?= $row['bed_hours'] % 24 ?> часов
                </td>
                <td class="text-right"><?= number_format($row['bed_price']) ?></td>
                <td class="text-right">
                    <?php $total_price += $row['price']; echo number_format($row['price']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr class="table-secondary">
			<th colspan="3">Общее колличество: <?= $i-1 ?></th>
            <th colspan="3" class="text-right">Итого:</th>
            <th class="text-right"><?= number_format($total_price) ?></th>
        </tr>
    </tbody>
</table>