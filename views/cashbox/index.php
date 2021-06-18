<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "Рабочий стол";

$tb = new Table($db, "visits vs");
$search = $tb->get_serch();
$tb->set_data("DISTINCT vss.visit_id, vs.user_id")->additions("LEFT JOIN visit_services vss ON(vss.visit_id=vs.id) LEFT JOIN users us ON(us.id=vs.user_id)");

$where_search = array(
	"vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 1", 
	"vs.direction IS NULL AND vs.completed IS NULL AND vss.status = 1 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($where_search);
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

				<?php include 'tabs_1.php' ?>
				<!-- Highlighted tabs -->
				<div class="row">

				    <div class="col-md-5">
				        <div class="<?= $classes['card'] ?>">

							<div class="card-header bg-white header-elements-sm-inline">
								<h5 class="card-title">Приём платежей</h5>
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
				                        <tbody id="search_display">
				                            <?php foreach($tb->get_table() as $row): ?>
				                                <tr onclick="Check('get_mod.php?pk=<?= $row->visit_id ?>')" id="VisitIDPrice_<?= $row->visit_id ?>">
				                                    <td><?= addZero($row->user_id) ?></td>
				                                    <td class="text-center">
				                                        <div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
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
			<div class="<?= $classes['modal-global_content'] ?>">
				<div class="<?= $classes['modal-global_header'] ?>">
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
						success: function (result) {
							var data = JSON.parse(result);
							console.log(data);

							if (data.status == "success") {
								if (data.count == 0) {
									$('#check_div').html("");
									$('#VisitIDPrice_'+data.visit_pk).css("background-color", "red");
									$('#VisitIDPrice_'+data.visit_pk).css("color", "white");
									$('#VisitIDPrice_'+data.visit_pk).fadeOut('slow', function() {
										$(this).remove();
									});
								}else{
									$('#'+tr).css("background-color", "red");
									$('#'+tr).css("color", "white");
									$('#'+tr).fadeOut('slow', function() {
										$(this).remove();
										sumTo($('.total_cost'));
									});
								}
								new Noty({
									text: data.message,
									type: 'success'
								}).show();
								
							}else {

								new Noty({
									text: data.message,
									type: 'error'
								}).show();
								
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
