<?php
require_once '../../tools/warframe.php';
is_auth('master');

if ($_GET['file']) {

    if ($_GET['status'] == 1) {

        echo exec("mysql -u clinic -pclin_pik27 clinic < ../../dump/".$_GET['file']);
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();

    }elseif ($_GET['status'] == 0) {

        if (unlink("../../dump/".$_GET['file'])) {
            $_SESSION['message'] = '
            <div class="alert alert-primary" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>
            ';
        }else {
            $_SESSION['message'] = '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> Ошибка при удалении </span>
            </div>';
        }
        render();

    }else {

        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> Ошибка статуса </span>
        </div>';
        render();

    }
}
?>
