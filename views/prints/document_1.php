<?php
require_once '../../tools/warframe.php';
is_auth();

$docs = $db->query("SELECT vs.user_id, vs.parent_id, us.dateBith, vs.report_title, vs.report_description, vs.report_diagnostic, vs.report_recommendation, vs.completed FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= img('prints/icon/company.png') ?>" width="400" height="120">
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

            <h3 class="text-center h1"><b><?= $docs->report_title ?></b></h3>
            <div class="h3 text-justify">
                <p>
                    <?= preg_replace("#\r?\n#", "<br />", $docs->report_description) ?>
                </p>
                <p>
                    <span class="h2"><b>Диагноз:</b></span>
                    <?= preg_replace("#\r?\n#", "<br />", $docs->report_diagnostic) ?>
                </p>
                <p>
                    <span class="h2"><b>Рекомендации:</b></span>
                    <?= preg_replace("#\r?\n#", "<br />", $docs->report_recommendation) ?>
                </p>
            </div>


        </div>

    </body>

</html>
