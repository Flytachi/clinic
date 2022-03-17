<?php
require '../../../tools/warframe.php';

importModel('User');

$tb = new User;
$search = $tb->getSearch();
$tb->Where(array("is_active iS NOT NULL", "is_active iS NOT NULL AND (username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))"));
$tb->Order("user_level, last_name ASC")->Limit(20);
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="bg-dark">
            <tr>
                <th>#</th>
                <th>Роль</th>
                <th>Логин</th>
                <th>ФИО</th>
                <th class="text-right" style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->list(1) as $row): ?>
                <tr 
                <?php if ($row->user_level == 1): ?>
                    class="table-dark text-danger"
                <?php elseif ($row->user_level == 8): ?>
                    class="table-dark text-dark"
                <?php endif; ?>
                >
                    <td><?= $row->count ?></td>
                    <td>
                        <?php if ($row->user_level == 5): ?>
                            <span class="text-success"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif ($row->user_level == 6): ?>
                            <span class="text-primary"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif (in_array($row->user_level, [2, 3, 32])): ?>
                            <span class="text-teal"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif ($row->user_level == 10): ?>
                            <span class="text-indigo"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif (in_array($row->user_level, [7, 9])): ?>
                            <span class="text-orange"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif (in_array($row->user_level, [12, 13, 14])): ?>
                            <span class="text-brown"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php else: ?>
                            <span><?= $PERSONAL[$row->user_level] ?></span>
                        <?php endif; ?>
                        <?php
                        if(division_name($row->id)){
                            echo " (".division_name($row->id).")";
                        }
                        ?>
                    </td>
                    <td><?= $row->username ?></td>
                    <td><?= get_full_name($row->id); ?></td>
                    <td class="text-right">
                        <div class="list-icons">
                            <a href="<?= ajax("master/avatar") ?>?pk=<?= $row->id ?>" class="list-icons-up text-success"><i class="icon-arrow-up16"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->panel(); ?>