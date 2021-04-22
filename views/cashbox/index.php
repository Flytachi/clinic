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

				<?php include 'tabs.php' ?>
				<!-- Highlighted tabs -->
				<div class="row">

				    <div class="col-md-5">
				        <div class="card border-1 border-info">

							<div class="card-header bg-white header-elements-sm-inline">
								<h5 class="card-title">Приём платежей</h5>
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
				                            <?php
				                            foreach($db->query("SELECT DISTINCT user_id 'id' FROM visit WHERE direction IS NULL AND priced_date IS NULL AND add_date") as $row) {
				                            ?>
				                                <tr onclick="Check('get_mod.php?pk=<?= $row['id'] ?>')">
				                                    <td><?= addZero($row['id']) ?></td>
				                                    <td class="text-center">
				                                        <a>
				                                            <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
				                                        </a>
				                                    </td>
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

				    <div class="col-md-7">

				        <div id="message_ses">
				            <?php
				            if($_SESSION['message']){
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
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Оплата</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?php VisitPriceModel::form(); ?>

			</div>
		</div>
	</div>


	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">

		if (sessionStorage['message']) {
			$('#message_ses').html(sessionStorage['message']);
			sessionStorage['message'] = '';
		}

		function Delete(events, tr) {
			swal({
                position: 'top',
                title: 'Вы уверены что хотоите отменить услугу?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: "Да"
            }).then(function(ivi) {
                if (ivi.value) {
					$.ajax({
						type: "GET",
						url: events,
						success: function (data) {
							if (data == 1) {
								$('#'+tr).css("background-color", "red");
								$('#'+tr).css("color", "white");
								$('#'+tr).fadeOut('slow', function() {
								 	$(this).remove();
									sumTo($('.total_cost'));
								});
							}else{
								sessionStorage['message'] = data;
								location.reload();
							}
						},
					});
                }
            });
		};

		function sumTo(arr) {
			var total = 0;
			for (value of arr) {
				total += Number($(value).text());
			}
			$('#total_title').html(total);
		}

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

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					tab: 1,
                    search: $("#search_input").val(),
                },
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});

		function Downsum(input) {
			input.attr("class", 'form-control');
			input.val("");
			var inp_s = $('.input_chek');
			inp_s.val($('#total_price').val()/inp_s.length);
		}

		function Upsum(input) {
			input.attr("class", 'form-control input_chek');
			var inp_s = $('.input_chek');
			var vas = 0;
			for (let key of inp_s) {
				vas += Number(key.value);
			}
			input.val($('#total_price').val()-vas);
		}
	</script>

</body>
</html>
