<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Журнал";
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
						<h5 class="card-title">Журнал</h5>
					</div>

					<div class="card-body">

						<?php
						if( isset($_SESSION['message']) ){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>№</th>
                                        <th>ID</th>
                                        <th>Дата</th>
                                        <th>ФИО</th>
                                        <th>Адресс</th>
                                        <th>Телефон</th>
                                        <th>Направление</th>
                                        <th>Номер визита</th>
                                        <th>Диагноз</th>
                                        <th>Отдел</th>
                                        <th>Дата выписки</th>
                                        <th>Лечащий врач</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($db->query("SELECT vs.id, vs.user_id, vs.add_date, us.region, us.residenceAddress, us.numberPhone, vs.report, vs.completed, vs.parent_id FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id)  WHERE vs.direction IS NOT NULL AND vs.service_id = 1 ORDER BY vs.add_date") as $row): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= addZero($row['user_id']) ?></td>
                                            <td><?= date('d.m.y H:i', strtotime($row['add_date'])) ?></td>
                                            <td><?= get_full_name($row['user_id']) ?></td>
                                            <td>г. <?= $row['region']." ".$row['residenceAddress'] ?></td>
                                            <td><?= $row['numberPhone'] ?></td>
                                            <td></td>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= str_replace("Сопутствующие заболевания:", '', stristr(str_replace("Клинический диагноз:", '', stristr($row['report'], "Клинический диагноз:")), "Сопутствующие заболевания:", true)) ?></td>
                                            <td><?= division_title($row['parent_id']) ?></td>
											<td><?= date('d.m.y H:i', strtotime($row['completed'])) ?></td>
                                            <td><?= get_full_name($row['parent_id']) ?></td>
											<td class="text-right">
												<button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a href="<?= viv('card/content_1') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-eye"></i>История</a>
													<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_3').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i>Выписка</a>
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

	<div id="modal_edit" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Заказ</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>


			</div>
		</div>
	</div>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
