<?php
require_once '../../../tools/warframe.php';
is_auth(7);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>

<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

					<div class="card-body">

					   <?php
					   include "content_tabs.php";
					   if($_SESSION['message']){
						   echo $_SESSION['message'];
						   unset($_SESSION['message']);
					   }
					   ?>

					   <div class="card">

						   <div class="card-header header-elements-inline">
							   <h6 class="card-title">Примечание Врача</h6>
						   </div>

						   <div class="table-responsive">
							   <table class="table table-hover table-sm table-bordered">
 								  <thead>
 									  <tr class="bg-info">
 										  <th style="width: 40px !important;">№</th>
 										  <th style="width: 400px;">Препарат</th>
 										  <th>Описание</th>
 										  <th class="text-center" style="width: 150px;">Метод введения </th>
 										  <th class="text-right" style="width: 150px;">Действия</th>
 									  </tr>
 								  </thead>
 								  <tbody>
 									  <?php
 									  $i=1;
 									  foreach ($db->query("SELECT * FROM bypass WHERE user_id = $patient->id") as $row) {
 										  ?>
 										  <tr>
 											  <td><?= $i++ ?></td>
 											  <td>
 												  <?php
 												  foreach ($db->query("SELECT preparat_id FROM bypass_preparat WHERE bypass_id = {$row['id']}") as $serv) {
 													  echo $serv['preparat_id']." Препарат -------------<br>";
 												  }
 												  ?>
 											  </td>
 											  <td><?= $row['description'] ?></td>
 											  <td><?= $methods[$row['method']] ?></td>
 											  <td>
 												  <button onclick="Check('<?= viv('doctor/bypass') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple">Подробнее</button>
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

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<div id="modal_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_show').modal('show');
					$('#div_show').html(data);
				},
			});
		};
	</script>
    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
