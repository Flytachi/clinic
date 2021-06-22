<?php
require_once '../tools/warframe.php';

$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
foreach ($comp as $value) {
    $company[$value['const_label']] = $value['const_value'];
}

$docs = $db->query("SELECT vs.user_id, vs.parent_id, us.birth_date, vs.service_title, vs.service_report, vs.completed FROM visit_services vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.id={$_GET['id']}")->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("vendors/css/document.css") ?>">

    <body>

        <div class="row">

            <div class="col-6">
                <img src="<?= $company['print_header_logotype'] ?>" width="400" height="120">
            </div>

            <div class="col-6 text-right h3">
                <b>
                    <?= $company['print_header_title'] ?><br>
                    <?= $company['print_header_address'] ?><br>
                    <?= $company['print_header_phones'] ?>
                </b>
            </div>

        </div>

        <div class="my_hr-1"></div>
        <div class="my_hr-2"></div>

        <div class="text-left">
            <div class="h3">
                <b>Ф.И.О.: </b><?= get_full_name($docs->user_id) ?><br>
                <b>ID Пациента: </b><?= addZero($docs->user_id) ?><br>
                <b>Дата рождения: </b><?= date_f($docs->birth_date) ?><br>
                <b>Дата исследования: </b><?= date('d.m.Y H:i', strtotime($docs->completed)) ?><br>
                <b>Врач: </b><?= get_full_name($docs->parent_id) ?><br>
            </div>

            <h3 class="text-center h1"><b><?= $docs->service_title ?></b></h3>
            <div class="h3">
                <?= $docs->service_report ?>
            </div>

        </div>

    </body>

</html>
