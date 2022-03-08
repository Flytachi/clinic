<?php
require_once '../../tools/warframe.php';
$session->is_auth(14);
$header = "Стационарные пациенты";

$tb = new Table($db, "visit_operations vo");
$tb->set_data("DISTINCT v.id, vo.patient_id, p.first_name, p.last_name, p.father_name, p.birth_date, vo.grant_id, vr.id 'order'")->additions("LEFT JOIN visits v ON(v.id=vo.visit_id) LEFT JOIN patients p ON(p.id=vo.patient_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"v.completed IS NULL AND v.is_active IS NOT NULL AND v.division_id = $session->session_division",
	"v.completed IS NULL AND v.is_active IS NOT NULL AND v.division_id = $session->session_division AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->order_by('')->set_limit(20);
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
						<h6 class="card-title">Стационарные пациенты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body" id="search_display">

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
                                        <th>Операции</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->get_table() as $row): ?>
										<tr>
                                            <td><?= addZero($row->patient_id) ?></td>
                                            <td>
												<span class="font-weight-semibold"><?= patient_name($row) ?></span>
												<?php if ( $row->order ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger ml-1">Ордер</span>
												<?php endif; ?>
												<div class="text-muted">
													<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE patient_id = $row->patient_id")->fetch()): ?>
														<?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
													<?php endif; ?>
												</div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
                                            <td>
												<?php foreach($db->query("SELECT operation_name, completed FROM visit_operations WHERE visit_id = $row->id") as $serv): ?>
													<span class="<?= ($serv['completed']) ? 'text-primary' : 'text-danger' ?>"><?= $serv['operation_name'] ?></span><br>
												<?php endforeach; ?>
											</td>
                                            <td class="text-center">
												<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a href="<?= viv('card/content-1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
													<?php if(module('module_laboratory')): ?>
														<a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
													<?php endif; ?>
													<?php if(module('module_diagnostic')): ?>
														<a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
													<?php endif; ?>
													<a href="<?= viv('card/content-12') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-clipboard2"></i> Состояние</a>
												</div>
                                            </td>
                                        </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

						<?php $tb->get_panel(); ?>

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
