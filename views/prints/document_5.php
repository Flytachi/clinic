<?php
require_once '../../tools/warframe.php';

$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}
$sql = "SELECT 
            d.name,
            wd.ward,
            bp.user_id,
            bpd.completed 
        FROM bypass bp
            LEFT JOIN bypass_date bpd ON(bpd.bypass_id = bp.id)
            LEFT JOIN diet d ON(d.id = bp.diet_id)
            LEFT JOIN beds bd ON(bd.user_id = bp.user_id)
            LEFT JOIN wards wd ON(wd.id = bd.ward_id)
        WHERE 
            bp.diet_id IS NOT NULL AND bpd.status IS NOT NULL AND 
            bpd.date = '{$_GET['date']}' AND bpd.time = '{$_GET['time']}'";
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body>
    
        <h1 class="text-center"><b><?= date_f($_GET['date']." ".$_GET['time'], 1) ?></b></h1>

            <div class="table-responsive card">
                <table class="minimalistBlack">
                    <thead>
                        <tr id="text-h">
                            <th style="width: 40px !important;">№</th>
                            <th class="text-center">Диета</th>
                            <th class="text-center">Койка</th>
                            <th class="text-center">ФИО</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;foreach ($db->query($sql) as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td class="text-center"><?= $row['name'] ?></td>
                                <td class="text-center"><?= $row['ward'] ?></td>
                                <td class="text-center"><?= get_full_name($row['user_id']) ?></td>
                                <td class="text-center"><?= addZero($row['user_id']) ?></td>
                                <td class="text-center"><?= ($row['completed']) ? '<span class="text-success">Confirmed</span>' : '<span class="text-danger">Not confirmed</span>' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

    </body>
</html>
