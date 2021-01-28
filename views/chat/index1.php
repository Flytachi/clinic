<?php
require_once '../../tools/warframe.php';
is_auth();
$header = "Пациент";

?>
<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="<?= stack("vendors/js/lightzoom/style.css") ?>" type="text/css">
<?php include '../layout/head.php' ?>

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

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Переписка</h6>
				    </div>

				    <div>

						<?php include "content_tabs.php"; ?>

						<div>
							<div>
								<div class="nav-tabs-responsive">
									<ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
									<?php

									$id = $_SESSION['session_id'];

									foreach ($db->query("SELECT * FROM users WHERE user_level NOT IN(1,15) AND id != $id") as $key => $value) {

										$id_user = $value['id'];

										$sql1 = "SELECT COUNT(*) FROM `chat` WHERE `id_push` = '$id_user' AND `id_pull` = '$id' AND `activity` = 0";

										$count = $db->query($sql1)->fetchColumn();

										$count = $count == 0 ? "" : $count;
									?>

										<li class="nav-item" onclick="deletNotice(this)" data-idChat="<?=$value['id']?>">
											<a href="#<?=$value['id']?>" class="nav-link legitRipple" data-idChat="<?=$value['id']?>" data-toggle="tab">
												<img src="../../../../clinic/static/global_assets/images/placeholders/placeholder.jpg" alt="" class="rounded-circle mr-2" width="20" height="20" />
												<?= get_full_name($value['id'])?> <span class="badge bg-danger badge-pill ml-auto" data-idChat="<?=$value['id']?>"><?= $count?></span>
											</a>
										</li>

									<?php
										}

									?>

										<li class="nav-item dropdown ml-md-auto">
											<a href="#" class="nav-link dropdown-toggle legitRipple" data-toggle="dropdown" data-boundary="window"><i class="icon-users4"></i> Список врачей</a>
											<div class="dropdown-menu dropdown-menu-right">

												<?php

													foreach ($db->query("SELECT * FROM users WHERE user_level NOT IN(1,15) AND id != $id") as $key => $value) {
												?>
													<a href="#<?=$value['id']?>" class="dropdown-item" data-toggle="tab">
														<?= get_full_name($value['id'])?>
													</a>
												<?php
													}
												?>
											</div>
										</li>

									</ul>
								</div>

								<div class="tab-content card-body border-top-0 rounded-0 rounded-bottom mb-0">

									<?php

									$i = 0;

									foreach ($db->query("SELECT id , first_name , last_name FROM users WHERE user_level != 1 AND id != $id") as $key => $value) {

										$status = $i == 0 ? "active show" : "";

										$i = 1;

									?>

										<div class="tab-pane fade <?= $status ?>" id="<?= $value['id'] ?>" >
											<h1 style=" margin-left: auto;    margin-right: auto; width: 30%;" ><?= $value['first_name'] ?> <?= $value['last_name'] ?></h1>
											<ul id="we<?= $value['id'] ?>" class="media-list media-chat mb-3" data-chatid="<?= $value['id'] ?>" data-offset="100" style="height: 600px; overflow: scroll;">


												<?php

													$id_user = $value['id'];

													$sql = "SELECT * FROM (SELECT * FROM `chat` WHERE `id_push` = '$id' AND `id_pull` = '$id_user' OR `id_push` = '$id_user' AND `id_pull` = '$id' ORDER BY id DESC LIMIT 100)sub ORDER BY id ASC";

													foreach ($db->query($sql) as $key => $val) {

														if($val['id_push'] == $id){

															switch ($val['type_message']) {
																case 'text':

												?>
															<li class="media media-chat-item-reverse">
																<div class="media-body">
																	<div class="media-chat-item"><?=$val['message']?></div>
																	<div class="font-size-sm text-muted mt-2"><?=$val['time']?>
																		<a href="#">
																			<i class="icon-pin-alt ml-2 text-muted"></i>
																		</a>
																	</div>
																</div>

																<div class="ml-3">
																	<a href="#">
																		<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
																	</a>
																</div>
															</li>

												<?php

																break;
																case 'file':

												?>
															<li class="media media-chat-item-reverse">
																<div class="media-body">
																	<div class="media-chat-item">
																		<a style="color: white;" href="<?=$val['message']?>" download>Скачать файл</a>
																	</div>
																	<div class="font-size-sm text-muted mt-2"><?=$val['time']?>
																		<a href="#">
																			<i class="icon-pin-alt ml-2 text-muted"></i>
																		</a>
																	</div>
																</div>

																<div class="ml-3">
																	<a href="#">
																		<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
																	</a>
																</div>
															</li>

													<?php

																	break;
																	case 'image':

												?>
															<li class="media media-chat-item-reverse">
																<div class="media-body">
																	<div class="media-chat-item">
																		<a href="<?=$val['message']?>" class="lightzoom">
																			<img src="<?=$val['message']?>" width="200">
																		</a>
																	</div>
																	<div class="font-size-sm text-muted mt-2"><?=$val['time']?>
																		<a href="#">
																			<i class="icon-pin-alt ml-2 text-muted"></i>
																		</a>
																	</div>
																</div>

																<div class="ml-3">
																	<a href="#">
																		<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
																	</a>
																</div>
															</li>

													<?php

																	break;
																default:
																	echo $val['message'];

																break;
															}

														}else{

															switch ($val['type_message']) {
																case 'text':
															?>
																<li class="media">
																	<div class="mr-3">
																		<a href="#">
																			<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
																		</a>
																	</div>

																	<div class="media-body">
																		<div class="media-chat-item"><?=$val['message']?></div>
																		<div class="font-size-sm text-muted mt-2">
																			<?=$val['time']?><a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
																		</div>
																	</div>
																</li>

															<?php
																break;

																case 'file':
															?>
																<li class="media">
																	<div class="mr-3">
																		<a href="#">
																			<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
																		</a>
																	</div>

																	<div class="media-body">
																		<div class="media-chat-item">
																			<a style="color: #333333;" href="<?=$val['message']?>" download>Скачать файл</a>
																		</div>
																		<div class="font-size-sm text-muted mt-2">
																			<?=$val['time']?><a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
																		</div>
																	</div>
																</li>
															<?php
																break;

																case 'image':
															?>

																<li class="media">
																	<div class="mr-3">
																		<a href="#">
																			<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
																		</a>
																	</div>

																	<div class="media-body">
																		<div class="media-chat-item">
																			<a href="<?=$val['message']?>" class="lightzoom">
																				<img src="<?=$val['message']?>" width="200">
																			</a>
																		</div>
																		<div class="font-size-sm text-muted mt-2">
																			<?=$val['time']?><a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
																		</div>
																	</div>
																</li>

															<?php
																break;

																default:
																	echo $val['message'];
																break;
															}

														}

													}

												?>
											</ul>

											<div class="ww">

											</div>


											<div class="d-flex align-items-center">
												<div class="list-icons list-icons-extended">
													<form id="lo" method="POST" enctype="multipart/form-data" data-inputid="<?= $value['id'] ?>">

														<a onclick="sendToImage(this)" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send photo"><i class="icon-file-picture"></i></a>
														<a onclick="sendToFile(this)" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send file"><i class="icon-file-plus"></i></a>
													</form>
												</div>

												<button type="button" onclick="sendMessage(this)" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto legitRipple" data-buttonid="<?= $value['id'] ?>">
													<b><i class="icon-paperplane"></i></b> Отправить
												</button>
											</div>
										</div>

									<?php
										}

									?>
								</div>
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

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
<script src="<?= stack("vendors/js/lightzoom/lightzoom.js") ?>"></script>

    <script>

    	// $('.lightzoom').lightzoom({speed: 400, viewTitle: true});

    	// $('.lightzoom').lightzoom();

    	function lightZoom(argument) {
    		$( '.lightzoom' ).lightzoom( {
			   speed:                 400,   // скорость появления
			   imgPadding:            10,    // значение отступа у изображения
			   overlayOpacity:        '0.5', // прозрачность фона (от 0 до 1)
			   viewTitle:             true, // true, если надо показывать подпись к изобажению
			   isOverlayClickClosing: false, // true, если надо закрывать окно при клике по затемненной области
			   isWindowClickClosing:  true, // true, если надо закрывать окно при клике по любой области
			   isEscClosing:          false, // true, если надо закрывать окно при нажатии на кнопку Esc
			   boxClass:              '',    // позволяет задавать класс окну обертке (с версии 1.1.0)
			   overlayColor:          '',    // позволяет задавать цвет фону (с версии 1.1.0)
			   titleColor:            '',    // позволяет задавать цвет подписи (с версии 1.1.0)
			 } );
    	}

    	lightZoom();

    	$('textarea').keypress(function(e){
			if(e.keyCode == 13){
				let id_cli = $(this).attr('data-inputid');
				let word = $(this).val();
				$(this).val('');
				let obj = JSON.stringify({ type : 'messages',  type_message : 'text', id : id, id_cli : id_cli, message : word });
				conn.send(obj);
			}
		});

		function sendToFile(body) {
		  file = document.createElement('input');
		  file.setAttribute('type', `file`);
		  file.setAttribute('onchange', `sendTo(this)`);
		  file.setAttribute('name', `filedata`);
		  file.setAttribute('id', `filedata`);
		  file.click();
		}

		function sendToImage(body) {
		  file = document.createElement('input');
		  file.setAttribute('type', `file`);
		  file.setAttribute('onchange', `sendToI(this)`);
		  file.setAttribute('name', `filedata`);
		  file.setAttribute('id', `filedata`);
		  file.click();
		}

		function sendTo(body) {
		  let form = $(`#lo`) ;
		  $(`#lo`).prepend(body);
		  let formData = new FormData(form[0]);
		  $(`#filedata`).remove();
		  $.ajax({
		      type : "POST",
		      url : "saveFile.php",
		      data : formData,
		      processData: false,
		      contentType: false,
		      success: function(data){

						chat.emit('message', {'mes' : data.file_url, 'id_pull' : Number($("#lo").attr('data-inputid')), 'id_push' : id, 'type_message' : 'file'})
						console.log(data);

		               }
		    })
		}

		function sendToI(body) {
		  let form = $(`#lo`) ;
		  $(`#lo`).prepend(body);
		  let formData = new FormData(form[0]);
		  $(`#filedata`).remove();
		  $.ajax({
		      type : "POST",
		      url : "saveImage.php",
		      data : formData,
		      processData: false,
		      contentType: false,
		      success: function(data){

						chat.emit('message', {'mes' : data.file_url, 'id_pull' : Number($("#lo").attr('data-inputid')), 'id_push' : id, 'type_message' : 'image'});
		               }
		    })
		}

    </script>

    <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
	<script src="../../node_modules/socket.io/client-dist/socket.io.min.js" crossorigin="anonymous"></script>

    <script type="text/babel">

    	let element= <textarea name="enter-message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..."></textarea>

		let chat = io.connect('<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>/chat');

		chat.emit('joinRoom', {'id' : id});

		chat.on('joinRoom',(data) =>{

			console.log('join room ' + data.id);

		});


    	class Textarea extends React.Component {
		  constructor(props) {
		    super(props);
		    this.state = {isToggleOn: true};

		    this.state.value = "";

		    this.state.id = this.props.id;

		    // Эта привязка обязательна для работы `this` в колбэке.
		    this.sendMessage = this.sendMessage.bind(this);
		}


			sendMessage(e) {
				if(e.key === "Enter"){
					chat.emit('message', {'mes' : e.target.value, 'id_pull' : this.state.id, 'id_push' : id, 'type_message' : 'text'})
				}else{

					this.setState({value: e.target.value});
				}
			}
		  render() {
		    return (
		      <textarea id={this.state.id} name="enter-message" onKeyPress={this.sendMessage} class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..."></textarea>
		    );
		  }
		}

		let mas = [

			<?php

				foreach ($db->query("SELECT id FROM users WHERE user_level NOT IN(1,15) AND id != $id") as $key => $value) {
					echo $value['id']. ",";
				}
			?>
		]

		for(let x = 0 ; x < document.getElementsByClassName('ww').length; x++){

			ReactDOM.render(
				<Textarea id={mas[x]} />,
				document.getElementsByClassName('ww')[x]
			);
        }


    	chat.on('we', function (d) {

    		console.log(d);

			let time = new Date();

			let hour = addZero(time.getHours());

			let mitune = addZero(time.getMinutes());

			$(`ul#we3`).append(`
              <li class="media media-chat-item-reverse">
                <div class="media-body">
                  <div class="media-chat-item">${d.mes}</div>
                  <div class="font-size-sm text-muted mt-2">
                    ${ hour } : ${ mitune }
                    <a href="#">
                      <i class="icon-pin-alt ml-2 text-muted"></i>
                    </a>
                  </div>
                </div>

                <div class="ml-3">
                  <a href="#">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
                  </a>
                </div>
              </li>
              `)
		})

		chat.on('text',(d) =>{

			let time = new Date();

			let hour = addZero(time.getHours());

			let mitune = addZero(time.getMinutes());

			if(d.id_push == id){
			    $(`ul#we${d.id_pull}`).append(`
	              <li class="media media-chat-item-reverse">
	                <div class="media-body">
	                  <div class="media-chat-item">${d.mes}</div>
	                  <div class="font-size-sm text-muted mt-2">
	                    ${ hour } : ${ mitune }
	                    <a href="#">
	                      <i class="icon-pin-alt ml-2 text-muted"></i>
	                    </a>
	                  </div>
	                </div>

	                <div class="ml-3">
	                  <a href="#">
	                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
	                  </a>
	                </div>
	              </li>
	              `)
					$(`ul#we${d.id_pull}`).scrollTop($(`ul#we${d.id_pull}`).prop('scrollHeight'));
			}else{

	  			let active = Number($('a.show').attr('data-idChat')) == NaN ? 0 : Number($('a.show').attr('data-idChat'));

	  			console.log(active);

	  			if(active == d.id_push){

	  				$.ajax({
	  			        type: "POST",

	  			        url: "http://"+config.SOCKET.HOST+"/clinic/static/vendors/js/scriptJS/ajax.php",

	  			        data: { id: id, id1: d.id_push },

	  			        success: function (www) {
	  			        	console.log(www);
	  			        },
	  			    });


	  			}else{

					$('#audio').trigger('play');

					let p = Number($(`span[data-idchat=${d.id_push}]`).text()) + 1;

					let b = Number($(`span#noticeus`).text()) + 1;

					$(`span#noticeus`).html('');

					$(`span#noticeus`).html(b);

					$(`span[data-idChat=${d.id_push}]`).text(p)

	  			}

				$(`ul#we${d.id_push}`).append(`
	              <li class="media">
	                <div class="mr-3">
	                  <a href="#">
	                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
	                  </a>
	                </div>
	                <div class="media-body">
	                  <div class="media-chat-item">${d.mes}</div>
	                  <div class="font-size-sm text-muted mt-2">
	                    ${ hour } : ${ mitune }
	                    <a href="#">
	                      <i class="icon-pin-alt ml-2 text-muted"></i>
	                    </a>
	                  </div>
	                </div>
	              </li>
	              `)
				$(`ul#we${d.id_push}`).scrollTop($(`ul#we${d.id_push}`).prop('scrollHeight'));
			}


		  });

		  chat.on('file',(d) =>{

			let time = new Date();

			let hour = addZero(time.getHours());

			let mitune = addZero(time.getMinutes());

			if(d.id_push == id){
			    $(`ul#we${d.id_pull}`).append(`
	              <li class="media media-chat-item-reverse">
	                <div class="media-body">
	                  <div class="media-chat-item">
	                    <a style="color: white;" href="${d.mes}" download>Скачать файл</a>
	                  </div>
	                  <div class="font-size-sm text-muted mt-2">
	                    ${ hour } : ${ mitune }
	                    <a href="#">
	                      <i class="icon-pin-alt ml-2 text-muted"></i>
	                    </a>
	                  </div>
	                </div>

	                <div class="ml-3">
	                  <a href="#">
	                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
	                  </a>
	                </div>
	              </li>
	              `)
			}else{
				$(`ul#we${d.id_push}`).append(`
	              <li class="media">
	                <div class="mr-3">
	                  <a href="#">
	                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
	                  </a>
	                </div>

	                <div class="media-body">
	                  <div class="media-chat-item">
	                    <a style="color: #333333;" href="${d.mes}" download>Скачать файл</a>
	                  </div>
	                  <div class="font-size-sm text-muted mt-2">
	                    ${ hour } : ${ mitune }
	                      <a href="#">
	                        <i class="icon-pin-alt ml-2 text-muted"></i>
	                      </a>
	                  </div>
	                </div>
	              </li>
	              `)
			}

		  });

		  chat.on('image',(d) =>{

			let time = new Date();

			let hour = addZero(time.getHours());

			let mitune = addZero(time.getMinutes());

			if(d.id_push == id){
			    $(`ul#we${d.id_pull}`).append(`
	              <li class="media media-chat-item-reverse">
	                <div class="media-body">
	                  <div class="media-chat-item">
							<a href="${d.mes}" class="lightzoom">
			                    <img src="${d.mes}" width="200">
			                </a>
	                  </div>
	                  <div class="font-size-sm text-muted mt-2">
	                    ${ hour } : ${ mitune }
	                    <a href="#">
	                      <i class="icon-pin-alt ml-2 text-muted"></i>
	                    </a>
	                  </div>
	                </div>

	                <div class="ml-3">
	                  <a href="#">
	                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
	                  </a>
	                </div>
	              </li>
	              `)
			}else{
				$(`ul#we${d.id_push}`).append(`
	              <li class="media">
	                <div class="mr-3">
	                  <a href="#">
	                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
	                  </a>
	                </div>
	                <div class="media-body">
	                  <div class="media-chat-item">
	                  	<a href="${d.mes}" class="lightzoom">
		                    <img src="${d.mes}" width="200">
		                </a>
	                  </div>
	                  <div class="font-size-sm text-muted mt-2">
	                    ${ hour } : ${ mitune }
	                    <a href="#">
	                      <i class="icon-pin-alt ml-2 text-muted"></i>
	                    </a>
	                  </div>
	                </div>
	              </li>
	              `)
			}

	    	lightZoom();

		  });
    </script>

</body>
</html>
