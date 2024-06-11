<?php
require '../../../tools/warframe.php';
$session->is_auth();
importModel('VisitService');

$tb = new VisitService('vs');
$tb->Data("vs.id, vs.patient_id, p.last_name, p.first_name, p.father_name, p.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.parent_id, vr.name 'status_name'");
$tb->JoinLEFT("visits v", "v.id=vs.visit_id");
$tb->JoinLEFT("visit_status vr", "v.id = vr.visit_id");
$tb->JoinLEFT("patients p", "p.id=vs.patient_id");
if ($search = $tb->getSearch()) {
	$tb->Where("vs.status = 2 AND vs.level = 5 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id = $session->session_division) ) AND (p.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', p.last_name, p.first_name, p.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )");
} else {
	$tb->Where("vs.status = 2 AND vs.level = 5 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id = $session->session_division) )");
}
$tb->Order('vs.id ASC')->Limit(10);
?>
<div class="table-responsive">
	<table class="table table-hover table-sm">
		<thead class="<?= $classes['table-thead'] ?>">
			<tr>
				<th>ID</th>
				<th>ФИО</th>
				<th>Дата рождения</th>
				<th>Дата назначения</th>
				<th>Мед услуга</th>
				<th>Направитель</th>
				<th>Тип визита</th>
				<th class="text-right" style="width:210px">Действия</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($tb->list() as $row): ?>
				<tr id="VisitService_tr_<?= $row->id ?>">
					<td><?= addZero($row->patient_id) ?></td>
					<td>
						<span class="font-weight-semibold"><?= patient_name($row) ?></span>
						<?php if ( $row->status_name ): ?>
							<span style="font-size:13px;" class="badge badge-flat border-danger text-danger"><?= $row->status_name ?></span>
						<?php endif; ?>
						<div class="text-muted">
							<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE patient_id = $row->patient_id")->fetch()): ?>
								<?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
							<?php endif; ?>
						</div>
					</td>
					<td><?= date_f($row->birth_date) ?></td>
					<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
					<td><?= $row->service_name ?></td>
					<td>
						<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
						<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
					</td>
					<td class="text-center">
						<?php if($row->direction): ?>
							<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
						<?php else: ?>
							<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
						<?php endif; ?>
					</td>
					<td class="text-center">
						<button onclick="VisitUpStatus(<?= $row->id ?>)" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
						<?php if($session->session_id == $row->parent_id): ?>
							<button onclick="FailureVisitService('<?= del_url($row->id, 'VisitFailure') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php $tb->panel(); ?>