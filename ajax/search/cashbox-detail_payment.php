<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$tb = new Table($db, "visit_service_transactions");
$search = $tb->get_serch();
$search_array = array(
	"is_visibility IS NOT NULL AND user_id = {$_GET['pk']} AND is_price IS NOT NULL", 
	"is_visibility IS NOT NULL AND user_id = {$_GET['pk']} AND is_price IS NOT NULL AND (LOWER(item_name) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->order_by('price_date DESC')->set_limit(20);
$tb->set_self(viv('cashbox/detail_payment'));  
?>
<div class="table-responsive card">
    <table class="table table-hover table-sm" id="table">
        <thead class="<?= $classes['table-thead'] ?>">
            <tr>
                <th>№</th>
                <th>Дата  платежа</th>
                <th>Услуга/Медикоменты</th>
                <th>Наличные</th>
                <th>Пластик</th>
                <th>Перечисление</th>
                <th>Скидка</th>
                <th>Кассир</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tb->get_table(1) as $row): ?>
                <?php
                if ( empty($mas) ) $mas = '';
                if (empty($temp_old)) {
                    $temp_old = $row->price_date;
                    $color = "";
                }else {
                    if ($temp_old != $row->price_date) {
                        if ($color) {
                            $color = "";
                            $staus = 0;
                        }else {

                            $color = "table-secondary";

                            $staus = 1;

                        }
                    }
                    $temp_old = $row->price_date;
                }

                $mas .=  $row->id . ",";
                ?>
                <tr class="<?= $color ?>" onclick="addArray(this)" data-color="<?= $color ?>" data-status="true" data-id="<?= $row->id ?>">
                    <td><?= $row->count ?></td>
                    <td><?= date_f($row->price_date, 1) ?></td>
                    <td><?= $row->item_name ?></td>
                    <td><?= $row->price_cash ?></td>
                    <td><?= $row->price_card ?></td>
                    <td><?= $row->price_transfer ?></td>
                    <td><?= ($row->sale) ? $row->sale : '<span class="text-muted">Нет данных</span>' ?></td>
                    <td><?= get_full_name($row->pricer_id) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>