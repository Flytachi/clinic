<?php
require_once '../../tools/warframe.php';
is_auth('master');
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
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-blue">
				                        <th>#</th>
				                        <th>Логин</th>
				                        <th>ФИО</th>
				                        <th>Роль</th>
				                        <th class="text-right" style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
				                    <?php
				                    $i = 1;
				                    foreach($db->query('SELECT * from users WHERE not user_level = 15') as $row) {
				                        ?>
				                        <tr>
				                            <td><?= $i++ ?></td>
				                            <td><?= $row['username'] ?></td>
				                            <td><?= get_full_name($row['id']); ?></td>
				                            <td><?php
				                                echo $PERSONAL[$row['user_level']];
				                                if(division_name($row['id'])){
				                                    echo " (".division_name($row['id']).")";
				                                }
				                                ?>
				                            </td>
				                            <td class="text-right">
				                                <div class="list-icons">
													<a href="<?= viv("master/index") ?>?avatar=<?= $row['id'] ?>" class="list-icons-up text-success"><i class="icon-arrow-up16"></i></a>
				                                </div>
				                            </td>
				                        </tr>
				                        <?php
				                    }
				                    ?>
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

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
