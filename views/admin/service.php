<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Услуги";
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

				<div class="card border-1 border-primary">

          			<div class="card-header text-dark header-elements-inline alpha-primary">
		              	<h5 class="card-title">Добавить Услугу</h5>
		          	</div>

		          	<div class="card-body">

						<?php if ($_POST['flush']): ?>

							<?php
							Mixin\T_flush('service');
							$task = Mixin\insert('service', array('id' => 1, 'user_level' => 1, 'name' => "Стационарный Осмотр", 'type' => 101));
							?>

							<?php if (intval($task) == 1): ?>
								<div class="alert alert-primary" role="alert">
						            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
						            Услуги успешно очищены!
						        </div>
							<?php else: ?>
								<div class="alert bg-danger alert-styled-left alert-dismissible">
									<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
									<span class="font-weight-semibold"><?= $task ?></span>
							    </div>
							<?php endif; ?>

						<?php endif; ?>

						<div class="row">

							<div class="col-md-9" id="form_card"><?php ServiceModel::form(); ?></div>

							<div class="col-md-3"><?php ServiceModel::form_template(); ?></div>

						</div>

		          	</div>

	        	</div>

        		<div class="card border-1 border-primary">

	          		<div class="card-header text-dark header-elements-inline alpha-primary">
	                  	<h5 class="card-title">Список Услуг</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
							  	<a href="<?= download_url('ServiceModel', 'Услуги') ?>" class="btn">Шаблон</a>
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
										<th style="width:10%">Код</th>
										<th style="width:40%">Название</th>
										<th>Роль</th>
										<th>Отдел</th>
										<th>Тип</th>
										<th>Цена</th>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
	                              	<?php
	                              	foreach($db->query('SELECT * from service WHERE type != 101') as $row) {
	                                  	?>
                                  		<tr>
											<td><?= $row['code'] ?></td>
											<td><?= $row['name'] ?></td>
	                                      	<td><?= $PERSONAL[$row['user_level']] ?></td>
	                                      	<td><?= ($row['division_id']) ? $db->query("SELECT title FROM division WHERE id ={$row['division_id']}")->fetchColumn() : "" ?></td>
											<td>
												<?php switch ($row['type']) {
													case 1:
														echo "Обычная";
														break;
													case 2:
														echo "Консультация";
														break;
													case 3:
														echo "Операционная";
														break;
												} ?>
											</td>
											<td><?= $row['price'] ?></td>
	                                      	<td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'ServiceModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'ServiceModel') ?>" onclick="return confirm('Вы уверены что хотите удалить услугу?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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

          		</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">
		function Conf() {
			swal({
                position: 'top',
                title: 'Вы уверены что хотите очистить список услуг?',
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

</body>
</html>
