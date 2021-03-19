<?php
require_once '../../../tools/warframe.php';
is_auth();

if(empty($_GET['search'])){
    $sql = "SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date
            FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
            WHERE vs.completed IS NOT NULL AND vs.assist_id = {$_SESSION['session_id']} ORDER BY us.id DESC LIMIT 20";
}else {
    $ser = $_GET['search'];
    $sql = "SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date
            FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
            WHERE vs.completed IS NOT NULL AND vs.assist_id = {$_SESSION['session_id']}
                AND (us.id LIKE '%$ser%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$ser%'))";
}
foreach($db->query($sql) as $row) {
    ?>
    <tr>
        <td><?= addZero($row['id']) ?></td>
        <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
        <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
        <td><?= $row['numberPhone'] ?></td>
        <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
        <td class="text-center">
            <a href="<?= viv('archive/assist/list_visit') ?>?id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
        </td>
    </tr>
    <?php
}
?>
