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

	<!-- <script src="jquery.js"></script> -->

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
						<form action="incoming.php" method="post" >
							<div class="row">
								<div class="col-md-9">
									<input type="hidden" name="pt" value="<?php echo $_GET['id']; ?>" />
									<input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />

									<div class="row">

										<div id="sel" class="col-md-6" >
											<select class="form-control  select-search select2-hidden-accessible" data-placeholder="Введите название или отсканируйте баркод" name="product" data-fouc="true">
												<option></option>

												<?php
												$result = $db->query("SELECT * FROM products WHERE qty >0");
													// $result->bindParam(':userid', $res);
													// $result->execute();
												for($i=0; $row = $result->fetch(); $i++){
												?>
													<option value="<?php echo $row['product_id'];?>" ><?php echo $row['product_code']; ?> - <?php echo $row['gen_name']; ?> -Остаток <?php echo $row['qty']; ?> |  Код продукта <?php echo $row['shcod']; ?> | Годен до: <?php echo $row['expiry_date']; ?></option>

												<?php
													}
												?>
											</select>
										</div>

										<div id="sel" class="col-md-6">
											<select class="form-control  select-search select2-hidden-accessible" data-placeholder="Введите название или отсканируйте баркод" name="client" data-fouc="true">
												<option></option>

												<?php

							                	$result = $db->query("SELECT * FROM users ORDER BY id DESC");
												while($row = $result->fetch(PDO::FETCH_ASSOC)) {
												?>

													<td><</td>
													<option value="<?= $row['id']; ?>"><?= $row['first_name']; ?></option>

												<?php
												}
											?>
											</select>
										</div>

									</div>


									<input type="hidden" name="nall" id = "nall" value="111"/>
									<input type="hidden" name="discount" value="" autocomplete="off" style="width: 68px; height:30px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" />
									<input type="hidden" name="date" value="<?php echo date("m/d/y"); ?>" />
								</div>
								<div class="col-md-1">
									<input type="text" name="qty" id="qty" value="1" class="form-control">
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-info">Добавить</button>
								</div>
							</div>
						</form>
					</div>

				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Продажы</h5>
				    </div>

				    <div class="card-body">

				        <div class="table-responsive">
				            <table class="table table-hover">
				                <thead>
				                    <tr class="bg-blue">
				                        <th> Наименование: </th>
										<th> Производитель:</th>
										<th> Серия:</th>
										<th> Цена за единицу: </th>
										<th> Количество: </th>
										<th> Цена: </th>
										<th> Прибыль: </th>
										<!-- <th> Действия: </th> -->
				                    </tr>
				                </thead>
				                <tbody>

				                	<?php
									$id=$_GET['invoice'];
									$result = $db->prepare("SELECT * FROM sales_order");
									$result->bindParam(':userid', $id);
									$result->execute();
									for($i=1; $row = $result->fetch(); $i++){
								?>
								<tr>
									<td hidden><?= $row['product']; ?></td>
									<td><?= $row['product_code']; ?></td>
									<td><?= $row['gen_name']; ?></td>
									<td><?= $row['name']; ?></td>
									<td>
									<?= formatMoney($row['price'], true);
									?>
									</td>
									<td><?= $row['qty']; ?></td>
									<td>
									<?= formatMoney($row['amount'], true);?>
									</td>
									<td>
									<?= formatMoney($row['profit'], true);?>
									</td>
									<!-- <td><a href="delete.php?id=<?= $row['transaction_id']; ?>&invoice=<?= $_GET['invoice']; ?>&dle=<?= $_GET['id']; ?>&qty=<?= $row['qty'];?>&code=<?= $row['product'];?>"><button class="btn btn-mini btn-warning"><i class="icon-cross2"></i></button></a></td> -->
								</tr>
								<?php
									}
								?>

								<tr>
									<th colspan="5"></th>
									<td>Общая цена: </td>
									<td>Общая прибыль: </td>
									<!-- <th></th> -->
								</tr>

								<tr>
									<td colspan="4"></td>
									<td><strong style="font-size: 12px; color: #222222;">Всего:</strong></td>
									<td colspan="1"><strong style="font-size: 12px; color: #222222;">
									<?php
									$sdsd=$_GET['invoice'];
									$resultas = $db->prepare("SELECT sum(amount) FROM sales_order");
									$resultas->bindParam(':a', $sdsd);
									$resultas->execute();
									for($i=0; $rowas = $resultas->fetch(); $i++){
									$fgfg=$rowas['sum(amount)'];
									echo formatMoney($fgfg, true);
									}
									?>
									</strong></td>
									<td colspan="1"><strong style="font-size: 12px; color: #222222;">
								<?php
									$resulta = $db->prepare("SELECT sum(profit) FROM sales_order");
									$resulta->bindParam(':b', $sdsd);
									$resulta->execute();
									for($i=0; $qwe = $resulta->fetch(); $i++){
									$asd=$qwe['sum(profit)'];
									echo formatMoney($asd, true);
									}
									?>

									</td>
									<!-- <th></th> -->
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
	<!-- /page content -->


<!-- 	<span class="select2-container select2-container--default select2-container--open"	style="position: absolute; top:118px; left: 310px;">
	    <span class="select2-dropdown select2-dropdown--below" dir="ltr" style="width: 683.5px;">
	        <span class="select2-search select2-search--dropdown">
	            <input class="select2-search__field" type="search" tabindex="0" autocomplete="off"
	            autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox">
	        </span>
	        <span class="select2-results">
	            <ul class="select2-results__options" role="tree" id="select2-bzv5-results"
	            aria-expanded="true" aria-hidden="false">
	                <li class="select2-results__option" id="select2-bzv5-result-fv26-152"
	                role="treeitem" aria-selected="false">
	                    Парацетамол таб 500 мг №10 - ???? -Остаток 417 | Код продукта 565656 |
	                    Годен до: 2020-11-21
	                </li>
	                <li class="select2-results__option select2-results__option--highlighted"
	                id="select2-bzv5-result-plb3-155" role="treeitem" aria-selected="false">
	                    Кислота ацетилсалициловая таб. 500 мг №10 - 3 -Остаток 12 | Код продукта
	                    22 | Годен до: 2020-11-19
	                </li>
	            </ul>
	        </span>
	    </span>
</span>
 -->


<?php
 	//onclick="$('.select2-container')[2].remove(); $('.select2-container')[2].remove(); $('#sel').attr('onclick', '')"
?>

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
	<script>


		window.onload = function() {
		   // Ваш скрипт

			// [0].mousedown();

			$('.select2-container')[0].dispatchEvent(new MouseEvent('mouseleave'))
			$('.select2-search__field')[0].focus();

			// $('#qty').focus();
		};




	<!-- <!-- </script> --> -->
</body>
</html>
