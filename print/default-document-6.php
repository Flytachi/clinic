<?php

use Mixin\Hell;

require_once '../tools/warframe.php';

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {
    $docs = $db->query("SELECT vi.*, v.parad_id FROM visit_inspections vi LEFT JOIN visits v ON(v.id=vi.visit_id) WHERE vi.id={$_GET['pk']}")->fetch(PDO::FETCH_OBJ);
    if (!$docs) Mixin\error('404');
}else Hell::error('404');
?>
<!DOCTYPE html>
<html lang="en">

    <?php include layout('head') ?>
    <link rel="stylesheet" href="<?= stack("assets/my_css/document.css") ?>">

    <body>

        <div class="text-left">

            <h3 class="text-center h1"><b>История болезни №<?= $docs->parad_id ?></b></h3>
            <div class="h3">
                <?= $docs->report ?>
            </div>

            <small><b>
            Написанно <?= date('d.m.Y H:i', strtotime($docs->add_date)) ?> 
            <?php if($docs->last_update): ?>
                <span class="text-muted">(измененно <?= date_f($docs->last_update, 1) ?>)</span>
            <?php endif; ?>
        </b></small>

        </div>

        <div class="btn_panel text-center">
            <button class="btn btn-sm" onclick="print();">Печать</button>
        </div>

    </body>

</html>