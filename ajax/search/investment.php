<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "investment iv");
$tb->set_data('DISTINCT iv.user_id');
$search = $tb->get_serch();
$search_array = array(
	"", 
	"(us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->additions('LEFT JOIN users us ON(us.id=iv.user_id)')->where_or_serch($search_array)->order_by('iv.add_date DESC')->set_limit(20);
$tb->set_self(viv('cashbox/list_investment'));  
?>
<div class="table-responsive card">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th class="text-center">ФИО</th>
                <th class="text-center" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->user_id) ?></td>
                    <td class="text-center"><div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div></td>
                    <td class="text-center">
                        <a href="<?= viv('cashbox/detail_investment') ?>?pk=<?= $row->user_id ?>" class="<?= $classes['btn_detail'] ?>">Детально</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>