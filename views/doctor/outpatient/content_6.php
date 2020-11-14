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

						<h4 class="card-title">Анализ Пациента</h4>
						<div class="card">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr class="bg-blue text-center">
											<th>ID</th>
											<th>ФИО</th>
											<th>Дата и время</th>
											<th>Имя анализа</th>
											<th>Специалист</th>
											<th>Результаты</th>
											<th>Норматив</th>
											<th>Примечание</th>
										</tr>
									</thead>
									<tbody>
										<tr class="text-center">
											<td>0001</td>
											<td>Якубов Фарход Абдурасулович</td>
											<td>13.03.2020 13:04</td>

											<td>Анализ мочи</td>
											<td>Ахмедова З</td>
											<td>10-12</td>
											<td>10</td>
											<td>Тест</td>
										</tr>
										<tr class="text-center">
											<td>0001</td>
											<td>Якубов Фарход Абдурасулович</td>
											<td>13.03.2020 13:04</td>

											<td>Анализ мочи</td>
											<td>Ахмедова З</td>
											<td>10-12</td>
											<td>10</td>
											<td>Тест</td>
										</tr>
										<tr class="text-center">
											<td>0001</td>
											<td>Якубов Фарход Абдурасулович</td>
											<td>13.03.2020 13:04</td>

											<td>Анализ мочи</td>
											<td>Ахмедова З</td>
											<td>10-12</td>
											<td>10</td>
											<td>Тест</td>
										</tr>
										<tr class="text-center">
											<td>0001</td>
											<td>Якубов Фарход Абдурасулович</td>
											<td>13.03.2020 13:04</td>

											<td>Анализ мочи</td>
											<td>Ахмедова З</td>
											<td>10-12</td>
											<td>10</td>
											<td>Тест</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

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
