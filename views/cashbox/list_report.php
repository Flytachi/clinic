<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "Отчёт";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/tables/datatables/datatables.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/datatables_basic.js") ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>

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

                                <div class="col-md-3">
                                    <label>Дата визита:</label>
                                    <div class="input-group">
										<input type="text" class="form-control daterange-locale" name="date" value="<?= ($_POST['date']) ? $_POST['date'] : "" ?>">
                                        <span class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label>Кассир:</label>
                                    <select class="form-control multiselect-full-featured" data-placeholder="Выбрать кассира" name="priser_id[]" multiple="multiple" required data-fouc>
                                        <?php foreach ($db->query("SELECT * from users WHERE user_level = 3") as $row): ?>
                                            <option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $_POST['priser_id'])) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
                                        <?php endforeach; ?>
            						</select>
                                </div>

                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
                            </div>

                        </form>

                    </div>

                </div>

                <?php if ($_POST): ?>
                    <div class="card border-1 border-info">

                        <div class="card-header text-dark header-elements-inline alpha-info">
                            <h6 class="card-title">Отчёт</h6>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            <?php
                            $_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
                            $_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
                            $sql = "SELECT
                                        vsp.pricer_id,
                                        vs.user_id,
                                        (vsp.price_cash + vsp.price_card + vsp.price_transfer) 'price',
                                        vsp.price_cash,
                                        vsp.price_card,
                                        vsp.price_transfer,
										vsp.refund,
                                        vsp.add_date
                                    FROM visit_price vsp
                                        LEFT JOIN visit vs ON(vs.id=vsp.visit_id)
                                    WHERE
                                        (DATE_FORMAT(vsp.add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."') AND
                                        vsp.pricer_id IN (".implode($_POST['priser_id']).")
                                    ";

							$sql2 = "SELECT
                                        iv.pricer_id,
                                        iv.user_id,
                                        iv.balance,
                                        iv.add_date
                                    FROM investment iv
                                    WHERE
                                        (DATE_FORMAT(iv.add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."') AND
                                        iv.pricer_id IN (".implode($_POST['priser_id']).")
                                    ";
							// prit($db->query($sql2)->fetchAll());
                            ?>

                            <table class="table table-hover datatable-basic table-sm">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>№</th>
                                            <th>Дата</th>
                                            <th>Кассир</th>
                                            <th>Пациент</th>
                                            <th>Сумма оплаты</th>
                                            <th>Наличные</th>
                                            <th>Терминал</th>
                                            <th>Перечисление</th>
											<th>Предоплата</th>
                                            <th>Возврат</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($db->query($sql) as $row): ?>
                                            <tr>
                                                <th><?= $i++ ?></th>
                                                <th><?= date("d.m.Y H:i", strtotime($row['add_date'])) ?></th>
                                                <th><?= get_full_name($row['pricer_id']) ?></th>
                                                <th><?= get_full_name($row['user_id'])  ?></th>
                                                <th><?= $row['price'] ?></th>
                                                <th><?= $row['price_cash'] ?></th>
                                                <th><?= $row['price_card'] ?></th>
                                                <th><?= $row['price_transfer'] ?></th>
												<th>0</th>
												<th><?= $row['refund'] ?></th>
                                            </tr>
                                        <?php endforeach; ?>
										<?php foreach ($db->query($sql2) as $row): ?>
                                            <tr>
                                                <th><?= $i++ ?></th>
                                                <th><?= date("d.m.Y H:i", strtotime($row['add_date'])) ?></th>
                                                <th><?= get_full_name($row['pricer_id']) ?></th>
                                                <th><?= get_full_name($row['user_id'])  ?></th>
												<th>0</th>
                                                <th>0</th>
                                                <th>0</th>
                                                <th>0</th>
												<th><?= ($row['balance'] > 0) ? $row['balance'] : 0 ?></th>
												<th><?= ($row['balance'] < 0) ? $row['balance'] : 0 ?></th>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

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
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
