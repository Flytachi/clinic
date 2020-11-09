<?php
require_once '../../tools/warframe.php';
is_auth(1);
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

				<div class="card">

          			<div class="card-header header-elements-inline">
		              	<h5 class="card-title">Добавить Услугу</h5>
		              	<div class="header-elements">
	                  		<div class="list-icons">
		                      	<a class="list-icons-item" data-action="collapse"></a>
		                  	</div>
		              	</div>
		          	</div>

		          	<div class="card-body" id="form_card">
		    			<?php ServiceModel::form(); ?>
		          	</div>

	        	</div>

        		<div class="card">

	          		<div class="card-header header-elements-inline">
	                  	<h5 class="card-title">Список Услуг</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
	                          	<a class="list-icons-item" data-action="collapse"></a>
	                      	</div>
	                  	</div>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="bg-blue">
										<th style="width:8%">Id</th>
										<th style="width:40%">Название</th>
										<th>Роль</th>
										<th>Отдел</th>
										<th>Цена</th>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
	                              	<?php
	                              	foreach($db->query('SELECT * from service') as $row) {
	                                  	?>
                                  		<tr>
											<td><?= $row['id'] ?></td>
											<td><?= $row['name'] ?></td>
	                                      	<td><?= level_name($row['user_level']) ?></td>
	                                      	<td><?= division_name($row['division_id']) ?></td>
											<td><?= $row['price'] ?></td>
	                                      	<td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'ServiceModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'ServiceModel') ?>" onclick="return confirm('Вы уверены что хотите удалить койку?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
    <?php include '../layout/footer.php' ?>
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
	</script>

</body>
</html>
