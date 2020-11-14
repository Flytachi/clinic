<?php
require_once '../../tools/warframe.php';
is_auth();

if ($_GET['id']) {
    $pack = $db->query('SELECT report FROM visit_service WHERE id='.$_GET['id'])->fetch();
    ?>
    <div class="card border-1 border-dark">
        <?= $pack['report'] ?>
    </div>
    <?php
}
if ($_GET['pk']) {
    foreach ($db->query('SELECT report FROM visit_service WHERE visit_id='.$_GET['pk']) as $pack) {
        ?>
        <div class="card border-1 border-dark">
            <?= $pack['report'] ?>
        </div>
        <?php
    }
}
?>
