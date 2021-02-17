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
						<form action="incoming.php" method="post" >
							<div class="row">
								<div class="col-md-12">
									<input type="text" placeholder="Поиск" name="qty" id="qty"  class="form-control">	
								</div>
							</div>
						</form>
					</div>
					
				</div>

				<div class="card">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Таблица продаж</h5>
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
					                   	<th> Номер чека </th>
										<th> Дата </th>
										<th> Название </th>
										<th> Производитель </th>
										<th> Серия </th>
										<th> Цена </th>
										<th> Количество </th>
										<th> Сумма </th>
										<th> Прибыль </th>
										<th> Действия </th>
				                    </tr>
				                </thead>
				                <tbody>

				                	<?php
				                	$result = $db->query("SELECT * FROM sales_order ORDER BY transaction_id DESC");
									while($row = $result->fetch(PDO::FETCH_ASSOC)) {
									?>
									<tr>
										<td><?= $row['invoice']; ?></td>
										<td><?= $row['date']; ?></td>
										<td><?= $row['product_code']; ?></td>
										<td><?= $row['gen_name']; ?></td>
										<td><?= $row['name']; ?></td>
										<td><?= formatMoney($row['price'], true);
										?></td>
										<td><?= $row['qty']; ?></td>
										<td><?= formatMoney($row['amount'], true);?></td>
										<td><?= formatMoney($row['profit'], true);?></td>
										<td> 				
										<a href="deletesalesinventory.php?id=<?= $row['transaction_id']; ?>&qty=<?= $row['qty'];?>"><button class="btn btn-mini btn-danger"><i class="icon icon-trash"></i> Удалить </button></a>
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
	<!-- /page content -->

    <!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
