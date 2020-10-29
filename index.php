<?php
require_once 'tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= ShowTitle() ?></title>

	<!-- Global stylesheets -->
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

	<script src="assets/js/app.js"></script>
	<script src="global_assets/js/demo_pages/form_layouts.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	<?php include 'layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

				<?php
				if(permission(1)){
					?>
					<div class="card">

						<div class="card-header header-elements-inline">
							<h5 class="card-title">Служебный персонал</h5>
							<div class="header-elements">
								<div class="list-icons">
									<a class="list-icons-item" data-action="collapse"></a>
									<a class="list-icons-item" data-action="reload"></a>
									<a class="list-icons-item" data-action="remove"></a>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr class="bg-blue">
										<th>#</th>
										<th>Логин</th>
										<th>Ф.И.О</th>
										<th style="width: 100px">Действия</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i = 1;
									foreach($db->query('SELECT * from users') as $row) {
										?>
										<tr>
											<td><?= $i++ ?></td>
											<td><?= $row['username'] ?></td>
											<td><?= get_full_name($row['id']); ?></td>
											<td>
												<div class="list-icons">
													<a href="#" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="model/delete.php?<?= delete($row['id'], 'users', 'index.php') ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													<!-- <a href="#" class="list-icons-item text-teal-600"><i class="icon-cog6"></i></a> -->
												</div>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>
						</div>

					</div>
					<?php
				}elseif (permission(2)) {
					
				}
				?>

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
