<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
$header = "Главная";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include 'navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->

		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<div class="card border-1">

					<div class="card-header header-elements-inline">
						<h5 class="card-title">Список Пользователей</h5>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="form-control border-dark wmin-200" value="" id="search_input" placeholder="Поиск..." title="Введите логин или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body" id="search_display"></div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
	
	<script type="text/javascript">

		function credoSearch(params = '') {
			if (document.querySelector('#search_display')) {
				var display = document.querySelector('#search_display');
				isLoading(display);

				$.ajax({
					type: "GET",
					url: "<?= api('table/master/User') ?>"+params,
					data: {
						CRD_search: document.querySelector('#search_input').value,
					},
					success: function (result) {
						isLoaded(display);
						display.innerHTML = result;
					},
				});

			}
		}
		
		$(document).ready(() => credoSearch());
		$("#search_input").keyup(() => credoSearch());

	</script>

</body>
</html>
