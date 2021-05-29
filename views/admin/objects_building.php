<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Палаты";

$tb = new Table($db, "buildings");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(name) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->set_limit(15);
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
		              	<h5 class="card-title">Добавить Здание</h5>
		              	<div class="header-elements">
	                  		<div class="list-icons">
		                      	<a class="list-icons-item" data-action="collapse"></a>
		                  	</div>
		              	</div>
		          	</div>

		          	<div class="card-body" id="form_card">
		    			<?php (new BuildingsModel)->form(); ?>
		          	</div>

	        	</div>

        		<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список Зданий</h5>
                        <div class="header-elements">
							<form action="" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="form-control border-info" value="<?= $search ?>" id="search_input" placeholder="Введите логин или имя">
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
										<th>Название</th>
										<th>Этажи</th>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
                                    <?php foreach ($tb->get_table() as $row): ?>
										<tr>
				                            <td><?= $row->name ?></td>
				                            <td><?= $row->floors ?> этажей</td>
				                            <td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'BuildingsModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'BuildingsModel') ?>" onclick="return confirm('Вы уверены что хотите удалить палату?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
				url: "<?= ajax('admin/search_objects_building') ?>",
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
