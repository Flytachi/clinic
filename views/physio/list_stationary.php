<?php
require_once '../../tools/warframe.php';
$session->is_auth(12);
$header = "Стационарные пациенты";
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
						<h6 class="card-title">Стационарные пациенты</h6>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm datatable-basic">
                                <thead class="<?= $classes['table-thead'] ?>">
                                    <tr>
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата назначения</th>
										<th>Дата рождения</th>
										<th>Мед услуга</th>
                                        <th class="text-center" style="width:300px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$sql = "SELECT DISTINCT us.id, us.dateBith, vs.add_date
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.direction IS NOT NULL AND vs.physio IS NOT NULL AND vs.add_date IS NOT NULL ORDER BY vs.add_date ASC";

                                    foreach($db->query($sql) as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
											<td><?= date('d.m.Y', strtotime($row['add_date'])) ?></td>
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td>
												<?php
												foreach ($db->query("SELECT DISTINCT sc.name FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$row['id']} AND vs.physio IS NOT NULL AND vs.completed IS NULL") as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
												?>
											</td>
                                            <td class="text-center">
												<button onclick="MListVisit(<?= $row['id'] ?>)" class="btn btn-outline-primary btn-sm">Детально</button>
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
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_result_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="modal_result_show_content">

			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php include layout('footer') ?>
	<!-- /footer -->

	<script type="text/javascript">

		function ListVisit(events, type = null){
			$.ajax({
				type: "GET",
				url: "<?= ajax('physio_table_visit') ?>",
				data: {
					user_id: events,
					type: type,
				},
				success: function (result) {
					$('#modal_result_show_content').html(result);
				},
			});
		}

		function MListVisit(events, type = null) {
			$('#modal_result_show').modal('show');
			ListVisit(events, type);
		};

		function Complt(url, ev) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (data) {
					console.log(data);
                    ListVisit(ev);
				},
			});
        };

		function Delete(url, ev) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (data) {
                    ListVisit(ev);
				},
			});
        };

	</script>
</body>
</html>
