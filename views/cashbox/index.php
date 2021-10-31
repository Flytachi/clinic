<?php
require_once '../../tools/warframe.php';
$session->is_auth(22);
$header = "Приём платежей";

$tb = (new VisitModel)->tb('v');
$search = $tb->get_serch();
$tb->set_data("DISTINCT vs.visit_id, v.client_id")->additions("LEFT JOIN visit_services vs ON(vs.visit_id=v.id) LEFT JOIN clients c ON(c.id=v.client_id)");

$where_search = array(
	"v.branch_id = $session->branch AND v.direction IS NULL AND v.completed IS NULL AND vs.status = 1", 
	"v.branch_id = $session->branch AND v.direction IS NULL AND v.completed IS NULL AND vs.status = 1 AND (c.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', c.last_name, c.first_name, c.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($where_search);
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("assets/js/custom.js") ?>"></script>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
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

				<?php include 'tabs_1.php' ?>
				<!-- Highlighted tabs -->
				<div class="row">

				    <div class="col-md-5">
				        <div class="<?= $classes['card'] ?>">

							<div class="<?= $classes['card-header'] ?>">
								<h5 class="card-title">Приём платежей</h5>
								<div class="header-elements">
									<div class="form-group-feedback form-group-feedback-right mr-2">
										<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
										<div class="form-control-feedback">
											<i class="icon-search4 font-size-base text-muted"></i>
										</div>
									</div>
								</div>
							</div>

				            <div class="card-body" id="search_display">

				                <div class="table-responsive">
				                    <table class="table table-hover">
				                        <thead>
				                            <tr>
				                                <th>ID</th>
				                                <th class="text-center">ФИО</th>
				                            </tr>
				                        </thead>
				                        <tbody id="search_display">
				                            <?php foreach($tb->get_table(1) as $row): ?>
				                                <tr onclick="Check('<?= up_url($row->visit_id, 'TransactionPanel') ?>')" id="VisitIDPrice_<?= $row->visit_id ?>">
				                                    <td><?= addZero($row->client_id) ?></td>
				                                    <td class="text-center">
				                                        <div class="font-weight-semibold"><?= client_name($row->client_id) ?></div>
				                                    </td>
				                                </tr>
				                            <?php endforeach; ?>
											<?php if(isset($row->count)): ?>
												<tr class="<?= $classes['table-count_menu'] ?>">
													<th colspan="2" class="text-right">Всего: <?= $row->count ?></th>
												</tr>
											<?php else: ?>
												<tr class="table-secondary">
													<th colspan="2" class="text-center">Нет данных</th>
												</tr>
											<?php endif; ?>
				                        </tbody>
				                    </table>
				                </div>

				            </div>

				        </div>
				    </div>

				    <div class="col-md-7">

				        <div id="message_ses">
				            <?php
				            if( isset($_SESSION['message']) ){
				                echo $_SESSION['message'];
				                unset($_SESSION['message']);
				            }
				            ?>
				        </div>

				        <div id="check_div">
				        </div>

				    </div>

				</div>
				<!-- /highlighted tabs -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Basic modal -->
	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>


	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/cashbox-index') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#check_div').html(result);
					sumTo($('.total_cost'));
				},
			});
		};

		function sumTo(arr) {
			var total = 0;
			for (value of arr) {
				total += Number($(value).text());
			}
			$('#total_title').html(total);
		}

	</script>

</body>
</html>
