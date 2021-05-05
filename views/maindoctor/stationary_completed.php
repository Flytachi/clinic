<?php
require_once '../../tools/warframe.php';
$session->is_auth(8);
$header = "Завершёные стационарные пациенты";
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

                <?php include 'tabs.php' ?>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Завершёные стационарные пациенты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Направитель</th>
                                        <th>Специолист</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach ($db->query("SELECT vs.*, us.dateBith FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.service_id = 1 AND vs.bed_id IS NOT NULL AND vs.completed IS NOT NULL ORDER BY vs.completed DESC") as $row): ?>
										<tr>
											<td><?= addZero($row['user_id']) ?></td>
											<td><div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div></td>
											<td><?= date_f($row['dateBith']) ?></td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td>
                                                <?= level_name($row['grant_id']) ." ". division_name($row['grant_id']) ?>
												<div class="text-muted"><?= get_full_name($row['grant_id']) ?></div>
                                            </td>
											<td class="text-center">
												<button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
												<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(928px, -95px, 0px); top: 0px; left: 0px; will-change: transform;">
													<a href="<?= viv('card/content_1') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-repo-forked"></i>Обход</a>
													<?php if(module('module_laboratory')): ?>
														<a href="<?= viv('card/content_5') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
                    								<?php endif; ?>
													<a href="<?= viv('card/content_6') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
                                                    <a href="<?= viv('card/content_8') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
