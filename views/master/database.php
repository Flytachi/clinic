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

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-blue">
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
                                            <td><?= substr($value, 3, 10); ?></td>
                                            <td>
                                                <a onclick="Conf('<?= viv('master/cap') ?>', '<?= $value ?>')" class="list-icons-up text-success"><i class="icon-arrow-up16"></i></a>
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

    <script type="text/javascript">
        function Conf(url, file) {
            swal({
                position: 'top',
                title: 'Вы уверены что откатить базу данных?',
                type: 'info',
                showCancelButton: true,
                confirmButtonText: "Уверен"
            }).then(function(ivi) {
                if (ivi.value) {
                    swal({
                        position: 'top',
                        title: 'Внимание!',
                        text: 'Вернуть данные назад будет невозможно!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "Да"
                    }).then(function(ivi) {
                        if (ivi.value) {
                            console.log(file);
                            location = url+"?file="+file;
                        }
                    });
                }

            });
        }
    </script>

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
