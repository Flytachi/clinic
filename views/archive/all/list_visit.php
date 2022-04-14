<?php

use Mixin\Hell;

require_once '../../../tools/warframe.php';
$session->is_auth();

if (is_numeric($_GET['id'])) {
	$header = "Пациент ".addZero($_GET['id']);
	importModel('Patient');
	$patient = (new Patient)->byId($_GET['id']);
	if(!$patient) Hell::error('404');
} else Hell::error('404');
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

                <?php include "../profile.php" ?>

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Визиты</h6>
						<div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>№</th>
			                            <th>Дополнения</th>
										<th style="width: 11%">Дата визита</th>
										<th style="width: 11%">Дата завершения</th>
										<th>Тип визита</th>
										<th>Статус</th>
                                        <th class="text-right" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									$tb = new Table($db, "visits v");
									$tb->set_data("v.id, v.parad_id, v.icd_id, v.icd_autor, vr.name 'status_name', v.add_date, v.completed, v.direction")->additions("LEFT JOIN visit_status vr ON (v.id = vr.visit_id)");
									$search = $tb->get_serch();
									$search_array = array(
										"v.patient_id = $patient->id", 
										"v.patient_id = $patient->id"
									);
									$tb->where_or_serch($search_array)->order_by('v.add_date DESC')->set_limit(20);
									?>
									<?php foreach($tb->get_table(1) as $row): ?>
										<tr>
                                            <td><?= $row->count ?></td>
                                            <td>
												<?php if ( $row->parad_id ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-indigo text-indigo">Иcтория болезни №<?= $row->parad_id ?></span>
												<?php endif; ?>
												<?php if ( $row->icd_id ): ?>
													<?php $icd = icd($row->icd_id) ?>
													<span class="badge badge-flat border-pink text-pink" data-trigger="hover" data-popup="popover" data-html="true" data-placement="right" title="" 
														data-original-title="<div class='d-flex justify-content-between'><?= $icd['code'] ?><span class='font-size-sm text-muted'><?= get_full_name($row->icd_autor) ?></span></div>"
														data-content="<?= $icd['decryption'] ?>" style="font-size:15px;">
														ICD <?= $icd['code'] ?>
													</span>
												<?php endif; ?>
												<?php if ( $row->status_name ): ?>
													<span style="font-size:13px;" class="badge badge-flat border-danger text-danger"><?= $row->status_name ?></span>
												<?php endif; ?>
											</td>
                                            <td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td><?= ($row->completed) ? date_f($row->completed, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td>
												<?php if ($row->direction): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Стационарный</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($row->completed): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Не завершён</span>
												<?php endif; ?>
											</td>
											<td class="text-right">
												<?php if(permission([5])): ?>
													<?php if ($row->direction): ?>
														<a href="<?= viv('card/content-2') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php else: ?>
														<a href="<?= viv('card/content-6') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php endif; ?>
												<?php elseif(permission([2,32])): ?>
													<?php if ($row->direction): ?>
														<a href="<?= viv('card/content-2') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php else: ?>
														<a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php endif; ?>
												<?php elseif(permission(6)): ?>
													<a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
												<?php elseif(permission(10)): ?>
													<a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
												<?php elseif(permission(12)): ?>
													<a href="<?= viv('card/content-10') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
												<?php else: ?>
													<a href="<?= viv('card/content-4') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
												<?php endif; ?>
											</td>
                                        </tr>
									<?php endforeach; ?>
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
