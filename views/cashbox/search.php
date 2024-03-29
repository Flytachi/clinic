<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);

switch ($_GET['tab']) {
    case 1:
        if(empty($_GET['search'])){
            $sql = "SELECT DISTINCT us.id
                    FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
                    WHERE us.user_level = 15 AND vs.direction IS NULL AND us.status = 1 AND vs.priced_date IS NULL AND vs.add_date";
        }else {
            $ser = $_GET['search'];
            $sql = "SELECT DISTINCT us.id
                    FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
                    WHERE
                        us.user_level = 15 AND vs.direction IS NULL
                        AND us.status = 1 AND vs.priced_date IS NULL
                        AND (us.id LIKE '%$ser%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$ser%'))";
        }
        foreach($db->query($sql) as $row) {
            ?>
            <tr onclick="Check('get_mod.php?pk=<?= $row['id'] ?>')">
                <td><?= addZero($row['id']) ?></td>
                <td class="text-center">
                    <a>
                        <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                    </a>
                </td>
            </tr>
            <?php
        }
        break;
    case 2:
        if(empty($_GET['search'])){
            $sql = "SELECT DISTINCT us.id
                    FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
                    WHERE us.user_level = 15 AND vs.direction IS NOT NULL AND vs.priced_date IS NULL AND vs.service_id = 1";
        }else {
            $ser = $_GET['search'];
            $sql = "SELECT DISTINCT us.id
                    FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id)
                    WHERE
                        us.user_level = 15 AND vs.direction IS NOT NULL
                        AND vs.priced_date IS NULL AND vs.service_id = 1
                        AND (us.id LIKE '%$ser%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$ser%'))";
        }
        foreach($db->query($sql) as $row) {
        ?>
        <tr onclick="Check('get_mod.php?pk=<?= $row['id'] ?>', '<?= $row['id'] ?>')">
            <td><?= addZero($row['id']) ?></td>
            <td class="text-center">
                <a>
                    <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                </a>
            </td>
        </tr>
        <?php
        }
        break;
}
?>
