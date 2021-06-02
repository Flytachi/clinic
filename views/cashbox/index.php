<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("vendors/js/custom.js") ?>"></script>

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
				        <div class="<?= $classes['card'] ?>">

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
				                            <?php foreach($db->query("SELECT DISTINCT vss.visit_id, vs.user_id FROM visits vs LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) WHERE vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 1 ") as $row): ?>
				                                <tr onclick="Check('get_mod.php?pk=<?= $row['visit_id'] ?>')">
				                                    <td><?= addZero($row['user_id']) ?></td>
				                                    <td class="text-center">
				                                        <a>
				                                            <div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div>
				                                        </a>
				                                    </td>
				                                </tr>
				                            <?php endforeach; ?>
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
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Оплата</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div id="div_modal_price"></div>

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
							// console.log(data);
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
				url: "<?= ajax('cashbox/search') ?>",
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
			input.className = "form-control";
			input.value = "";
			var input_selectors = document.querySelectorAll(".input_chek");

			for (let item of input_selectors) {
				item.value = (document.querySelector("#total_price").value).replace(/,/g,'') / input_selectors.length;
			}
		}

		function Upsum(input) {
			input.className = "form-control input_chek";
			var input_selectors = document.querySelectorAll(".input_chek");
			var vas = 0;
			for (let key of input_selectors) {
				vas += Number(key.value);
			}
			input.value = (document.querySelector("#total_price").value).replace(/,/g,'') - vas;
		}
	</script>

</body>
</html>
