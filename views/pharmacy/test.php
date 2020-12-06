<?php
require_once '../../tools/warframe.php';
$header = "Персонал";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

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

	                            <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-users"></i>
                                        <span>Продажа</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-users"></i>
                                        <span>Препараты (товары)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-bed2"></i>
                                        <span>Клиенты</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-bed2"></i>
                                        <span>Поставщики</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-bed2"></i>
                                        <span>Отчет продаж</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-width"></i>
                                        <span>Инвентаризация продаж</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link legitRipple">
                                        <i class="icon-width"></i>
                                        <span>Все наименования</span>
                                    </a>
                                </li>
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
							<div class="row">
								<div class="card col-md-4">
									<div class="card-header">
										<h6 class="card-title">Продажа</h6>
									</div>
								</div>

								<div class="card col-md-4">
									<div class="card-header">
										<h6 class="card-title">Препараты (товары)</h6>
									</div>
								</div>
								<div class="card col-md-4">
									<div class="card-header">
										<h6 class="card-title">Препараты (товары)</h6>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="card col-md-4">
									<div class="card-header">
										<h6 class="card-title">Поставщики</h6>
									</div>
								</div>

								<div class="card col-md-4">
									<div class="card-header">
										<h6 class="card-title">Отчет продаж</h6>
									</div>
								</div>
								<div class="card col-md-4">
									<div class="card-header">
										<h6 class="card-title">Инвентаризация продаж</h6>
									</div>
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
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
