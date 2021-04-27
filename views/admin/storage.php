<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Аптека";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Добавить Препарат</h5>
					</div>

					<div class="card-body">

						<?php if ($_POST['flush']): ?>

							<?php
							$__storage = Mixin\T_flush('storage');
							?>

							<?php if (!$__storage): ?>
								<div class="alert alert-primary" role="alert">
									<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
									Препараты успешно очищены!
								</div>
							<?php else: ?>
								<div class="alert bg-danger alert-styled-left alert-dismissible">
									<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
									<span class="font-weight-semibold"><?= $task ?></span>
								</div>
							<?php endif; ?>

						<?php endif; ?>

						<div class="row">

							<div class="col-md-9" id="form_card"><?php Storage::form(); ?></div>

							<div class="col-md-3"><?php Storage::form_template(); ?></div>

						</div>

					</div>

				</div>

				<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список Препаратов</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
							  <a href="<?= download_url('Storage', 'Препараты') ?>" class="btn">Шаблон</a>
								<form action="" method="post">
									<input style="display:none;" id="btn_flush" type="submit" value="FLUSH" name="flush"></input>
								</form>
								<a class="btn text-danger" onclick="Conf()">FLUSH</a>
	                      	</div>
	                  	</div>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive">
	                      	<table class="table table-hover datatable-basic">
	                          	<thead>
	                              	<tr class="bg-blue">
									  	<th style="width:35%">Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Код</th>
										<th>Категория</th>
                                        <th>Срок годности</th>
										<th class="text-right">Бронь</th>
                                        <th class="text-right">Кол-во</th>
                                        <th class="text-right">Цена ед.</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
								  <?php
									$sql = "SELECT st.*,
									 		(
												IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) +
												IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)

											) 'reservation'
											FROM storage st ORDER BY st.name ASC";
								 	?>
                                    <?php foreach ($db->query($sql) as $row): ?>
										<?php
										$tr="";
										if ($dr= date_diff(new \DateTime(), new \DateTime($row['die_date']))->days <= 10) {
											// Предупреждение срока годности
											$tr = "bg-teal text-dark";
										}elseif ($row['qty'] <= 10) {
											// Предупреждение критическое
											$tr = "bg-danger";
										}elseif ($row['qty_limit'] and $row['qty'] <= $row['qty_limit']){
											// Предупреждение
											$tr = "bg-orange text-dark";
										}
										?>
										<tr class="<?= $tr ?>">
											<td><?= $row['name'] ?></td>
											<td><?= $row['supplier'] ?></td>
											<td><?= $row['code'] ?></td>
											<td><?= $CATEGORY[$row['category']] ?></td>
											<td><?= date("d.m.Y", strtotime($row['die_date'])) ?></td>
											<td class="text-right"><?= $row['reservation'] ?></td>
											<td class="text-right"><?= $row['qty'] ?></td>
											<td class="text-right"><?= number_format($row['price'], 1) ?></td>
											<td class="text-right">
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'Storage') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'Storage') ?>" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
	                          	</tbody>
	                      	</table>
	                  	</div>
	              	</div>

          		</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">
		function Conf() {
			swal({
                position: 'top',
                title: 'Вы уверены что хотите очистить список препаратов?',
                type: 'info',
                showCancelButton: true,
                confirmButtonText: "Уверен"
            }).then(function(ivi) {
				if (ivi.value) {
					swal({
		                position: 'top',
		                title: 'Внимание!',
		                text: 'Вернуть данные назад будет невозможно!',
		                type: 'warning',
		                showCancelButton: true,
		                confirmButtonText: "Да"
		            }).then(function(ivi) {
						if (ivi.value) {
							$('#btn_flush').click();
						}
		            });
				}

            });
		}

		function Update(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
