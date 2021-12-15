<?php
require_once '../../tools/warframe.php';
is_module('anesthesia');
$session->is_auth(15);
$header = "Стационарные пациенты";

$tb = (new VisitOperationModel)->as('vo');
$tb->Data("DISTINCT v.id, vo.client_id, c.first_name, c.last_name, c.father_name, c.birth_date, vo.grant_id, vr.id 'order'")->Join("LEFT JOIN visits v ON(v.id=vo.visit_id) LEFT JOIN clients c ON(c.id=vo.client_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->getSearch();
$search_array = array(
	"v.branch_id = $session->branch AND v.completed IS NULL AND v.is_active IS NOT NULL",
	"v.branch_id = $session->branch AND v.completed IS NULL AND v.is_active IS NOT NULL AND (c.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', c.last_name, c.first_name, c.father_name)) LIKE LOWER('%$search%'))"
);
$tb->Where($search_array)->Limit(20);
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
									<?php foreach($tb->list() as $row): ?>
										<tr>
                                            <td><?= addZero($row->client_id) ?></td>
                                            <td>
												<span class="font-weight-semibold"><?= client_name($row) ?></span>
												<?php if ( $row->order ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер №<?= (new VisitOrder)->byId($row->order)->order_number ?></span>
												<?php endif; ?>
												<div class="text-muted">
													<?php if($stm = (new BedModel())->Where("client_id = $row->client_id")->get()): ?>
														<?= $stm->building ?>  <?= $stm->floor ?> этаж <?= $stm->ward ?> палата <?= $stm->bed ?> койка
													<?php endif; ?>
												</div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
                                            <td>
												<?php foreach((new VisitOperationModel())->Data("operation_name, completed")->Where("visit_id = $row->id")->list() as $serv): ?>
													<span class="<?= ($serv->completed) ? 'text-primary' : 'text-danger' ?>"><?= $serv->operation_name ?></span><br>
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

						<?php $tb->panel(); ?>

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
