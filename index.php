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
        include('docs/index/anestiziolog.php');
        break;
    case 6:
        include('docs/index/laboratory.php');
        break;
    case 7:
        include('docs/index/ambulator.php');
        break;
    case 8:
        include('docs/index/nurse.php');
        break;
endswitch;
?>
