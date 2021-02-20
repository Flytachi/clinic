<?php
require_once '../../tools/warframe.php';
is_auth();

if ($_GET['type']) {
    ?>
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="bg-info">
                    <th style="width:50px;">№</th>
                    <th>ID</th>
                    <th>ФИО</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($db->query("SELECT DISTINCT b.user_id, bd.completed FROM bypass_date bd LEFT JOIN bypass b ON(b.id=bd.bypass_id) WHERE bd.date = CURRENT_DATE() AND status IS NOT NULL AND bd.completed IS NOT NULL") as $row): ?>
                    <tr onclick="Check('<?= viv('nurce/task') ?>?pk=<?= $row['user_id'] ?>')">
                        <td><?= $i++ ?></td>
                        <td><?= addZero($row['user_id']) ?></td>
                        <td><?= get_full_name($row['user_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}else {
    ?>
    <div class="table-responsive card">
        <table class="table table-hover table-sm">
            <thead>
                <tr class="bg-info">
                    <th style="width:50px;">№</th>
                    <th>ID</th>
                    <th>ФИО</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1;foreach ($db->query("SELECT DISTINCT b.user_id FROM bypass_date bd LEFT JOIN bypass b ON(b.id=bd.bypass_id) WHERE bd.date = CURRENT_DATE() AND status IS NOT NULL AND bd.completed IS NULL") as $row): ?>
                    <tr onclick="Check('<?= viv('nurce/task') ?>?pk=<?= $row['user_id'] ?>')">
                        <td><?= $i++ ?></td>
                        <td><?= addZero($row['user_id']) ?></td>
                        <td><?= get_full_name($row['user_id']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
