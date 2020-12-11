<?php
require_once '../../tools/warframe.php';
is_auth(4);
$header = "Персонал";


if ( isset($_POST['submit']) ) {
	unset($_POST['submit']);
	Mixin\insert('pharmacy_category', $_POST);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Добавить категорию</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body" id="form_card">
				        <form method="POST">

						    <div class="row">
						        <div class="col-md-12">
					                <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Категория</legend>

					                <div class="form-group">
					                    <label>Названия категория:</label>
					                    <input type="text" class="form-control" name="name" placeholder="Названия категория" required="" value="" />
					                </div>

						        </div>
						    </div>

						    <div class="text-right">
						        <button type="submit" name="submit" class="btn btn-primary legitRipple">Сохранить <i class="icon-paperplane ml-2"></i></button>
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
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
