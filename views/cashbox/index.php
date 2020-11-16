<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

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

				<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
					<li class="nav-item"><a href="#highlighted-tab1" class="nav-link active" data-toggle="tab">Приём платежей</a></li>
					<li class="nav-item"><a href="#highlighted-tab2" class="nav-link" data-toggle="tab">Стационар</a></li>
				</ul>

				<!-- Highlighted tabs -->
				<div class="tab-content">

					<div class="tab-pane fade show active" id="highlighted-tab1">
						<?php
							include 'tabs/kassa_1.php';
						?>
					</div>

					<div class="tab-pane fade" id="highlighted-tab2">
						<?php
							include 'tabs/kassa_2.php';
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


	<!-- Basic modal -->
	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Оплата</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?php UserCheckOutpatientModel::form(); ?>

			</div>
		</div>
	</div>


    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

	<script type="text/javascript">
		if (sessionStorage['message_amb']) {
			$('#message_ses').html(sessionStorage['message_amb']);
			sessionStorage['message_amb'] = '';
		}
		function Update(events, tr) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					var result = JSON.parse(data);
					if (result.stat) {
						sessionStorage['message_amb'] = result.message;
						location.reload();
					}else{
						$('#'+tr).css("background-color", "red");
						$('#'+tr).css("color", "white");
						$('#'+tr).fadeOut('slow', function() {
						 	$(this).remove();
							sumTo($('.total_cost'));
						});
					}
				},
			});
		};

		function sumTo(arr) {
			var total = 0;
			for (value of arr) {
			  total += parseInt(value.textContent);
			}
			$('#total_title').html(total);
		}

		function CheckAmb(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#check-amb').html(result);
					sumTo($('.total_cost'));
				},
			});
		};

		function CheckSt(events, pk) {
			$.ajax({
				type: "GET",
				url: events+"&mod=st",
				success: function (result) {
					$('#check-st').html(result);
					$('#visit_st_id').val(pk);
				},
			});
		};

		$("#search_tab-1").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					tab: 1,
                    search: $("#search_tab-1").val(),
                },
				success: function (result) {
					$('#displ_tab-1').html(result);
				},
			});
		});

		$("#search_tab-2").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					tab: 2,
                    search: $("#search_tab-2").val(),
                },
				success: function (result) {
					console.log(result);
					$('#displ_tab-2').html(result);
				},
			});
		});
	</script>

</body>
</html>