<?php
require_once '../tools/warframe.php';
// $session->is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="shortcut icon" href="<?= stack("assets/images/logo.png") ?>" type="image/x-icon">
    <link href="<?= stack("assets/fonts/font.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/colors.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="newcss.css" rel="stylesheet" type="text/css">
</head>
<body>

    <div class="login-box">
        <h2>Login</h2>
        <form>
            <div class="user-box">
                <input class="form-control" type="text" name="" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input class="form-control" type="password" name="" required="">
                <label>Password</label>
            </div>
            <a type="submit" class="text-info btn btn-block" onclick="alert('sub')"><span></span><span></span><span></span><span></span><b>Войти</b></a>
        </form>
    </div>

</body>
</html>



