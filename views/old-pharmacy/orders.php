<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('module_pharmacy');
$header = "Заказы";
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
				if( isset($_SESSION['message']) ){
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				}
				?>

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Список заказов</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
				            <table class="table table-hover table-sm">
				                <thead class="<?= $classes['table-thead'] ?>">
				                    <tr>
                                        <th>№</th>
                                        <th>ФИО</th>
				                        <th>Роль</th>
                                        <th>Отдел</th>
				                    </tr>
				                </thead>
				                <tbody>
                                    <?php $i=1; foreach ($db->query("SELECT DISTINCT parent_id FROM storage_orders WHERE date = CURRENT_DATE() AND user_id IS NULL") as $row): ?>
                                        <tr onclick="Check('<?= viv('pharmacy/orders_preparat') ?>?pk=<?= $row['parent_id'] ?>')">
                                            <td><?= $i++ ?></td>
                                            <td><?= get_full_name($row['parent_id']) ?></td>
                                            <td><?= level_name($row['parent_id']) ?></td>
                                            <td><?= division_title($row['parent_id']) ?></td>
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
				let obj = JSON.stringify({ type : 'alert_pharmacy_call',  id : id, message: "Забрать препараты!" });
				conn.send(obj);
			}
		}

    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
