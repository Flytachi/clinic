<?php
require_once '../../tools/warframe.php';
$session->is_auth();

?>
<div class="<?= $classes['modal-global_header'] ?>">
    <h5 class="modal-title">Осмотр</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body ml-3 mr-3 text-justify" style="font-size: 1rem">
<?php
$pack = $db->query("SELECT report, add_date FROM visit_operation_inspections WHERE id= {$_GET['pk']}")->fetch();
?>
    <h3 class="text-center"><?= date('d.m.Y H:i', strtotime($pack['add_date'])) ?></h3>
    <?= $pack['report'] ?>
</div>

<div class="modal-footer">
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>