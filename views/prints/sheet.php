<?php
require_once '../../tools/warframe.php';
// is_auth();

$comp = $db->query("SELECT * FROM company")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

$sql = "SELECT  us.id,
            vs.id 'visit_id',
            vs.parent_id
        FROM users us
            LEFT JOIN visit vs ON(us.id=vs.user_id)
        WHERE
            vs.id={$_GET['id']} AND
            vs.direction IS NOT NULL AND
            vs.service_id = 1";
$docs = $db->query($sql)->fetch(PDO::FETCH_OBJ);
// prit($docs);
?>

<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <style>
        table.minimalistBlack thead th {
            font-size: 16px;
        }
        table.minimalistBlack tbody td {
            font-size: 14px;
        }
        table .trasform_text {
            text-align:center;
            white-space:nowrap;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }
        table {
            text-align:center;
            table-layout:fixed;
            width:150%;
            border-collapse: collapse;
            border: 3px solid black;
        }
    </style>

    <body>

        <div class="table-responsive card">
            
            <table class="minimalistBlack">
                <thead>
                    <tr>
                        <th style="width: 30px;" rowspan="3">№</th>
                        <th colspan="2">ID: <span style="font-weight:normal;"><?= addZero($docs->id) ?></span></th>
                        <th colspan="5">ФИО: <span style="font-weight:normal;"><?= get_full_name($docs->id) ?></span></th>
                        <th colspan="5">Расположение: </th>
                        <th colspan="4">Врач: <span style="font-weight:normal;"><?= get_full_name($docs->parent_id) ?></span></th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="16">Лист врачебных назначений</th>
                    </tr>
                    <tr>
                        <th colspan="4">Назначения</th>
                        <th>Вр.</th>
                        <th>Исп.</th>
                        <?php for($i=0; $i < 10; $i++): ?>
                            <?php $date = new DateTime('+'.$i.' day'); ?>
                            <th height="80" class="trasform_text"><?= $date->format('d.m') ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td colspan="4">shduguwqgdqwdwqd</td>
                        <td>12:00</td>
                        <td>S/F</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </body>
</html>