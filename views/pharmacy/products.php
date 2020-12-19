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

<script src="<?= stack("global_assets/js/demo_pages/form_checkboxes_radios.js")?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/switchery.min.js")?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/switch.min.js")?>"></script>


</head>

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
							$rowcount = $db->query("SELECT * FROM products ORDER BY qty_sold DESC")->rowcount();

							$rowcount123 = $db->query("SELECT * FROM products where qty < 10 ORDER BY product_id DESC")->rowcount();

							$rowcountjnvls = $db->query("SELECT `catg`, `qty` FROM `products` WHERE `catg` = 'ОЛСИМН' && `qty` < 10;")->rowcount();

							$rowcountfixed = $db->query("SELECT `catg`, `qty` FROM `products` WHERE `catg` = 'Фиксированная' && `qty` < 10;")->rowcount();

							$d1 = strtotime('+120 days');
					        $d2 = date('Y-m-d', $d1);
							$result = $db->prepare("SELECT * FROM products WHERE expiry_date BETWEEN :a AND :b ORDER by product_id DESC ");
							$result->bindParam(':a', $d1);
							$result->bindParam(':b', $d2);
							$result->execute();
							$rowcountexpd = $result->rowcount();
						?>

						<div class="row">
							<div class="col-md-6">
								Количество вида препаратов: <span class="badge badge-flat badge-pill border-success text-success-600"> <?= $rowcount;?></span>
							</div>

							<div class="col-md-6">
								Общее количество препаратов оставшиеся меньше 10 шт: <span class="badge badge-flat badge-pill border-danger text-danger-600"><?= $rowcount123;?></span>
							</div>
						</div>
					</div>

				</div>

				<div class="card">

					<div class="card-body">

						<div class="row">
							<div class="col-md-2">
								<a href="revision.php">
									<button type="button" class="btn btn-info">ПЕЧАТЬ </button>

								</a>
							</div>

						</div>
					</div>

				</div>

				<div class="card">

					<div class="card-body">
							<div class="row">
								<div class="col-md-10">

									<input type="text" name="qty" id="qty"  class="form-control">
								</div>
								<div class="col-md-2">

									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_form_vertical" />Добавить</button>


									<div id="modal_form_vertical" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Наименование</h5>
													<button type="button" class="close" data-dismiss="modal">×</button>
												</div>

												<form action="saveproduct.php" method="POST">
													<div class="modal-body">
														<div class="form-group">
															<div class="row">
																<div class="col-md-10">
																	<label>Наименование</label>
																	<select name="product_code" class="form-control select select2-hidden-accessible" data-placeholder="Введите название" data-fouc="" tabindex="-1" aria-hidden="true">
																		<option></option>

																		<?php

																		$result = $db->query("SELECT * FROM goods");
																		for($i=0; $row = $result->fetch(); $i++){
																		?>
																			<option value="<?= $row['goodname'] ?>" ><?= $row['goodname'] ?></option>



																		<?php
																			}
																		?>
																	</select>
																</div>

																<div class="col-md-2">
																	<a href="newpr.php">

																		<button type="button" class="btn btn-info"><i class="icon-plus3"></i></button>

																	</a>
																</div>
															</div>
														</div>

														<div class="form-group">
															<div class="row">
																<div class="col-md-10">
																	<label>Поставщик</label>
																	<select name="supplier" class="form-control select select2-hidden-accessible" data-placeholder="Введите название" data-fouc="" tabindex="-1" aria-hidden="true">
																		<option></option>

																		<?php

																		$result = $db->query("SELECT * FROM supliers");
																		for($i=0; $row = $result->fetch(); $i++){
																		?>
																			<option value="<?= $row['suplier_name'] ?>" ><?= $row['suplier_name'] ?></option>


																		<?php
																			}
																		?>
																	</select>
																</div>
																<div class="col-md-2">
																	<a href="supplier.php">

																		<button type="button" class="btn btn-info"><i class="icon-plus3"></i></button>
																	</a>

																</div>
															</div>
														</div>

														<div class="form-group">
															<div class="row">
																<div class="col-md-6">
																	<label>Счет фактура №</label>
																	<input type="text" name="fakturanumber" placeholder="Ring street 12" class="form-control">
																</div>
																<div class="col-md-6">
																	<label>От</label>
																	<input class="form-control" name="sdate" type="date" name="date">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-4">
																	<label>Целая.УП</label>
																	<input id="e1" name="qtyu" class="form-control mult" type="number">
																</div>
																<div class="col-md-4">
																	<label>Шт.остаток</label>
																	<input id="e2" class="form-control mult" type="number">
																</div>
																<div class="col-md-4">
																	<label>Таб.в упаковке (шт)</label>
																	<input id="e3" class="form-control mult" type="number">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Производитель</label>
																	<input type="text" name="gen_name" placeholder="Munich" class="form-control">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Ед.изм</label>
																	<select name="ediz" class="form-control select select2-hidden-accessible" data-fouc="" tabindex="-1" aria-hidden="true">
																		<option value="УП">УП</option>
																        <option value="ПРТ">ПРТ</option>
																        <option value="ШТ">ШТ</option>
																        <option value="ОРГ">ОРГ</option>
																        <option value="КВТ">КВТ</option>
																        <option value="ФЛ">ФЛ</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Количество</label>
																	<input id="e4" name="qty" type="text" class="form-control" readonly="" value="">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Цена прихода одной упаковки</label>
																	<input id="e5" class="form-control mult" type="number" >
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Реальная цена одной </label>
																	<input id="e6" name="o_price" type="text" class="form-control" readonly="" value="">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Процент продаж</label>
																	<input id="e7" class="form-control mult" type="number">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Цена продажи</label>
																	<input id="e8" name="price" class="form-control mult" type="number">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Прибыль</label>
																	<input id="e9" name="profit" type="text" class="form-control" readonly="" value="">
																</div>
															</div>
														</div>

															
																<div class="form-group pt-2">
									<label>Категория</label>
									<div class="form-check">
										<label class="form-check-label">
											<input type="radio" class="form-check-input-styled" name="catg" value="0" checked data-fouc>
											Препарат
										</label>
									</div>
									<div class="form-check">
										<label class="form-check-label">
											<input type="radio" class="form-check-input-styled" name="catg" value="1" data-fouc>
											Расходный материал
										</label>
									</div>

									<div class="form-check">
										<label class="form-check-label">
											<input type="radio" class="form-check-input-styled" name="catg" value="1" data-fouc>
											Анестезия
										</label>
									</div>

								</div>

														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Дата получения</label>
																	<input class="form-control" name="date_arrival" type="date" name="date">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">

																	<label>Срок годности</label>
																	<input class="form-control" name="expiry_date" type="date" name="date">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Серия</label>
																	<input type="text" name="product_name" placeholder="Munich" class="form-control">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-12">
																	<label>Штрих код</label>
																	<input type="text" name="shcod" placeholder="Munich" class="form-control">
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
									<!-- <button type="button" class="btn btn-light legitRipple" data-toggle="modal" data-target="#modal_form_vertical">Launch <i class="icon-play3 ml-2"></i></button> -->
								</div>
							</div>

					</div>



				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">	Препараты (товары)</h5>
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
					                    <th> Название </th>
										<th> Производитель </th>
										<th> Серия </th>
										<th>Категория</th>
										<th>Поставщик</th>
										<th>Дата получения </th>
										<th>Срок годности</th>
										<th>Цена прихода</th>
										<th>Цена  продажи</th>
										<th>Кол-во</th>
										<th>Остаток</th>
										<th>Итого</th>
										<th>№ Сч/Факт</th>
										<th>Число.от</th>
										<th>Ед.изм</th>
										<th>Действия</th>

				                    </tr>
				                </thead>
				                <tbody>

				                	<?php

				                	$result = $db->query("SELECT *, price * qty as total FROM products ORDER BY product_id DESC");
									while($row = $result->fetch(PDO::FETCH_ASSOC)) {
										$total=$row['total'];
										$availableqty=$row['qty'];
										if ($availableqty < 10) {
										echo '<tr class="alert alert-warning record" style="color: #fff; background:#FF0000;">';
										}
										else {
										echo '<tr class="record">';
										}
									?>


										<td><?= $row['product_code']; ?></td>
										<td><?= $row['gen_name']; ?></td>
										<td><?= $row['product_name']; ?></td>
										<td><?= $row['catg']; ?></td>
										<td><?= $row['supplier']; ?></td>
										<td><?= $row['date_arrival']; ?></td>
										<td><?= $row['expiry_date']; ?></td>
										<td><?= formatMoney($row['o_price'], true);?></td>
										<td><?= formatMoney($row['price'], true);?></td>
										<td><?= $row['qty_sold']; ?></td>
										<td><?= $row['qty']; ?></td>
										<td><?= formatMoney($row['total'], true);?></td>
										<td><?= $row['fakturanumber']; ?></td>
										<td><?= $row['sdate']; ?></td>
										<td><?= $row['ediz']; ?></td>

										<td>
											<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#a<?= $row['product_id'] ?>"><i class="icon-pencil3"></i></button>
										<a href="deletproducts.php?id=<?= $row['product_id']; ?>" id="" class="delbutton" title="Удалить"><button class="btn btn-danger"><i class="icon-trash"></i></button></a></td>
									</tr>
									<?php
											}
										?>

									<tr>
										<td colspan="9">ИТОГ : </td>
										<td><?= $db->query("SELECT SUM(qty_sold) FROM products")->fetch()[0] ?></td>
										<td><?= $db->query("SELECT SUM(qty) FROM products")->fetch()[0] ?></td>


										<td colspan="5"></td>

									</tr>

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

	<?php

		$result1 = $db->query("SELECT *, price * qty as total FROM products ORDER BY product_id DESC");
		while($row1 = $result1->fetch()) {
	?>

	<div id="a<?= $row1['product_id'] ?>" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Наименование</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<form action="saveeditproduct.php" method="POST">
					<div class="modal-body">
						<input type="hidden" name="id" value="<?= $row1['product_id'] ?>">
						<div class="form-group">
							<div class="row">
								<div class="col-md-10">
									<label>Наименование</label>
									<select name="product_code" class="form-control select select2-hidden-accessible" data-placeholder="Введите название" data-fouc="" tabindex="-1" aria-hidden="true">
										<option value="<?= $row1['product_code'] ?>"><?= $row1['product_code'] ?></option>

										<?php

										$result = $db->query("SELECT * FROM goods");
										for($i=0; $row = $result->fetch(); $i++){
										?>
											<option value="<?= $row['goodname'] ?>" ><?= $row['goodname'] ?></option>



										<?php
											}
										?>
									</select>
								</div>

								<div class="col-md-2">
									<a href="newpr.php">

										<button type="button" class="btn btn-info"><i class="icon-plus3"></i></button>

									</a>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-10">
									<label>Поставщик</label>
									<select name="supplier" class="form-control select select2-hidden-accessible" data-placeholder="Введите название" data-fouc="" tabindex="-1" aria-hidden="true">
										<option value="<?= $row1['supplier'] ?>"><?= $row1['supplier'] ?></option>

										<?php

										$result = $db->query("SELECT * FROM supliers");
										for($i=0; $row = $result->fetch(); $i++){
										?>
											<option value="<?= $row['suplier_name'] ?>" ><?= $row['suplier_name'] ?></option>



										<?php
											}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<a href="supplier.php">

										<button type="button" class="btn btn-info"><i class="icon-plus3"></i></button>
									</a>

								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Счет фактура №</label>
									<input type="text" name="fakturanumber" value="<?= $row1['fakturanumber'] ?>" placeholder="Ring street 12" class="form-control">
								</div>
								<div class="col-md-6">
									<label>От</label>
									<input class="form-control" name="sdate" value="<?= $row1['sdate'] ?>" type="date" name="date">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Целая.УП</label>
									<input id="e1" name="qtyu" class="form-control mult" value="<?= $row1['qtyu'] ?>" type="number">
								</div>
								<div class="col-md-4">
									<label>Шт.остаток</label>
									<input id="e2" class="form-control mult"  type="number">
								</div>
								<div class="col-md-4">
									<label>Таб.в упаковке (шт)</label>
									<input id="e3" class="form-control mult" type="number">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Производитель</label>
									<input type="text" name="gen_name" value="<?= $row1['gen_name'] ?>" placeholder="Munich" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Ед.изм</label>
									<select name="ediz" class="form-control select select2-hidden-accessible" value="<?= $row1['ediz'] ?>"  data-fouc="" tabindex="-1" aria-hidden="true">
										<option value="УП">УП</option>
								        <option value="ПРТ">ПРТ</option>
								        <option value="ШТ">ШТ</option>
								        <option value="ОРГ">ОРГ</option>
								        <option value="КВТ">КВТ</option>
								        <option value="ФЛ">ФЛ</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Количество</label>
									<input id="e4" name="qty" type="text" value="<?= $row1['qty'] ?>" class="form-control" readonly="" value="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Цена прихода одной упаковки</label>
									<input id="e5" class="form-control mult" type="number" >
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Реальная цена одной </label>
									<input id="e6" name="o_price" value="<?= $row1['o_price'] ?>" type="text" class="form-control" readonly="" value="">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Процент продаж</label>
									<input id="e7" class="form-control mult" type="number">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Цена продажи</label>
									<input id="e8" name="price" value="<?= $row1['price'] ?>" class="form-control mult" type="number">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Прибыль</label>
									<input id="e9" name="profit" value="<?= $row1['profit'] ?>" type="text" class="form-control" readonly="" value="">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Категория</label>
									<select name="catg" class="form-control select select2-hidden-accessible"  data-fouc="" tabindex="-1" aria-hidden="true">
										<option></option>
										<?php foreach ($db->query("SELECT * FROM pharmacy_category") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ($row1['catg']==$row['id']) ? "selected" : ""?>><?= $row['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Дата получения</label>
									<input class="form-control" name="date_arrival" value="<?= $row1['date_arrival'] ?>"  type="date" name="date">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Срок годности</label>
									<input class="form-control" name="expiry_date" value="<?= $row1['expiry_date'] ?>" type="date" name="date">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Серия</label>
									<input type="text" name="product_name" value="<?= $row1['product_name'] ?>" placeholder="Munich" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<label>Штрих код</label>
									<input type="text" name="shcod" value="<?= $row1['shcod'] ?>" placeholder="Munich" class="form-control">
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

	<script>

		$('.mult').focusout(function() {
			$('#e4').val( Number( $('#e1').val() ) * Number( $('#e3').val() ) + Number( $('#e2').val() ) );
			$('#e6').val( Number( $('#e5').val() ) / Number( $('#e3').val() ) );
		});

		$('#e7').focusout(function() {

			let price = Number( $('#e6').val() );

			$('#e8').val( (Number( $('#e7').val() ) / 100) * price + price );

			$('#e9').val( Number( $('#e8').val() )- price  );
		});

		$('#e8').focusout(function() {

			$('#e9').val( Number( $('#e8').val() ) - Number( $('#e6').val() )  );
		});


	</script>


	<!-- /page content -->

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
