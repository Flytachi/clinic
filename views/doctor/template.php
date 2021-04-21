<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Шаблоны";
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

				<div class="card">

          			<div class="card-header header-elements-inline">
		              	<h5 class="card-title">Добавить шаблон</h5>
		              	<div class="header-elements">
	                  		<div class="list-icons">
		                      	<a class="list-icons-item" data-action="collapse"></a>
		                  	</div>
		              	</div>
		          	</div>

		          	<div class="card-body" id="form_card">
		    			<?php TemplateModel::form(); ?>
		          	</div>

	        	</div>

        		<div class="card">

	          		<div class="card-header header-elements-inline">
	                  	<h5 class="card-title">Список Шаблонов</h5>
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
                                        <th style="width:50px">№</th>
										<th style="width:60%">Название</th>
										<th style="width:20%">Дата создания</th>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
	                              	<?php
	                              	foreach($db->query("SELECT * from templates WHERE autor_id = {$_SESSION['session_id']}") as $row) {
	                                  	?>
                                  		<tr>
											<td><?= $row['id'] ?></td>
											<td><?= $row['name'] ?></td>
											<td><?= date('Y.m.d H:i', strtotime($row['add_date'])) ?></td>
	                                      	<td>
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'TemplateModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a onclick="Update('<?= up_url($row['id'], 'TemplateModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'TemplateModel') ?>" onclick="return confirm('Вы уверены что хотите удалить врача оператора?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
