<?php
require_once '../../tools/warframe.php';
$session->is_auth(5);
is_config("package");
$header = "Мой пакеты";
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
		              	<h5 class="card-title">Добавить пакет</h5>
		          	</div>

                    <div class="card-body" id="form_card">
                      	<?php (new PackageModel)->form(); ?>
                  	</div>

	        	</div>

                <div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список пакетов</h5>
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
	                              	<tr class="<?= $classes['table-thead'] ?>">
                                        <th style="width:50px">№</th>
										<th style="width:60%">Название</th>
										<th style="width:20%">Дата создания</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php foreach ($db->query("SELECT * from packages WHERE autor_id = {$_SESSION['session_id']}") as $row): ?>
										<tr>
											<td><?= $row['id'] ?></td>
											<td><?= $row['name'] ?></td>
											<td><?= date('Y.m.d H:i', strtotime($row['add_date'])) ?></td>
	                                      	<td class="text-right">
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row['id'], 'PackageModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'PackageModel') ?>" onclick="return confirm('Вы уверены что хотите удалить врача оператора?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
		function Update(events) {
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
