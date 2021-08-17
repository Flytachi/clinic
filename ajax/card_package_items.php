<?php
require_once '../tools/warframe.php';
$session->is_auth();
?>

<?php if (isset($_GET['pk']) and is_numeric($_GET['pk'])): ?>

    <?php $package = $db->query("SELECT * FROM packages WHERE id = {$_GET['pk']}")->fetch(); ?>

    <?php if ($package): ?>
        <div class="form-group-feedback form-group-feedback-right row ">

            <div class="col-md-10"></div>
            <div class="col-md-1">
                <div class="text-right mb-2">
                    <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Отправить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
            </div>

        </div>

        <div class="form-group">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-dark">
                            <th>#</th>
                            <th>Отдел</th>
                            <th>Услуга</th>
                            <th>Cпециалист</th>
                            <th style="width: 100px">Кол-во</th>
                            <th class="text-right">Цена</th>
                        </tr>
                    </thead>
                    <tbody id="table_form">

                    </tbody>
                </table>
            </div>

        </div>

        <script type="text/javascript">var service = {};var divisions = {};</script>

        <?php foreach (json_decode($package['divisions']) as $key => $value): ?>
            <script type="text/javascript">
                divisions["<?= $key ?>"] = "<?= $value ?>";
            </script>
        <?php endforeach; ?>

        <?php foreach (json_decode($package['items']) as $value): ?>
            <script type="text/javascript">
                service["<?= $value->service_id ?>"] = {};
                service["<?= $value->service_id ?>"]['parent'] = "<?= $value->parent_id ?>";
                service["<?= $value->service_id ?>"]['count'] = "<?= $value->count ?>";
            </script>
        <?php endforeach; ?>

        <script type="text/javascript">
            $.ajax({
                type: "GET",
                url: "<?= ajax('service_table') ?>",
                data: {
                    divisions: divisions,
                    selected: service,
                    is_foreigner: "<?= $_GET['is_foreigner'] ?>",
                    is_order: "<?= $_GET['is_order'] ?>",
                    types: "1,2",
                    cols: 1,
                    is_service_checked: 1,
                },
                success: function (result) {
                    var service = {};
                    $("#table_form").html(result);
                },
            });
        </script>
    <?php endif; ?>

<?php endif; ?>

