<?php
require_once '../../tools/warframe.php';
$session->is_auth();
?>
<?php if($_GET['type'] == 1): ?>
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead class="<?= $classes['table-thead'] ?>">
                <tr>
                    <th style="width:50px;">№</th>
                    <th>ID</th>
                    <th>ФИО</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tb = new Table($db, "visit_services vs");
                $tb->set_data("DISTINCT vs.visit_id, vs.user_id")->additions("LEFT JOIN visits v ON(vs.visit_id=v.id)");
                $tb->where("v.completed IS NULL AND v.division_id = $session->session_division AND DATE(vs.add_date) = CURRENT_DATE() AND vs.service_id != 1 AND vs.status = 2");
                ?>
                <?php foreach ($tb->get_table(1) as $row): ?>
                    <tr onclick="Check('<?= viv('nurce/task_service') ?>?pk=<?= $row->visit_id ?>')">
                        <td><?= $row->count ?></td>
                        <td><?= addZero($row->user_id) ?></td>
                        <td><?= get_full_name($row->user_id) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> 
<?php elseif($_GET['type'] == 2): ?>
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead class="<?= $classes['table-thead'] ?>">
                <tr>
                    <th style="width:50px;">№</th>
                    <th>ID</th>
                    <th>ФИО</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tb = new Table($db, "visit_bypass_events vbe");
                $tb->set_data("DISTINCT vbe.visit_id, vbe.user_id")->additions("LEFT JOIN visits v ON(vbe.visit_id=v.id)");
                $tb->where("v.completed IS NULL AND v.division_id = $session->session_division AND DATE(vbe.event_start) = CURRENT_DATE() AND vbe.event_completed IS NULL");
                ?>
                <?php foreach ($tb->get_table(1) as $row): ?>
                    <tr onclick="Check('<?= viv('nurce/task_bypass') ?>?pk=<?= $row->visit_id ?>')">
                        <td><?= $row->count ?></td>
                        <td><?= addZero($row->user_id) ?></td>
                        <td><?= get_full_name($row->user_id) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif($_GET['type'] == 3): ?>
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead class="<?= $classes['table-thead'] ?>">
                <tr>
                    <th style="width:50px;">№</th>
                    <th>ID</th>
                    <th>ФИО</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tb = new Table($db, "visit_bypass_events vbe");
                $tb->set_data("DISTINCT vbe.visit_id, vbe.user_id")->additions("LEFT JOIN visits v ON(vbe.visit_id=v.id)");
                $tb->where("v.completed IS NULL AND v.division_id = $session->session_division AND DATE(vbe.event_start) = CURRENT_DATE() AND vbe.event_completed IS NOT NULL");
                ?>
                <?php foreach ($tb->get_table(1) as $row): ?>
                    <tr onclick="Check('<?= viv('nurce/task_bypass') ?>?pk=<?= $row->visit_id ?>')">
                        <td><?= $row->count ?></td>
                        <td><?= addZero($row->user_id) ?></td>
                        <td><?= get_full_name($row->user_id) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
