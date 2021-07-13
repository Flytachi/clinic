<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "Приём платежей";

$tb = new Table($db, "visits vs");
$search = $tb->get_serch();
$tb->set_data("vs.id, vs.user_id")->additions("LEFT JOIN users us ON(us.id=vs.user_id)");

$where_search = array(
	"vs.direction IS NOT NULL AND vs.completed IS NULL", 
	"vs.direction IS NOT NULL AND vs.completed IS NULL AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($where_search);
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("assets/js/custom.js") ?>"></script>

<body>
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

                <?php include 'tabs_1.php' ?>

				<!-- Highlighted tabs -->
                <div class="row">

                    <div class="col-md-5">

                        <div class="<?= $classes['card'] ?>">

							<div class="<?= $classes['card-header'] ?>">
								<h5 class="card-title">Стационар</h5>
								<div class="header-elements">
									<form action="" class="mr-2">
										<div class="form-group-feedback form-group-feedback-right">
											<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
											<div class="form-control-feedback">
												<i class="icon-search4 font-size-base text-muted"></i>
											</div>
										</div>
									</form>
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
                                        <tbody>
											<?php foreach($tb->get_table(1) as $row): ?>
				                                <tr onclick="Check('get_mod.php?pk=<?= $row->id ?>')" id="VisitIDPrice_<?= $row->id ?>">
				                                    <td><?= addZero($row->user_id) ?></td>
				                                    <td class="text-center">
				                                        <div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
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

                    <div class="col-md-7" id="check_div">
                        <?php
                        if( isset($_SESSION['message']) ){
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>
                    </div>

                </div>
				<!-- /highlighted tabs -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<?php if(module('module_pharmacy')): ?>
		<div id="modal_default" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Оплата Препаратов</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<?php (new VisitPriceModel)->form_pharm(); ?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="modal_sale" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Скидка</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div id="modal_sale_div"></div>

			</div>
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
				url: "<?= ajax('search/cashbox-stationary') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

		if (sessionStorage['message']) {
			$('#check_div').html(sessionStorage['message']);
			sessionStorage['message'] = '';
		}

		function Detail(events) {
			if (event.target.dataset.show == 1) {
				$(event.target).addClass('btn-primary');
				$(event.target).removeClass('btn-outline-primary');
				event.target.dataset.show = 0;
				$.ajax({
					type: "GET",
					url: events,
					success: function (result) {
						$('#detail_div').html(result);
					},
				});
			}else {
				$(event.target).addClass('btn-outline-primary');
				$(event.target).removeClass('btn-primary');
				event.target.dataset.show = 1;
				$('#detail_div').html("");
			}
		}

		function Invest(status) {
			$('#modal_invest').modal('show');
			$('#input_balance').text(event.target.dataset.balance);
			$('#balance_name').text(event.target.dataset.name);
			$('#price_type').val(status);
		}

		function Check(events, pk) {
			$.ajax({
				type: "GET",
				url: events+"&mod=st",
				success: function (result) {
					$('#check_div').html(result);
					$('#user_st_id').val(pk);
	                document.querySelectorAll('.input_check').forEach(function(events) {
						$(events).val("");
	                });
					document.querySelectorAll('.swit_check').forEach(function(events) {
						if (events.checked) {
							$(events).trigger('click');
						}
				   	});
				},
			});
		};
	</script>

</body>
</html>
