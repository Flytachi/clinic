<?php
require_once '../../tools/warframe.php';
is_auth(6);
$header = "Текущие задачи";
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
						<h6 class="card-title">Текущие задачи</h6>
					</div>

					<div class="card-body">

						<?php
			            if($_SESSION['message']){
			                echo $_SESSION['message'];
			                unset($_SESSION['message']);
			            }
			            ?>

						<div class="table-responsive">
                            <table class="table table-hover">

                                <tbody>
                                    <?php
									$sql = "SELECT DISTINCT us.id, vs.route_id,
											(
												(YEAR(CURRENT_DATE) - YEAR(us.dateBith)) -
												(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(us.dateBith, '%m%d'))
											) 'age'
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.laboratory IS NOT NULL ORDER BY vs.accept_date DESC";
                                    foreach($db->query($sql) as $row) {
                                        ?>
                                        <tr>
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
											<td><?= $row['age'] ?></td>
                                            <td>
												<?php
												$item_vs = [];
                                                foreach ($db->query("SELECT sc.name, vs.id, vs.laboratory_num FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$row['id']} AND vs.parent_id = vs.laboratory IS NOT NULL AND accept_date IS NOT NULL AND completed IS NULL") as $serv) {
                                                    echo $serv['name']."<br>";
													$item_vs[] = $serv['id'];
													$item_laboratory_num = $serv['laboratory_num'];
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
													<a onclick="PrintLab('<?= viv('prints/labrotoria_label') ?>?id=<?= $row['id'] ?>&num=<?= $item_laboratory_num ?>')" class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
													<a onclick="UpNumber(<?= json_encode($item_vs) ?>, <?= $item_laboratory_num ?>)" class="dropdown-item"><strong class="mr-3"><?= ($item_laboratory_num) ? $item_laboratory_num : "-" ?></strong> Номер</a>
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
