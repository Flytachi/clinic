<?php
require_once 'tools/warframe.php';
is_auth();

if ($_SESSION['session_id'] == "master") {
    render('master/index');
}else {
    switch (level()):
        case 1:
            render('admin/index');
            break;
        case 2:
            render('registry/index');
            break;
        case 3:
            render('cashbox/index');
            break;
        case 4:
            render('pharmacy/index');
            break;
        case 5:
            render('doctor/index');
            break;
        case 6:
            render('laboratory/index');
            break;
        case 7:
            render('nurce/index');
            break;
        case 8:
            render('maindoctor/index');
            break;
        case 9:
            render('coock/index');
            break;
        case 10:
            render('diagnostic/index');
            break;
        case 11:
            render('anesthetist/index');
            break;
        case 12:
            render('physio/index');
            break;
        case 13:
            render('manipulation/index');
            break;
        case 32:
            render('registry/index');
            break;
    endswitch;
}
?>
