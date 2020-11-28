<!-- Информация о койках -->
<div class="mb-3">
	<h6 class="mb-0 font-weight-semibold">Койки</h6>
	<span class="text-muted d-block">Информация о койках</span>
</div>

<div class="row">
	<div class="col-sm-6 col-xl-3">

		<!-- Invitation stats colored -->
		<div class="card text-center bg-blue-400 has-bg-image">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">Информация о койках</h6>
				<div class="opacity-75 mb-3">539 invites sent</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_three"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT id FROM beds")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободнае</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT id FROM beds WHERE user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL")->rowCount() ?>
						</h5>
					</div>
				</div>
			</div>
		</div>
		<!-- /invitation stats colored -->

	</div>

	<div class="col-sm-6 col-xl-3">

		<!-- Invitation stats white -->
		<div class="card text-center">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">1 Этаж</h6>
				<div class="text-muted mb-3">539 invites sent</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_one"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 1")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободнае</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 1 AND user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 1 AND user_id IS NOT NULL")->rowCount() ?>
						</h5>
					</div>
				</div>
			</div>
		</div>
		<!-- /invitation stats white -->

	</div>

	<div class="col-sm-6 col-xl-3">

		<!-- Tickets stats white -->
		<div class="card text-center">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">2 Этаж</h6>
				<div class="text-muted mb-3">893 tickets in total</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_two"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 2")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободнае</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 2 AND user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 2 AND user_id IS NOT NULL")->rowCount() ?>
						</h5>
					</div>
				</div>
			</div>
		</div>
		<!-- /tickets stats white -->

	</div>

	<div class="col-sm-6 col-xl-3">

		<!-- Tickets stats colored -->
		<div class="card text-center">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">3 Этаж</h6>
				<div class="text-muted mb-3">893 tickets in total</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_four"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 3")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободнае</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 3 AND user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
							<?= $db->query("SELECT bd.id FROM wards wd LEFT JOIN beds bd ON(bd.ward_id=wd.id) WHERE wd.floor = 3 AND user_id IS NOT NULL")->rowCount() ?>
						</h5>
					</div>
				</div>
			</div>
		</div>
		<!-- /tickets stats colored -->

	</div>
</div>
<!-- /Информация о койках -->

<!-- Информация о пациентах -->
<div class="mb-3">
	<h6 class="mb-0 font-weight-semibold">Пациенты</h6>
	<span class="text-muted d-block">Информация о пациентах</span>
</div>

<div class="row">

	<div class="col-sm-6 col-xl-4">
		<div class="card card-body">
			<div class="media">
				<div class="media-body">
					<h3 class="font-weight-semibold mb-0">
						<?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL")->rowCount() ?>
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
						<?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?>
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
						<?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL AND DATE_FORMAT(add_date, '%Y-%m-%d') != CURRENT_DATE()")->rowCount() ?>
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
