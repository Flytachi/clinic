<?php
require_once '../../tools/warframe.php';
is_auth(6);
$header = "Амбулаторные пациенты";
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
						<h6 class="card-title">Амбулаторные пациенты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Мед услуга</th>
										<th>Дата принятия</th>
                                        <th>Направитель</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($db->query("SELECT vs.id, vs.user_id, us.dateBith, vs.route_id, vs.direction, vs.accept_date FROM visit vs LEFT JOIN users us ON (vs.user_id = us.id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC") as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['user_id']) ?></td>
                                            <td><?= get_full_name($row['user_id']) ?></td>
                                            <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td>
                                                <?php
												$serv = $db->query("SELECT sr.name, sr.id FROM visit_service vsr LEFT JOIN service sr ON (vsr.service_id = sr.id) WHERE vsr.visit_id = {$row['id']}")->fetch();
												echo $serv['name'];
                                                ?>
                                            </td>
											<td><?= date('d.m.Y H:i', strtotime($row['accept_date'])) ?></td>
                                            <td><?= get_full_name($row['route_id']) ?></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-primary btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a href="<?= viv('laboratory/print') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-repo-forked"></i> Печать</a>
                                                    <a onclick="ResultShow('<?= viv('laboratory/result') ?>?id=<?= $row['id'] ?>&user_id=<?= $row['user_id'] ?>')" class="dropdown-item"><i class="icon-users4"></i> Добавить результ</a>
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
    <?php include '../layout/footer.php' ?>
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

	</script>

</body>
</html>
