<?php
require_once '../../tools/warframe.php';
$session->is_auth(7);
$header = "Рабочий стол";
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

				<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
					<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/floor') ?>?type=1')" href="#" class="nav-link legitRipple" data-toggle="tab">1 Этаж</a></li>
					<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/floor') ?>?type=2')" href="#" class="nav-link legitRipple active show" data-toggle="tab">2 Этаж</a></li>
					<li class="nav-item"><a onclick="Tabs('<?= viv('nurce/floor') ?>?type=3')" href="#" class="nav-link legitRipple" data-toggle="tab">3 Этаж</a></li>
				</ul>

				<div id="tab_div">

					<div class="card border-1 border-info">

					    <div class="card-header text-dark header-elements-inline alpha-info">
					        <h6 class="card-title">2 Этаж</h6>
					        <div class="header-elements">
					            <div class="list-icons">
					                <a class="list-icons-item" data-action="collapse"></a>
					            </div>
					        </div>
					    </div>

					    <div class="card-body">

					        <div class="table-responsive">
					            <table class="table table-hover table-sm">
					                <thead class="bg-info">
					                    <tr>
					                        <th>ID</th>
					                        <th>ФИО</th>
					                        <th>Возрвст</th>
					                        <th>Дата размещения</th>
					                        <th>Дата выписки</th>
					                        <th>Лечущий врач</th>
					                        <th class="text-center" style="width:210px">Действия</th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <?php
					                    foreach($db->query("SELECT vs.id, wd.ward, bd.bed, bd.types, vs.user_id, vs.grant_id, vs.add_date, vs.discharge_date, us.dateBith FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) LEFT JOIN visit vs ON (vs.user_id=bd.user_id) LEFT JOIN users us ON (us.id=bd.user_id) WHERE bd.user_id IS NOT NULL AND wd.floor = 2 AND vs.accept_date IS NOT NULL AND vs.completed IS NULL AND vs.grant_id = vs.parent_id") as $row) {
					                        ?>
					                        <tr>
					                            <td><?= addZero($row['user_id']) ?></td>
					                            <td>
					                                <div class="font-weight-semibold"><?= get_full_name($row['user_id']) ?></div>
					                                <div class="text-muted"><?= $row['ward']." палата ".$row['bed']." койка"?></div>
					                            </td>
					                            <td><?= date_diff(new \DateTime(), new \DateTime($row['dateBith']))->y ?></td>
					                            <td><?= date('d.m.Y', strtotime($row['add_date'])) ?></td>
					                            <td><?= ($row['discharge_date']) ? date('d.m.Y', strtotime($row['discharge_date'])) : "Не назначено" ?></td>
					                            <td>
					                                <?= level_name($row['grant_id']) ." ". division_name($row['grant_id']) ?>
					                                <div class="text-muted"><?= get_full_name($row['grant_id']) ?></div>
					                            </td>
					                            <td class="text-center">
					                                <button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
					                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
					                                    <a href="<?= viv('card/content_1') ?>?id=<?= $row['user_id'] ?>" class="dropdown-item"><i class="icon-repo-forked"></i>Обход</a>
														<?php if(module('module_laboratory')): ?>
															<a href="<?= viv('card/content_5') ?>?id=<?= $row['user_id'] ?>" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
															<a onclick="PrintLab('<?= viv('prints/labrotoria_label') ?>?id=<?= $row['user_id'] ?>')" class="dropdown-item"><i class="icon-printer2"></i> Печать пробирки</a>
														<?php endif; ?>
					                                    <a href="<?= viv('card/content_7') ?>?id=<?= $row['user_id'] ?>" class="dropdown-item"><i class="icon-magazine"></i>Лист назначений</a>
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

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">
		function Tabs(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#tab_div').html(result);
				},
			});
		}

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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
