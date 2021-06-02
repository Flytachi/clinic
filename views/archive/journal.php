<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Журнал";

$tb = new Table($db, "visit vs");
$tb->set_data('vs.id, vs.user_id, vs.add_date, us.region, us.residenceAddress, us.numberPhone, vs.report, vs.completed, vs.parent_id');
$search = $tb->get_serch();
$search_array = array(
	"vs.direction IS NOT NULL AND vs.service_id = 1", 
	"vs.direction IS NOT NULL AND vs.service_id = 1 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->additions('LEFT JOIN users us ON(us.id=vs.user_id)')->where_or_serch($search_array)->order_by('vs.add_date ASC')->set_limit(20);
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
						<h5 class="card-title">Журнал</h5>
						<div class="header-elements">
							<form action="" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="form-control border-info" value="<?= $search ?>" id="search_input" placeholder="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="card-body" id="search_display">

						<?php
						if( isset($_SESSION['message']) ){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>№</th>
                                        <th>ID</th>
                                        <th>Дата</th>
                                        <th>ФИО</th>
                                        <th>Адресс</th>
                                        <th>Телефон</th>
                                        <th>Номер визита</th>
                                        <th>Диагноз</th>
                                        <th>Отдел</th>
                                        <th>Дата выписки</th>
                                        <th>Лечащий врач</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->get_table(1) as $row): ?>
										<tr>
                                            <td><?= $row->count ?></td>
                                            <td><?= addZero($row->user_id) ?></td>
                                            <td><?= date_f($row->add_date, 1) ?></td>
                                            <td><?= get_full_name($row->user_id) ?></td>
                                            <td>г. <?= $row->region." ".$row->residenceAddress ?></td>
                                            <td><?= $row->numberPhone ?></td>
                                            <td><?= $row->id ?></td>
                                            <td><?= str_replace("Сопутствующие заболевания:", '', stristr(str_replace("Клинический диагноз:", '', stristr($row->report, "Клинический диагноз:")), "Сопутствующие заболевания:", true)) ?></td>
                                            <td><?= division_title($row->parent_id) ?></td>
											<td><?= date_f($row->completed) ?></td>
                                            <td><?= get_full_name($row->parent_id) ?></td>
											<td class="text-right">
												<button type="button" class="<?= $classes['btn_detail'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a href="<?= viv('card/content_1') ?>?pk=<?= $row->id ?>" class="dropdown-item"><i class="icon-eye"></i>История</a>
													<a <?= ($row->completed) ? 'onclick="Print(\''. viv('prints/document_3').'?id='. $row->id. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i>Выписка</a>
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
	
	<script type="text/javascript">
		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/archive-journal') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});
	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
