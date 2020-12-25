<?php
require_once '../tools/warframe.php';
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= ShowTitle() ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/components.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/colors.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("vendors/css/style.css") ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?= stack("global_assets/js/main/jquery.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/main/bootstrap.bundle.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/loaders/blockui.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/ui/ripple.min.js") ?>"></script>
	<script src="<?= stack("vendors/js/box.js") ?>"></script>
	<!-- /core JS files -->

	<script src="<?= stack("global_assets/js/plugins/notifications/jgrowl.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/notifications/noty.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/notifications/sweet_alert.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

	<!-- Theme JS files -->
	<script src="<?= stack("global_assets/js/plugins/ui/moment/moment.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/visualization/d3/d3.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/visualization/d3/d3_tooltip.js") ?>"></script>
	<!-- /theme JS files -->

	<script src="<?= stack("assets/js/app.js") ?>"></script>

	<script src="<?= stack("global_assets/js/demo_pages/extra_sweetalert.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/extra_jgrowl_noty.js") ?>"></script>

	<!-- JS chained -->
	<script src="<?= stack("vendors/js/jquery.chained.js") ?>"></script>

	<script>
			let id = '1983';
			let conn = new WebSocket("ws://<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>");
	</script>
	<script src="<?= stack("vendors/js/scriptJS/socket.js") ?>"></script>
	<!-- Theme JS files -->
	<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js")?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js")?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/components_dropdowns.js")?>"></script>
	<!-- /theme JS files -->
</head>




<!-- Theme JS files -->
<!-- /theme JS files -->

<body>
	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark bg-info navbar-static" >
	    <div class="navbar-brand">
	        <ul class="navbar-nav ml-md-auto">
				<li class="nav-item dropdown show">
					<a href="#" data-toggle="dropdown" aria-expanded="true">
			            <img src="<?= stack("global_assets/images/logo_light.png") ?>" alt="">
			        </a>

					<div class="dropdown-menu dropdown-menu-left dropdown-content wmin-md-350">
						<div class="dropdown-content-body p-1">
							<div class="row no-gutters">

								<div class="dropdown-menu" id="dm" style="display: block; position: static; width: 100%; margin-top: 0; float: none; z-index: auto;">

								<?php

									$sql = "SELECT us.* FROM users us LEFT JOIN division dv ON (dv.id = us.division_id) WHERE us.user_level = 5 OR (dv.assist != 2 AND us.user_level = 10)";

									$allUser = $db->query($sql)->fetchAll();

									foreach ($allUser as $key) {
								?>

									<div class="dropdown-item form-check">
										<label class="form-check-label">
											<div class="chew" data-chatid="<?= $key['id'] ?>">
												<input type="checkbox" class="form-input-styled"   data-fouc>
											</div>
											<?= $key['last_name'] ?> - <?= $key['first_name'] ?>
										</label>
									</div>

								<?php
									}

								?>
							</div>
						</div>
						</div>
					</div>
				</li>
			</ul>
	    </div>

	    <div class="d-md-none">
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
	            <i class="icon-tree5"></i>
	        </button>
	        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
	            <i class="icon-paragraph-justify3"></i>
	        </button>
	    </div>

	    <div class="collapse navbar-collapse" id="navbar-mobile">

	        <span class="ml-md-3 siya-long" id="timedisplay"></span>

	        <script>

	        	let we = "";

	        	$(document).on('click', '.chew', function () {
	        		id1 = $(this).attr('data-chatid');

	        		// alert($(''))

	        		$(this).attr('class', "dele");

	        		$.ajax({
				        type: "POST",

				        url: "visit.php",

				        data: { id: id1},

				        success : function (data) {

				        	let d = JSON.parse(data);
				        	console.log(d);

				        	cout = Number($("#dd").attr("data-cout"));

				        	let queue = d.queue;

				        	let reception = d.reception;

				        	console.log(reception);

				        	if(reception.length != 0){
					        	we += `<tr style=" background-color: #97E32F;"><td>${ reception[0].first_name }</td><td>${ reception[0].last_name }</td></tr>`;

				        	}


				        	for (let i = 0; i < queue.length; i++) {
				        		we += `<tr style=" background-color: #E3E64C;" data-userid="${ queue[i].user_id }" data-parentid="${ queue[i].parent_id }">
				        				<td>${ queue[i].user_id }</td>
				        				<td>${ queue[i].last_name } - ${ queue[i].first_name }</td>
				        				</tr>`
				        	}

				        	if ( cout == 0 ||  cout != 1 && cout % 2 == 0) {
				        		$('#dd').append(`<div class="col-md-12 card" id="ad" style="height: 50%; max-width: 99%; margin-right: 1%; padding: 0px;" data-chatid1="${id1}">
									<div class="card-header alpha-success text-success-800 header-elements-inline">
										<h6 class="card-title">${id1} - Кабинет</h6>
									</div>
									<div class="table-responsive card-body" style="padding: 0px;">
										<table class="table table-hover">
							                <thead>
							                    <tr class="bg-blue">
								                    <th> Номер </th>
													<th> Пациент </th>
							                    </tr>
							                </thead>
							                <tbody id="${id1}">

							               		${we}

							                </tbody>
							            </table>
							        </div>

								</div>`);

								we = "";

								cout += 1;

								$("#dd").attr("data-cout" , cout);


				        	}else{

				        		$('#ad').css("max-width", "49%");

				        		$('#ad').attr("id", "");

					        	$('#dd').append(`<div class="col-md-6 card" style="height: 50%; max-width: 49%; margin-right: 1%; padding: 0px;" data-chatid1="${id1}">
										<div class="card-header alpha-success text-success-800 header-elements-inline">
											<h6 class="card-title">${id1} - Кабинет</h6>
										</div>
										<div class="table-responsive card-body" style="padding: 0px;">
											<table class="table table-hover">
								                <thead>
								                    <tr class="bg-blue">
									                    <th> Номер </th>
														<th> Пациент </th>
								                    </tr>
								                </thead>
								                <tbody id="${id1}">

								               		${we}

								                </tbody>
								            </table>
								        </div>

									</div>`);


								cout += 1;

								$("#dd").attr("data-cout" , cout);

								we = "";
				        	}

				        }

				    });     		
	        	});

	        	$(document).on('click', '.dele', function () {

	        		id1 = $(this).attr('data-chatid');

	        		$(this).attr('class', "chew");

	        		$(`div[data-chatid1=${id1}]`).remove()

	        	})

	        </script>

	    </div>
	</div>

	<div class="dropdown-menu" id="dm" style=" display: none; position: static; width: 100%; margin-top: 0; float: none; z-index: auto;">
		<div class="dropdown-item form-check active">
			<label class="form-check-label">
				<input type="checkbox" class="form-input-styled" checked data-fouc>
				Some action
			</label>
		</div>
		<div class="dropdown-item form-check active">
			<label class="form-check-label">
				<input type="checkbox" class="form-input-styled" checked data-fouc>
				Active action
			</label>
		</div>
	</div>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content">

				<div class="row" id="dd" style="height: 80%" data-cout="0">

				</div>
				 
			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


</body>
</html>
