<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Все пациенты";
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
						<h6 class="card-title">Все пациенты</h6>
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

					<div class="card-body" id="search_display">

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>ID</th>
                                        <th>ФИО</th>
                                        <th>Дата рождения</th>
                                        <th>Номер телефона</th>
                                        <th>Дата регистрации </th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									$table = new Table($db, "users us");
									$table->set_data("id, dateBith, numberPhone, add_date");
									$table->where("user_level = 15");
									$table->order_by("id DESC");
									$table->set_limit(20);
									?>
									<?php foreach ($table->get_table() as $row): ?>
										<tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
                                            <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td><?= $row['numberPhone'] ?></td>
											<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                            <td class="text-center">
												<a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
                                            </td>
                                        </tr>
									<?php endforeach;?>
                                </tbody>
                            </table>
							
                        </div>

						<?php $table->get_panel(); ?>

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
