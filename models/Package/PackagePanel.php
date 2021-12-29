<?php

class PackagePanel extends Model
{
    public $service = 'package_services';

    public function get_or_404(int $pk)
    {
        global $db;
        if ( isset($_GET) and $_GET['id'] == 1 and isset($_POST) ) {
            $this->post = $_POST;
            unset($_POST);
            if ( isset($this->post['pk']) and is_numeric($this->post['pk']) ) {

                $this->package = $db->query("SELECT * FROM $this->service WHERE id = {$this->post['pk']}")->fetch();

                if ($this->package) {
                    $this->table();
                }

            }else {
                $this->empty_result();
            }
        }

    }

    public function table()
    {
        ?>
        <div class="form-group-feedback form-group-feedback-right row">

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

        <?php foreach (json_decode($this->package['divisions']) as $key => $value): ?>
            <script type="text/javascript">
                divisions["<?= $key ?>"] = "<?= $value ?>";
            </script>
        <?php endforeach; ?>

        <?php foreach (json_decode($this->package['items']) as $value): ?>
            <script type="text/javascript">
                service["<?= $value->service_id ?>"] = {};
                service["<?= $value->service_id ?>"]['parent'] = "<?= $value->parent_id ?>";
                service["<?= $value->service_id ?>"]['count'] = "<?= $value->count ?>";
            </script>
        <?php endforeach; ?>

        <script type="text/javascript">
            $.ajax({
                type: "POST",
                url: "<?= up_url(1, 'ServicePanel') ?>",
                data: {
                    divisions: divisions,
                    selected: service,
                    is_foreigner: "<?= $this->post['is_foreigner'] ?>",
                    is_order: "<?= $this->post['is_order'] ?>",
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
        <?php
    }

    public function empty_result()
    {
        ?>
        <tr class="table-secondary">
            <th class="text-center" colspan="<?= 7-$this->post['cols'] ?>">Нет данных</th>
        </tr>
        <?php
    }

}

?>
