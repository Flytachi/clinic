<?php
require_once '../../tools/warframe.php';
is_auth(5);
$header = "Стационарные пациенты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
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
                            <table class="table table-hover table-sm datatable-basic">
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
									$sql = "SELECT DISTINCT us.id, vs.route_id, us.dateBith
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} AND vs.grant_id IS NOT NULL ORDER BY vs.accept_date DESC";
                                    foreach($db->query($sql) as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td>
												<div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
												<div class="text-muted">
													<?php
													if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
														echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
													}
													?>
												</div>
											</td>
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td>
												<?php
                                                foreach ($db->query("SELECT sc.name FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$row['id']} AND vs.parent_id = {$_SESSION['session_id']} AND accept_date IS NOT NULL AND completed IS NULL") as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
                                                ?>
                                            </td>
                                            <td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(928px, -95px, 0px); top: 0px; left: 0px; will-change: transform;">
													<a href="<?= viv('card/content_1') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-repo-forked"></i>Обход / Осмотр</a>
													<a href="<?= viv('card/content_3') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-add"></i>Добавить визит</a>
													<a href="<?= viv('card/content_5') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
													<a href="<?= viv('card/content_6') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
                                                    <a href="<?= viv('card/content_7') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-magazine"></i>Лист назначения</a>
                                                    <a href="<?= viv('card/content_8') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
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
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
