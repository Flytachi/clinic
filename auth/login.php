<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link href="<?= stack("assets/css/style.css") ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?= stack("assets/images/logo.png") ?>" type="image/x-icon">
    <link href="<?= stack("assets/fonts/font.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/components.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/css/colors.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="<?= stack("assets/my_css/login.css") ?>" rel="stylesheet" type="text/css">
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

            <div class="col"></div>

			<div class="col-xl-3 col-lg-5 col-md-10 local_card">

				<div class="card backcard">
					<div class="card-header header-elements-inline" style="text-align: center;">
                        <h5 class="card-title">Форма входа</h5>
                    </div>
                    
					<div class="card-body">
                        <?php if ( isset($_SESSION['message']) ): ?>
                            <div class="alert alert-danger" role="alert">
                                <button type='button' class='close' data-dismiss='alert'><span>×</span><span class='sr-only'>Close</span></button>
                                <?= $_SESSION['message'] ?>
                            </div>
                            <?php unset($_SESSION['message']); endif; ?>
                            <form action="" method="post" id="Login_form">

							<div class="form-group">
								<label>Логин:</label>
								<input type="text" class="form-control border-primary text-white" name="username" placeholder="Введите логин">
							</div>

							<div class="form-group">
								<label>Пароль:</label>
								<input type="password" class="form-control border-primary text-white" name="password" placeholder="Введите пароль">
							</div>

							<div class="text-right">
                                <?php if ( isset(ini['MASTER_IPS']) and in_array(trim($_SERVER['REMOTE_ADDR']), ini['MASTER_IPS']) ): ?>
                                    <button type="button" class="btn btn-outline-danger btn-sm legitRipple" onclick="KeySub()">Login in master<i class="icon-key ml-2"></i></button>
                                    <script>
                                        function KeySub() { $('#Login_form').append('<input type="hidden" name="master-key" value="master-key">'); $('#Login_form').submit(); }
                                    </script>
                                <?php endif; ?>
							    <button type="submit" class="btn btn-outline bg-white text-white border-white btn-sm legitRipple">Войти<i class="icon-circle-right2 ml-2"></i></button>
                            </div>

						</form>
					</div>
				</div>

			</div>

		</div>

    </div>

</body>
</html>
