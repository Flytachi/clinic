<?php
require_once '../../../tools/warframe.php';

$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));

$sql = "SELECT vs.user_id, SUM(iv.balance_cash + iv.balance_card + iv.balance_transfer) 'deposit'
        FROM visit vs 
            LEFT JOIN investment iv ON(iv.user_id=vs.user_id AND iv.status IS NOT NULL AND (DATE_FORMAT(iv.add_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\"))
        WHERE vs.direction IS NOT NULL AND bed_id IS NOT NULL
            AND vs.grant_id={$_POST['parent_id']} 
            AND vs.priced_date IS NULL 
            AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\") 
        GROUP BY vs.user_id";
$total_price = 0; $i = 1;
?>
<div class="text-right">
    <button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
</div>
<table class="table table-hover table-sm table-bordered" id="table">
    <thead>
        <tr class="<?= $classes['table-thead'] ?>">
            <th style="width: 50px">№</th>
            <th>Пациент</th>
            <th class="text-right">Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($db->query($sql) as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= get_full_name($row['user_id']) ?></td>
                <td class="text-right">
                    <?php $total_price += $row['deposit']; echo number_format($row['deposit']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr class="table-secondary">
            <th colspan="2" class="text-right">Итого:</th>
            <th class="text-right"><?= number_format($total_price) ?></th>
        </tr>
    </tbody>
</table>