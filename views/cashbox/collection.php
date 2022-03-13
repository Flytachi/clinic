<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "Инкассация";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<div class="<?= $classes['card'] ?>">

				    <div class="<?= $classes['card-header'] ?>">
				        <h5 class="card-title">Добавить транзакцию</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">
				        <?php (new Collection)->form(); ?>
				    </div>

				</div>

				<div class="<?= $classes['card'] ?>">

				    <div class="<?= $classes['card-header'] ?>">
				        <h5 class="card-title">Список</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

						<div class="form-group">
							<label>Дата принятия:</label>
							<div class="input-group">
								<input type="text" class="<?= $classes['form-daterange'] ?>" onchange="Change()" name="date" id="data_range">
								<span class="input-group-append">
									<span class="input-group-text"><i class="icon-calendar22"></i></span>
								</span>
							</div>
						</div>

						<div id="check_div"></div>

				    </div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
	<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js') ?>"></script>
	<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
	<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
	<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
	<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>

	<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

	<script>

		function Change(){
			var date = document.querySelector("#data_range");
			
			$.ajax({
				type: "POST",
				url: "<?= ajax('collection_list') ?>",
				data: { date:date.value },
				success: function (result) {
					$('#check_div').html(result);
				}
			});
		}

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
