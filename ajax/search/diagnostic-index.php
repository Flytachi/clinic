<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_services vs");
$tb->set_data("vs.id, vs.user_id, us.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.parent_id")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id = $session->session_division) )", 
	"vs.status = 2 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id = $session->session_division) ) AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($search_array)->order_by('vs.id ASC')->set_limit(20);
$tb->set_self(viv('diagnostic/index'));  
?>
<div class="table-responsive">
	<table class="table table-hover table-sm">
		<thead>
			<tr class="<?= $classes['table-thead'] ?>">
				<th>ID</th>
				<th>ФИО</th>
				<th>Дата рождения</th>
				<th>Дата назначения</th>
				<th>Мед услуга</th>
				<th>Направитель</th>
				<th>Тип визита</th>
				<th class="text-center" style="width:210px">Действия</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($tb->get_table() as $row): ?>
				<tr id="VisitService_tr_<?= $row->id ?>">
					<td><?= addZero($row->user_id) ?></td>
					<td>
						<div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
						<div class="text-muted">
							<?php
							// if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
							// 	echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
							// }
							?>
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
						<!-- <a href="<?= up_url($row->id, 'VisitUpStatus') ?>&user_id=<?= $row->user_id ?>" type="button" class="btn btn-outline-success btn-sm legitRipple" data-chatid="<?= $row->user_id ?>" data-userid="<?= $row->user_id ?>" data-parentid="<?= $row->parent_id ?>"
							<?php if (!$row->direction): ?>
								onclick="sendPatient(this)"
							<?php endif; ?>
							>Принять</a> -->

						<button onclick="VisitUpStatus(<?= $row->id ?>)" href="<?php //up_url($row->id, 'VisitUpStatus') ?>" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
						<?php if($session->session_id == $row->parent_id): ?>
							<button onclick="FailureVisitService('<?= del_url($row->id, 'VisitFailure') ?>')" data-toggle="modal" data-target="#modal_failure" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php $tb->get_panel(); ?>