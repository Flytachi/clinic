<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack('global_assets/js/plugins/ui/moment/moment.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js"') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/notifications/jgrowl.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

<!-- <script src="../../../../global_assets/js/demo_pages/picker_date.js"></script> -->


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

						<?php include "content_tabs.php"; ?>

						<div class="card">
							<div class="card-header header-elements-inline">
								<h5 class="card-title">Заметки</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
								</div>
							</div>

							<?php //prit($patient); ?>
							<table id="data_table" class="table table-striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Date</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
								<?php
								foreach ($db->query("SELECT * FROM notes") as $developer) {
								?>
								<tr id="<?php echo $developer ['id']; ?>">
							   		<td><?php echo $developer ['id']; ?></td>
								   	<td><?php echo $developer ['date']; ?></td>
								   	<td><?php echo $developer ['description']; ?></td>
							   	</tr>
								<?php } ?>
								</tbody>
							</table>
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

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Добавить Заметку</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">

					<?php NotesModel::form() ?>

				</div>
			</div>
		</div>
	</div>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
