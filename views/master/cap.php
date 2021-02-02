<?php
require_once '../../tools/warframe.php';
is_auth('master');

if ($_GET['file']) {
    echo exec("mysql -u clinic -pclin_pik27 clinic < ../../dump/".$_GET['file']);
    render();
}
?>
