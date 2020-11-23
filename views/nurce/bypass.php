<?php
require_once '../../tools/warframe.php';
is_auth();
$byp = $db->query("SELECT * FROM bypass WHERE id= {$_GET['pk']}")->fetch();
?>
<div class="modal-header">
    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> <?= get_full_name($byp['parent_id']) ?></h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body">
    <div class="alert alert-info alert-dismissible alert-styled-left border-top-0 border-bottom-0 border-right-0">
        <span class="font-weight-semibold">Примечание!</span> <?= $byp['description'] ?>.
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>

    <h6 class="font-weight-semibold"><i class="icon-law mr-2"></i>Препорат: <?= $byp['preparat_id'] ?></h6>

</div>

<div class="modal-footer">
    <button class="btn btn-link legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    <button class="btn bg-info legitRipple"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
</div>
