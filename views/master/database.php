<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
$header = "База данных";
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
				        <h5 class="card-title">База данных</h5>
				    </div>

				    <div class="card-body">

                        <?php
                        if( isset($_SESSION['message']) ){
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>

				        <div class="table-responsive">
				            <table class="table table-hover table-sm">
				                <thead>
				                    <tr class="bg-dark">
				                        <th>Table</th>
                                        <td>Records</td>
				                        <th class="text-right" style="width: 100px">Action</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    <?php foreach ($db->query("show tables") as $row): ?>
                                        <tr>
                                            <td><?= $row['Tables_in_' . ini['DATABASE']['NAME']] ?></td>
                                            <td>
                                                <?php $rec = $db->query("SELECT count(*) FROM {$row['Tables_in_' . ini['DATABASE']['NAME']]}")->fetchColumn() ?>
                                                <?php if ($rec == 0): ?>
                                                    <span class="text-success"><?= $rec ?></span>
                                                <?php elseif ($rec <= 10000000000): ?>
                                                    <span class="text-dark"><?= $rec ?></span>
                                                <?php else: ?>
                                                    <span class="text-danger"><?= $rec ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right">
												<?php if ($rec != 0): ?>
													<a onclick="Conf('<?= ajax('master/flush') ?>', '<?= $row['Tables_in_'.$ini['DATABASE']['NAME']] ?>')" title="Flush Database" class="list-icons-up text-danger"><i class="icon-database-refresh"></i></a>
                                                <?php endif; ?>
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
		function Conf(url, name) {
			var wha = `Вы уверены что хотите очистить базу данных ${name}?`;
			swal({
				position: 'top',
				title: wha,
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
							location = url+"?tb_name="+name;
						}
					});
				}

			});
		}
	</script>
</body>
</html>
