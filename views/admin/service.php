<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Услуги";

$tb = new Table($db, "services sc");
$tb->set_data("sc.*, ds.title")->additions("LEFT JOIN divisions ds ON(ds.id=sc.division_id)");
$search = $tb->get_serch();
$where_search = array("sc.type != 101", "sc.type != 101 AND ( sc.code LIKE '%$search%' OR LOWER(sc.name) LIKE LOWER('%$search%') OR LOWER(ds.title) LIKE LOWER('%$search%') )");

$tb->where_or_serch($where_search)->order_by("user_level, division_id, code, name ASC")->set_limit(15);
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
		              	<h5 class="card-title">Добавить Услугу</h5>
		          	</div>

		          	<div class="card-body">

						<?php if ( isset($_POST['flush']) ): ?>

							<?php
							Mixin\T_flush('services');
							$task = Mixin\insert('services', array('id' => 1, 'user_level' => 1, 'name' => "Стационарный Осмотр", 'type' => 101));
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

							<div class="col-md-9" id="form_card"><?php (new ServiceModel)->form(); ?></div>

							<div class="col-md-3"><?php (new ServiceModel)->form_template(); ?></div>

						</div>

		          	</div>

	        	</div>

        		<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список Услуг</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
							  	<a href="<?= download_url('ServiceModel', 'Услуги') ?>" class="btn">Шаблон</a>
								<form action="" method="post">
									<input style="display:none;" id="btn_flush" type="submit" value="FLUSH" name="flush"></input>
								</form>
								<a class="btn text-danger" onclick="Conf()">FLUSH</a>
	                      	</div>
							<form action="" class="mr-2 ml-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск...">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
	                  	</div>
	              	</div>

              		<div class="card-body" id="search_display">

                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
										<th style="width:7%">№</th>
										<th>Роль</th>
										<th>Отдел</th>
										<th style="width:10%">Код</th>
										<th style="width:40%">Название</th>
										<th>Тип</th>
										<th>Цена</th>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
	                              	<?php foreach($tb->get_table(1) as $row): ?>
                                  		<tr>
											<td><?= $row->count ?></td>
	                                      	<td><?= $PERSONAL[$row->user_level] ?></td>
	                                      	<td><?= $row->title ?></td>
											<td><?= $row->code ?></td>
											<td><?= $row->name ?></td>
											<td>
												<?php switch ($row->type) {
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
											<td><?= $row->price ?></td>
	                                      	<td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'ServiceModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'ServiceModel') ?>" onclick="return confirm('Вы уверены что хотите удалить услугу?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
	                                      	</td>
                              			</tr>
									<?php endforeach; ?>
	                          	</tbody>
	                      	</table>
	                  	</div>

						<?php $tb->get_panel(); ?>
						
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

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('admin/search_service') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

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
