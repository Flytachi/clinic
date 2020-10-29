<?php
require_once 'phpBox/warframe.php';
?>
<table>
    <tbody>
    <?php
    foreach($db->query('SELECT * from users') as $row) {
        ?>
        <tr>
            <th><?= $row['id'] ?></th>
            <th><?= get_full_name($row['id']) ?></th>
            <th><a href="phpBox/delete.php?<?= delete($row['id'], 'users', 'test.php')?>"><button>delete</button></a></th>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>