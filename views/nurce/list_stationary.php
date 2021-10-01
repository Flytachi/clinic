<?php
require_once '../../tools/warframe.php';
$session->is_auth(7);
$header = "Рабочий стол";

$tb = new Table($db, "visit_services vs");
$tb->set_data("v.id, v.user_id, v.add_date, v.discharge_date, v.grant_id, vs.division_id")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.service_id = 1 AND vs.division_id = $session->session_division AND vs.status = 3",
	"vs.service_id = 1 AND vs.division_id = $session->session_division AND vs.status = 3",
);
$tb->where_or_serch($search_array)->order_by("v.add_date DESC")->set_limit(20);
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

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Пациенты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover table-sm">
								<thead class="<?= $classes['table-thead'] ?>">
									<tr>
										<th>#</th>
										<th>ID</th>
										<th>ФИО</th>
										<th>Дата размещения</th>
										<th>Дата выписки</th>
										<th>Лечущий врач</th>
										<th class="text-center" style="width:210px">Действия</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($tb->get_table(1) as $row): ?>
										<tr>
                                            <td><?= $row->count ?></td>
                                            <td><?= addZero($row->user_id) ?></td>
                                            <td>
												<div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
												<div class="text-muted">
													<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE user_id = $row->user_id")->fetch()): ?>
														<?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
													<?php endif; ?>
												</div>
											</td>
                                            <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td><?= ($row->discharge_date) ? date_f($row->discharge_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td>
												<?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
												<div class="text-muted"><?= get_full_name($row->grant_id) ?></div>
											</td>
											<td class="text-right">
												<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a href="<?= viv('card/content-1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
													<a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-add"></i>Назначенные услуги</a>
													<?php if(module('module_laboratory')): ?>
														<a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
													<?php endif; ?>
													<?php if(module('module_diagnostic')): ?>
														<a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
													<?php endif; ?>
													<?php if(module('module_bypass')): ?>
                                                    	<a href="<?= viv('card/content-9') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-magazine"></i>Лист назначения</a>
            										<?php endif; ?>
                                                    <a href="<?= viv('card/content-12') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
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
		


	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
