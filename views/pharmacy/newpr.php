<?php
require_once '../../tools/warframe.php';

$header = "Персонал";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<?php
	function formatMoney($number, $fractional=false) {
		if ($fractional) {
			$number = sprintf('%.2f', $number);
			// echo " ff ". $number." ff ";
		}
		while (true) {
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
			// echo " ff ". $replaced." ff ";
			if ($replaced != $number) {
				$number = $replaced;
			} else {
				break;
			}
		}
		return $number;
	}
?>

<script src="<?= stack("global_assets/js/plugins/extensions/jquery_ui/interactions.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js")?>"></script>

<script src="<?= stack("assets/js/app.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js")?>"></script>

<body>
	<!-- Main navbar -->
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">
    <!-- Sidebar content -->
		    <div class="sidebar-content">

		        <!-- User menu -->
		        <div class="sidebar-user-material">
		            <div class="sidebar-user-material-body">

		                <div class="sidebar-user-material-footer" >
		                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Мой профиль</span></a>
		                </div>

		            </div>
		            <!-- /user menu -->

		            <div class="collapse" id="user-nav">
		                <ul class="nav nav-sidebar">

		                    <!-- <li class="nav-item">
		                        <a href="index.php" class="nav-link">
		                            <i class="icon-users"></i>
		                            <span>Персонал</span>
		                        </a>
		                    </li> -->
		                    <li class="nav-item">
		                        <a href="<?= logout() ?>" class="nav-link">
		                            <i class="icon-switch2"></i>
		                            <span>Logout</span>
		                        </a>
		                    </li>

		                </ul>
		            </div>


		            <!-- Main navigation -->
		            <div class="card card-sidebar-mobile">

		                <ul class="nav nav-sidebar" data-nav-type="accordion">
		                    <!-- Main -->
		                    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Рабочий стол</div> <i class="icon-menu" title="Main"></i></li>

	                            <?php include 'sidebar.php' ?>
		                </ul>

		            </div>
		            <!-- /main navigation -->

		        </div>
		        <!-- /sidebar content -->

		    </div>
		</div>

		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">
				<div class="card">

					<div class="card-body">
						<form action="savenewpr.php" method="POST" >
							<div class="row">
								<div class="col-md-10">
									<input type="text" name="goodname"  class="form-control">	
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-info">Добавить</button>	
								</div>
							</div>
						</form>
					</div>
					
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>

	<!-- /page content -->

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
