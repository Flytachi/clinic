<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Завершёный пациенты";
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
						<h6 class="card-title">Завершёный пациенты</h6>
						<div class="header-elements">
							<form action="#" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Номер телефона</th>
                                        <th>Дата регистрации </th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody id="search_display">
                                    <?php
									$i = 1;
									$count_elem = 20;
									$count = ceil(intval($db->query("SELECT COUNT(DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date) FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']}")->fetchColumn()) / $count_elem);
									$_GET['of'] = isset($_GET['of']) ? $_GET['of'] : 0;
									$offset = intval($_GET['of']) * $count_elem;

									foreach($db->query("SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NOT NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY us.id DESC LIMIT $count_elem OFFSET $offset") as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
                                            <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td><?= $row['numberPhone'] ?></td>
											<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                            <td class="text-center">
												<a href="<?= viv('archive/completed/list_visit') ?>?id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

						<?php pagination_page($count, $count_elem, 2); ?>

					</div>

				</div>


			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">
		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					search: $("#search_input").val(),
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
