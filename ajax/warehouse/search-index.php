<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$is_grant = $_GET['is_grant'];
$is_payment = $_GET['is_payment'];

$tb = new Table($db, "warehouse_storage wc");
$search = $tb->get_serch();
$tb->set_data("wc.warehouse_id, wc.item_name_id, wc.item_manufacturer_id, wc.item_price, win.name, wim.manufacturer, wc.item_qty, wc.item_die_date")->additions("LEFT JOIN warehouse_item_names win ON(win.id=wc.item_name_id) LEFT JOIN warehouse_item_manufacturers wim ON(wim.id=wc.item_manufacturer_id)");
$where_search = array(
    "wc.warehouse_id = {$_GET['pk']}", 
    "wc.warehouse_id = {$_GET['pk']} AND ( LOWER(win.name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($where_search)->order_by("win.name ASC, wim.manufacturer ASC")->set_limit(20);
$tb->set_self(viv('warehouse/index'));  
?>
<?php
if( isset($_SESSION['message']) ){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr class="<?= $classes['table-thead'] ?>">
                <th>Наименование</th>
                <th style="width:250px">Производитель</th>
                <?php if($is_payment): ?>
                    <th class="text-right" style="width:200px">Стоимость</th>
                <?php endif; ?>
                <th class="text-center" style="width:2s00px">Кол-во доступно/бронь</th>
                <th class="text-center">Срок годности</th>
                <?php if($is_grant): ?>
                    <th class="text-right" style="width: 100px">Действия</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tb->get_table() as $row): ?>
                <tr>
                    <td><?= $row->name ?></td>
                    <td><?= $row->manufacturer ?></td>
                    <?php if($is_payment): ?>
                        <td class="text-right"><?= number_format($row->item_price) ?></td>
                    <?php endif; ?>
                    <td class="text-center">
                        <?php
                        $price = ($is_payment) ? "AND item_price = $row->item_price" : null;
                        $row->reservation = $db->query("SELECT SUM(item_qty) FROM warehouse_storage_applications WHERE status IN(1,2) AND warehouse_id_from = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id $price")->fetchColumn();
                        $row->reservation += $db->query("SELECT SUM(item_qty) FROM visit_bypass_event_applications WHERE warehouse_id = $row->warehouse_id AND item_name_id = $row->item_name_id AND item_manufacturer_id = $row->item_manufacturer_id $price")->fetchColumn();
                        ?>
                        <?= number_format($row->item_qty - $row->reservation) ?> /
                        <span class="<?= ($row->reservation) ? "text-danger" : "text-muted" ?>"> <?= number_format($row->reservation) ?></span>
                    </td>
                    <td class="text-center"><?= $row->item_die_date ?></td>
                    <?php if($is_grant): ?>
                        <td class="text-right"s>
                            <div class="list-icons">
                                <a href="#" onclick="Check('<?= up_url($row->id, 'WarehouseStorageTransactionModel') ?>')" class="list-icons-item text-danger-600"><i class="icon-clipboard6"></i></a>
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $tb->get_panel(); ?>