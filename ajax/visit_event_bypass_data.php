<?php
require_once '../tools/warframe.php';
importModel('Method');
$bypass = (new Table($db, "visit_bypass"))->where("id = {$_GET['pk']}")->get_row();
?>
<ol>
    <?php foreach (json_decode($bypass->items) as $item): ?>
        <?php if ( isset($item->item_name_id) and $item->item_name_id ): ?>
            <li><span class="text-primary"><?= $item->item_qty ?> шт.</span> <?= (new Table($db, "warehouse_item_names"))->where("id = $item->item_name_id")->get_row()->name ?></li>
        <?php else: ?>
            <li><span class="text-primary"><?= $item->item_qty ?> шт.</span> <?= $item->item_name ?> <span class="text-warning">(Сторонний)</span></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ol>
<b><em>Метод:</em></b> <?= (new Method)->byId($bypass->method, 'name')->name ?><br>
<?php if ( $bypass->description ): ?>
    <b><em>Описание:</em></b> <br> <?= preg_replace("#\r?\n#", "<br />", $bypass->description) ?>
<?php endif; ?>