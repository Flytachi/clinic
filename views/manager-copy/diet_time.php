<?php 
require_once '../../tools/warframe.php';
$session->is_auth(1);
is_module('module_diet');
$header = "Время приёма";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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
                        <h5 class="card-title">Время приёма</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <?php
						if( isset($_SESSION['message']) ){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						$comp = $db->query("SELECT * FROM company_constants WHERE const_label LIKE 'const_diet_time'")->fetchAll();
						foreach ($comp as $value) {
							$company[$value['const_label']] = $value['const_value'];
						}
						?>

                        <form action="<?= viv('admin/admin_model') ?>" method="post">

                            <button onclick="AddinputTime()" type="button" class="btn btn-outline-success btn-sm"><i class="icon-plus22 mr-2"></i>Добавить время</button>
                            <fieldset class="mb-3">

                                <legend><b>Время для диеты:</b></legend>
                                <div class="form-group row" id="time_div">
                                    <?php if( isset($company['const_diet_time']) ): ?>
                                        <?php foreach (json_decode($company['const_diet_time']) as $time_key => $value): ?>
                                            <div class="col-md-3" id="time_input_<?= $time_key ?>">
                                                <div class="form-group-feedback form-group-feedback-right">
                                                    <input type="time" name="const_diet_time[<?= $time_key ?>]" class="form-control" value="<?= $value ?>" required>
                                                    <div class="form-control-feedback text-danger">
                                                        <i class="icon-minus-circle2" onclick="$('#time_input_<?= $time_key ?>').remove();"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                            </fieldset>

                            <div class="text-right">
                                <button type="submit" class="btn">Send</button>
                            </div>

                        </form>

                    </div>

                </div>
                   
            </div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">
        let i = Number("<?= (isset($time_key)) ? $time_key + 1 : 0 ?>");
		function AddinputTime(time = null) {
			$('#time_div').append(`
				<div class="col-md-3" id="time_input_${i}">
					<div class="form-group-feedback form-group-feedback-right">
						<input type="time" name="const_diet_time[${i}]" class="form-control" value="${time}" required>
						<div class="form-control-feedback text-danger">
							<i class="icon-minus-circle2" onclick="$('#time_input_${i}').remove();"></i>
						</div>
					</div>
				</div>
			`);
			i++;
		}
		function Update(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
				},
			});
		};
	</script>

</body>
</html>