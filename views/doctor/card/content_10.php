<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<link href="<?= stack("global_assets/js/plugins/datetimepicker-master/jquery.datetimepicker.css") ?>" rel="stylesheet" type="text/css">
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

						<?php
						include "content_tabs.php";
						if($_SESSION['message']){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

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
								foreach ($db->query("SELECT * FROM notes WHERE visit_id = $patient->visit_id AND parent_id = {$_SESSION['session_id']}") as $row) {
								?>
									<tr data-id="<?php echo $row['id']; ?>">
								   		<td><?php echo $row['id']; ?></td>
									   	<td class="pass_d" data-id="<?= $row['id'] ?>"><?php echo $row['date']; ?></td>
									   	<td class="pass_e"><?php echo $row['description']; ?></td>
								   	</tr>
								<?php
								}
								?>
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

				<?php NotesModel::form() ?>

			</div>
		</div>
	</div>
	<script src="<?= stack('global_assets/js/plugins/datetimepicker-master/build/jquery.datetimepicker.full.js') ?>"></script>


	<script>

		<?php
		foreach ($db->query("SELECT * FROM notes WHERE visit_id = $patient->visit_id AND parent_id = {$_SESSION['session_id']}") as $row) {
		?>
		$(document).on('click', '.datati', function function_name() {


			$('#<?= $row['id'] ?>').AnyTime_picker({
	            format: '%M %D %H:%i',
	        });
		});
		<?php
		}
		?>

		$(document).on('click', '.pass_e', function function_name() {
			word = $(this).text();
			$(this).text('');
			$(this).attr('class', 'activ_e');
			$(this).append(`<input class="form-control inpt" type="text" value="${word}">`);

		});

		$(document).on('keypress', '.inpt', function(e) {
			if(e.keyCode == 13){
				$('.activ_e').text(`${$(this).val()}`)
				$('.activ_e').attr('class', 'pass_e');
			}
		});

		$(document).on('click', '.pass_d', function function_name() {
			word = $(this).text();
			$(this).text('');
			$(this).attr('class', 'activ_d');
			id = $(this).attr('data-id');
			$(this).append(`<input type="text" class="form-control datati" value="${0}" id="${id}">`);	
		});

		$(document).on('keypress', '.datati', function(e) {
			alert(e.keyCode);
			if(e.keyCode == 115){
				alert('d');
				$('.activ_d').text(`${$(this).val()}`)
				$('.activ_d').attr('class', 'pass_d');
			}
		});

	</script>


	<script>
		

		<?php
		foreach ($db->query("SELECT * FROM notes WHERE visit_id = $patient->visit_id AND parent_id = {$_SESSION['session_id']}") as $row) {
		?>
		$(document).on('keypress', '#AnyTime--<?= $row['id'] ?>', function function_name(e) {
			alert(e.keyCode);
			if(e.keyCode == 115){
				alert('d');
				$('.activ_d').text(`${$(this).val()}`)
				$('.activ_d').attr('class', 'pass_d');
			}
		});
		<?php
		}
		?>
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
