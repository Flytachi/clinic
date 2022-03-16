<?php
require_once '../../tools/warframe.php';
require_once '../../extra/Core/Command/__backup.php';
$session->is_auth();


if ($session->session_level == "master") {
    
    if ($_GET['is_create']) {
        new __Backup("create");
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Дамп успешно сохранён!
        </div>
        ';
        render();
    }elseif ($_GET['is_delete']) {
        new __Backup("delete", $_GET['file']);
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Дамп успешно удалён!
        </div>
        ';
        render();
    }elseif ($_GET['file']) {
        new __Backup("create", "merge_in_".date("Y-m-d_H-i-s"));
        new __Backup("migrate", $_GET['file']);
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }else {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> Ошибка статуса </span>
        </div>';
        render();
    }

}else {
    $_SESSION['message'] = '
    <div class="alert bg-danger alert-styled-left alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        <span class="font-weight-semibold"> Доступ запрещён! </span>
    </div>';
    render();
}
?>
