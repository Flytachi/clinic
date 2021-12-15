<?php
require_once '../../tools/warframe.php';
$session->is_auth(25);
$pk = $_GET['pk'];

$visit = $tb = (new VisitModel)->Where("id = $pk AND is_active IS NOT NULL AND completed IS NULL")->get();
?>

<?php if($visit): ?>
    <?php $services = (new VisitServiceModel)->Data("DISTINCT level")->Where("visit_id = $pk AND DATE(add_date) = CURRENT_DATE() AND service_id != 1 AND status = 2")->Order("level ASC"); ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <h3> <b>ID <?= addZero($visit->client_id) ?>:</b> <?= client_name($visit->client_id) ?></h3>
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
                <?php foreach ($services->list() as $service): ?>
                    <tr>
                        <td>
                            <strong><?= $PERSONAL[$service->level] ?></strong>
                            <ul>
                                <?php $serv = (new VisitServiceModel)->Data("service_name")->Where("visit_id = $pk AND DATE(add_date) = CURRENT_DATE() AND service_id != 1 AND status = 2 AND level = $service->level")->Order("service_name ASC"); ?>
                                <?php foreach ($serv->list() as $row): ?>
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
        <a href="<?= viv('card/content-7') ?>?pk=<?= $pk ?>&activity=1" class="btn btn-outline-info btn-sm">Перейти к пациенту</a>
    </div>
<?php endif; ?>
