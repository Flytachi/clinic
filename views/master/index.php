<?php
require_once '../../tools/warframe.php';
is_auth('master');
$header = "Главная";

function division_temp()
{
    Mixin\insert('division', array('level' => 10, 'title' => 'Радиология', 'name' => 'Радиолог', 'assist' => 2));
    Mixin\insert('division', array('level' => 10, 'title' => 'МРТ', 'name' => 'МРТ', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'Рентген', 'name' => 'Рентгенолог', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'МСКТ', 'name' => 'МСКТ', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'Маммография', 'name' => 'Маммограф', 'assist' => 1));
    Mixin\insert('division', array('level' => 10, 'title' => 'УЗИ', 'name' => 'УЗИ', 'assist' => null));
    Mixin\insert('division', array('level' => 6, 'title' => 'Лаборатория', 'name' => 'Лаборант', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Хирургия', 'name' => 'Хирург', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Гинекология', 'name' => 'Гинеколог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Неврология', 'name' => 'Невролог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Оториноларинголог', 'name' => 'Лор', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Кардиология', 'name' => 'Кардиолог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Урология', 'name' => 'Уролог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Ревматология', 'name' => 'Ревматолог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Стоматология', 'name' => 'Стамотолог', 'assist' => null));
    Mixin\insert('division', array('level' => 5, 'title' => 'Терапия', 'name' => 'Терапевт', 'assist' => null));
	Mixin\insert('division', array('level' => 5, 'title' => 'Нейрохирургия', 'name' => 'Нейрохирург', 'assist' => null));
	Mixin\insert('division', array('level' => 5, 'title' => 'Травматология', 'name' => 'Травматолог', 'assist' => null));
    Mixin\insert('division', array('level' => 12, 'title' => 'Физиотерапия', 'name' => 'Физиотерапевт', 'assist' => null));
    Mixin\insert('division', array('level' => 13, 'title' => 'Процедурная', 'name' => 'Процедурная мед-сестра/брат', 'assist' => null));
}

function users_temp()
{
    Mixin\insert('users', array('parent_id' => null, 'username' => 'admin', 'password' => 'd033e22ae348aeb5660fc2140aec35850c4da997', 'user_level' => 1));
}
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

				<?php if ($_POST['flush']): ?>

					<?php
					Mixin\T_flush('barcode');
					Mixin\T_flush('beds');
					Mixin\T_flush('bed_type');
					Mixin\T_flush('beds');
					Mixin\T_flush('bypass');
					Mixin\T_flush('bypass_date');
					Mixin\T_flush('bypass_time');
					Mixin\T_flush('bypass_preparat');
					Mixin\T_flush('chat');
					Mixin\T_flush('collection');
					Mixin\T_flush('customer');
					Mixin\T_flush('goods');
					Mixin\T_flush('guides');
					Mixin\T_flush('investment');
					Mixin\T_flush('laboratory_analyze');
					Mixin\T_flush('laboratory_analyze_type');
					Mixin\T_flush('members');
					Mixin\T_flush('multi_accounts');
					Mixin\T_flush('notes');
					Mixin\T_flush('operation');
					Mixin\T_flush('operation_inspection');
					Mixin\T_flush('operation_member');
					Mixin\T_flush('operation_stats');
					Mixin\T_flush('products');
					Mixin\T_flush('purchases');
					Mixin\T_flush('purchases_item');
					Mixin\T_flush('sales');
					Mixin\T_flush('sales_order');
					Mixin\T_flush('storage_orders');
					Mixin\T_flush('storage_preparat');
					Mixin\T_flush('storage_type');
					Mixin\T_flush('supliers');
					Mixin\T_flush('templates');
					Mixin\T_flush('user_card');
					Mixin\T_flush('user_settings');
					Mixin\T_flush('user_stats');
					Mixin\T_flush('wards');
					Mixin\T_flush('visit');
					Mixin\T_flush('visit_price');
					Mixin\T_flush('visit_inspection');

					Mixin\T_flush('division');
					division_temp();

					Mixin\T_flush('users');
					users_temp();

					Mixin\T_flush('service');
					$task = Mixin\insert('service', array('id' => 1, 'user_level' => 1, 'name' => "Стационарный Осмотр", 'type' => 101));
					?>

					<?php if (intval($task) == 1): ?>
						<div class="alert alert-primary" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
							Новая база данных готова к использованию!
							<ul>
								<li>Очищены препараты</li>
								<li>Очищены услуги</li>
								<li>Очищены визиты</li>
								<li>Создан администратор</li>
								<ol>
									<li>login: admin</li>
									<li>password: admin</li>
								</ol>
							</ul>

						</div>
					<?php else: ?>
						<div class="alert bg-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
							<span class="font-weight-semibold"><?= $task ?></span>
						</div>
					<?php endif; ?>

				<?php endif; ?>



				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Список Пользователей</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
								<form action="" method="post">
									<input style="display:none;" id="btn_flush" type="submit" value="FLUSH" name="flush"></input>
								</form>
								<a class="btn text-danger" onclick="Conf()">GET START</a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-dark">
				                        <th>#</th>
                                        <th>Роль</th>
                                        <th>Логин</th>
				                        <th>ФИО</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    <?php $i=1;foreach ($db->query("SELECT * from users WHERE not user_level = 15") as $row): ?>
                                        <tr
                                        <?php if ($row['user_level'] == 1): ?>
                                            class="table-dark text-danger"
                                        <?php elseif ($row['user_level'] == 8): ?>
                                            class="table-dark text-dark"
                                        <?php endif; ?>
                                        >
				                            <td><?= $i++ ?></td>
				                            <td>
                                                <?php if ($row['user_level'] == 5): ?>
                                                    <span class="text-success"><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php elseif ($row['user_level'] == 6): ?>
                                                    <span class="text-primary"><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php elseif (in_array($row['user_level'], [2, 3, 32])): ?>
                                                    <span class="text-teal"><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php elseif ($row['user_level'] == 10): ?>
                                                    <span class="text-indigo"><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php elseif (in_array($row['user_level'], [7, 9])): ?>
                                                    <span class="text-orange"><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php elseif (in_array($row['user_level'], [12, 13, 14])): ?>
                                                    <span class="text-brown"><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php else: ?>
                                                    <span><?= $PERSONAL[$row['user_level']] ?></span>
                                                <?php endif; ?>
                                                <?php
				                                if(division_name($row['id'])){
				                                    echo " (".division_name($row['id']).")";
				                                }
				                                ?>
				                            </td>
                                            <td><?= $row['username'] ?></td>
				                            <td><?= get_full_name($row['id']); ?></td>
				                            <td class="text-right">
				                                <div class="list-icons">
													<a href="<?= viv("master/index") ?>?avatar=<?= $row['id'] ?>" class="list-icons-up text-success"><i class="icon-arrow-up16"></i></a>
				                                </div>
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
		function Conf() {
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
							$('#btn_flush').click();
						}
					});
				}

			});
		}
	</script>

</body>
</html>
