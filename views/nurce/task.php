<?php
require_once '../../tools/warframe.php';
is_auth(7);
$pk = $_GET['pk'];

$sql = "SELECT * FROM bypass WHERE user_id = $pk";
?>
<div class="table-responsive card">
    <table class="table table-hover table-sm">
        <thead>
            <tr class="bg-secondary">
                <th>Информация</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($db->query($sql) as $row): ?>
                <tr>
                    <td>
                        <?php foreach ($db->query("SELECT p.product_code FROM bypass_preparat bp LEFT JOIN products p ON(p.product_id=bp.preparat_id) WHERE bp.bypass_id = {$row['id']}") as $prep): ?>
                            <?= $prep['product_code'] ?><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php foreach ($db->query("SELECT bt.time, bd.status, bd.completed FROM bypass_time bt LEFT JOIN bypass_date bd ON(bd.bypass_time_id=bt.id AND bd.bypass_id={$row['id']} AND bd.status IS NOT NULL AND bd.date = CURRENT_DATE()) WHERE bt.bypass_id = {$row['id']}") as $value): ?>
                    <?php if ($value['status']): ?>
                        <tr class="text-right table-<?= ($value['completed']) ? "success" : "danger" ?>">
                            <td><?= date('H:i', strtotime($value['time'])) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
