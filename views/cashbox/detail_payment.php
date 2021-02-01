<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "История платежей ". addZero($_GET['pk']);
$mas = '';

$staus = 0;

?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>

	<script>

    	flag = true;

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

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title"><?= get_full_name($_GET['pk']) ?></h6>
						<div class="header-elements">
							<div class="list-icons">
								<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
							</div>
						</div>
					</div>

					<div class="card-body">


						<div class="table-responsive card">
                            <table class="table table-hover table-sm" id="table">
                                <thead>
                                    <tr class="bg-info">
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
									foreach($db->query("SELECT vs.id as id_visit, vsp.* FROM visit_price vsp LEFT JOIN visit vs ON(vs.id=vsp.visit_id) WHERE vs.user_id = {$_GET['pk']} AND vsp.price_date IS NOT NULL ORDER BY price_date DESC") as $row) {
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

										$mas .=  $row['id_visit'] . ",";
										?>
                                        <tr class="<?= $color ?>" data-href="/clinic/views/prints/check.php?id=<?= $_GET['pk']?>&items=[<?= $row['id_visit'] ?>]" onclick="//printS(this)

                                        	let id = Number(this.dataset.id);

                                        	if (this.dataset.status == 'true') {
	                                        	this.style.backgroundColor = 'green';
	                                        	this.dataset.status = 'false'

	                                        	arr.push(this.dataset.id);

                                        	}else{
	                                        	this.style.backgroundColor = '';
	                                        	this.dataset.status = 'true'

	                                        	arr = arr.map(function(it, ind, arr ) {
	                                        		if(it == id ){
	                                        			delet(arr[ind]);
	                                        		}
	                                        	})
                                        	}
                                        " data-color="<?= $staus ?>" data-status="true" data-id="<?= $row['id_visit'] ?>">
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
						<button type="button" data-href="/clinic/views/prints/check.php?id=<?= $_GET['pk']?>&items=[<?= substr( $mas, 0,-1) ?>]" onclick="printS(this)"> ww</button>

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


		function printS(body){

			$.ajax({
		        type: "GET",
		        url: `/views/prints/check.php?id=<?= $_GET['pk']?>&items=[${arr}]`,
		        success: function (data) {
		            let ww = window.open();
		            ww.document.write(data);
		            ww.focus();
		            ww.print();
		            ww.close();
		        },
		    });

		}

	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
