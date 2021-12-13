<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="shortcut icon" href="<?= stack("assets/images/logo.png") ?>" type="image/x-icon">
    <link href="<?= stack("assets/my_css/login.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
</head>
<body>

    <div class="login-box">
        <h2>Login</h2>
        <form action="" method="post" id="Login_form">
            <div class="user-box">
                <input type="text" name="username" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <?php if ( isset($ini['MASTER_IPS']) and in_array(trim($_SERVER['REMOTE_ADDR']), $ini['MASTER_IPS']) ): ?>
                <button type="button" onclick="KeySub()"><span></span><span></span><span></span><span></span> <em>Login in master</em> <i class="icon-key"></i></button>
                <script>
                    function KeySub() {
                        var form = document.querySelector('#Login_form');
                        var input = document.createElement('input');
                        input.type = "hidden";
                        input.name = "master-key";
                        input.value = "master-key";
                        form.append(input);
                        form.submit();
                    }
                </script>
            <?php endif; ?>
            <button type="submit"><span></span><span></span><span></span><span></span><b>Войти</b></button>
        </form>

        <small style="color: red;"><?php is_message(); ?></small>
    </div>

</body>
</html>