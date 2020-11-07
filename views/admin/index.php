<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">
			<!-- Content area -->
			<div class="content">

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Добавить Пользователя</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">
				        <?php
						UserModel::form();
				        ?>
				    </div>

				</div>

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
				                        <th>Ф.И.О</th>
				                        <th>Роль</th>
				                        <th style="width: 100px">Действия</th>
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
				                                echo level_name($row['user_level']);
				                                if(division_name($row['division_id'])){
				                                    echo " (".division_name($row['division_id']).")";
				                                }
				                                ?>
				                            </td>
				                            <td>
				                                <div class="list-icons">
													<a href="<?= up_url($row['id'], 'UserModel') ?>" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'UserModel') ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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

    <?php include 'layout/footer.php' ?>

    <!-- /footer -->

</body>
</html>
