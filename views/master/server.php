<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
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

                <div class="card border-1">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Дамп базы данных</h5>
						<?php if( $dir = is_dir(dirname(__DIR__, 2)."/dump") ): ?>
							<div class="header-elements">
								<a href="<?= ajax('master/cap').'?is_create=1' ?>" class="btn btn-sm border-1 text-dark" title="Create Dump"><i class="icon-database-add"></i></a>
							</div>
						<?php endif; ?>
				    </div>

				    <div class="card-body">

                        <?php
                        if( isset($_SESSION['message']) ){
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
									<?php if( $dir ): ?>
										<?php $i=1; foreach (array_diff(scandir(dirname(__DIR__, 2)."/dump"), array('..', '.')) as $value): ?>
											<tr> 
												<td><?= $i++ ?></td>
												<td><?= pathinfo($value, PATHINFO_FILENAME); ?></td>
												<td>
													<a onclick="Conf('<?= ajax('master/cap') ?>', '<?= pathinfo($value, PATHINFO_FILENAME) ?>')" title="Use Dump" class="list-icons-up text-success"><i class="icon-upload"></i></a>
													<a href="/dump/<?= $value ?>" class="list-icons-up text-dark" title="Download Dump" download><i class="icon-download"></i></a>
													<a onclick="Conf('<?= ajax('master/cap') ?>', '<?= pathinfo($value, PATHINFO_FILENAME) ?>', 1)" title="Delete Dump" class="list-icons-up text-danger"><i class="icon-trash"></i></a>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr class="text-center"> 
											<td colspan="3">Dump folder not found</td>
										</tr>
									<?php endif; ?>
                                    
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
		function Conf(url, file, is_delete) {
			var wha = "Вы уверены что хотите откатить базу данных?";
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
							var ups = url+"?file="+file;
							if (is_delete) {
								ups += "&is_delete="+is_delete;
							}
							location = ups;
						}
					});
				}

			});
		}
	</script>
</body>
</html>
