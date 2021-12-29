<?php
require_once '../../tools/warframe.php';
$session->is_auth(7);
$pk = $_GET['pk'];

$visit = $tb = (new Table($db, "visits"))->where("id = $pk AND is_active IS NOT NULL AND completed IS NULL")->get_row();
?>

<?php if($visit): ?>
    <?php
    $services = (new Table($db, "visit_services"))->set_data("DISTINCT level")->where("visit_id = $pk AND DATE(add_date) = CURRENT_DATE() AND service_id != 1 AND status = 2")->order_by("level ASC");
    ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <h3> <b>ID <?= addZero($visit->user_id) ?>:</b> <?= get_full_name($visit->user_id) ?></h3>
        </div>
    </div>
    
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="bg-secondary">
                    <th colspan="1">Информация</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services->get_table() as $service): ?>
                    <tr>
                        <td>
                            <strong><?= $PERSONAL[$service->level] ?></strong>
                            <ul>
                                <?php
                                $serv = (new Table($db, "visit_services"))->set_data("service_name")->where("visit_id = $pk AND DATE(add_date) = CURRENT_DATE() AND service_id != 1 AND status = 2 AND level = $service->level")->order_by("service_name ASC");
                                ?>
                                <?php foreach ($serv->get_table() as $row): ?>
                                    <li><?= $row->service_name ?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="text-right">
        <a href="<?= viv('card/content-9') ?>?pk=<?= $pk ?>&activity=1" class="btn btn-outline-info btn-sm">Перейти к пациенту</a>
    </div>
<?php endif; ?>
