<?php

use Mixin\Hell;

require_once '../../../tools/warframe.php';
$session->is_auth();

if (is_numeric($_GET['id'])) {
	$header = "Пациент ".addZero($_GET['id']);
	$patient = $db->query("SELECT * FROM clients WHERE id = {$_GET['id']}")->fetch(PDO::FETCH_OBJ);
} else {
	$patient = False;
	echo "err";
}
if (!$patient) Hell::error('404');

$tb = (new VisitServiceModel)->Data("id, service_name, route_id, accept_date, completed, status, visit_id");
$tb->Where("client_id = $patient->id AND responsible_id = $session->session_id")->Order('add_date DESC');
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

                <?php include "profile.php" ?>

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Мои Услуги</h6>
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
                                    <tr class="<?= $classes['table-thead'] ?>">
										<th>№</th>
										<th>Направитель</th>
										<th>Мед услуга</th>
										<th>Дата визита</th>
										<th>Дата завершения</th>
										<th>Тип визита</th>
										<th>Статус</th>
										<th class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach ($tb->list(1) as $row): ?>
										<tr>
											<td><?= $row->count ?></td>
											<td>
												<?= level_name($row->route_id) ?>
												<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
											</td>
											<td><?= $row->service_name ?></td>
											<td><?= ($row->accept_date) ? date_f($row->accept_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td><?= ($row->completed) ? date_f($row->completed, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td>
												<?php if ( $db->query("SELECT direction FROM visits WHERE id = $row->visit_id")->fetchColumn() ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($row->status == 1): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
												<?php elseif ($row->status == 2): ?>
													<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
												<?php elseif ($row->status == 3): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специалиста</span>
												<?php elseif ($row->status == 5): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Возврат</span>
												<?php elseif ($row->status == 6): ?>
													<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Отменённый</span>
												<?php elseif ($row->status == 7): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Неизвестный</span>
												<?php endif; ?>
											</td>
											<td class="text-right">
												<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
												<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<?php if ( in_array($row->status, [3,5,7]) ): ?>
														<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
													<?php endif; ?>
													<a <?= ($row->completed) ? 'onclick="Print(\''. prints('document-1').'?pk='. $row->id. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		};
	</script>

	<!-- Footer -->
	<?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
