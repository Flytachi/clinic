<?php
require_once '../../tools/warframe.php';
is_auth(7);
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

                <div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h5 class="card-title">Задачи на сегодня</h5>
					</div>

					<div class="card-body row">

						<div class="col-md-6">

							<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
								<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/list_task') ?>?type=0')" href="#" class="nav-link legitRipple active show" data-toggle="tab">Не завершёные</a></li>
								<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/list_task') ?>?type=1')" href="#" class="nav-link legitRipple" data-toggle="tab">Завершёные</a></li>
							</ul>

							<div id="tab_div">

								<div class="table-responsive card">
							        <table class="table table-hover table-sm">
							            <thead>
							                <tr class="bg-info">
							                    <th style="width:50px;">№</th>
							                    <th>ID</th>
							                    <th>ФИО</th>
							                </tr>
							            </thead>
							            <tbody>
							                <?php $i=1;foreach ($db->query("SELECT DISTINCT b.user_id FROM bypass_date bd LEFT JOIN bypass b ON(b.id=bd.bypass_id) WHERE bd.date = CURRENT_DATE() AND status IS NOT NULL AND bd.completed IS NULL") as $row): ?>
							                    <tr onclick="Check('<?= viv('nurce/task') ?>?pk=<?= $row['user_id'] ?>')">
							                        <td><?= $i++ ?></td>
							                        <td><?= addZero($row['user_id']) ?></td>
							                        <td><?= get_full_name($row['user_id']) ?></td>
							                    </tr>
							                <?php endforeach; ?>
							            </tbody>
							        </table>
							    </div>

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
				},
			});
        }
    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
