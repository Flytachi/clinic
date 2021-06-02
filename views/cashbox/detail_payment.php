<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "История платежей ". addZero($_GET['pk']);

$tb = new Table($db, "visit_prices");
$search = $tb->get_serch();
$search_array = array(
	"user_id = {$_GET['pk']} AND price_date IS NOT NULL", 
	"user_id = {$_GET['pk']} AND price_date IS NOT NULL"
);
$tb->where_or_serch($search_array)->order_by('price_date DESC')->set_limit(20);
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
							<form action="" class="mr-2 ml-2">
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
									<?php foreach($tb->get_table(1) as $row): ?>
                                        <?php
										if ( empty($mas) ) $mas = '';
										if (empty($temp_old)) {
											$temp_old = $row->price_date;
											$color = "";
										}else {
											if ($temp_old != $row->price_date) {
												if ($color) {
													$color = "";
													$staus = 0;
												}else {

													$color = "table-secondary";

													$staus = 1;

												}
											}
											$temp_old = $row->price_date;
										}

										$mas .=  $row->id . ",";
										?>
                                        <tr class="<?= $color ?>" onclick="addArray(this)" data-color="<?= $color ?>" data-status="true" data-id="<?= $row->id ?>">
                                            <td><?= $row->count ?></td>
                                            <td><?= date_f($row->price_date, 1) ?></td>
                                            <td><?= $row->item_name ?></td>
                                            <td><?= $row->price_cash ?></td>
                                            <td><?= $row->price_card ?></td>
                                            <td><?= $row->price_transfer ?></td>
											<td><?= ($row->sale) ? $row->sale : '<span class="text-muted">Нет данных</span>' ?></td>
											<td><?= get_full_name($row->pricer_id) ?></td>
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

	<script>

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/payment-detail') ?>",
				data: {
					table_search: input.value,
					pk: "<?= $_GET['pk'] ?>",
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

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
