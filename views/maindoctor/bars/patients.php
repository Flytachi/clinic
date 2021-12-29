<!-- Информация о пациентах -->
<div class="mb-3">
	<div class="header-elements-sm-inline">
		<span class="mb-0 text-muted d-block">Пациенты</span>
		<h4 class="font-weight-semibold d-block">Информация о пациентах</h4>
		<span class="mb-0 text-muted d-block">Сегодня</span>
	</div>
</div>

<div class="row">

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= $db->query("SELECT * FROM users WHERE DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Новые пациенты</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users2 icon-3x text-success-400"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visits v LEFT JOIN visit_services vs ON(v.user_id=vs.user_id) LEFT JOIN users us ON(us.id=vs.user_id) WHERE v.direction IS NULL AND DATE_FORMAT(vs.add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Посещаемость (Амбулатор)</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users4 icon-3x text-blue-400"></i>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= $db->query("SELECT * FROM visits WHERE direction IS NOT NULL AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Посещаемость (Стационар)</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users4 icon-3x text-danger-400"></i>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /Информация о пациентах -->