<?php
require_once '../../tools/warframe.php';
$session->is_auth();

?>
<div class="modal-header bg-info">
    <h5 class="modal-title">Примечание</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body ml-3 mr-3 text-justify" style="font-size: 1rem">
<?php
$pack = $db->query("SELECT report_title, report FROM visit WHERE id= {$_GET['pk']}")->fetch();
?>
    <h3 class="text-center"><?= $pack['report_title'] ?></h3>
    <p>
        <?= $pack['report'] ?>
    </p>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline-info btn-sm legitRipple" data-dismiss="modal">Закрыть</button>
</div>
