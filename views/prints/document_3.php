<?php
require_once '../../tools/warframe.php';
is_auth();

// $docs = $db->query("SELECT vs.user_id, vs.parent_id, us.dateBith, vs.report_title, vs.report_description, vs.report_diagnostic, vs.report_recommendation, vs.completed FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include '../layout/head.php' ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body onload="window.print();">

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

            <h3 class="text-center h1"><b><?= $docs->report_title ?></b></h3>
            <div class="h3 text-justify">
                <p>
                    <?= $docs->report_description ?>
                </p>
                <p>
                    <span class="h2"><b>Диагноз:</b></span>
                    <?= $docs->report_diagnostic ?>
                </p>
                <p>
                    <span class="h2"><b>Рекомендации:</b></span>
                    <?= $docs->report_recommendation ?>
                </p>
            </div>


        </div>

    </body>

</html>
