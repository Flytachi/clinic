<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('module_pharmacy');
$header = "Аптека";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

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

						<?php if ( isset($_POST['flush']) ): ?>

							<?php
							$__storage = Mixin\T_flush('storages');
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

							<div class="col-md-9" id="form_card"><?php (new StoragesModel)->form(); ?></div>

							<div class="col-md-3"><?php (new StoragesModel)->form_template(); ?></div>

						</div>

					</div>

				</div>

				<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Склад</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
								<form action="" method="post">
									<input style="display:none;" id="btn_flush" type="submit" value="FLUSH" name="flush"></input>
								</form>
								<a class="btn text-danger" onclick="Conf()">FLUSH</a>
							  	<a href="<?= download_url('StoragesModel', 'Препараты') ?>" class="btn">Шаблон</a>
							  	<a href="<?= download_url('StoragesModel', 'Препараты', true) ?>" class="btn">Лист поступления</a>
	                      	</div>
	                  	</div>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
									  	<th>Ключ</th>
									  	<th style="width:35%">Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Срок годности</th>
                                        <th class="text-right">Кол-во</th>
                                        <th class="text-right">Цена прихода</th>
                                        <th class="text-right">Цена расхода</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php
									$tb = new Table($db, "storages");
									?>
                                    <?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->item_key ?></td>
											<td><?= $row->item_name ?></td>
											<td><?= $row->item_supplier ?></td>
											<td><?= date_f($row->item_die_date) ?></td>
											<td class="text-right"><?= $row->item_qty ?></td>
											<td class="text-right"><?= number_format($row->item_cost, 1) ?></td>
											<td class="text-right"><?= number_format($row->item_price, 1) ?></td>
											<td class="text-right">
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'StoragesModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'StoragesModel') ?>" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
