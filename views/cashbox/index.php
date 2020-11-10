<?php
require_once '../../tools/warframe.php';
is_auth(3);
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
			<!-- Content area -->
			<div class="content">

				<!-- Highlighted tabs -->
				<div class="row">

				    <div class="col-md-12">
				        <div class="card">

				            <div class="card-body">
				                <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
				                    <li class="nav-item"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab">Приём платежей</a></li>
				                    <li class="nav-item"><a href="#highlighted-justified-tab2" class="nav-link" data-toggle="tab">История платежей</a></li>
				                    <li class="nav-item"><a href="#highlighted-justified-tab3" class="nav-link" data-toggle="tab">Возврат</a></li>
				                    <li class="nav-item"><a href="#highlighted-justified-tab4" class="nav-link" data-toggle="tab">Стационар</a></li>
				                </ul>

				                <div class="tab-content">

				                    <div class="tab-pane fade show active" id="highlighted-justified-tab1">
				                        <?php
				                            include 'tabs/kassa_1.php';
				                        ?>
				                    </div>

				                    <div class="tab-pane fade" id="highlighted-justified-tab2">
				                        <?php
				                            include 'tabs/kassa_2.php';
				                        ?>
				                    </div>

				                    <div class="tab-pane fade" id="highlighted-justified-tab3">
				                        <?php
				                            include 'tabs/kassa_3.php';
				                        ?>
				                    </div>

				                    <div class="tab-pane fade" id="highlighted-justified-tab4">
				                        <?php
				                            include 'tabs/kassa_4.php';
				                        ?>
				                    </div>

				                </div>
				            </div>

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

				<?php UserCheckOutpatientModel::form(); ?>

			</div>
		</div>
	</div>


	<div id="modal_default2" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Возврат</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width:20%;">Дата и время</th>
								<th>Мед услуги</th>
								<th>Сумма</th>
								<th>Статус</th>
								<th>Действия</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>02.05.2021 14:30</td>
								<td>Осмотр терапевта</td>
								<td>50000</td>
								<td>Проведен/Пластик</td>
								<td><button type="button" class="btn btn-sm btn-danger legitRipple" data-toggle="button">Отменить</button></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn bg-primary">Печать чека</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /basic modal -->


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
						});
						$('#message_ses').html(result.message);
					}
				},
			});
		};

		function CheckAmb(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#check-amb').html(result);
				},
			});
		};
		function CheckSt(events, pk) {
			$.ajax({
				type: "GET",
				url: events+"&mod=st",
				success: function (result) {
					$('#check-st').html(result);
					$('#user_st_id').val(pk);
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

		$("#search_tab-4").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					tab: 4,
                    search: $("#search_tab-4").val(),
                },
				success: function (result) {
					$('#displ_tab-4').html(result);
				},
			});
		});
	</script>

</body>
</html>
