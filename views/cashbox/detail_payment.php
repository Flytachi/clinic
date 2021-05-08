<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "История платежей ". addZero($_GET['pk']);
$mas = '';

$staus = 0;

?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>

	<script>
    	arr = [];
	</script>
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
						<h6 class="card-title"><?= get_full_name($_GET['pk']) ?></h6>
						<div class="header-elements">
							<div class="list-icons">
								<button onclick="printS(this)" type="button" class="btn btn-outline-info btn-sm legitRipple">Чек</button>
								<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
							</div>
						</div>
					</div>

					<div class="card-body">


						<div class="table-responsive card">
                            <table class="table table-hover table-sm" id="table">
                                <thead class="<?= $classes['table-thead'] ?>">
                                    <tr>
                                        <th>№</th>
                                        <th>Дата  платежа</th>
										<th>Услуга/Медикоменты</th>
										<th>Наличные</th>
                                        <th>Пластик</th>
                                        <th>Перечисление</th>
                                        <th>Скидка</th>
										<th>Кассир</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // prit($db->query("SELECT vsp.* FROM visit_price vsp LEFT JOIN visit vs ON(vs.id=vsp.visit_id) WHERE vs.user_id = {$_GET['pk']} AND vsp.price_date IS NOT NULL ORDER BY price_date DESC")->fetchAll());
                                    $i = 1;
									foreach($db->query("SELECT vsp.* FROM visit_price vsp LEFT JOIN visit vs ON(vs.id=vsp.visit_id) WHERE vs.user_id = {$_GET['pk']} AND vsp.price_date IS NOT NULL ORDER BY price_date DESC") as $row) {
										if (empty($temp_old)) {
											$temp_old = $row['price_date'];
											$color = "";
										}else {
											if ($temp_old != $row['price_date']) {
												if ($color) {
													$color = "";
													$staus = 0;
												}else {

													$color = "table-secondary";

													$staus = 1;

												}
											}
											$temp_old = $row['price_date'];
										}

										$mas .=  $row['id'] . ",";
										?>
                                        <tr class="<?= $color ?>" onclick="addArray(this)" data-color="<?= $color ?>" data-status="true" data-id="<?= $row['id'] ?>">
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d.m.Y H:i', strtotime($row['price_date'])) ?></td>
                                            <td><?= $row['item_name'] ?></td>
                                            <td><?= $row['price_cash'] ?></td>
                                            <td><?= $row['price_card'] ?></td>
                                            <td><?= $row['price_transfer'] ?></td>
											<td><?= ($row['sale']) ? $row['sale'] : '<span class="text-muted">Нет данных</span>' ?></td>
											<td><?= get_full_name($row['pricer_id']) ?></td>
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

	<script>


		function addArray(body) {
			let id = Number(body.dataset.id);

        	if (body.dataset.status == 'true') {
            	body.style.backgroundColor = 'yellow';
            	body.dataset.status = 'false'

            	arr.push(id);

            	body.className = '';

            	console.log(arr);
        	}else{
            	body.style.backgroundColor = '';
            	body.dataset.status = 'true';
            	body.className = body.dataset.color;

            	for(let a = 0; a < arr.length; a++){
            		if(arr[a] == id ){
            			arr.splice(a, 1);
	            	}

            	}

            	console.log(arr);

        	}
		}

		function printS(body){
			if ("<?= $_SESSION['browser'] ?>" == "Firefox") {
				$.ajax({
			        type: "GET",
			        url: `<?= viv('prints/check') ?>?id=<?= $_GET['pk']?>&items=[${arr}]`,
			        success: function (data) {
			        	console.log(`<?= viv('prints/check') ?>?id=<?= $_GET['pk']?>&items=[${arr}]`)
			            let ww = window.open();
			            ww.document.write(data);
			            ww.focus();
			            ww.print();
			            ww.close();
			        },
			    });
			}else {
				let we = window.open(`<?= viv('prints/check') ?>?id=<?= $_GET['pk']?>&items=[${arr}]`,'mywindow');
		        setTimeout(function() {we.close()}, 100);
			}
		}

	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
