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
									<tr>
								   		<td><?php echo $row['id']; ?></td>
									   	<td class="pass_d" data-id="<?= $row['id']?>">

									   		<div class="date" data-id="<?= $row['id']?>"><?= $row['date_text']; ?></div>


									   		<div class="time" data-id="<?= $row['id']?>"><?= $row['time_text']; ?></div>

									   			
								   		</td>
									   	<td class="pass_e" data-id="<?= $row['id']?>"><?= $row['description']; ?></td>
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


		$(document).on('click', '.pass_e', function function_name() {
			word = $(this).text();

			

			id = $(this).attr('data-id');
			$(this).text('');
			$(this).attr('class', 'activ_e');
			$(this).append(`<input class="form-control inpt" type="text" value="${word}" data-id="${id}">`);

		});

		$(document).on('keypress', '.inpt', function(e) {
			id = $(this).attr('data-id');
			if(e.keyCode == 13){

				$.ajax({
			        type: "POST",

			        url: "ajax/upadateNotes.php",

			        data: { id: id, description : $(this).val()}

			    });

				$(`.activ_e[data-id="${id}"]`).text(`${$(this).val()}`)
				$(`.activ_e[data-id="${id}"]`).attr('class', 'pass_e');
			}
		});

		$(document).on('click', '.pass_d', function function_name() {

			id = $(this).attr('data-id');

			date = $(`.date[data-id="${id}"]`).text();

			time = $(`.time[data-id="${id}"]`).text();

			$(this).text('');

			$(this).attr('class', 'activ_d');

			$(this).append(`<input type="date" class="form-control date1" value="${date}" data-id="${id}">`);

			$(this).append(`<input type="time" class="form-control time1" value="${time}"" data-id="${id}">`);

		});

		$(document).on('keypress', '.date1', function(e) {
			id = $(this).attr('data-id');

			if (e.keyCode == 13) {

				date = $(`.date1[data-id="${id}"]`).val();

				time = $(`.time1[data-id="${id}"]`).val();

				$.ajax({
			        type: "POST",

			        url: "ajax/upadateNotes.php",

			        data: { id: id, date_text : date, time_text : time }

			    });

				$(`.date1[data-id="${id}"]`).remove();

				$(`.time1[data-id="${id}"]`).remove();

				$(`.activ_d[data-id="${id}"]`).append(`<div class="date" data-id="${id}">${date}</div>`);

				$(`.activ_d[data-id="${id}"]`).append(`<div class="time" data-id="${id}">${time}</div>`);


				$(`.activ_d[data-id="${id}"]`).attr('class', 'pass_d');
			}
				
		});

		$(document).on('keypress', '.time1', function(e) {
			id = $(this).attr('data-id');

			if (e.keyCode == 13) {

				date = $(`.date1[data-id="${id}"]`).val();

				time = $(`.time1[data-id="${id}"]`).val();

				$.ajax({
			        type: "POST",

			        url: "ajax/upadateNotes.php",

			        data: { id: id, date_text : date, time_text : time }

			    });

				$(`.date1[data-id="${id}"]`).remove();

				$(`.time1[data-id="${id}"]`).remove();

				$(`.activ_d[data-id="${id}"]`).append(`<div class="date" data-id="${id}">${date}</div>`);

				$(`.activ_d[data-id="${id}"]`).append(`<div class="time" data-id="${id}">${time}</div>`);

				$(`.activ_d[data-id="${id}"]`).attr('class', 'pass_d');
			}
				
		});
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
