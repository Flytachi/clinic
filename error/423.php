<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Ошибка - 423</title>

	<!-- Global stylesheets -->
	<link rel="shortcut icon" href="<?= stack("assets/images/logo.ico") ?>" type="image/x-icon">
	<link href="<?= stack("assets/fonts/font.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/components.min.css") ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

</head>

<body>
	
	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Container -->
				<div class="flex-fill">

					<!-- Error title -->
					<div class="text-center mb-3">
						<h1 class="error-title <?= $classes['error_page-code-color'] ?>">423</h1>
						<h4>Доступ запрещён!</h4>
					</div>
					<!-- /error title -->


					<!-- Error content -->
					<div class="row">
						<div class="col-xl-4 offset-xl-4 col-md-8 offset-md-2">

							<!-- Buttons -->
							<div class="row">
								<div class="col-sm-6">
									<a href="../" class="btn btn-primary btn-block"><i class="icon-home4 mr-2"></i> Dashboard</a>
								</div>

								<div class="col-sm-6">
									<a href="javascript:history.back()" class="btn btn-light btn-block mt-3 mt-sm-0" title="Вернуться на предыдущую страницу" >><i class="icon-menu7 mr-2"></i> назад </a>
								</div>
							</div>
							<!-- /buttons -->

						</div>
					</div>
					<!-- /error wrapper -->

				</div>
				<!-- /container -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


</body>
</html>
