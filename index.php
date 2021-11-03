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
        case 13: render('laboratory/index'); break;
        case 14: render('physio/index'); break;

        case 21: render('registry/index'); break;
        case 22: render('cashbox/index'); break;
        case 23: render('registry/index'); break;
        case 24: render('pharmacy/index'); break;
        case 25: render('nurce/index'); break;
        
    endswitch;
}
?>
