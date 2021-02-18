<?php
require_once '../../tools/warframe.php';
is_auth('master');
$header = "Панель управления";
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

					<?php $_initialize =  Mixin\T_INITIALIZE_database(); ?>

					<?php if ($_initialize == 200): ?>
						<div class="alert alert-primary" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            База данных создана!
                        </div>
					<?php else: ?>
						<div class="alert bg-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
							<span class="font-weight-semibold">Ошибка при создании базы данных!</span>
					    </div>
                    <?php endif; ?>

				<?php elseif ($_POST['GET_START']): ?>

                    <?php
                    $flush = Mixin\T_FLUSH_database();
                    $_division = division_temp();
                    $_user = users_temp();
                    $_service = service_temp();
                    ?>

                    <?php if ($flush == 200): ?>
                        <div class="alert alert-primary" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            Новая база данных готова к использованию!
                            <ul>
								<?php if ($_division == 200): ?>
                                    <li>Очищены/Созданы отделы</li>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка создания отделов</li>
                                <?php endif; ?>
                                <li>Очищены склады</li>
								<li>Очищены заказы</li>
                                <li>Очищены визиты</li>
                                <li>Очищены услуги</li>
                                <?php if ($_service == 200): ?>
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
                                <li>Очищены пользователи</li>
                                <?php if ($_user == 200): ?>
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
					<?php else: ?>
						<div class="alert bg-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
							<span class="font-weight-semibold">Ошибка при очистке базы данных!</span>
					    </div>
                    <?php endif; ?>

                <?php endif; ?>

                <div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Control Panel</h5>
				    </div>

				    <div class="card-body">

                        <?php
                        if($_SESSION['message']){
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <form action="" method="post">
                            <input style="display:none;" id="btn_INITIALIZE" type="submit" value="INITIALIZE" name="INITIALIZE"></input>
                            <input style="display:none;" id="btn_GET_START" type="submit" value="GET_START" name="GET_START"></input>

                            <input style="display:none;" id="btn_INITIALIZE_clinic" type="submit" value="INITIALIZE_clinic" name="INITIALIZE_clinic"></input>
                            <input style="display:none;" id="btn_GET_START_clinic" type="submit" value="GET_START_clinic" name="GET_START_clinic"></input>
                            <input style="display:none;" id="btn_INITIALIZE_pharmacy" type="submit" value="INITIALIZE_pharmacy" name="INITIALIZE_pharmacy"></input>
                            <input style="display:none;" id="btn_GET_START_pharmacy" type="submit" value="GET_START_pharmacy" name="GET_START_pharmacy"></input>
                        </form>

                        <div class="form-group row">


                            <div class="col-6">
                                <legend>The main</legend>
                                <a class="btn text-primary" onclick="Conf('#btn_INITIALIZE')">Initialize the database</a>
                                <a class="btn text-danger" onclick="Conf('#btn_GET_START')">GET START</a>
                            </div>

                            <div class="col-6">
                                <legend>In detail</legend>
                                <div class="form-group">
                                    <span class="mr-5" style="font-size: 1rem;"><b>Clinic</b></span>
                                    <a class="btn text-primary" onclick="Conf('#btn_INITIALIZE_clinic')">Initialize the database</a>
                                    <a class="btn text-danger" onclick="Conf('#btn_GET_START_clinic')">GET START</a>
                                </div>
                                <div class="form-group">
                                    <span class="mr-5" style="font-size: 1rem;"><b>Pharmacy</b></span>
                                    <a class="btn text-primary" onclick="Conf('#btn_INITIALIZE_pharmacy')">Initialize the database</a>
                                    <a class="btn text-danger" onclick="Conf('#btn_GET_START_pharmacy')">GET START</a>
                                </div>
                            </div>

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
				title: 'Внимание!',
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