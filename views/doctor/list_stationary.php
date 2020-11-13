<?php
require_once '../../tools/warframe.php';
is_auth(5);
$header = "Стационарные пациенты";
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
						<h6 class="card-title">Стационарные пациенты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->query('SELECT vs.id, vs.user_id, us.dateBith, vs.route_id, vs.direction FROM visit vs LEFT JOIN users us ON (vs.user_id = us.id) WHERE vs.die_date IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = '.$_SESSION['session_id'].' ORDER BY vs.add_date ASC') as $row) {
                                        ?>
                                        <tr id="PatientFailure_tr_<?= $row['id'] ?>">
                                            <td><?= addZero($row['user_id']) ?></td>
                                            <td><?= get_full_name($row['user_id']) ?></td>
                                            <td><?= $row['dateBith'] ?></td>
                                            <td>
                                                <?php
                                                foreach ($db->query('SELECT sr.name FROM visit_service vsr LEFT JOIN service sr ON (vsr.service_id = sr.id) WHERE status IS NULL AND visit_id ='. $row['id']) as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
                                                ?>
                                            </td>
                                            <td><?= get_full_name($row['route_id']) ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-primary btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(928px, -95px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                    <a href="<?= viv('doctor/stationary/content_8') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
                                                    <a href="<?= viv('doctor/stationary/content_7') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
                                                    <a href="<?= viv('doctor/stationary/content_3') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
                                                    <a href="<?= viv('doctor/stationary/content_10') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
                                                    <a href="<?= viv('doctor/stationary/content_7') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
                                                    <a href="<?= viv('doctor/stationary/content_9') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
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
