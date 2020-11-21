<?php
require_once '../../tools/warframe.php';
is_auth();

?>
<div class="modal-header bg-info">
    <h5 class="modal-title">История пациента подробно</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body text-justify" style="font-size: 1rem">
<?php
$pack = $db->query("SELECT report_title, report_description, report_conclusion FROM visit_service WHERE id= {$_GET['pk']}")->fetch();
?>
    <h3 class="text-center"><?= $pack['report_title'] ?></h3>
    <ul>
        <li><h5><b>Описание</b></h5> - <?= $pack['report_description'] ?></li>
        <li><h5><b>Заключение</b></h5> - <?= $pack['report_conclusion'] ?></li>
    </ul>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-info legitRipple" data-dismiss="modal">Закрыть</button>
</div>
