<?php
require_once '../../tools/warframe.php';
is_auth(4);

?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<?php
	function formatMoney($number, $fractional=false) {
		if ($fractional) {
			$number = sprintf('%.2f', $number);
			// echo " ff ". $number." ff ";
		}
		while (true) {
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
			// echo " ff ". $replaced." ff ";
			if ($replaced != $number) {
				$number = $replaced;
			} else {
				break;
			}
		}
		return $number;
	}

?>

<script src="<?= stack("global_assets/js/plugins/extensions/jquery_ui/interactions.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js")?>"></script>

<script src="<?= stack("assets/js/app.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js")?>"></script>

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

				<div class="card">

					<div class="card-body">

						<?php
							$rowcount = $db->query("SELECT * FROM customer ORDER BY customer_id DESC")->rowcount();
						?>

						<div class="row">
							<div class="col-md-6">
								Общее количество клиентов: <span class="badge badge-flat badge-pill border-success text-success-600"><?= $rowcount;?></span>
							</div>
						</div>
					</div>

				</div>

				<div class="card">

					<div class="card-body">
						<form action="incoming.php" method="post" >
							<div class="row">
								<div class="col-md-10">
									<input type="text" name="qty" id="qty"  class="form-control">
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_form_vertical" />Добавить</button>
									<!-- <button type="button" class="btn btn-light legitRipple" data-toggle="modal" data-target="#modal_form_vertical">Launch <i class="icon-play3 ml-2"></i></button> -->
								</div>
							</div>
						</form>
					</div>

				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Клиенты</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-blue">
										<th> ID Транзакции </th>
										<th> Дата транзакции </th>
										<th> Наименование клиента </th>
										<th> Номер счета </th>
										<th> Всего </th>
										<th> Прибыль </th>
				                    </tr>
				                </thead>
				                <tbody>

				                	<?php

				                	$result = $db->query("SELECT * FROM sales ORDER BY transaction_id DESC");
									while($row = $result->fetch(PDO::FETCH_ASSOC)) {
									?>

									<tr class="record">
										<td>STI-00<?= $row['transaction_id']; ?></td>
										<td><?= $row['date']; ?></td>
										<td><?= $row['name']; ?></td>
										<td><?= $row['invoice_number']; ?></td>
										<td><?= formatMoney($row['amount'], true); ?></td>
										<td><?= formatMoney($row['profit'], true); ?></td>
									</tr>
									<?php
											}
										?>
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
	<div id="modal_form_vertical" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"> Добавить клиента</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<form action="savecustomer.php" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Наименование</label>
									<input type="text" name="customer_name" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Адрес</label>
									<input type="text" name="address" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Телефон</label>
									<input type="text" name="contact" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Название товара</label>
									<textarea rows="3" cols="3" name="prod_name" class="form-control" ></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Общая сумма</label>
									<input type="text" name="membership_number" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Заметки (р/с и т д...)</label>
									<textarea rows="3" cols="3" name="note" class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Дата поставки</label>
									<input class="form-control" name="expected_date" type="date" name="date">
								</div>
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Закрыть</button>
						<button type="submit" class="btn bg-primary legitRipple">Сохранить</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php

    	$result = $db->query("SELECT * FROM customer ORDER BY customer_id DESC");
		while($row = $result->fetch()) {
	?>
		<div id="a<?= $row['customer_id'] ?>" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"> Добавить клиента</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>

					<form action="saveeditcustomer.php" method="POST">
						<input type="hidden" name="id" value="<?= $row['customer_id'] ?>">
						<div class="modal-body">
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Наименование</label>
										<input type="text" name="customer_name" value="<?= $row['customer_name'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Адрес</label>
										<input type="text" name="address" value="<?= $row['address'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Телефон</label>
										<input type="text" name="contact" value="<?= $row['contact'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Название товара</label>
										<textarea rows="3" cols="3" name="prod_name" value="<?= $row['prod_name'] ?>" class="form-control" > <?= $row['prod_name'] ?> </textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Общая сумма</label>
										<input type="text" name="membership_number" value="<?= $row['membership_number'] ?>" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Заметки (р/с и т д...)</label>
										<textarea rows="3" cols="3" name="note" value="<?= $row['note'] ?>" class="form-control"><?= $row['note'] ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<label>Дата поставки</label>
										<input class="form-control" name="expected_date" value="<?= $row['expected_date'] ?>" type="date" name="date">
									</div>
								</div>
							</div>

						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Закрыть</button>
							<button type="submit" class="btn bg-primary legitRipple">Сохранить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php
		}
	?>

	<!-- /page content -->

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
