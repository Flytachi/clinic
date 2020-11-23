<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

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
								<h5 class="card-title">Переписка</h5>
							</div>

							<div class="card">
								<div class="nav-tabs-responsive">
									<ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
									<?php

									$id = $_SESSION['session_id'];

									foreach ($db->query("SELECT * FROM users WHERE user_level = 5 AND id != $id") as $key => $value) {

									?>

										<li class="nav-item" onclick="deletNotice(this)" data-idChat="<?=$value['id']?>">
											<a href="#<?=$value['id']?>" class="nav-link legitRipple" data-idChat="<?=$value['id']?>" data-toggle="tab">
												<img src="../../../../clinic/static/global_assets/images/placeholders/placeholder.jpg" alt="" class="rounded-circle mr-2" width="20" height="20" />
												<?=$value['first_name']?>
												<p data-idChat="<?=$value['id']?>"></p>
											</a>
										</li>

									<?php
										}

									?>

										<li class="nav-item dropdown ml-md-auto">
											<a href="#" class="nav-link dropdown-toggle legitRipple" data-toggle="dropdown" data-boundary="window"><i class="icon-users4"></i> Список врачей</a>
											<div class="dropdown-menu dropdown-menu-right">

												<?php

													foreach ($db->query("SELECT * FROM users WHERE user_level = 5 AND id != $id") as $key => $value) {
												?>
													<a href="#<?=$value['id']?>" class="dropdown-item" data-toggle="tab"><?=$value['first_name']?></a>
												<?php
													}
												?>
											</div>
										</li>

									</ul>
								</div>

								<div class="tab-content card-body border-top-0 rounded-0 rounded-bottom mb-0">

									<?php

									foreach ($db->query("SELECT id FROM users WHERE user_level = 5 AND id != $id") as $key => $value) {

									?>

										<div class="tab-pane fade" id="<?= $value['id'] ?>">
											<ul class="media-list media-chat mb-3" data-chatid="<?= $value['id'] ?>">
												
												<?php

													$id_user = $value['id'];

													$sql = "SELECT * FROM `chat` WHERE `id_push` = '$id' AND `id_pull` = '$id_user' OR `id_push` = '$id_user' AND `id_pull` = '$id' LIMIT 100 ";

													foreach ($db->query($sql) as $key => $val) {

														if($val['id_push'] == $id){

												?>
															<li class="media media-chat-item-reverse">
																<div class="media-body">
																	<div class="media-chat-item"><?=$val['message']?></div>
														<div class="font-size-sm text-muted mt-2">													<?=$val['time']?><a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
																	</div>
																</div>

																<div class="ml-3">
																	<a href="#">
																		<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40">
																	</a>
																</div>
															</li>

													<?php

														}else{
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
														}

													}
												?>
											</ul>


											<textarea name="enter-message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..." data-inputid="<?= $value['id'] ?>"></textarea>

											<div class="d-flex align-items-center">
												<div class="list-icons list-icons-extended">
													<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send photo"><i class="icon-file-picture"></i></a>
													<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send video"><i class="icon-file-video"></i></a>
													<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send file"><i class="icon-file-plus"></i></a>
												</div>

												<button type="button" onclick="sendMessage(this)" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto legitRipple" data-buttonid="<?= $value['id'] ?>">
													<b><i class="icon-paperplane"></i></b> Send
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
    <?php include '../../layout/footer.php' ?>

    <script>
    	
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

    </script>

</body>
</html>
