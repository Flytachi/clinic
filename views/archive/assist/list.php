<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Завершёный пациенты";

$tb = new Table($db, "patients p");
$tb->set_data("DISTINCT p.id, p.dateBith, p.numberPhone, p.add_date");
$search = $tb->get_serch();

$search_array = array(
	"vs.completed IS NOT NULL AND vs.assist_id = $session->session_id", 
	"vs.completed IS NOT NULL AND vs.assist_id = $session->session_id AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->additions("LEFT JOIN visit vs ON(p.id=vs.patient_id)")->where_or_serch($search_array)->order_by("p.id DESC")->set_limit(20);
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
						<h6 class="card-title">Завершёный пациенты</h6>
						<div class="header-elements">
							<form action="" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="form-control border-info" value="<?= $search ?>" id="search_input" placeholder="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
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

									<?php foreach ($tb->get_table() as $row): ?>
										<tr>
                                            <td><?= addZero($row->id) ?></td>
                                            <td><div class="font-weight-semibold"><?= patient_name($row->id) ?></div></td>
                                            <td><?= date_f($row->dateBith) ?></td>
                                            <td><?= $row->numberPhone ?></td>
                                            <td><?= date_f($row->add_date, 1) ?></td>
                                            <td class="text-center">
												<a href="<?= viv('archive/assist/list_visit') ?>?id=<?= $row->id ?>" type="button" class="<?= $classes['btn_detail'] ?>">Визиты</button>
                                            </td>
                                        </tr>
									<?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

						<?php $tb->get_panel(); ?>

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
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= viv('archive/assist/search') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
