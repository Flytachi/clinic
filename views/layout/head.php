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

	<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>
	<!-- /theme JS files -->

	<script src="<?= stack("assets/js/app.js") ?>"></script>

	<script src="<?= stack("global_assets/js/demo_pages/extra_sweetalert.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/extra_jgrowl_noty.js") ?>"></script>

	<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
	<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>

	<script src="<?= stack("global_assets/js/plugins/tables/datatables/datatables.min.js") ?>"></script>
	<script src="<?= stack("global_assets/js/demo_pages/datatables_basic.js") ?>"></script>

	<!-- JS chained -->
	<script src="<?= stack("vendors/js/jquery.chained.js") ?>"></script>

	<script>
		let id = <?= $_SESSION['session_id'] ?>;
		let conn = new WebSocket("ws://<?= $ini['SOCKET']['HOST'] ?>:<?= $ini['SOCKET']['PORT'] ?>");
	</script>
	<script src="<?= stack("vendors/js/scriptJS/socket.js") ?>"></script>
</head>
<audio id="audio">
    <source src="<?= stack("/audio/music") ?>" type="audio/mpeg">
</audio>
