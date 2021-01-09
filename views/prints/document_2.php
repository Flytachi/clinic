<?php
require_once '../../tools/warframe.php';
is_auth();

$docs = $db->query("SELECT vs.user_id, vs.parent_id, vs.service_id, us.dateBith, vs.completed FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= img('prints/icon/company.jpg') ?>" width="480" height="105">
            </div>

            <div class="col-6 text-right h3">
                <b>
                    Медицинский оздоровительный комплекс<br>
                    г.Бухара, ул. М.Икбол, ( )<br>
                    Тел: (+998945487701)<br>
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">
            <div class="h3">
                <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                <b>Дата рождения: </b><?= date('d.m.Y', strtotime($docs->dateBith)) ?><br>
                <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?><br>
                <b>Врач: </b><?= get_full_name($docs->parent_id) ?><br>
            </div>

            <h1 class="text-center"><b><?= $db->query("SELECT name FROM service WHERE id={$docs->service_id}")->fetch()['name'] ?></b></h1>

            <div class="table-responsive card">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th style="width:3%">№</th>
                            <th class="text-left">Анализ</th>
                            <th class="text-right" style="width:15%">Результат</th>
                            <th class="text-right" style="width:15%">Норма</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($db->query("SELECT la.id, la.result, la.deviation, lat.name, lat.standart FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON (la.analyze_id = lat.id) WHERE la.visit_id = {$_GET['id']}") as $row) {
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td class="text-left"><?= $row['name'] ?></td>
                                <td class="text-right"><?= $row['result'] ?></td>
                                <td class="text-right"><?= $row['standart'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>

    </body>
</html>
