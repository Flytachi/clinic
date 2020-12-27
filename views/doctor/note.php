<?php
require_once '../../tools/warframe.php';
is_auth([5,8]);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>
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
	<?php

		$id = $_SESSION['session_id'];

		$sql = "SELECT * FROM notes WHERE parent_id = $id AND status = 0";

		$res = $db->query($sql)->fetchAll();

	?>
<script>


	let mas = [
	<?php

		foreach ($res as $key) {
	?>

	{
		date : new Date('<?= $key['date_text']?> <?= $key['time_text']?>').getTime(),

		text : "<?= $key['description']?>",

		id : <?= $key['id']?>
	},


	<?php
		}

	?>


	]



	setInterval(function () {
		// alert(mas.length);
		if(mas.length != 0){
			for(let i = 0; i < mas.length; i++){
				if((Math.trunc(Date.now() / 100000) - Math.trunc(mas[i].date / 100000)) >= 0 ){

					new Noty({
			            text: mas[i].text,
			            type: 'info'
			        }).show();


					$.ajax({
				        type: "POST",

				        url: "card/ajax/upadateNotes1.php",

				        data: { id: mas[i].id, status : 1 }

				    });
					delete mas[i];
				}
			}
		}
	}, 1000);


</script>

<!-- <script src="../../../../global_assets/js/demo_pages/picker_date.js"></script> -->


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

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<div class="card border-1 border-info">

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
										<th>Дата</th>
										<th>Описания</th>
										<th>Удалить</th>
									</tr>
								</thead>
								<tbody>
								<?php
								foreach ($db->query("SELECT * FROM notes WHERE parent_id = {$_SESSION['session_id']}") as $row) {
								?>
									<tr data-id="<?= $row['id']?>">
									   	<td class="pass_d" data-id="<?= $row['id']?>">

									   		<div class="date" data-id="<?= $row['id']?>"><?= $row['date_text']; ?></div>


									   		<div class="time" data-id="<?= $row['id']?>"><?= $row['time_text']; ?></div>


								   		</td>
									   	<td class="pass_e" data-id="<?= $row['id']?>"><?= $row['description']; ?></td>
									   	<td>
									   		<button data-id="<?= $row['id']?>" type="button" class="btn btn-danger legitRipple active">Удалить</button>
									   	</td>
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
	<script>


		$(document).on('click', '.pass_e', function function_name() {
			word = $(this).text();



			id = $(this).attr('data-id');
			$(this).text('');
			$(this).attr('class', 'activ_e');
			$(this).append(`<input class="form-control inpt" type="text" value="${word}" data-id="${id}">`);

		});

		$(document).on('click', 'button', function() {
			id = $(this).attr('data-id');

			$.ajax({
		        type: "POST",

		        url: "card/ajax/deletNotes.php",

		        data: { id: id}

		    });

		    $(`tr[data-id="${id}"]`).remove();
		});

		$(document).on('keypress', '.inpt', function(e) {
			id = $(this).attr('data-id');
			if(e.keyCode == 13){

				$.ajax({
			        type: "POST",

			        url: "card/ajax/upadateNotes.php",

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

			        url: "card/ajax/upadateNotes.php",

			        data: { id: id, date_text : date, time_text : time }

			    });

			    $.ajax({
			        type: "POST",

			        url: "card/ajax/upadateNotes1.php",

			        data: { id: id, status : 0 }

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

			        url: "card/ajax/upadateNotes.php",

			        data: { id: id, date_text : date, time_text : time }

			    });

			    $.ajax({
			        type: "POST",

			        url: "card/ajax/upadateNotes1.php",

			        data: { id: id, status : 0 }

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
