<?php
require_once '../../tools/warframe.php';
$session->is_auth(25);
$pk = $_GET['pk'];

$visit = (new VisitModel)->tb()->where("id = $pk AND completed IS NULL")->get_row();
?>

<?php if($visit): ?>
    <?php
    $events = (new VisitBypassEventsModel)->tb()->set_data("DISTINCT visit_bypass_id, responsible_id, event_title")->where("visit_id = $pk AND DATE(event_start) = CURRENT_DATE()");
    ?>
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
                <?php foreach ($events->get_table() as $event): ?>
                    <tr>
                        <td>
                            <strong><?= $event->event_title ?></strong>
                            <ul>
                                <?php
                                $event_time = (new VisitBypassEventsModel)->tb()->where("visit_id = $pk AND DATE(event_start) = CURRENT_DATE() AND visit_bypass_id = $event->visit_bypass_id")->order_by("event_start");
                                ?>
                                <?php foreach ($event_time->get_table() as $row): ?>
                                    <li>
                                        <?php
                                        if ($row->event_completed) {
                                            $status = "выполнено";
                                            $color = "success";
                                            $tag = "s";
                                        }elseif ($row->event_fail) {
                                            $status = "отменено";
                                            $color = "secondary";
                                            $tag = "s";
                                        }else {
                                            $status = "не выполнено";
                                            $color = "danger";
                                            $tag = "span";
                                        }
                                        ?>
                                        <<?= $tag ?> class="text-<?= $color ?>">
                                            <?php
                                            if ($row->event_end) echo "от ".date_f($row->event_start, "H:i")." до ".date_f($row->event_end, "H:i");
                                            else echo date_f($row->event_start, "H:i");
                                            ?> - <?= $status ?>
                                        </<?= $tag ?>>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                            <div class="text-right"><em><b>Назначил <?= get_full_name($event->responsible_id) ?></b></em></div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if($visit->is_active): ?>
        <div class="text-right">
            <a href="<?= viv('card/content-9') ?>?pk=<?= $pk ?>&activity=1" class="btn btn-outline-info btn-sm">Перейти к пациенту</a>
        </div>
    <?php endif; ?>
<?php endif; ?>
