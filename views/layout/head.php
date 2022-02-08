<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= ShowTitle() ?></title>

	<!-- Global stylesheets -->
	<link rel="shortcut icon" href="<?= stack("assets/images/logo.png") ?>" type="image/x-icon">
	<link href="<?= stack("assets/fonts/font.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("global_assets/css/icons/icomoon/styles.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/bootstrap_limitless.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/layout.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/components.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/css/colors.min.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/my_css/style.css") ?>" rel="stylesheet" type="text/css">
	<link href="<?= stack("assets/my_css/ckeditor.css") ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Loader -->
	<?php include layout('load') ?>
	<!-- /Loader -->

	<!-- Core JS files -->
	<script src="<?= stack("global_assets/js/main/jquery.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/main/bootstrap.bundle.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/loaders/blockui.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/ui/moment/moment.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/ui/ripple.min.js") ?>"></script>
	<script src="<?= stack("assets/js/box.js") ?>"></script>
	<!-- /core JS files -->

	<script src="<?= stack("global_assets/js/plugins/notifications/jgrowl.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/notifications/noty.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/notifications/sweet_alert.min.js") ?>"></script>

	<!-- Theme JS files -->
	<script src="<?= stack("global_assets/js/plugins/visualization/d3/d3.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/visualization/d3/d3_tooltip.js") ?>"></script>

	<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>

	<script src="<?= stack("global_assets/js/plugins/buttons/spin.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/buttons/ladda.min.js") ?>"></script>
	<!-- /theme JS files -->

	<script src="<?= stack("assets/js/app.js") ?>"></script>

	<script src="<?= stack("global_assets/js/demo_pages/components_buttons.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/extra_sweetalert.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/extra_jgrowl_noty.js") ?>"></script>

	<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
	<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>

	<!-- JS chained -->
	<script src="<?= stack("assets/js/jquery.chained.js") ?>"></script>

	<script type="text/javascript">

		// Select
		$.fn.modal.Constructor.prototype._enforceFocus = function() {};

		// Sessions
		var sessionActive = Boolean("<?= ( isset($sessionActive) ) ? 'true' : 'false' ?>");
		var warningTimeout = Number("<?= ( isset($ini['GLOBAL_SETTING']['SESSION_TIMEOUT']) ) ? $ini['GLOBAL_SETTING']['SESSION_TIMEOUT'] : 1 ?>") * 60000; 
		var timoutNow = (Number("<?= $ini['GLOBAL_SETTING']['SESSION_LIFE'] ?>") * 60000) - warningTimeout;
		var logout_url = "<?= $session->logout_link() ?>";
		var timeout_mark = "<?= $session->timeout_mark_link() ?>";
		var warningTimerID,timeoutTimerID;

		// console.log(warningTimeout / 60000);
		// console.log(timoutNow / 60000);

		// Socket
		let id = <?= $_SESSION['session_id'] ?>;
		// let conn = new WebSocket("ws://<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>");

	</script>
	<script src="<?= stack("assets/js/sessions.js") ?>"></script>

	<script src="<?= stack("assets/js/socket.js") ?>"></script>

	<!-- JS CKEditor -->
	<script src="<?= node("@ckeditor/ckeditor5-build-decoupled-document/build/ckeditor.js") ?>"></script>
</head>

<!-- Timeout modal -->
<div id="modal_timeout_auto_logout" class="modal fade" tabindex="-1" style="z-index:9999 !important;">
	<div class="modal-dialog">
		<div class="<?= $classes['modal-session_content'] ?>">
			<div class="<?= $classes['modal-session_header'] ?>">
				<h5 class="modal-title">Confirm login password</h5>
			</div>

			<form method="post" action="<?= $session->confirm_password_link() ?>" onsubmit="TimeoutAutoLogout(this)">
			
				<div class="modal-body">
					<h5 class="font-weight-semibold">Подтвердите пароль от <b class="text-primary"><?= $session->session_login ?></b>: </h5>

					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Введите пароль">
					</div>
					<em>
						У вас есть 3 попытки ввести код!<br>
						Осталось: <span id="sessionErrorCounts"></span><br>
					</em>
					<hr>

				</div>

				<div class="modal-footer">
					<a href="<?= $session->logout_link() ?>" type="button" class="<?= $classes['modal-session_btn_logout'] ?>">Выйти</a>
					<button type="submit" class="<?= $classes['modal-session_btn_confirm'] ?>" name="button_submit">Подтвердить</button>
				</div>

			</form>

		</div>
	</div>
</div>
<!-- /Timeout modal -->

