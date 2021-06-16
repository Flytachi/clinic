<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Палаты";

$tb = new Table($db, "wards w");
$search = $tb->get_serch();
$tb->set_data("w.id, bg.name, ds.title, w.floor, w.ward")->additions("LEFT JOIN buildings bg ON(bg.id=w.building_id) LEFT JOIN divisions ds ON(ds.id=w.division_id)");
$where_search = array(null, "LOWER(bg.name) LIKE LOWER('%$search%') OR LOWER(ds.title) LIKE LOWER('%$search%') OR LOWER(w.ward) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("bg.name, w.floor, w.ward ASC")->set_limit(15);
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
		              	<h5 class="card-title">Добавить Палату</h5>
		              	<div class="header-elements">
	                      	<div class="list-icons">
	                          	<a class="list-icons-item" data-action="collapse"></a>
	                      	</div>
	                  	</div>
		          	</div>

		          	<div class="card-body" id="form_card">
		    			<?php (new WardsModel)->form(); ?>
		          	</div>

	        	</div>

        		<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список Палат</h5>
						<div class="header-elements">
							<form action="" class="mr-2">
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
										<th style="width:8%">№</th>
										<th>Объект</th>
										<th>Этаж</th>
										<th>Палата</th>
										<?php if(config('wards_by_division')): ?>
											<th>Отдел</th>
                						<?php endif; ?>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
								  	<?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
				                            <td><?= $row->count ?></td>
				                            <td><?= $row->name ?></td>
				                            <td><?= $row->floor ?> этаж</td>
				                            <td><?= $row->ward ?></td>
											<?php if(config('wards_by_division')): ?>
				                            	<td><?= $row->title ?></td>
											<?php endif; ?>
				                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'WardsModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'WardsModel') ?>" onclick="return confirm('Вы уверены что хотите удалить палату?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('admin/search_objects_ward') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});
	</script>

</body>
</html>
