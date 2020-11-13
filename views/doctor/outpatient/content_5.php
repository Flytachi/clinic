<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "../profile_card.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">
				        <?php include "content_tabs.php"; ?>

						<h4 class="card-title">Мои Заключение</h4>
						<table class="table table-hover table-columned">
							<thead>
								<tr class="bg-blue text-center">
									<th>ID</th>
									<th>ФИО</th>
									<th>Дата и время</th>
									<th>Тип визита</th>
									<th>Тип Группы</th>
									<th>Мед услуга</th>
									<th class="text-center">Действия</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-center">
									<td>1</td>
									<td>2</td>
									<td>4</td>
									<td>5</td>
									<td>6</td>
									<td>7</td>
									<td class="text-center">
										<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="#" data-toggle="modal" data-target="#modal_2323" class="dropdown-item"><i class="icon-paste2"></i>История</a>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
