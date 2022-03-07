<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "История платежей";

$tb = new Table($db, "visit_service_transactions vt");
$tb->set_data('DISTINCT vt.patient_id, p.last_name, p.first_name, p.father_name')->additions('LEFT JOIN patients p ON(p.id=vt.patient_id)');
$search = $tb->get_serch();
$search_array = array(
	"vt.is_visibility IS NOT NULL", 
	"vt.is_visibility IS NOT NULL AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->order_by('vt.add_date DESC')->set_limit(20);
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
                        <h5 class="card-title">История платежей</h5>
                        <div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
						</div>
                    </div>
					<div class="card-body" id="search_display">

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="<?= $classes['table-thead'] ?>">
                                    <tr>
                                        <th>ID</th>
										<th>ФИО</th>
                                        <th class="text-right" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tb->get_table() as $row): ?>
                                        <tr>
                                            <td><?= addZero($row->patient_id) ?></td>
                                            <td><div class="font-weight-semibold"><?= patient_name($row) ?></div></td>
                                            <td class="text-right">
                                                <a href="<?= viv('cashbox/detail_payment') ?>?pk=<?= $row->patient_id ?>" class="<?= $classes['btn-viewing'] ?>">Детально</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
				url: "<?= ajax('search/cashbox-list_payment') ?>",
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
