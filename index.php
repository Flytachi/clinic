<?php
require_once 'tools/warframe.php';
$session->is_auth();

if ($_SESSION['session_id'] == "master") {
    render('master/index');
}elseif ($_SESSION['session_id'] == "avatar") {
    include "views/master/avatar_panel.php";
}else {

    switch (level()):
        case 1: render('admin/index'); break;
        case 2: render('manager/index'); break;

        case 11: render('doctor/index'); break;
        case 12: render('diagnostic/index'); break;

        case 21: render('registry/index'); break;
        case 22: render('cashbox/index'); break;
    endswitch;
}
?>
