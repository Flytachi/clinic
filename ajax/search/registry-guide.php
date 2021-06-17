<?php
require_once '../../tools/warframe.php';
$session->is_auth([2, 32]);

$tb = new Table($db, "guides");
$search = $tb->get_serch();
$where_search = array(null, "LOWER(name) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("name ASC")->set_limit(20);  
$tb->set_self(viv('registry/guide'));  
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th style="width:50px">№</th>
                <th style="width:50%">ФИО</th>
                <th>Сумма</th>
                <th>Доля</th>
                <th style="width: 100px">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table(1) as $row): ?>
                <tr>
                    <td><?= $row->count ?></td>
                    <td><?= $row->name ?></td>
                    <td><?= number_format($row->price) ?></td>
                    <td><?= number_format($row->share, 1) ?></td>
                    <td>
                        <div class="list-icons">
                            <a onclick="Update('<?= up_url($row->id, 'GuideModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                            <a href="<?= del_url($row->id, 'GuideModel') ?>" onclick="return confirm('Вы уверены что хотите удалить направителя?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>