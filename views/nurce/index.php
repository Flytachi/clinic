<?php
require_once '../../tools/warframe.php';
$session->is_auth(25);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

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

                <div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Задачи на сегодня</h5>
					</div>

					<div class="card-body row">

						<div class="col-md-6">

							<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
								<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/list_task') ?>?type=1')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Услуги</a></li>
								<?php if(module('pharmacy')): ?>
									<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/list_task') ?>?type=2')" href="#" class="nav-link legitRipple" data-toggle="tab">Назначения</a></li>
									<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/list_task') ?>?type=3')" href="#" class="nav-link legitRipple" data-toggle="tab">Назначения (завершёные)</a></li>
								<?php endif; ?>
							</ul>

							<div id="tab_div">

								<script type="text/javascript">
									$(document).ready(function(){
										Tabs('<?= viv('nurce/list_task') ?>?type=1')
									});
    							</script>

							</div>


                        </div>

                        <div class="col-md-6" id="check_div"></div>

					</div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script type="text/javascript">
        function Check(events) {
            $.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#check_div').html(result);
				},
			});
        }

		function Tabs(events) {
            $.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#tab_div').html(result);
					$('#check_div').html('');
				},
			});
        }
    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
