<?php
require_once '../../tools/warframe.php';
is_auth('master');
$header = "Контроль базы данных";
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

                <div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Дамп базы данных</h5>
				    </div>

				    <div class="card-body">

                        <?php
                        if($_SESSION['message']){
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-dark">
				                        <th>#</th>
				                        <th>Дата</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    <?php
                                     $scanned_files = array_diff(scandir("../../dump"), array('..', '.'));
                                     $i = 1;
                                    ?>
                                    <?php foreach ($scanned_files as $value): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= substr($value, 0, 19); ?></td>
                                            <td>
                                                <a onclick="Conf('<?= viv('master/cap') ?>', '<?= $value ?>', 1)" class="list-icons-up text-success"><i class="icon-upload"></i></a>
                                                <a href="/dump/<?= $value ?>" class="list-icons-up text-dark" download><i class="icon-download"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
				                </tbody>
				            </table>
				        </div>

				    </div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
