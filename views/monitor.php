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

	<style>
		
		.title {
		  position: absolute;
		  top: 0;
		  font: 36px Arial;
		  letter-spacing: 0.1em;
		  width: 80vw;
		  margin: 6vh 10vw;
		  color: rgba(256, 256, 256, 0.5);
		}
		@media only screen and (min-width: 768px) {
		  .title {
		    font: 48px Arial;
		  }
		}

		.clock {
		  width: 200px;
		  height: 200px;
		  border: solid 10px #333;
		  border-radius: 50%;
		  margin: calc(50vh - 100px) calc(50% - 100px);
		  position: relative;
		  background: rgba(256, 256, 256, 0.25);
		  cursor: pointer;
		}
		@media only screen and (min-width: 768px) and (min-height: 540px) {
		  .clock {
		    width: 300px;
		    height: 300px;
		    border: solid 15px #333;
		    margin: calc(50vh - 150px) calc(50% - 150px);
		  }
		}

		.dot {
		  background: red;
		  width: 10px;
		  height: 10px;
		  position: absolute;
		  top: calc(50% - 5px);
		  left: calc(50% - 5px);
		  display: none;
		}

		.spire {
		  position: absolute;
		}

		.hour {
		  top: calc(50% - 37.5px);
		  left: calc(50% - 2.5px);
		  width: 5px;
		  height: 40px;
		  border-radius: 0 0 5px 5px;
		  background: #333;
		  z-index: 4;
		  transform-origin: 2.5px 37.5px;
		  transition: transform 2s ease;
		}
		@media only screen and (min-width: 768px) and (min-height: 540px) {
		  .hour {
		    top: calc(50% - 57.5px);
		    left: calc(50% - 2.5px);
		    width: 5px;
		    height: 60px;
		    transform-origin: 2.5px 57.5px;
		  }
		}

		.min {
		  top: calc(50% - 67.5px);
		  left: calc(50% - 2.5px);
		  width: 5px;
		  height: 70px;
		  border-radius: 0 0 5px 5px;
		  background: rgba(167, 139, 131, 1);
		  z-index: 3;
		  transform-origin: 2.5px 67.5px;
		  transition: transform 1s ease;
		}
		@media only screen and (min-width: 768px) and (min-height: 540px) {
		  .min {
		    top: calc(50% - 102.5px);
		    left: calc(50% - 2.5px);
		    width: 5px;
		    height: 105px;
		    transform-origin: 2.5px 102.5px;
		  }
		}

		.sec {
		  top: calc(50% - 78.75px);
		  left: calc(50% - 1.25px);
		  width: 2.5px;
		  height: 80px;
		  border-radius: 0 0 2.5px 2.5px;
		  background: rgba(231, 76, 60, 1);
		  z-index: 2;
		  transform-origin: 1.25px 78.75px;
		  transition: transform .5s ease;
		}
		@media only screen and (min-width: 768px) and (min-height: 540px) {
		  .sec {
		    top: calc(50% - 118.75px);
		    left: calc(50% - 1.25px);
		    width: 2.5px;
		    height: 120px;
		    transform-origin: 1.25px 118.75px;
		  }
		}

		.digit {
		  position: absolute;
		  top: calc(50% - 100px);
		  left: calc(50% - 100px);
		  width: 200px;
		  font: 42px/200px Arial;
		  color: rgba(32, 32, 32, 0.6);
		  display: none;
		  z-index: -10;
		}
		@media only screen and (min-width: 768px) and (min-height: 540px) {
		  .digit {
		    top: calc(50% - 150px);
		    left: calc(50% - 150px);
		    width: 300px;
		    font: 58px/300px Arial;
		  }
		}
		.clock:hover + .digit {
		  display: block;
		}

		footer {
		  position: absolute;
		  bottom: 3vh;
		  font: 16px Arial;
		  color: rgba(256, 256, 256, 0.5);
		  width: 100vw;
		}
		footer a {
		  color: rgba(51, 51, 51, 0.75);
		  text-decoration: none;
		}
		footer a:hover {
		  color: rgba(256, 256, 256, 0.5);
		}

		.background {
		  background: #9b59b6;
		  background: linear-gradient(to top left, #9b59b6, #f39c12);
		  position: fixed;
		  top: 0;
		  height: 100vh;
		  width: 100%;
		  z-index: -100;
		}

	</style>

</head>




<!-- Theme JS files -->
<!-- /theme JS files -->

<body>

	<?php

		// $ew = read_excel('templates/qwe.xlsx');

		// prit($ew);

	?>
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

				        	}else{
				        		// for (let i = 0; i < 4; i++) {
					        	// 	we += `<tr data-userid="" data-parentid="">
					        	// 			<td></td>
					        	// 			<td></td>
					        	// 			</tr>`
					        	// }
				        	}

				        	if( queue.length != 0 ){

				        		for (let i = 0; i < queue.length; i++) {
					        		we += `<tr data-userid="${ queue[i].user_id }" data-parentid="${ queue[i].parent_id }">
					        				<td>${ queue[i].user_id }</td>
					        				<td>${ queue[i].last_name } - ${ queue[i].first_name }</td>
					        				</tr>`
					        	}
					        }

				        	// }else{
				        	// 	for (let i = 0; i < 4; i++) {
					        // 		we += `<tr data-userid="" data-parentid="">
					        // 				<td></td>
					        // 				<td></td>
					        // 				</tr>`
					        // 	}
				        	// }

				        	

				        	if ( cout == 0 ||  cout != 1 && cout % 2 == 0) {
				        		$('#dd').append(`<div class="col-md-12 card" id="ad" style="max-width: 99%; margin-right: 1%; padding: 0px;" data-chatid1="${id1}">
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

				// var msg = new SpeechSynthesisUtterance('Welcom to home');
				// window.speechSynthesis.speak(msg);

				 // speechSynthesis.speak(
				 //    new SpeechSynthesisUtterance('Саня')
				 //  );

				 // let re = new webkitSpeechRecognition();

				 // let voice = speechSynthesis.getVoices();

				 // let ee = new SpeechSynthesisUtterance();

				 // ee.voice = voice[0];

				//  ee.lang = "ru-Ru";

				//  ee.text = "Пациент";

				// window.speechSynthesis.speak(ee);

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

				<div class="row">

					<div class="row col-md-4">
						<div class="col-md-12">
							<div class="card-img-actions m-1">
								<div class="card-img embed-responsive embed-responsive-16by9">
									<video autoplay>
										<source src="../meadi/video/Рекламный_ролик_клиники _Гранд Медика_.mp4">
									</video>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							
							<section class="clock" style="margin: 13%;">
							  <div class="dot"></div>
							  <div class="spire hour"></div>
							  <div class="spire min"></div>
							  <div class="spire sec"></div>
							</section>

						</div>
					</div>

					<div class="row col-md-8" id="dd" style="height: 50%" data-cout="0">


					</div>
				</div>
				

				<!-- <div class="row" style="height: 50%" >
					
					<div class="col-md-1 card">qwe</div>

				</div> -->

				<script>
	

					$(document).ready(function() {

						$("video")[0].play();

					}); 

					setInterval(function () {
						$("video")[0].play();
					}, 13200)


					var date = new Date();
					var hour = date.getHours();
					var min = date.getMinutes();
					var sec = date.getSeconds();
					var hourElt = document.getElementsByClassName("hour")[0];
					var minElt = document.getElementsByClassName("min")[0];
					var secElt = document.getElementsByClassName("sec")[0];
					var digit = document.getElementsByClassName("digit")[0];

					moveTime();

					function moveTime() {
					  moveSec();
					  moveMin();
					  moveHour();  
					}

					function moveSec() {
					  var turnSec = sec*6;
					  secElt.style.transform = "rotate(" + turnSec + "deg)";
					  secElt.style.webkitTransform = "rotate(" + turnSec + "deg)";
					  // for each sec after first
					  var eachSec = setInterval(function () {
					    turnSec += 6;
					    secElt.style.transform = "rotate(" + turnSec + "deg)";
					    secElt.style.webkitTransform = "rotate(" + turnSec + "deg)";
					  }, 1000);
					}

					function moveMin() {
					  var turnMin = min*6;
					  minElt.style.transform = "rotate(" + turnMin + "deg)";
					  minElt.style.webkitTransform = "rotate(" + turnMin + "deg)";
					  digit.innerHTML = date.getHours() + ":" + date.getMinutes();
					  // after first min leftovers
					  setTimeout(function () {
					    turnMin += 6;
					    minElt.style.transform = "rotate(" + turnMin + "deg)";
					    minElt.style.webkitTransform = "rotate(" + turnMin + "deg)";
					    digit.innerHTML = new Date().getHours() + ":" + new Date().getMinutes();
					    // for each min after first
					    var eachMin = setInterval(function () {
					      turnMin += 6;
					      minElt.style.transform = "rotate(" + turnMin + "deg)";
					      minElt.style.webkitTransform = "rotate(" + turnMin + "deg)";
					      digit.innerHTML = new Date().getHours() + ":" + new Date().getMinutes();
					    }, 60000);
					  }, (60 - sec) * 1000);
					}

					function moveHour() {
					  if(hour > 11) {hour -= 12;}
					  var turnHour = hour*30;
					  hourElt.style.transform = "rotate(" + turnHour + "deg)";
					  hourElt.style.webkitTransform = "rotate(" + turnHour + "deg)";
					  // after first hour leftovers
					  setTimeout(function () {
					    turnHour += 30;
					    hourElt.style.transform = "rotate(" + turnHour + "deg)";
					    hourElt.style.webkitTransform = "rotate(" + turnHour + "deg)";
					    // for each hour after first
					    var eachHour = setInterval(function () {
					      turnHour += 30;
					      hourElt.style.transform = "rotate(" + turnHour + "deg)";
					      hourElt.style.webkitTransform = "rotate(" + turnHour + "deg)";
					    }, 3600000);
					  }, (60 - min) * 60000);
					}

				</script>
				 
			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


</body>
</html>
