<?php
require_once '../../tools/warframe.php';
is_auth();

?>
<div class="modal-header bg-info">
    <h5 class="modal-title">История пациента подробно</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body ml-3 mr-3 text-justify" style="font-size: 1rem">
<?php
$pack = $db->query("SELECT report_title, report_description, report_diagnostic, report_recommendation FROM visit WHERE id= {$_GET['pk']}")->fetch();
?>
    <h3 class="text-center"><?= $pack['report_title'] ?></h3>
    <p>
        <h4 class="text-center"><b>Описание</b></h4>
        <?= preg_replace("#\r?\n#", "<br />", $pack['report_description']) ?>
    </p>
    <p>
        <b style="font-size: 1.1rem">Диагноз:</b>
        <?= preg_replace("#\r?\n#", "<br />", $pack['report_diagnostic']) ?>
    </p>
    <p>
        <b style="font-size: 1.1rem">Рекомендации:</b>
        <?= preg_replace("#\r?\n#", "<br />", $pack['report_recommendation']) ?>
    </p>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline-info btn-sm legitRipple" data-dismiss="modal">Закрыть</button>
</div>
