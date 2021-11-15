<?php
require_once '../../tools/warframe.php';
$session->is_auth("master");

$tb = (new UserModel)->tb('us');
$search = $tb->get_serch();
$where_search = array(null, "us.username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%')");
$tb->set_data('cb.name, us.id, us.first_name, us.last_name, us.father_name, us.user_level, us.username')->additions("LEFT JOIN corp_branchs cb ON(cb.id=us.branch_id)");
$tb->where_or_serch($where_search)->order_by("cb.name ASC, us.user_level ASC, us.last_name ASC")->set_limit(20);
$tb->set_self(viv('master/index'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="bg-dark">
            <tr>
                <th>#</th>
                <th>Филиал</th>
                <th>Роль</th>
                <th>Логин</th>
                <th>ФИО</th>
                <th class="text-right" style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table(1) as $row): ?>
                <tr 
                <?php if ($row->user_level == 1): ?>
                    class="table-dark text-danger"
                <?php elseif ($row->user_level == 2): ?>
                    class="table-dark text-dark"
                <?php endif; ?>
                >
                    <td><?= $row->count ?></td>
                    <td><?= ($row->name) ? "<span class=\"text-primary\">$row->name</span>" : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td>
                        <?php if ($row->user_level < 10): ?>
                            <span class="text-danger"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif (10 < $row->user_level && $row->user_level < 20): ?>
                            <span class="text-brown"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php elseif (20 < $row->user_level && $row->user_level < 30): ?>
                            <span class="text-teal"><?= $PERSONAL[$row->user_level] ?></span>
                        <?php else: ?>
                            <span><?= $PERSONAL[$row->user_level] ?></span>
                        <?php endif; ?>
                        <?php
                        if(division_title($row->id)) echo " (".division_title($row->id).")";
                        ?>
                    </td>
                    <td><?= $row->username ?></td>
                    <td><?= get_full_name($row); ?></td>
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

<?php $tb->get_panel(); ?>
