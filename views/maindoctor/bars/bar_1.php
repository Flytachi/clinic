<!-- Widgets with charts -->
<div class="row">
    <div class="col-sm-6 col-xl-3">

        <!-- Area chart in colored card -->
        <div class="card bg-indigo-400 has-bg-image">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Все Пациенты</h3>
                </div>

                <div>
                    <?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL")->rowCount() ?>
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

                <div>
                    <?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL AND direction IS NULL")->rowCount() ?>
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

                <div>
                    <?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL AND direction IS NOT NULL")->rowCount() ?>
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
