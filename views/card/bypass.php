<?php
require_once '../../tools/warframe.php';
is_auth([5,7]);
$bypass = $db->query("SELECT * FROM bypass WHERE id= {$_GET['pk']}")->fetch();
$grant_id = $db->query("SELECT grant_id FROM visit WHERE id= {$bypass['visit_id']}")->fetch()['grant_id'];
$grant = false;
if ($grant_id == $_SESSION['session_id']) {
    $grant = true;
}
?>
<script src="<?= stack("vendors/js/custom.js") ?>"></script>

<div class="modal-header bg-info">
    <h5 class="modal-title">Назначение <?= get_full_name($bypass['user_id']) ?></h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body">
    <!-- Circle empty -->
    <div class="card card-body border-top-1 border-top-success">
        <div class="list-feed list-feed-rhombus list-feed-solid">

            <div class="list-feed-item border-info" style="margin-bottom: -25px;">
                <strong>Препараты: </strong>
                <ul>
                    <?php foreach ($db->query("SELECT preparat_id, preparat_name, preparat_supplier, preparat_die_date, qty FROM bypass_preparat WHERE bypass_id = {$bypass['id']}") as $serv): ?>
                        <?php if ($serv['preparat_id']): ?>
                            <li><span class="text-primary"><?= $serv['qty'] ?> шт</span> - <?= $serv['preparat_name'] ?> | <?= $serv['preparat_supplier'] ?> (годен до <?= date("d.m.Y", strtotime($serv['preparat_die_date'])) ?>)</li>
                            <input type="hidden" class="products" value="<?= $serv['preparat_id'] ?>">
                        <?php else: ?>
                            <li><span class="text-primary"><?= $serv['qty'] ?> шт</span> - <?= $serv['preparat_name'] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="list-feed-item border-info">
                <strong>Метод: </strong><?= $methods[$bypass['method']] ?>
            </div>

            <div class="list-feed-item border-info">
                <strong >Описание: </strong><?= $bypass['description'] ?>
            </div>

            <div class="list-feed-item border-info">
                <strong>Врач: </strong><?= get_full_name($bypass['parent_id']) ?>
            </div>

        </div>
    </div>
    <!-- /circle empty -->

    <?php if ($activity or true): ?>
        <?php if (permission(5)): ?>
            <?php BypassDateModel::table_form_doc() ?>
        <?php elseif (permission(7)): ?>
            <?php BypassDateModel::table_form_nurce() ?>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold">Внимание!</span> ведется разработка.
        </div>
    <?php endif; ?>

</div>

<div class="modal-footer">
    <button class="btn btn-outline-info legitRipple btn-sm" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>Закрыть</button>
</div>
