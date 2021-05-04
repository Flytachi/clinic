<?php
require_once '../../tools/warframe.php';
$session->is_auth(9);
is_module('module_diet');
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

				<div class="row">

					<?php if( $diet_time = json_decode($db->query("SELECT const_value FROM company_constants WHERE const_label LIKE 'const_diet_time'")->fetchColumn()) ): ?>
						<?php foreach ($diet_time as $time_key => $time): ?>

							<?php
							$inform = $bypass_date_pk = [];
							$sql = "SELECT DISTINCT dt.name,
										(SELECT COUNT(*) FROM bypass bp2 LEFT JOIN bypass_date bpd ON(bpd.bypass_id = bp2.id) WHERE bp.diet_id = bp2.diet_id AND bpd.status IS NOT NULL AND bpd.completed IS NULL AND bpd.date = CURRENT_DATE() AND bpd.time = '$time') 'qty'
									FROM bypass bp 
										LEFT JOIN diet dt ON(dt.id = bp.diet_id)
									WHERE bp.diet_id IS NOT NULL";
							foreach ($db->query($sql) as $key => $value) {
								if($value['qty'] != 0) $inform[$key] = $value;
							}
							foreach ($db->query("SELECT bpd.id FROM bypass bp2 LEFT JOIN bypass_date bpd ON(bpd.bypass_id = bp2.id) WHERE bp2.diet_id IS NOT NULL AND bpd.status IS NOT NULL AND bpd.completed IS NULL AND bpd.date = CURRENT_DATE() AND bpd.time = '$time'") as $value) {
								$bypass_date_pk[] = $value['id'];
							}
							?>
							<div class="col-md-4">
								<div class="<?= $classes['card'] ?>">

									<div class="<?= $classes['card-header'] ?>">
										<h5 class="card-title"><?= $time ?></h5>
										<div class="header-elements">
											<button type="button" class="btn bg-blue btn-icon legitRipple"><i class="icon-cog2"></i></button>
											<button onclick="Diet_completed(this, 'BypassDateModel', '<?= json_encode($bypass_date_pk) ?>', 'table_body<?= $time_key ?>')" type="button" class="btn <?= (count($inform) == 0) ? 'bg-success' : 'bg-danger' ?> btn-icon ml-2 legitRipple" <?= (count($inform) == 0) ? 'disabled' : '' ?>><i class="icon-task"></i></button>
											<button onclick="Print('<?= viv('prints/document_5') ?>?date=<?= date('Y-m-d') ?>&time=<?= $time ?>')" type="button" class="btn btn-dark btn-icon ml-2 legitRipple"><i class="icon-printer2"></i></button>
										</div>
									</div>

									<div class="card-body">

										<table class="table table-hover">
											<tbody id="table_body<?= $time_key ?>">
												<?php if($inform): ?>
													<?php foreach($inform as $row): ?>
														<tr class="table-danger">
															<td><?= $row['name'] ?></td>
															<td class="text-right"><?= $row['qty'] ?></td>
														</tr>
													<?php endforeach; ?>
												<?php else: ?>
													<?php if( $completed = $db->query("SELECT bpd.id FROM bypass bp2 LEFT JOIN bypass_date bpd ON(bpd.bypass_id = bp2.id) WHERE bp2.diet_id IS NOT NULL AND bpd.status IS NOT NULL AND bpd.completed IS NOT NULL AND bpd.date = CURRENT_DATE() AND bpd.time = '$time'")->rowCount() ): ?>
														<tr class="table-success text-center">
															<td colspan="2">Сделано (<?= $completed ?>)</td>
														</tr>
													<?php else: ?>
														<tr class="table-secondary text-center">
															<td colspan="2">Пусто</td>
														</tr>
													<?php endif; ?>
												<?php endif; ?>
											</tbody>
										</table>
										
									</div>

								</div>
							</div>
						<?php unset($inform); unset($bypass_date_pk); endforeach; ?>
					<?php endif; ?>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script>
		function Diet_completed(btn, model, pks, table) {
			$.ajax({
				type: "post",
				url: "<?= add_url() ?>",
				data: {
					model: model,
					pks: pks,
				},
				success: function (result) {
					console.log(result);
					if (!Number(result)) {
						if (result != "success") {
							new Noty({
								text: result,
								type: 'error'
							}).show();
						}else {
							new Noty({
								text: result,
								type: 'success'
							}).show();
							btn.disabled = true;
							btn.className = "btn bg-success btn-icon ml-2 legitRipple";
							$(`#${table}`).html(`
								<tr class="table-primary text-center">
									<td colspan="2">Обновите страницу</td>
								</tr>
							`);
						}
					}
				},
			});
		}
	</script>

	<!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
