<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

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
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <?php include 'tabs.php' ?>

				<!-- Highlighted tabs -->
                <div class="row">

                    <div class="col-md-5">

                        <div class="card border-1 border-info">
                            <div class="card-body">

                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label text-success font-weight-semibold animate">ID или имя пациента</label>
                                    <div class="form-group-feedback form-group-feedback-right">
                                        <input type="text" class="form-control border-success" id="search_input" placeholder="Введите ID или имя">
                                        <div class="form-control-feedback text-success">
                                            <i class="icon-search4"></i>
                                        </div>
                                    </div>
                                    <span class="form-text text-success">Выбор пациента</span>
                                </div>

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
                                            foreach($db->query("SELECT DISTINCT user_id 'id' FROM visit WHERE direction IS NOT NULL AND priced_date IS NULL AND status IS NOT NULL") as $row) {
                                                ?>
                                                    <tr onclick="Check('get_mod.php?pk=<?= $row['id'] ?>', '<?= $row['id'] ?>')">
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

                    <div class="col-md-7" id="check_div">
                        <?php
                        if($_SESSION['message']){
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

				<?php InvestmentModel::form(); ?>

			</div>
		</div>
	</div>

	<!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->

	<script type="text/javascript">

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
