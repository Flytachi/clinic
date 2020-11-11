<?php
require_once '../../tools/warframe.php';
is_auth(3);
switch ($_GET['tab']) {
    case 1:
        if(empty($_GET['search'])){
            $sql = "SELECT * FROM users WHERE user_level = 15 AND status_bed IS NULL AND status IS NULL AND parent_id IS NOT NULL ORDER BY add_date ASC LIMIT 5";
        }else {
            $ser = $_GET['search'];
            $sql = "SELECT * FROM users WHERE user_level = 15 AND status_bed IS NULL AND status IS NULL AND parent_id IS NOT NULL AND (id LIKE '%$ser%' OR first_name LIKE '%$ser%' OR last_name LIKE '%$ser%' OR father_name LIKE '%$ser%')";
        }
        foreach($db->query($sql) as $row) {
        ?>
            <tr>
                <td class="text-left"><?= date("d/m/Y H:i"); ?></td>
                <td class="text-center"><?= addZero($row['id']) ?></td>
                <td class="text-center">
                    <a onclick="CheckAmb('get_mod.php?pk=<?= $row['id'] ?>')">
                        <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                    </a>
                </td>
            </tr>
        <?php
        }
        break;

    case 4:
        if(empty($_GET['search'])){
            $sql = "SELECT * FROM users WHERE user_level = 15 AND status_bed IS NOT NULL AND status IS NOT NULL AND parent_id IS NOT NULL ORDER BY add_date ASC LIMIT 5";
        }else {
            $ser = $_GET['search'];
            $sql = "SELECT * FROM users WHERE user_level = 15 AND status_bed IS NOT NULL AND status IS NOT NULL AND parent_id IS NOT NULL AND (id LIKE '%$ser%' OR first_name LIKE '%$ser%' OR last_name LIKE '%$ser%' OR father_name LIKE '%$ser%')";
        }
        foreach($db->query($sql) as $row) {
        ?>
            <tr>
                <td class="text-left"><?= date("d/m/Y H:i"); ?></td>
                <td class="text-center"><?= addZero($row['id']) ?></td>
                <td class="text-center">
                    <a onclick="CheckSt('get_mod.php?pk=<?= $row['id'] ?>', '<?= $row['id'] ?>')" >
                        <div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
                    </a>
                </td>
            </tr>
        <?php
        }
        break;
}
?>
