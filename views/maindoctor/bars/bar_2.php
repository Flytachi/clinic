<!-- Информация о пациентах -->
<div class="mb-3">
	<h4 class="mb-0 font-weight-semibold">Пациенты</h4>
	<span class="text-muted d-block">Информация о пациентах</span>
</div>

<div class="row">

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?php
						// prit($db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() AND DATE_FORMAT(us.add_date, '%Y-%m-%d') = CURRENT_DATE()")->fetchAll());
						?>
						<?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Общие пациенты</span>
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
						<?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() AND DATE_FORMAT(us.add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
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
						<?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() AND DATE_FORMAT(us.add_date, '%Y-%m-%d') != CURRENT_DATE()")->rowCount() ?>
					</h3>
					<span class="text-uppercase font-size-sm text-muted">Постояные пациенты</span>
				</div>

				<div class="ml-3 align-self-center">
					<i class="icon-users icon-3x text-danger-400"></i>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /Информация о пациентах -->

<!-- Информация об отделах -->
<div class="mb-3">

	<div class=" header-elements-sm-inline">
		<h4 class="mb-0 font-weight-semibold">Отделы</h4>
		<span class="text-muted d-block">Информация об отделах</span>
		<h4 class="mb-0 font-weight-semibold"></h4>
	</div>
</div>

<div class="row">

	<?php foreach ($db->query("SELECT id, title FROM division WHERE level IN(5, 6, 12) OR level = 10 AND (assist IS NULL OR assist = 1) ORDER BY level") as $row): ?>
		<div class="col-sm-4 col-xl-3">
			<div class="card card-body">
				<div class="media">
					<div class="media-body">
						<h3 class="font-weight-semibold mb-0">
							<?= $db->query("SELECT id FROM visit WHERE division_id = {$row['id']} AND accept_date IS NOT NULL AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
						</h3>
						<span class="text-uppercase font-size-sm text-muted"><?= $row['title'] ?></span>
					</div>

					<div class="ml-3 align-self-center">
						<i class="icon-cube4 icon-3x text-blue-400"></i>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

</div>
<!-- /Информация об отделах -->
