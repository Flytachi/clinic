<?php
require_once '../../../tools/warframe.php';
is_auth(8);
$header = "Отчёт по услугам";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
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

						<div class="form-group row">

							<div class="col-md-3">
								<label>Дата визита:</label>
								<div class="input-group">
									<input type="text" class="form-control daterange-locale">
									<span class="input-group-append">
										<span class="input-group-text"><i class="icon-calendar22"></i></span>
									</span>
								</div>
							</div>

							<div class="col-md-3">
			                    <label>Отдел:</label>
			                    <select data-placeholder="Выберите отдел" id="division" class="form-control form-control-select2" required data-fouc>
			                       <option>Выберите отдел</option>
			                        <?php
			                        foreach($db->query('SELECT * from division WHERE level = 5 OR level = 6') as $row) {
			                            ?>
			                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
			                            <?php
			                        }
			                        ?>
			                    </select>
			                </div>

			                <div class="col-md-3">
			                    <label>Услуга:</label>
			                    <select data-placeholder="Выберите услугу" id="service" class="form-control form-control-select2" required data-fouc>
			                        <option></option>
			                        <?php
			                        foreach($db->query('SELECT * from service WHERE user_level = 5 OR user_level = 6') as $row) {
			                            ?>
			                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= $row['name'] ?></option>
			                            <?php
			                        }
			                        ?>
			                    </select>
			                </div>

							<div class="col-md-3">
			                    <label>Специалист:</label>
			                    <select data-placeholder="Выберите специалиста" id="parent_id" class="form-control form-control-select2" data-fouc required>
			                        <option></option>
			                        <?php
			                        foreach($db->query('SELECT * from users WHERE user_level = 5 OR user_level = 6') as $row) {
			                            ?>
			                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
			                            <?php
			                        }
			                        ?>
			                    </select>
			                </div>

						</div>

						<div class="from-group row">

							<div class="col-md-3">
			                    <label>Тип визита:</label>
			                    <select data-placeholder="Выберите тип визита" class="form-control form-control-select2" data-fouc required>
			                        <option>Выберите тип визита</option>
									<option value="0">Амбулаторный</option>
									<option value="1">Стационарный</option>
			                    </select>
			                </div>

							<div class="col-md-3">
			                    <label>Пациент:</label>
								<select class="form-control form-control-select2" data-fouc required>
			                        <option>Выберите пациента</option>
									<?php
									foreach($db->query('SELECT * from users WHERE user_level = 15') as $row) {
										?>
										<option value="<?= $row['id'] ?>"><?= addZero($row['id'])." - ".get_full_name($row['id']) ?></option>
										<?php
									}
									?>
			                    </select>
			                </div>

							<div class="col-md-3">
								<label class="d-block font-weight-semibold">Статус</label>
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_unchecked" checked>
									<label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Завершёные</label>
								</div>

								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked" checked>
									<label class="custom-control-label" for="custom_checkbox_stacked_checked">Не завершёные</label>
								</div>
							</div>

						</div>

						<div class="text-right">
							<button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
						</div>

                    </div>

                </div>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Услуги</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <thead>
                                    <tr class="bg-info">
			                            <th>Отдел</th>
			                            <th>Услуга</th>
										<th>Специалист</th>
										<th>Дата проведения</th>
			                            <th>Тип визита</th>
										<th>Статус</th>
										<th>Пациент</th>
                                    </tr>
                                </thead>
                                <tbody>

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
		$(function(){
			$("#parent_id").chained("#division");
			$("#service").chained("#division");
		});
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
