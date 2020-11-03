<?php
require_once '../tools/connection.php';
session_start();
if ($_SESSION['session_id']) {
    header('location: ../index.php');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Авторизвция</title>
  <link rel="stylesheet" href="../assets/css/style.css">

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="../global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/layout.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/components.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/colors.min.css" rel="stylesheet" type="text/css">
  <link href="../vendors/css/login.css" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script src="../global_assets/js/main/jquery.min.js"></script>
  <script src="../global_assets/js/main/bootstrap.bundle.min.js"></script>
  <script src="../global_assets/js/plugins/loaders/blockui.min.js"></script>
  <script src="../global_assets/js/plugins/ui/ripple.min.js"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->

  <script src="../global_assets/js/plugins/forms/selects/select2.min.js"></script>
  <script src="../global_assets/js/plugins/forms/styling/uniform.min.js"></script>
  <script src="../global_assets/js/demo_pages/form_layouts.js"></script>
  <script src="../assets/js/app.js"></script>
</head>
<?php
    if($_POST){
        $username = $_POST['username'];
        $password = sha1($_POST['password']);

        $stmt = $db->query("SELECT id from users where username = '$username' and password = '$password'")->fetch(PDO::FETCH_OBJ);
        if($stmt){
            $_SESSION['session_id'] = $stmt->id;
            header('location: ../index.php');
        }else{
            $_SESSION['message'] = 'Не верный логин или пароль';
        }
    }
?>
<body>

    <div class="content">
      
		<div class="row">
		
			<div class="col-md-3 local_card">

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