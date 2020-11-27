<!-- Quick stats boxes -->
<div class="row">

    <div class="col-lg-4">

        <!-- Members online -->
        <div class="card bg-teal-400">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Пациенты</h3>
                    <span class="badge bg-teal-800 badge-pill align-self-center ml-auto" style="font-size: 1rem;">
                        <?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL")->rowCount() ?>
                    </span>
                </div>

                <div>
                    <div class="font-size-sm opacity-75">avg</div>
                </div>
            </div>

            <div class="container-fluid">
                <div id="members-online"></div>
            </div>
        </div>
        <!-- /members online -->

    </div>

    <div class="col-lg-4">

        <!-- Today's revenue -->
        <div class="card bg-blue-400">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Амбулаторные пациенты</h3>
                    <span class="badge bg-teal-800 badge-pill align-self-center ml-auto" style="font-size: 1rem;">
                        <?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL AND direction IS NULL")->rowCount() ?>
                    </span>
                </div>

                <div>
                    <div class="font-size-sm opacity-75">$37,578 avg</div>
                </div>
            </div>

            <div id="today-revenue"></div>
        </div>
        <!-- /today's revenue -->

    </div>

    <div class="col-lg-4">

        <!-- Current server load -->
        <div class="card bg-pink-400">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="font-weight-semibold mb-0">Стационарные пациенты</h3>
                    <span class="badge bg-teal-800 badge-pill align-self-center ml-auto" style="font-size: 1rem;">
                        <?= $db->query("SELECT DISTINCT user_id FROM visit WHERE status IS NOT NULL AND direction IS NOT NULL")->rowCount() ?>
                    </span>
                </div>

                <div>
                    <div class="font-size-sm opacity-75">34.6% avg</div>
                </div>
            </div>

            <div id="server-load"></div>
        </div>
        <!-- /current server load -->

    </div>

</div>
<!-- /quick stats boxes -->
