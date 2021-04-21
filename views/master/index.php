<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
$header = "Главная";
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
				        <h5 class="card-title">Список Пользователей</h5>
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

</body>
</html>
