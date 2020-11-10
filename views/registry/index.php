<?php
require_once '../../tools/warframe.php';
is_auth(2);
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
			<!-- Content area -->
			<div class="content">

				<div class="row">
					<div class="col-md-6">

					</div>

					<div class="col-md-6">

					</div>
				</div>

				<div class="card">

					<div class="card-header">
						<ul class="nav nav-tabs nav-justified">
							<li class="nav-item"><a href="#basic-justified-tab1" class="nav-link legitRipple active show" data-toggle="tab">Регистрация</a></li>
							<li class="nav-item"><a href="#basic-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационарная</a></li>
							<li class="nav-item"><a href="#basic-justified-tab3" class="nav-link legitRipple" data-toggle="tab">Амбулаторная</a></li>
							<li class="nav-item"><a href="#basic-justified-tab4" class="nav-link legitRipple" data-toggle="tab">Список пациетов</a></li>
						</ul>
					</div>

					<div class="card-body">

						<div class="tab-content">
							<div class="tab-pane fade active show" id="basic-justified-tab1">
								<?php PatientForm::form(); ?>
							</div>

							<div class="tab-pane fade" id="basic-justified-tab2">
								<?php StationaryTreatmentForm::form(); ?>
							</div>

							<div class="tab-pane fade" id="basic-justified-tab3">
								<?php OutpatientTreatmentForm::form(); ?>
							</div>

							<div class="tab-pane fade" id="basic-justified-tab4">
								<div class="card card-table table-responsive shadow-0 mb-0">
								    <table class="table table-bordered">
										<thead class="bg-blue text-center">
											<tr>
												<th>ID</th>
												<th>ФИО</th>
												<th>Дата рождение</th>
												<th>Телефон</th>
												<th>Регион</th>
												<th>Тип визита</th>
												<th>Дата визита</th>
												<th class="text-center">Действия</th>
											</tr>
										</thead>
										<tbody>
								            <?php
								            $i = 1;
								            foreach($db->query('SELECT * FROM users WHERE user_level = 15 ORDER BY add_date DESC') as $row) {
								                ?>
								                <tr>
								                    <td><?= addZero($row['id']) ?></td>
								                    <td>
														<div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
														<div class="text-muted">
															<?php
															if($stm = $db->query('SELECT floor, ward, num FROM beds WHERE user_id='.$row['id'])->fetch()){
																echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['num']." койка";
															}
															?>
														</div>
													</td>
								                    <td><?= $row['dateBith'] ?></td>
								                    <td><?= $row['numberPhone'] ?></td>
								                    <td><?= $row['region'] ?></td>
													<td><?= ($row['status_bed']) ? "Стационарный" : "Амбулаторная" ?></td>
								                    <td><?= $row['add_date'] ?></td>
								                    <td class="text-center">
														<button onclick="Update('<?= up_url($row['id'], 'PatientForm') ?>')" type="button" class="btn btn-outline-primary btn-lg legitRipple">Редактировать</button>
								                    </td>
								                </tr>
								                <?php
								            }
								            ?>
								        </tbody>
									</table>
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

    <?php include 'layout/footer.php' ?>

    <!-- /footer -->

	<script type="text/javascript">
		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#basic-justified-tab1').html(result);
					TabControl('basic-justified-tab1');
				},
			});
		};
	</script>

</body>
</html>
