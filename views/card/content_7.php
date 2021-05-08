<?php
require_once '../../tools/warframe.php';
$session->is_auth();
is_module('module_bypass');
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/demo_pages/components_popups.js") ?>"></script>
<!-- <script src="<?= stack("vendors/js/custom.js") ?>"></script> -->

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

				<div class="<?= $classes['card'] ?>">
				    <div class="<?= $classes['card-header'] ?>">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

						<?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-magazine mr-2"></i>Лист назначений
							<?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
								<a class="float-right <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_add">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
							<a onclick="Print('<?= viv('prints/sheet') ?>?id=<?= $patient->visit_id ?>')" class="float-right text-info mr-2">
								<i class="icon-drawer3 mr-1"></i>Лист
							</a>
						</legend>

						<?php if ($activity and empty($patient->completed)): ?>

							<div class="card">
								<div class="table-responsive">
									<table class="table table-hover table-sm table-bordered">
										<thead class="<?= $classes['table-thead'] ?>">
											<tr>
												<th style="width: 40px !important;">№</th>
												<th style="width: 45%;">Препарат</th>
												<th>Описание</th>
												<th class="text-center" style="width: 150px;">Метод введения </th>
												<th class="text-center" style="width: 100px;">Время</th>
												<th class="text-right" style="width: 150px;">Действия</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i=1;
											foreach ($db->query("SELECT * FROM bypass WHERE user_id = $patient->id AND visit_id = $patient->visit_id ORDER BY diet_id DESC") as $row) {
												?>
												<tr>
													<td><?= $i++ ?></td>
													<td>
														<?php
														if ($row['diet_id']) {
															echo "<b>Диета: </b>".$db->query("SELECT name FROM diet WHERE id = {$row['diet_id']}")->fetchColumn();
														}else {
															foreach ($db->query("SELECT preparat_id, preparat_name, preparat_supplier, preparat_die_date FROM bypass_preparat WHERE bypass_id = {$row['id']}") as $serv) {
																if ($serv['preparat_id']) {
																	echo $serv['preparat_name']. " | " .$serv['preparat_supplier']. " (годен до " .date("d.m.Y", strtotime($serv['preparat_die_date'])).")<br>";
																} else {
																	echo $serv['preparat_name']."<br>";
																}
															}
														}
														?>
													</td>
													<td><?= $row['description'] ?></td>
													<td><?= ( isset($row['method']) ) ? $methods[$row['method']] : '' ?></td>
													<td class="text-center">
														<?php foreach ($db->query("SELECT status, completed, time FROM bypass_date WHERE bypass_id = {$row['id']} AND date = CURRENT_DATE()") as $time): ?>
															<?php if ($time['status']): ?>
																<?php if ($time['completed']): ?>
																	<span class="text-success"><?= date('H:i', strtotime($time['time'])) ?></span><br>
																<?php else: ?>
																	<span class="text-danger"><?= date('H:i', strtotime($time['time'])) ?></span><br>
																<?php endif; ?>
															<?php else: ?>
																<span class="text-muted"><?= date('H:i', strtotime($time['time'])) ?></span><br>
															<?php endif; ?>
														<?php endforeach; ?>
													</td>
													<td>
														<button onclick="Check('<?= viv('card/bypass') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple">Подробнее</button>
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>

						<?php else: ?>

							<div class="alert bg-warning alert-styled-left alert-dismissible">
								<span class="font-weight-semibold">Технические работы</span>
							</div>

						<?php endif; ?>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<?php if ($activity): ?>
		<div id="modal_add" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content border-3 border-info">
					<div class="modal-header bg-info">
						<h5 class="modal-title">Назначить препарат</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					
					</div>

					<?php (new BypassModel)->form() ?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="modal_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_show').modal('show');
					$('#div_show').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
