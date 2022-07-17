<?php
require '../../../tools/warframe.php';
$session->is_auth();
importModel('VisitService');

$tb = new VisitService('vs');
$tb->Data("v.id, vs.patient_id, p.birth_date, p.last_name, p.first_name, p.father_name, vs.route_id, vr.name 'status_name'");
$tb->JoinLEFT("visits v", "v.id=vs.visit_id");
$tb->JoinLEFT("visit_status vr", "v.id = vr.visit_id");
$tb->JoinLEFT("patients p", "p.id=vs.patient_id");
if ($search = $tb->getSearch()) {
	$tb->Where("vs.status = 3 AND vs.level = 5 AND v.direction IS NULL AND vs.parent_id = $session->session_id AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%'))");
} else {
	$tb->Where("vs.status = 3 AND vs.level = 5 AND v.direction IS NULL AND vs.parent_id = $session->session_id");
}
$tb->Group('v.id')->Order('vs.accept_date DESC')->Limit(10);
?>
<div class="table-responsive">
	<table class="table table-hover table-sm">
		<thead class="<?= $classes['table-thead'] ?>">
			<tr>
				<th>ID</th>
				<th>ФИО</th>
				<th>Дата рождения</th>
				<th>Мед услуга</th>
				<th>Направитель</th>
				<th class="text-right" style="width:210px">Действия</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($tb->list() as $row): ?>
				<tr>
					<td><?= addZero($row->patient_id) ?></td>
					<td>
						<span class="font-weight-semibold"><?= patient_name($row) ?></span>
						<?php if ( $row->status_name ): ?>
							<span style="font-size:13px;" class="badge badge-flat border-danger text-danger"><?= $row->status_name ?></span>
						<?php endif; ?>
					</td>
					<td><?= date_f($row->birth_date) ?></td>
					<td>
						<?php foreach($db->query("SELECT vs.service_name, st.day, vs.accept_date FROM visit_services vs LEFT JOIN service_terms st ON(vs.service_id=st.service_id) WHERE vs.visit_id = $row->id AND vs.status = 3 AND vs.parent_id = $session->session_id AND vs.level = 5") as $serv): ?>
							<?php
								if($serv['day']) {
									if (date_diff(new DateTime('now'), new DateTime($serv['accept_date']))->days >= $serv['day']) {
										$color = 'success';
									}else $color = 'danger';
									echo "<span class=\"badge badge-$color mr-1\">{$serv['day']} day</span>"; 
								}
							?>
							<span><?= $serv['service_name'] ?></span><br>
						<?php endforeach; ?>
					</td>
					<td>
						<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
						<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
					</td>
					<td class="text-center">
						<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
						<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
							<a href="<?= viv('card/content-1') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-repo-forked"></i>Осмотр Врача</a>
							<a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-add"></i>Назначенные услуги</a>
							<?php if(module('module_laboratory')): ?>
								<a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
							<?php endif; ?>
							<?php if(module('module_diagnostic')): ?>
								<a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>&activity=1" class="dropdown-item"><i class="icon-pulse2"></i>Диагностика</a>
							<?php endif; ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php $tb->panel(); ?>