<?php
require_once '../../tools/warframe.php';
is_auth(6);
is_module('module_laboratory');
$header = "Амбулаторные пациенты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("global_assets/js/demo_pages/content_cards_header.js") ?>"></script>

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
						<h6 class="card-title">Амбулаторные пациенты</h6>
					</div>

					<div class="card-body">

						<?php
			            if($_SESSION['message']){
			                echo $_SESSION['message'];
			                unset($_SESSION['message']);
			            }
			            ?>

						<div class="table-responsive">
                            <table class="table table-hover table-sm datatable-basic">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$sql = "SELECT DISTINCT us.id, vs.route_id, us.dateBith
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.laboratory IS NOT NULL AND vs.accept_date IS NOT NULL ORDER BY vs.accept_date DESC";
                                    foreach($db->query($sql) as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td>
												<?php
                                                foreach ($db->query("SELECT sc.name FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$row['id']} AND vs.laboratory IS NOT NULL AND vs.accept_date IS NOT NULL AND vs.completed IS NULL") as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
                                                ?>
                                            </td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i>Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a onclick="PrintLab('<?= viv('prints/labrotoria_label') ?>?id=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
                                                    <a onclick="ResultShow('<?= viv('laboratory/result') ?>?id=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-users4"></i> Добавить результ</a>
                                                </div>
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
		<div class="modal-dialog modal-full">
			<div class="modal-content border-3 border-info" id="modal_result_show_content">

			</div>
		</div>
	</div>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">

		function ResultShow(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_result_show').modal('show');
					$('#modal_result_show_content').html(result);
				},
			});
		};

		function PrintLab(url) {
			if ("<?= $_SESSION['browser'] ?>" == "Firefox") {
				$.ajax({
					type: "GET",
					url: url,
					success: function (data) {
						let ww = window.open();
						ww.document.write(data);
						ww.focus();
						ww.print();
						ww.close();
					},
				});
			}else {
				let we = window.open(url,'mywindow');
				setTimeout(function() {we.close()}, 100);
			}
		}

	</script>

</body>
</html>
