<?php
require_once '../../tools/warframe.php';
is_auth(2);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
					<li class="nav-item"><a href="#basic-justified-tab1" class="nav-link legitRipple active show" data-toggle="tab">Регистрация</a></li>
					<li class="nav-item"><a href="#basic-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационарная</a></li>
					<li class="nav-item"><a href="#basic-justified-tab3" class="nav-link legitRipple" data-toggle="tab">Амбулаторная</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane fade active show" id="basic-justified-tab1">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Регистрация</h6>
								<div class="header-elements">
									<div class="list-icons">
				                		<a class="list-icons-item" data-action="collapse"></a>
				                	</div>
			                	</div>
							</div>

							<div class="card-body" style="" id="form_up">
								<?php PatientForm::form(); ?>
							</div>

						</div>

					</div>

					<div class="tab-pane fade" id="basic-justified-tab2">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Стационарная</h6>
								<div class="header-elements">
									<div class="list-icons">
				                		<a class="list-icons-item" data-action="collapse"></a>
				                	</div>
			                	</div>
							</div>

							<div class="card-body">
								<?php StationaryTreatmentForm::form(); ?>
							</div>

						</div>

					</div>

					<div class="tab-pane fade" id="basic-justified-tab3">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Амбулаторная</h6>
								<div class="header-elements">
									<div class="list-icons">
				                		<a class="list-icons-item" data-action="collapse"></a>
				                	</div>
			                	</div>
							</div>

							<div class="card-body">
								<?php OutpatientTreatmentForm::form(); ?>
							</div>

						</div>

					</div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
