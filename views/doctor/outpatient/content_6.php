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

				<?php include "../profile_card.php"; ?>

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
										<li class="nav-item">
											<a href="#james" class="nav-link legitRipple" data-toggle="tab">
												<img src="../../../../global_assets/images/placeholders/placeholder.jpg" alt="" class="rounded-circle mr-2" width="20" height="20" />
												James
												<span class="badge badge-mark ml-2 border-danger"></span>
											</a>
										</li>

										<li class="nav-item">
											<a href="#william" class="nav-link legitRipple" data-toggle="tab">
												<img src="../../../../global_assets/images/placeholders/placeholder.jpg" alt="" class="rounded-circle mr-2" width="20" height="20" />
												William
												<span class="badge badge-mark ml-2 border-success"></span>
											</a>
										</li>

										<li class="nav-item">
											<a href="#jared" class="nav-link legitRipple" data-toggle="tab">
												<img src="../../../../global_assets/images/placeholders/placeholder.jpg" alt="" class="rounded-circle mr-2" width="20" height="20" />
												Jared
												<span class="badge badge-mark ml-2 border-warning"></span>
											</a>
										</li>

										<li class="nav-item">
											<a href="#victoria" class="nav-link legitRipple active show" data-toggle="tab">
												<img src="../../../../global_assets/images/placeholders/placeholder.jpg" alt="" class="rounded-circle mr-2" width="20" height="20" />
												Victoria
												<span class="badge badge-mark ml-2 border-grey-300"></span>
											</a>
										</li>

										<li class="nav-item dropdown ml-md-auto">
											<a href="#" class="nav-link dropdown-toggle legitRipple" data-toggle="dropdown" data-boundary="window"><i class="icon-users4"></i> Список врачей</a>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#chat-tab3" class="dropdown-item" data-toggle="tab">Турсунов Б</a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Барноева С </a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Шеров А </a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Абдуллаев А </a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Собиров М </a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Ашуров Р </a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Авезова С </a>
												<a href="#chat-tab4" class="dropdown-item" data-toggle="tab">Дилмуродов В </a>
											</div>
										</li>
									</ul>
								</div>

								<div class="tab-content card-body border-top-0 rounded-0 rounded-bottom mb-0">
									<div class="tab-pane fade" id="james">
										<ul class="media-list media-chat mb-3" data-chatid="James">
											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Crud reran and while much withdrew ardent much crab hugely met dizzily that more jeez gent equivalent unsafely far one hesitant so therefore.</div>
													<div class="font-size-sm text-muted mt-2">
														Tue, 10:28 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">
														Far squid and that hello fidgeted and when. As this oh darn but slapped casually husky sheared that cardinal hugely one and some unnecessary factiously hedgehog a feeling one rudely much
													</div>
													<div class="font-size-sm text-muted mt-2">
														Mon, 10:24 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Tolerantly some understood this stubbornly after snarlingly frog far added insect into snorted more auspiciously heedless drunkenly jeez foolhardy oh.</div>
													<div class="font-size-sm text-muted mt-2">
														Wed, 4:20 pm <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media content-divider justify-content-center text-muted mx-0">
												<span class="px-2">New messages</span>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">Satisfactorily strenuously while sleazily dear frustratingly insect menially some shook far sardonic badger telepathic much jeepers immature much hey.</div>
													<div class="font-size-sm text-muted mt-2">
														2 hours ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Grunted smirked and grew less but rewound much despite and impressive via alongside out and gosh easy manatee dear ineffective yikes.</div>
													<div class="font-size-sm text-muted mt-2">
														13 minutes ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item"><i class="icon-menu"></i></div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>
										</ul>

										<textarea name="enter-message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..." data-inputid="James"></textarea>

										<div class="d-flex align-items-center">
											<div class="list-icons list-icons-extended">
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send photo"><i class="icon-file-picture"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send video"><i class="icon-file-video"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send file"><i class="icon-file-plus"></i></a>
											</div>

											<button type="button" onclick="sendMessage(this)" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto legitRipple" data-buttonid="James">
												<b><i class="icon-paperplane"></i></b> Send
											</button>
										</div>
									</div>

									<div class="tab-pane fade" id="william">
										<ul class="media-list media-chat media-chat-inverse mb-3">
											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Crud reran and while much withdrew ardent much crab hugely met dizzily that more jeez gent equivalent unsafely far one hesitant so therefore.</div>
													<div class="font-size-sm text-muted mt-2">
														Tue, 10:28 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">
														Far squid and that hello fidgeted and when. As this oh darn but slapped casually husky sheared that cardinal hugely one and some unnecessary factiously hedgehog a feeling one rudely much
													</div>
													<div class="font-size-sm text-muted mt-2">
														Mon, 10:24 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Tolerantly some understood this stubbornly after snarlingly frog far added insect into snorted more auspiciously heedless drunkenly jeez foolhardy oh.</div>
													<div class="font-size-sm text-muted mt-2">
														Wed, 4:20 pm <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media content-divider justify-content-center text-muted mx-0">
												<span class="px-2">New messages</span>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">Satisfactorily strenuously while sleazily dear frustratingly insect menially some shook far sardonic badger telepathic much jeepers immature much hey.</div>
													<div class="font-size-sm text-muted mt-2">
														2 hours ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Grunted smirked and grew less but rewound much despite and impressive via alongside out and gosh easy manatee dear ineffective yikes.</div>
													<div class="font-size-sm text-muted mt-2">
														13 minutes ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item"><i class="icon-menu"></i></div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>
										</ul>

										<textarea name="enter-message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..."></textarea>

										<div class="d-flex align-items-center">
											<div class="list-icons list-icons-extended">
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send photo"><i class="icon-file-picture"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send video"><i class="icon-file-video"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send file"><i class="icon-file-plus"></i></a>
											</div>

											<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto legitRipple">
												<b><i class="icon-paperplane"></i></b> Send
											</button>
										</div>
									</div>

									<div class="tab-pane fade" id="jared">
										<ul class="media-list media-chat mb-3">
											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Crud reran and while much withdrew ardent much crab hugely met dizzily that more jeez gent equivalent unsafely far one hesitant so therefore.</div>
													<div class="font-size-sm text-muted mt-2">
														Tue, 10:28 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">
														Far squid and that hello fidgeted and when. As this oh darn but slapped casually husky sheared that cardinal hugely one and some unnecessary factiously hedgehog a feeling one rudely much
													</div>
													<div class="font-size-sm text-muted mt-2">
														Mon, 10:24 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Tolerantly some understood this stubbornly after snarlingly frog far added insect into snorted more auspiciously heedless drunkenly jeez foolhardy oh.</div>
													<div class="font-size-sm text-muted mt-2">
														Wed, 4:20 pm <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media content-divider justify-content-center text-muted mx-0">
												<span class="px-2">New messages</span>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">Satisfactorily strenuously while sleazily dear frustratingly insect menially some shook far sardonic badger telepathic much jeepers immature much hey.</div>
													<div class="font-size-sm text-muted mt-2">
														2 hours ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Grunted smirked and grew less but rewound much despite and impressive via alongside out and gosh easy manatee dear ineffective yikes.</div>
													<div class="font-size-sm text-muted mt-2">
														13 minutes ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item"><i class="icon-menu"></i></div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>
										</ul>

										<textarea name="enter-message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..."></textarea>

										<div class="d-flex align-items-center">
											<div class="list-icons list-icons-extended">
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send photo"><i class="icon-file-picture"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send video"><i class="icon-file-video"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send file"><i class="icon-file-plus"></i></a>
											</div>

											<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto legitRipple">
												<b><i class="icon-paperplane"></i></b> Send
											</button>
										</div>
									</div>

									<div class="tab-pane fade active show" id="victoria">
										<ul class="media-list media-chat media-chat-inverse mb-3">
											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Crud reran and while much withdrew ardent much crab hugely met dizzily that more jeez gent equivalent unsafely far one hesitant so therefore.</div>
													<div class="font-size-sm text-muted mt-2">
														Tue, 10:28 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">
														Far squid and that hello fidgeted and when. As this oh darn but slapped casually husky sheared that cardinal hugely one and some unnecessary factiously hedgehog a feeling one rudely much
													</div>
													<div class="font-size-sm text-muted mt-2">
														Mon, 10:24 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Tolerantly some understood this stubbornly after snarlingly frog far added insect into snorted more auspiciously heedless drunkenly jeez foolhardy oh.</div>
													<div class="font-size-sm text-muted mt-2">
														Wed, 4:20 pm <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media content-divider justify-content-center text-muted mx-0">
												<span class="px-2">New messages</span>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item">Satisfactorily strenuously while sleazily dear frustratingly insect menially some shook far sardonic badger telepathic much jeepers immature much hey.</div>
													<div class="font-size-sm text-muted mt-2">
														2 hours ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>

											<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item">Grunted smirked and grew less but rewound much despite and impressive via alongside out and gosh easy manatee dear ineffective yikes.</div>
													<div class="font-size-sm text-muted mt-2">
														13 minutes ago <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>

											<li class="media media-chat-item-reverse">
												<div class="media-body">
													<div class="media-chat-item"><i class="icon-menu"></i></div>
												</div>

												<div class="ml-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>
											</li>
										</ul>

										<textarea name="enter-message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..."></textarea>

										<div class="d-flex align-items-center">
											<div class="list-icons list-icons-extended">
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send photo"><i class="icon-file-picture"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send video"><i class="icon-file-video"></i></a>
												<a href="#" class="list-icons-item" data-popup="tooltip" data-container="body" title="" data-original-title="Send file"><i class="icon-file-plus"></i></a>
											</div>

											<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto legitRipple">
												<b><i class="icon-paperplane"></i></b> Send
											</button>
										</div>
									</div>
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
    <!-- /footer -->
    <script>

    	var conn = new WebSocket('ws://192.168.1.106:8080');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
			let d = JSON.parse(e.data)
		    $(`ul[data-chatid=${d.id}]`).append(`<li class="media">
												<div class="mr-3">
													<a href="#">
														<img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" alt="" width="40" height="40" />
													</a>
												</div>

												<div class="media-body">
													<div class="media-chat-item"> ${d.message} </div>
													<div class="font-size-sm text-muted mt-2">
														Tue, 10:28 am <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a>
													</div>
												</div>
											</li>`)

		};

		function sendMessage(body) {
			let id = body.dataset.buttonid;
			let word = $(`textarea[data-inputid=${id}]`).val();
			$(`textarea[data-inputid=${id}]`).val('');
			let obj = JSON.stringify({ id : id , message : word });
			conn.send(obj);
		}

    </script>
</body>
</html>
