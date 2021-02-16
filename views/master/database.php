<?php
require_once '../../tools/warframe.php';
is_auth('master');
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

				<?php if ($_POST['INITIALIZE']): ?>

					<?php if (Mixin\T_INITIALIZE()): ?>
						<div class="alert bg-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
							<span class="font-weight-semibold">Ошибка при создании базы данных!</span>
					    </div>
					<?php else: ?>
						<div class="alert alert-primary" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            База данных создана!
                        </div>
                    <?php endif; ?>

				<?php elseif ($_POST['GET_START']): ?>

                    <?php
                    FLUSH_clinic();
                    division_temp();
                    $_user = users_temp();
                    $_service = service_temp();
                    ?>

                    <?php if ($_POST['GET_START']): ?>
                        <div class="alert alert-primary" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            Новая база данных готова к использованию!
                            <ul>
                                <li>Очищены препараты</li>
                                <li>Очищены визиты</li>
                                <li>Очищены услуги</li>
                                <?php if ($_service == 1): ?>
                                    <li>Создана услуга</li>
                                    <ol>
                                        <li>Стационарный Осмотр</li>
                                    </ol>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка создания услуги</li>
                                    <ol class="text-danger">
                                        <li><?= $_service ?></li>
                                    </ol>
                                <?php endif; ?>
                                <li>Очищены Пользователи</li>
                                <?php if ($_user == 1): ?>
                                    <li>Создан администратор</li>
                                    <ol>
                                        <li>login: admin</li>
                                        <li>password: admin</li>
                                    </ol>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка создания администратора</li>
                                    <ol class="text-danger">
                                        <li><?= $_user ?></li>
                                    </ol>
                                <?php endif; ?>
                            </ul>

                        </div>
                    <?php endif; ?>

                <?php endif; ?>

                <div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">База данных</h5>
                        <div class="header-elements">
				            <div class="list-icons">
								<form action="" method="post">
									<input style="display:none;" id="btn_INITIALIZE" type="submit" value="INITIALIZE" name="INITIALIZE"></input>
									<input style="display:none;" id="btn_GET_START" type="submit" value="GET_START" name="GET_START"></input>
								</form>
								<a class="btn text-primary" onclick="Conf('#btn_INITIALIZE')">Initialize the database</a>
								<a class="btn text-danger" onclick="Conf('#btn_GET_START')">GET START</a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

                        <?php
                        if($_SESSION['message']){
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
                                            <td><?= $row['Tables_in_clinic'] ?></td>
                                            <td>
                                                <?php $rec = $db->query("SELECT count(*) FROM {$row['Tables_in_clinic']}")->fetchColumn() ?>
                                                <?php if ($rec == 0): ?>
                                                    <span class="text-success"><?= $rec ?></span>
                                                <?php elseif ($rec <= 10000000000): ?>
                                                    <span class="text-dark"><?= $rec ?></span>
                                                <?php else: ?>
                                                    <span class="text-danger"><?= $rec ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>

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
		function Conf(btn) {
			swal({
				position: 'top',
				title: 'Очистить базу данных?',
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
							$(btn).click();
						}
					});
				}

			});
		}
	</script>

</body>
</html>
