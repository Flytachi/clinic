<?php
$registrators = [];
foreach ($db->query("SELECT id FROM users WHERE user_level IN (2, 32)") as $arr_users) {
    $registrators[] = $arr_users['id'];
}
$data = $db->query("SELECT vs.direction, COUNT(DISTINCT us.id) FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.route_id IN (".implode(", ", $registrators).") AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE() GROUP BY vs.direction")->fetchAll();
dd($data);
exit;
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
                        <span class="badge font-size-lg"><?= $db->query("SELECT COUNT(DISTINCT us.id) FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.route_id IN (".implode(", ", $registrators).") AND vs.direction IS NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->fetchColumn() ?></span>
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
                        <span class="badge font-size-lg"><?= $db->query("SELECT COUNT(DISTINCT us.id) FROM visit vs LEFT JOIN users us ON(us.id=vs.user_id) WHERE vs.route_id IN (".implode(", ", $registrators).") AND vs.direction IS NOT NULL AND DATE_FORMAT(vs.accept_date, '%Y-%m-%d') = CURRENT_DATE()")->fetchColumn() ?></span>

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
