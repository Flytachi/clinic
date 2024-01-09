<?php
foreach ($db->query("SELECT id FROM users WHERE user_level IN (2, 32)") as $arr_users) {
    $registrators[] = $arr_users['id'];
}
?>
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
                        <span class="badge font-size-lg"><?= $db->query("SELECT COUNT(*) FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.route_id IN (".implode(", ", $registrators).") AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() GROUP BY us.id")->fetchColumn() ?></span>
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
                        <span class="badge font-size-lg"><?= $db->query("SELECT COUNT(*) FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.route_id IN (".implode(", ", $registrators).") AND vs.direction IS NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() GROUP BY us.id")->fetchColumn() ?></span>
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
                        <span class="badge font-size-lg"><?= $db->query("SELECT COUNT(*) FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.route_id IN (".implode(", ", $registrators).") AND vs.direction IS NOT NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() GROUP BY us.id")->fetchColumn() ?></span>
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

<?php $bed_type = $db->query("SELECT id, name FROM bed_type")->fetchAll(); ?>

<div class="row">

	<div class="col-sm-6 col-xl-3">

		<!-- Invitation stats colored -->
		<div class="card text-center bg-blue-400 has-bg-image">
			<div class="card-body">
				<h6 class="font-weight-semibold mb-0 mt-1">Информация о койках</h6>
				<div class="opacity-75 mb-3">Всего
                    <span id="progress_percentage_all"><?= $db->query("SELECT id FROM beds")->rowCount() ?></span>
                </div>
				<div class="svg-center position-relative mb-1" id="progress_percentage"></div>
			</div>

			<div class="card-body border-top-0 pt-0">

                <span style="display:none" id="progress_percentage_open"><?= $db->query("SELECT id FROM beds WHERE user_id IS NULL")->rowCount() ?></span>
                <span style="display:none" id="progress_percentage_close"><?= $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL")->rowCount() ?></span>

                <div class="row">

                    <div class="col-12">Свободные</div>

                    <?php foreach ($bed_type as $row): ?>
                        <div class="col-6">
                            <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <?= $db->query("SELECT id FROM beds WHERE user_id IS NULL AND types = {$row['id']}")->rowCount() ?>
                            </h5>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="row">

                    <div class="col-12">Занятые</div>
                    <?php foreach ($bed_type as $row): ?>
                        <div class="col-6">
                            <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <?= $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL AND types = {$row['id']}")->rowCount() ?>
                            </h5>
                        </div>
                    <?php endforeach; ?>
                </div>

			</div>
		</div>
		<!-- /invitation stats colored -->

	</div>

    <?php foreach ($FLOOR as $key => $value): ?>
        <div class="col-sm-6 col-xl-3">

    		<!-- Invitation stats white -->
    		<div class="card text-center">
    			<div class="card-body">
    				<h6 class="font-weight-semibold mb-0 mt-1"><?= $value ?></h6>
    				<div class="text-muted mb-3">Всего
                        <span id="progress_percentage_<?=$key?>_all"><?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key")->rowCount() ?></span>
                    </div>
    				<div class="svg-center position-relative mb-1" id="progress_percentage_<?=$key?>"></div>
    			</div>

    			<div class="card-body border-top-0 pt-0">

                    <span style="display:none" id="progress_percentage_<?=$key?>_open"><?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NULL")->rowCount() ?></span>
                    <span style="display:none" id="progress_percentage_<?=$key?>_close"><?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NOT NULL")->rowCount() ?></span>

                    <div class="row">

                        <div class="col-12">Свободные</div>

                        <?php foreach ($bed_type as $row): ?>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NULL AND bd.types = {$row['id']}")->rowCount() ?>
                                </h5>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <div class="row">

                        <div class="col-12">Занятые</div>

                        <?php foreach ($bed_type as $row): ?>
                            <div class="col-6">
                                <div class="text-uppercase font-size-xs"><?= $row['name'] ?></div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = $key AND user_id IS NOT NULL AND bd.types = {$row['id']}")->rowCount() ?>
                                </h5>
                            </div>
                        <?php endforeach; ?>

                    </div>

    			</div>
    		</div>
    		<!-- /invitation stats white -->

    	</div>
    <?php endforeach; ?>

</div>
<!-- /Информация о койках -->
