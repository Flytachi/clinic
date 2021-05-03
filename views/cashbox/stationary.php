<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/forms/inputs/touchspin.min.js') ?>"></script>

<script src="<?= stack('global_assets/js/demo_pages/form_input_groups.js') ?>"></script>

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

                <?php include 'tabs.php' ?>

				<!-- Highlighted tabs -->
                <div class="row">

                    <div class="col-md-5">

                        <div class="card border-1 border-info">

							<div class="card-header bg-white header-elements-sm-inline">
								<h5 class="card-title">Стационар</h5>
								<div class="header-elements">
									<div class="form-group-feedback form-group-feedback-right">
										<input type="search" class="form-control wmin-200 border-success" id="search_input" placeholder="Введите ID или имя">
										<div class="form-control-feedback text-success">
											<i class="icon-search4 font-size-base text-muted"></i>
										</div>
									</div>
								</div>
							</div>

                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th class="text-center">ФИО</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search_display">
                                            <?php $i=0; foreach($db->query("SELECT DISTINCT us.id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE us.user_level = 15 AND vs.direction IS NOT NULL AND vs.priced_date IS NULL AND vs.service_id = 1") as $row): ?>
                                                <tr onclick="Check('get_mod.php?pk=<?= $row['id'] ?>', '<?= $row['id'] ?>')">
                                                    <td><?= addZero($row['id']) ?></td>
                                                    <td class="text-center">
                                                        <a>
                                                            <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                                                        </a>
                                                    </td>
                                                </tr>
											<?php $i++; endforeach; ?>
											<tr class="table-secondary">
												<th colspan="2" class="text-right">Всего: <?= $i ?></th>
											</tr>
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

	<div id="modal_invest" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Оплата</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?php (new InvestmentModel)->form(); ?>

			</div>
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

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					tab: 2,
                    search: $("#search_input").val(),
                },
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});
	</script>

</body>
</html>
