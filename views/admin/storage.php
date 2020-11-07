<?php
require_once '../../tools/warframe.php';
is_auth(1);
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
				        <h5 class="card-title">Добавить Склад</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>



				    <div class="card-body">
				        <?php
				        // form('StorageTypeForm');
				        ?>
				    </div>

				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Список Складов</h5>
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
				                        <th style="">#</th>
				                        <th>Название</th>
				                        <th style="width: 100px">Действия</th>
				                    </tr>
				                </thead>
				                <tbody>
				                    <?php
				                    $i = 1;
				                    foreach($db->query('SELECT * from storage_type') as $row) {
				                        ?>
				                        <tr>
				                            <td><?= $i++ ?></td>
				                            <td><?= $row['name'] ?></td>
				                            <td>
				                                <div class="list-icons">
				                                    <a href="model/update.php?id=<?= $row['id'] ?>&form=StorageTypeForm" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
				                                    <a href="model/delete.php?<?= delete($row['id'], 'users', $_SERVER['PHP_SELF']) ?>" onclick="return confirm('Вы уверены что хотите удалить пользоватиля?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                    <!-- <a href="#" class="list-icons-item text-teal-600"><i class="icon-cog6"></i></a> -->
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
