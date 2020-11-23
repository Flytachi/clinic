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
							</div>

							<?php NotesModel::form() ?>

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

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
    <script>

    	let id = '<?= $_SESSION['session_id'] ?>';


		function addZero(number){

		    let strNumber = String(number);
		    let newNumber = "";

		    if(strNumber.length < 2){

		        let countZero = 2 - strNumber.length;

		        for ($i=0; $i < countZero; $i++) {

		            newNumber += "0";
		        }
		        newNumber += strNumber;
		        return newNumber;
		    }

		    return strNumber;
		}

    	var conn = new WebSocket("ws://<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>");
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
			let d = JSON.parse(e.data)

			let time = new Date();

			let hour = addZero(time.getHours());

			let mitune = addZero(time.getMinutes());

			if(d.id == id || d.id_cli == id ){

				if(d.id == id){
					$(`ul[data-chatid=${d.id_cli}]`).append(`<li class="media media-chat-item-reverse">
													<div class="media-body">
														<div class="media-chat-item">${d.message}</div>
														<div class="font-size-sm text-muted mt-2">
															${ hour } : ${ mitune } <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
														</div>
													</div>

													<div class="ml-3">
														<a href="#">
															<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
														</a>
													</div>
												</li>`)
				}else{

					let active = $('a.show').attr('data-idChat');


					if(active == d.id){
					    $(`ul[data-chatid=${d.id}]`).append(`<li class="media">
															<div class="mr-3">
																<a href="#">
																	<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
																</a>
															</div>

															<div class="media-body">
																<div class="media-chat-item"> ${d.message} </div>
																<div class="font-size-sm text-muted mt-2">
																	${ hour } : ${ mitune } <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
																</div>
															</div>
														</li>`)
					}else{
						let p = Number($(`p[data-idChat=${d.id}]`).text()) + 1;

						let b = Number($(`b#noticeus`).text()) + 1;

						$(`b#noticeus`).html(b);

						$(`p[data-idChat=${d.id}]`).text(p)						

						console.log(p);
					}
				}
			}

		};

		$('textarea').keypress(function(e){
			console.log(e.keyCode);

			if(e.keyCode == 13){
				let id_cli = $(this).attr('data-inputid');
				let word = $(this).val();
				$(this).val('');
				let obj = JSON.stringify({ id : id, id_cli : id_cli, message : word });
				conn.send(obj);
			}
		})

		function sendMessage(body) {
			let id_cli = body.dataset.buttonid;
			let word = $(`textarea[data-inputid=${id_cli}]`).val();
			console.log(word);
			$(`textarea[data-inputid=${id_cli}]`).val('');
			let obj = JSON.stringify({ id : id, id_cli : id_cli, message : word });
			conn.send(obj);
		}

		function deletNotice(body) {
			let id1 = $(body).attr('data-idChat');
			let count;

			try{
				console.log('--------------------------------')
				count = Number($(`b#noticeus`).html()) - Number($(`p[data-idChat=${id1}]`).html());
				$(`b#noticeus`).html(count);
				$(`p[data-idChat=${id1}]`).html('');
			}catch{
				console.log('error')
			}
		}

    </script>

</body>
</html>
