<?php
require_once '../../../tools/warframe.php';
is_auth();
$header = "Общий отчёт по колличеству принятых пациентов";
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

				<?php include "content_tabs.php"; ?>

                <div class="card border-1 border-info">

                    <div class="card-header text-dark header-elements-inline alpha-info">
                        <h6 class="card-title" >Фильтр</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

						<form action="" method="post">

							<div class="form-group row">

								<div class="col-md-6">
									<label>Дата:</label>
									<div class="input-group">
										<input type="text" class="form-control daterange-locale" name="date" value="<?= $_POST['date'] ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>


						</form>

                    </div>

                </div>

				<?php if ($_POST): ?>
					<?php
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					// $sql = "SELECT
					// 			op.oper_date,
					// 			(SELECT title FROM division WHERE id=op.division_id) 'division',
					// 			vp.item_name,
					// 			op.parent_id,
					// 			op.user_id,
					// 			op.completed
					// 		FROM operation op
					// 			LEFT JOIN visit_price vp ON(vp.operation_id=op.id)
					// 		WHERE
					// 			vp.item_type = 5 AND op.oper_date IS NOT NULL";
					// // Обработка
					// if ($_POST['date_start'] and $_POST['date_end']) {
					// 	$sql .= " AND (DATE_FORMAT(op.oper_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					// }
					// $i=1;
					?>
					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
							<h6 class="card-title">Услуги</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered" id="table">
	                                <tbody>

                                        <tr>
                                            <th style="width: 25%;" class="table-primary">Амбулаторные пациента</th>
    										<th style="width: 25%;" class="text-center table-primary">
                                                <?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NULL AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')")->rowCount() ?>
                                            </th>

                                            <th style="width: 25%;" class="table-danger">Стационарные пациента</th>
    										<th style="width: 25%;" class="text-center table-danger">
                                                <?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.direction IS NOT NULL AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')")->rowCount() ?>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td colspan="2" style="width: 85%;">Новые пациенты</td>
                                            <td colspan="2" class="text-center">
                                                <?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."') AND DATE_FORMAT(us.add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="width: 85%;">Постояные пациенты</td>
                                            <td colspan="2" class="text-center">
                                                <?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."') AND DATE_FORMAT(us.add_date, '%Y-%m-%d') != CURRENT_DATE()")->rowCount() ?>
                                            </td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <th colspan="2" style="width: 85%;">Все пациенты</th>
    										<th colspan="2" class="text-center">
                                                <?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')")->rowCount() ?>
                                            </th>
                                        </tr>

	                                </tbody>
	                            </table>
	                        </div>

						</div>

					</div>

				<?php endif; ?>

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
