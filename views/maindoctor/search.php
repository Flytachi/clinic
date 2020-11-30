<?php
require_once '../../tools/warframe.php';
is_auth();


if(empty($_GET['search'])){
    $sql = "SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE us.user_level = 15 ORDER BY us.add_date DESC";
}else {
    $ser = $_GET['search'];
    $sql = "SELECT DISTINCT us.id, us.dateBith, us.numberPhone, us.add_date FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE us.user_level = 15 AND (us.id LIKE '%$ser%' OR us.first_name LIKE '%$ser%' OR us.last_name LIKE '%$ser%' OR us.father_name LIKE '%$ser%')";
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
            <a href="<?= viv('maindoctor/list_all_visit') ?>?id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Визиты</button>
        </td>
    </tr>
    <?php
}
?>
