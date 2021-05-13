<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_price vsp");
$tb->set_data('DISTINCT vsp.user_id');
$search = $tb->get_serch();
$search_array = array(
	"", 
	"(us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->additions('LEFT JOIN users us ON(us.id=vsp.user_id)')->where_or_serch($search_array)->order_by('vsp.add_date DESC')->set_limit(20);
$tb->set_self(viv('cashbox/list_payment'));  
?>
<div class="table-responsive">
    <table class="table table-hover table-sm">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th class="text-right" style="width:210px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table() as $row): ?>
                <tr>
                    <td><?= addZero($row->user_id) ?></td>
                    <td><div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div></td>
                    <td class="text-right">
                        <a href="<?= viv('cashbox/detail_payment') ?>?pk=<?= $row->user_id ?>" class="<?= $classes['btn_detail'] ?>">Детально</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>