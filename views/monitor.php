<?php
require_once '../tools/warframe.php';
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en" style=" text-transform: uppercase;">
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

	<script type='text/javascript' src='<?= stack("vendors/js/aamirafridi-jQuery.Marquee-2425821/jquery.marquee.min.js") ?>'></script>

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
		@font-face {
		    font-family: 'BebasNeueRegular';
		    src: url('fonts/BebasNeue-webfont.eot');
		    src: url('fonts/BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
		         url('fonts/BebasNeue-webfont.woff') format('woff'),
		         url('fonts/BebasNeue-webfont.ttf') format('truetype'),
		         url('fonts/BebasNeue-webfont.svg#BebasNeueRegular') format('svg');
		    font-weight: normal;
		    font-style: normal;

		}

		html { overflow-x:  hidden; }

		.container {
		    width: 960px;
		    margin: 0 auto;
		    overflow: hidden;
		}

		.clock {
		    width:377px;
		    margin:0 auto;
		    padding:5px;
		    color:#fff;
		}

		#Date {
		    font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif;
		    font-size:17px;
		    text-align:center;
		    text-shadow:0 0 5px #000;
		}

		ul {
		    width:156px;
		    margin:0 auto;
		    padding:0px;
		    list-style:none;
		    text-align:center;
		}

		ul li {
		    display:inline;
		    font-size:2em;
		    text-align:center;
		    font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif;
		    text-shadow:0 0 5px #000;
		    color: #b2e8e3;
		}

		#point {
		    position:relative;
		    /*-moz-animation:mymove 1s ease infinite; */
		    /*-webkit-animation:mymove 1s ease infinite; */
		    /*text-shadow:0 0 5px #000;*/
		    padding-left:10px;
		    padding-right:10px;
		    color: #b2e8e3;

		}

		@-webkit-keyframes mymove
		{
		    0% {
		        opacity:1.0;
		        text-shadow:0 0 20px #00c6ff;
		    }

		    50% {
		        opacity:0;
		        text-shadow:none;
		    }

		    100% {
		        opacity:1.0;
		        text-shadow:0 0 20px #00c6ff;
		    }
		}


		@-moz-keyframes mymove
		{
		    0% {
		        opacity:1.0;
		        text-shadow:0 0 20px #00c6ff;
		    }

		    50% {
		        opacity:0;
		        text-shadow:none;
		    }

		    100% {
		        opacity:1.0;
		        text-shadow:0 0 20px #00c6ff;
		    }
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

									$sql = "SELECT us.* FROM users us LEFT JOIN division dv ON (dv.id = us.division_id) WHERE us.user_level = 5 OR ((dv.assist != 2 OR dv.assist IS NULL) AND us.user_level = 10)";

									$allUser = $db->query($sql)->fetchAll();

									foreach ($allUser as $key) {
								?>

									<div class="dropdown-item form-check">
										<label class="form-check-label">
											<div class="chew" data-chatid="<?= $key['id'] ?>" data-nameLast="<?= $key['room'] ?> - Кабинет">
												<input type="checkbox" class="form-input-styled" data-fouc>
											</div>
											<?= $key['room'] ?> Кабинет
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

							    <!-- <div id="Date"></div> -->
	        <span class="ml-md-3 siya-long" id="Date"></span>

	        <div class="col-md-5">
				<div class="clock">
				    <ul>
				        <li id="hours"> </li>
				        <li id="point">:</li>
				        <li id="min"> </li>
				        <li id="point">:</li>
				        <li id="sec"> </li>
				    </ul>
				</div>
			</div>

	        <script>

//                let er = new Audio('ee.mp3');
//
//                er.play();

	        	let we = "";


	        	$(document).on('click', '.chew', function () {

	        		id1 = $(this).attr('data-chatid');

	        		name = $(this).attr('data-nameLast');

	        		// $('#audio').trigger('play');
	        		// alert($(''))

	        		// $('#audio').trigger('play');

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

				        	console.log(queue.length);

				        	if(reception.length != 0){
				        		console.log(reception);
					        	we += `<tr data-status="accept_patient" style=" text-transform: uppercase; background-color: #97E32F; font-weight: 900; font-size: 250%;" data-userid="${ reception[0].user_id }" data-parentid="${ reception[0].parent_id }">
								        	<td style="text-align: center;">${ reception[0].user_id }</td>
								        </tr>`;

				        	}

				        	if( queue.length != 0 ){
				        		for (let i = 0; i < queue.length; i++) {
					        		we += `<tr style="text-transform: uppercase; font-weight: 900; font-size: 250%;" data-userid="${ queue[i].user_id }" data-parentid="${ queue[i].parent_id }">
					        				<td style="text-align: center;"> ${ queue[i].user_id }  </td>
					        				</tr>`
					        	}
					        }

				        	if (cout % 8 == 0 ) {
				        		$('#dd').append(`<div class="w-100"></div>`)
				        	}


			        		col = 12 / cout;

			        		$('#dd').append(`
				        		<div class="col" id="ad" data-chatid1="${id1}">
				        			<div class="card" style="height:400px">
										<div class="card-header alpha-success text-success-800 header-elements-inline">
											<h2 class="card-title" style="font-weight: 900; color: #1A1A1A;"> ${name} </h2>
										</div>
										<div class="table-responsive card-body" style="padding: 0px;">
											<table class="table table-hover">
								                <thead>
								                    <tr class="bg-blue" style="font-size: 200%; text-transform: none;">
									                    <th style="text-align: center;"> Номер - чека </th>
								                    </tr>
								                </thead>
								                <tbody id="${id1}">

								               		${we}

								                </tbody>
								            </table>
								        </div>
									</div>
								</div>
							`);

							// $(`div.col-md-${12 / (cout-1)}`).each(function () {
							// 	$(this).attr("class",`col-md-${12 / cout}`);
							// });

							we = "";

							cout += 1;

							$("#dd").attr("data-cout" , cout);


				        }

				    });
	        	});

	        	$(document).on('click', '.dele', function () {

	        		id1 = $(this).attr('data-chatid');

	        		$(this).attr('class', "chew");

	        		$(`div[data-chatid1=${id1}]`).remove()

		        	cout = Number($("#dd").attr("data-cout"));

		        	cout -= 1;

		        	$("#dd").attr("data-cout", cout);

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

				<!-- <div class="row">



					<div class="col-md-7">
						<div class="card-img-actions m-1">
							<div class="card-img embed-responsive embed-responsive-16by9">
								<video autoplay width="5000" height="1000">
									<source src="../meadi/video/Рекламный_ролик_клиники _Гранд Медика_.mp4">
								</video>
							</div>
						</div>
					</div>
				</div> -->

				<div class="row" id="dd" style="height: 50%;" data-cout="0"></div>


                    <audio id="audio" style="display:none;">
                        <source src="../media/audio/music" type="audio/mpeg">
                      </audio>

					</div>


				<!-- <div class="row" style="height: 50%" >

					<div class="col-md-1 card">qwe</div>

				</div> -->

				<script>

	        		// $('#audio').trigger('play');


					$(document).ready(function() {

						$("video")[0].play();

					});

					// setInterval(function () {
					// 	$("video")[0].play();
					// }, 13200)

					$(document).ready(function() {
				        // Создаем две переменные с названиями месяцев и названиями дней.
				        var monthNames = [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ];
				        var dayNames= ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"]

				        // Создаем объект newDate()
				        var newDate = new Date();
				        // "Достаем" текущую дату из объекта Date
				        newDate.setDate(newDate.getDate());
				        // Получаем день недели, день, месяц и год
				        $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

				        setInterval( function() {
				            // Создаем объект newDate() и показывает секунды
				            var seconds = new Date().getSeconds();
				            // Добавляем ноль в начало цифры, которые до 10
				            $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
				        },1000);

				        setInterval( function() {
				            // Создаем объект newDate() и показывает минуты
				            var minutes = new Date().getMinutes();
				            // Добавляем ноль в начало цифры, которые до 10
				            $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
				        },1000);

				        setInterval( function() {
				            // Создаем объект newDate() и показывает часы
				            var hours = new Date().getHours();
				            // Добавляем ноль в начало цифры, которые до 10
				            $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
				        }, 1000);
				    });

				</script>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	<!-- Footer -->
    <div id="qwee" class="navbar navbar-expand-lg navbar-light">
	    <div class="navbar-collapse collapse" id="navbar-footer">
	        <h1 id="wew" class="navbar-text" style=" font-weight: 900; font-size: 250%;">
	            &copy; 2020 - 2021. <span class="text-primary">Пациент 50 5</span>
	        </h1>
	    </div>
	</div>

	<script>

        footer = $('#qwee').marquee({duration: 15000,direction: 'left'});

        footer.bind('finished', function () {
            // alert('fin');
            footer.marquee('pause');
        });
	</script>

    <!-- /footer -->


</body>
</html>
