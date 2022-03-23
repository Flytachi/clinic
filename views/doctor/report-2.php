<?php
require_once '../../tools/warframe.php';
$session->is_auth();

?>
<div class="<?= $classes['modal-global_header'] ?>">
    <h5 class="modal-title">История болезни</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body ml-3 mr-3 text-justify" style="font-size: 1rem">
<?php
$pack = $db->query("SELECT service_title, service_report, service_id FROM visit_services WHERE visit_id = {$_GET['pk']} AND service_id = 1")->fetch();
?>
    <h3 class="text-center"><?= $pack['service_title'] ?></h3>
    <?= $pack['service_report'] ?>
</div>

<div class="modal-footer">
    <button onclick="Print('<?= prints('document-3') ?>?pk=<?= $_GET['pk'] ?>')" type="button" class="btn btn-sm"><i class="icon-printer2"></i></button>
    <button onclick="Print('<?= prints('document-5') ?>?pk=<?= $_GET['pk'] ?>')" type="button" class="btn btn-sm bg-brown"><i class="icon-printer2"></i></button>
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>
