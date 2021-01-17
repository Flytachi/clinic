<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Персонал";
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

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Настройки</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

                        <form class="" action="" method="post">
                            <div class="form-group">
                                <label>Resident procent:</label>
                                <input type="number" class="form-control" name="proc" step="0.1" value="<?= $ini['GLOBAL_SETTING']['RES_PROC'] ?>">
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>

				    </div>

                    <?php
                    if ($_POST['proc']) {
                        // $ini['GLOBAL_SETTING']['RES_PROC'] = $_POST['proc'];
                        prit($ini);
                    }
					write_exel();
                    ?>

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

</body>
</html>
