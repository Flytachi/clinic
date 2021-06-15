<?php
require_once '../../tools/warframe.php';
$session->is_auth();

?>
<div class="<?= $classes['modal-global_header'] ?>">
    <h5 class="modal-title">История пациента подробно</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body ml-3 mr-3 text-justify" style="font-size: 1rem">
<?php
$pack = $db->query("SELECT service_title, service_report, service_id FROM visit_services WHERE id = {$_GET['pk']}")->fetch();
?>
    <h3 class="text-center"><?= $pack['service_title'] ?></h3>
    <?= $pack['service_report'] ?>
</div>

<div class="modal-footer">
    <?php if ($pack['service_id'] == 1): ?>
        <button onclick="Print('<?= viv('prints/document_3') ?>?id=<?= $_GET['pk'] ?>')" type="button" class="btn btn-sm"><i class="icon-printer2"></i></button>
    <?php else: ?>
        <button onclick="Print('<?= viv('prints/document_1') ?>?id=<?= $_GET['pk'] ?>')" type="button" class="btn btn-sm"><i class="icon-printer2"></i></button>
    <?php endif; ?>
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>
