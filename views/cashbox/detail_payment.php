<?php
require_once '../../tools/warframe.php';
$session->is_auth(22);
$header = "История платежей ". addZero($_GET['pk']);

if (!is_numeric($_GET['pk'])) {
	Mixin\error('404');
}

$tb = (new VisitTransactionModel)->tb();
$search = $tb->get_serch();
$search_array = array(
	"branch_id = $session->branch AND is_visibility IS NOT NULL AND client_id = {$_GET['pk']} AND is_price IS NOT NULL", 
	"branch_id = $session->branch AND is_visibility IS NOT NULL AND client_id = {$_GET['pk']} AND is_price IS NOT NULL AND (LOWER(item_name) LIKE LOWER('%$search%'))"
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
						<h6 class="card-title"><?= client_name($_GET['pk']) ?></h6>
						<div class="header-elements">
							<div class="list-icons">
								<button onclick="Print(`<?= prints('check') ?>?pk=<?= $_GET['pk']?>&items=[${arr}]`);" type="button" class="<?= $classes['btn-table'] ?>">Чек</button>
								<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="<?= $classes['btn-table'] ?>">Excel</button>
							</div>
							<div class="form-group-feedback form-group-feedback-right mr-2 ml-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите услугу или медикомент">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
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
				url: "<?= ajax('search/cashbox-detail_payment') ?>",
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

        	}
		}

	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
