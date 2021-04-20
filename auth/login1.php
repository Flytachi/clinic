<?php

use function Mixin\clean;

require_once '../tools/functions/connection.php';
require_once '../tools/functions/tag.php';
require_once '../tools/functions/mixin.php';

// Settings mod

if (!$ini['GLOBAL_SETTING']['ROOT_MOD']) {
    define('ROOT_DIR', "/".basename(dirname(__DIR__)));

    if ("/".$_SERVER['HTTP_HOST'] == ROOT_DIR) {
        define('DIR', "");
    }else {
        define('DIR', ROOT_DIR);
    }

}else {
    define('DIR', "");
}

// END Settings mod

// Settings debugger

if ($ini['GLOBAL_SETTING']['DEBUG']) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

// END Settings debugger


// File extension

if ($ini['GLOBAL_SETTING']['HIDE_EXTENSION']) {

    define('EXT', "");

}else {

    define('EXT', ".php");

}

// END File extension

class Session
{
    public $login_url = DIR."/auth/login1.php";
    public $index_url = "new_ses2".EXT; //../index.php
    protected $session_id;
    protected $session_login;

    function __construct()
    {
        session_start();
        if ($_SESSION['session_id']) {
            $this->session_id = $_SESSION['session_id'];
            $this->session_login = $_SESSION['session_login'];
            if ($this->login_url == $_SERVER['PHP_SELF']) {
                header("location: $this->index_url");
            }
        }else {
            if ($this->login_url != $_SERVER['PHP_SELF']) {
                $this->login();
            }elseif ($_POST) {
                global $db;
                $username = Mixin\clean($_POST['username']);
                $password = sha1($_POST['password']);
        
                if ($username == "master" and $_POST['password'] == gen_password()) {
                    $_SESSION['session_id'] = "master";
                    $_SESSION['session_login'] = "master";
                    header("location: $this->index_url");
                }
        
                $stmt = $db->query("SELECT id from users where username = '$username' and password = '$password'")->fetch(PDO::FETCH_OBJ);
                if($stmt){
                    $_SESSION['session_id'] = $stmt->id;
                    $_SESSION['session_login'] = $username;
                    $slot = $db->query("SELECT slot FROM multi_accounts WHERE user_id = $stmt->id")->fetchColumn();
                    if ($slot) {
                        $_SESSION['session_slot'] = Mixin\clean($slot);
                    }
                    header("location: $this->index_url");
                }else{
                    $_SESSION['message'] = 'Не верный логин или пароль';
                }
            }
        }
    }

    public function login()
    {
        header("location:".DIR."/auth/login1".EXT);
    }

    public function auth(string $login = null, string $password = null)
    {
        echo $login;
    }

}

$session = new Session;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Авторизация</title>
  <link href="<?= stack("assets/css/style.css") ?>" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("assets/css/components.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("assets/css/colors.min.css") ?>" rel="stylesheet" type="text/css">
  <link href="<?= stack("vendors/css/login.css") ?>" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script src="<?= stack("global_assets/js/main/jquery.min.js") ?>"></script>
  <script src="<?= stack("global_assets/js/main/bootstrap.bundle.min.js") ?>"></script>
  <script src="<?= stack("global_assets/js/plugins/loaders/blockui.min.js") ?>"></script>
  <script src="<?= stack("global_assets/js/plugins/ui/ripple.min.js") ?>"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->

  <script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
  <script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>
  <script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
  <script src="<?= stack("assets/js/app.js") ?>"></script>
</head>
<body>

    <div class="content">

		<div class="row">

			<div class="col-md-3 local_card" style="width: 100px;">

				<div class="card backcard">
					<div class="card-header header-elements-inline" style="text-align: center;">
                        <h5 class="card-title" >Форма входа</h5>
                    </div>
                    <?php
                        if ($_SESSION['message']) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <button type='button' class='close' data-dismiss='alert'><span>×</span><span class='sr-only'>Close</span></button>
                                <?= $_SESSION['message'] ?>
                            </div>
                            <?php
                        }
                        unset($_SESSION['message']);
                    ?>
					<div class="card-body">
						<form action="" method="post">

							<div class="form-group">
								<label>Логин:</label>
								<input type="text" class="form-control" name="username" placeholder="Введите логин">
							</div>

							<div class="form-group">
								<label>Пароль:</label>
								<input type="password" class="form-control" name="password" placeholder="Введите пароль">
							</div>

							<div class="text-right">
							    <button type="submit" class="btn btn-primary legitRipple">Войти<i class="icon-paperplane ml-2"></i></button>
                            </div>

						</form>
					</div>
				</div>

			</div>

		</div>

    </div>

</body>
</html>
