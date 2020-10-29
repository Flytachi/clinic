<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Med</title>
  <link rel="stylesheet" href="assets/css/style.css">

  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script src="global_assets/js/main/jquery.min.js"></script>
  <script src="global_assets/js/main/bootstrap.bundle.min.js"></script>
  <script src="global_assets/js/plugins/loaders/blockui.min.js"></script>
  <script src="global_assets/js/plugins/ui/ripple.min.js"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->

  <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>
  <script src="global_assets/js/plugins/forms/styling/uniform.min.js"></script>

  <script src="global_assets/js/demo_pages/form_layouts.js"></script>

  <script src="assets/js/app.js"></script>

  <style>
    
    .pad{
      margin-left: 850px; 
      margin-top:100px;
    }

    .backop{
      background: rgba(255, 255, 255, 0.5);
    }

  </style>

</head>

<body background="assets/images/fon-3.jpg">

    <div class="content">
      
		<div class="row">
		
			<div class="col-md-3 pad">

				<div class="card backop">
					<div class="card-header header-elements-inline" style="text-align: center;">
						<h5 class="card-title" >Форма входа</h5>
					</div>

					<div class="card-body">
						<form action="#">
							<div class="form-group">
								<label>Логин:</label>
								<input type="text" class="form-control" placeholder="Введите логин">
							</div>

							<div class="form-group">
								<label>Пароль:</label>
								<input type="password" class="form-control" placeholder="Введите пароль">
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
