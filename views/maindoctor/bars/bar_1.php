<!-- Widgets with charts -->
<div class="row">
    <div class="col-sm-6 col-xl-3">

        <!-- Area chart in colored card -->
        <div class="card bg-indigo-400 has-bg-image">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Все Пациенты</h3>
                </div>

                <div class="row">
                    <div class="col-md-6 text-left">
                        <!-- <span class="badge font-size-lg"><?= $db->query("SELECT DISTINCT user_id FROM visit WHERE accept_date IS NOT NULL AND completed IS NULL")->rowCount() ?></span> -->
                        <span class="badge font-size-lg"><?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="badge badge-pill badge-success font-size-lg">+3</span>
                    </div>
                </div>
            </div>

            <div id="chart_area_color"></div>
        </div>
        <!-- /area chart in colored card -->

    </div>

    <div class="col-sm-6 col-xl-3">

        <!-- Line chart in colored card -->
        <div class="card bg-blue-400 has-bg-image">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Амбулаторные Пациенты</h3>
                </div>

                <div class="row">
                    <div class="col-md-6 text-left">
                        <!-- <span class="badge font-size-lg"><?= $db->query("SELECT DISTINCT user_id FROM visit WHERE accept_date IS NOT NULL AND completed IS NULL AND direction IS NULL")->rowCount() ?></span> -->
                        <span class="badge font-size-lg"><?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE direction IS NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="badge badge-pill badge-success font-size-lg">+3</span>
                    </div>
                </div>
            </div>

            <div id="line_chart_color"></div>
        </div>
        <!-- /line chart in colored card -->

    </div>

    <div class="col-sm-6 col-xl-3">

        <!-- Bar chart in colored card -->
        <div class="card bg-danger-400 has-bg-image">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Стационарные Пациенты</h3>
                </div>

                <div class="row">
                    <div class="col-md-6 text-left">
                        <!-- <span class="badge font-size-lg"><?= $db->query("SELECT DISTINCT user_id FROM visit WHERE accept_date IS NOT NULL AND completed IS NULL AND direction IS NOT NULL")->rowCount() ?></span> -->
                        <span class="badge font-size-lg"><?= $db->query("SELECT DISTINCT us.id, us.add_date FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE direction IS NOT NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->rowCount() ?></span>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="badge badge-pill badge-success font-size-lg">+3</span>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="chart_bar_color"></div>
            </div>
        </div>
        <!-- /bar chart in colored card -->

    </div>

    <div class="col-sm-6 col-xl-3">

        <!-- Sparklines in colored card -->
        <div class="card bg-success-400 has-bg-image">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Операционные Пациенты</h3>
                </div>

                <div>
                    Нет данных
                </div>
            </div>

            <div id="sparklines_color"></div>
        </div>
        <!-- /sparklines in colored card -->

    </div>
</div>
<!-- /widgets with charts -->

<!-- Информация о койках -->
<div class="mb-3">
	<h4 class="mb-0 font-weight-semibold">Койки</h4>
	<span class="text-muted d-block">Информация о койках</span>
</div>

<div class="row">
	<div class="col-sm-6 col-xl-3">

		<!-- Invitation stats colored -->
		<div class="card text-center bg-blue-400 has-bg-image">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">Информация о койках</h6>
				<div class="opacity-75 mb-3">свободно</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_one"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_one_all">
							<?= $db->query("SELECT id FROM beds")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободные</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_one_open">
							<?= $db->query("SELECT id FROM beds WHERE user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_one_close">
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
				<div class="text-muted mb-3">свободно</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_two"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_two_all">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 1")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободные</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_two_open">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 1 AND user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_two_close">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 1 AND user_id IS NOT NULL")->rowCount() ?>
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
				<div class="text-muted mb-3">свободно</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_three"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_three_all">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 2")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободные</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_three_open">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 2 AND user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_three_close">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 2 AND user_id IS NOT NULL")->rowCount() ?>
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
				<div class="text-muted mb-3">свободно</div>
				<div class="svg-center position-relative mb-1" id="progress_percentage_four"></div>
			</div>

			<div class="card-body border-top-0 pt-0">
				<div class="row">
					<div class="col-4">
						<div class="text-uppercase font-size-xs">Все</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_four_all">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 3")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Свободные</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_four_open">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 3 AND user_id IS NULL")->rowCount() ?>
						</h5>
					</div>

					<div class="col-4">
						<div class="text-uppercase font-size-xs">Занятые</div>
						<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_four_close">
							<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 3 AND user_id IS NOT NULL")->rowCount() ?>
						</h5>
					</div>
				</div>
			</div>
		</div>
		<!-- /tickets stats colored -->

	</div>
</div>
<!-- /Информация о койках -->
