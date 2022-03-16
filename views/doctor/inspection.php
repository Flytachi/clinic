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
$pack = $db->query("SELECT report, last_update, add_date FROM visit_inspections WHERE id= {$_GET['pk']}")->fetch();
?>
    <?= $pack['report'] ?>

    <div class="mt-2 ml-1">
        <small><b>
            Написанно <?= date('d.m.Y H:i', strtotime($pack['add_date'])) ?> 
            <?php if($pack['last_update']): ?>
                <span class="text-muted">(измененно <?= date_f($pack['last_update'], 1) ?>)</span>
            <?php endif; ?>
        </b></small>
    </div>
</div>

<div class="modal-footer">
    <button onclick="Print('<?= prints('document-6') ?>?pk=<?= $_GET['pk'] ?>')" type="button" class="btn btn-sm"><i class="icon-printer2"></i></button>
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>
