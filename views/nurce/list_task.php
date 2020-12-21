<?php
require_once '../../tools/warframe.php';
is_auth(7);
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

                <div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h5 class="card-title">Задачи на сегодня</h5>
					</div>

					<div class="card-body row">

						<div class="col-md-6">

                            <div class="table-responsive card">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>ID</th>
                                            <th>ФИО</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($db->query("SELECT DISTINCT b.user_id FROM bypass_date bd LEFT JOIN bypass b ON(b.id=bd.bypass_id) WHERE bd.date = CURRENT_DATE() AND bd.completed IS NULL") as $row): ?>
                                            <tr onclick="Check('<?= viv('nurce/task') ?>?pk=<?= $row['user_id'] ?>')">
                                                <td><?= addZero($row['user_id']) ?></td>
                                                <td><?= get_full_name($row['user_id']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col-md-6" id="check_div">

                        </div>

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
    </script>

	<!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
