<?php
require_once '../../tools/warframe.php';
is_auth();
$header = "Пациент";
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

				<?php include "profile.php"; ?>

                <div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

					<div class="card-body">

					   <?php include "content_tabs.php"; ?>

					   <div class="card">

						   <div class="card-header header-elements-inline">
							   <h5 class="card-title">Услуги анестезиолога</h5>
							   <?php if ($activity): ?>
								   <?php if ($patient->direction): ?>
									   <div class="header-elements">
										   <div class="list-icons">
											   <a class="list-icons-item <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_route">
												   <i class="icon-plus22"></i>Добавить
											   </a>
										   </div>
									   </div>
								   <?php endif; ?>
							   <?php endif; ?>
						   </div>

						   <div class="table-responsive">
							   <table class="table table-hover table-sm">
								   <thead>
									   <tr class="bg-info">
										   <th style="width; 50px;">№</th>
										   <th>Специалист</th>
										   <th>Мед услуга</th>
										   <th>Дата</th>
										   <th class="text-right">Цена</th>
									   </tr>
								   </thead>
								   <tbody>
									   <?php
									   $i = 1;
									   if ($patient->completed) {
										   $sql_table = "SELECT vs.id, vs.parent_id, vs.completed, vp.item_name, vp.item_cost
														   FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
														   WHERE vs.user_id = $patient->id AND vs.anesthesia IS NOT NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i') BETWEEN \"$patient->add_date\" AND \"$patient->completed\") ORDER BY vs.id DESC";
									   } else {
										   $sql_table = "SELECT vs.id, vs.parent_id, vs.completed, vp.item_name, vp.item_cost
														   FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
														   WHERE vs.user_id = $patient->id AND vs.anesthesia IS NOT NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i') BETWEEN \"$patient->add_date\" AND \"CURRENT_DATE()\") ORDER BY vs.id DESC";
									   }
									   foreach ($db->query($sql_table) as $row) {
									   ?>
										   <tr id="TR_<?= $row['id'] ?>">
											   <td><?= $i++ ?></td>
											   <td><?= get_full_name($row['parent_id']) ?></td>
											   <td><?= $row['item_name'] ?></td>
											   <td><?= ($row['completed']) ? date('d.m.Y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
										  	   <td class="text-right"><?= number_format($row['item_cost'], 1) ?></td>
										   </tr>
									   <?php
									   }
									   ?>
								   </tbody>
							   </table>
						   </div>

					   </div>

				   </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <?php if ($activity): ?>
		<div id="modal_route" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Назначить услугу</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">

						<?php VisitAnestForm::form(); ?>

					</div>
				</div>
			</div>
		</div>
    <?php endif; ?>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
