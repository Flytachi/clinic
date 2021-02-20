<?php
require_once '../../tools/warframe.php';
is_auth(4);
$header = "Заявки";
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

				<?php
				if($_SESSION['message']){
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				}
				?>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h5 class="card-title">Список Пациентов</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
				            <table class="table table-hover table-sm">
				                <thead>
				                    <tr class="bg-blue">
				                        <th>ID</th>
				                        <th>ФИО</th>
				                        <th>Отдел</th>
                                        <th>Лечащий врач</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    <?php foreach ($db->query("SELECT DISTINCT user_id, parent_id FROM storage_orders WHERE date = CURRENT_DATE() AND user_id IS NOT NULL") as $row): ?>
                                        <tr onclick="Check('<?= viv('pharmacy/application_preparat') ?>?pk=<?= $row['user_id'] ?>')">
                                            <td><?= addZero($row['user_id']) ?></td>
                                            <td><?= get_full_name($row['user_id']) ?></td>
                                            <td><?= division_title($row['parent_id']) ?></td>
                                            <td><?= get_full_name($row['parent_id']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
				                </tbody>
				            </table>
				        </div>

					</div>

				</div>

                <div id="user_preparat_div"></div>

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
					$('#user_preparat_div').html(result);
				},
			});
        }

		function CallMed(id){
			if (id) {
				let obj = JSON.stringify({ type : 'alert_pharmacy_call',  id : id, message: "Забрать препараты для пациентов!" });
				conn.send(obj);
			}
		}

    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
