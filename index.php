<?php
require_once 'tools/warframe.php';
is_auth();

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
    case 5:
        render('doctor/index');
        break;
    case 6:
        render('laboratory/index');
        break;
    case 7:
        include('docs/index/ambulator.php');
        break;
    case 8:
        include('docs/index/nurse.php');
        break;
endswitch;
?>
