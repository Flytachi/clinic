<?php
require_once '../../tools/warframe.php';
is_auth(5);
$header = "Все пациенты";
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

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">


				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Все пациенты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Номер телефона</th>
                                        <th>Дата регистрации </th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // prit($db->query("SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY us.add_date DESC")->fetchAll());
									foreach($db->query("SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE us.user_level = 15 ORDER BY us.add_date DESC") as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
                                            <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td><?= $row['numberPhone'] ?></td>
											<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                            <td class="text-center">
												<a href="<?= viv('doctor/list_all_visit') ?>?id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
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
