<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "История платежей ". addZero($_GET['pk']);
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
						<h6 class="card-title"><?= get_full_name($_GET['pk']) ?></h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<!-- <a href="#" type="button" class="btn btn-outline-info btn-sm legitRipple">PDF</button> -->
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>№</th>
                                        <th>Дата  платежа</th>
										<th>Услуга/Медикоменты</th>
										<th>Наличные</th>
                                        <th>Пластик</th>
                                        <th>Перечисление</th>
                                        <th>Скидка</th>
										<th>Кассир</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // prit($db->query("SELECT vsp.* FROM visit_price vsp LEFT JOIN visit vs ON(vs.id=vsp.visit_id) WHERE vs.user_id = {$_GET['pk']} AND vsp.price_date IS NOT NULL ORDER BY price_date DESC")->fetchAll());
                                    $i = 1;
									foreach($db->query("SELECT vsp.* FROM visit_price vsp LEFT JOIN visit vs ON(vs.id=vsp.visit_id) WHERE vs.user_id = {$_GET['pk']} AND vsp.price_date IS NOT NULL ORDER BY price_date DESC") as $row) {
										if (empty($temp_old)) {
											$temp_old = $row['price_date'];
											$color = "";
										}else {
											if ($temp_old != $row['price_date']) {
												if ($color) {
													$color = "";
												}else {
													$color = "table-secondary";
												}
											}
											$temp_old = $row['price_date'];
										}
										?>
                                        <tr class="<?= $color ?>">
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d.m.Y H:i', strtotime($row['price_date'])) ?></td>
                                            <td><?= $row['item_name'] ?></td>
                                            <td><?= $row['price_cash'] ?></td>
                                            <td><?= $row['price_card'] ?></td>
                                            <td><?= $row['price_transfer'] ?></td>
											<td><?= ($row['sale']) ? $row['sale'] : '<span class="text-muted">Нет данных</span>' ?></td>
											<td><?= get_full_name($row['pricer_id']) ?></td>
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
