<?php
require_once '../../tools/warframe.php';
is_auth([5,7]);
$bypass = $db->query("SELECT * FROM bypass WHERE id= {$_GET['pk']}")->fetch();
?>
<?php include '../../layout/head.php' ?>
<script src="<?= stack("vendors/js/custom.js") ?>"></script>

<div class="modal-header bg-info">
    <h5 class="modal-title">Назначение <?= get_full_name($bypass['user_id']) ?></h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body">
    <!-- Circle empty -->
    <div class="card card-body border-top-1 border-top-success">
        <div class="list-feed list-feed-rhombus list-feed-solid">
            <div class="list-feed-item border-info">
                <strong>Врач: </strong><?= get_full_name($bypass['parent_id']) ?>
            </div>

            <div class="list-feed-item border-info">
                <strong>Метод: </strong><?= $methods[$bypass['method']] ?>
            </div>

            <div class="list-feed-item border-info">
                <strong>Препарат: </strong>
                <?php
                foreach ($db->query("SELECT preparat_id FROM bypass_preparat WHERE bypass_id = {$bypass['id']}") as $serv) {
                    echo $serv['preparat_id']." Препарат, ";
                }
                ?>
            </div>

            <div class="list-feed-item border-info">
                <strong>Описание: </strong><?= $bypass['description'] ?>
            </div>
        </div>
    </div>
    <!-- /circle empty -->

    <?php if (permission(5)): ?>
        <?php BypassDateModel::table_form_doc() ?>
    <?php elseif (permission(7)): ?>
        <?php BypassDateModel::table_form_nurce() ?>
    <?php endif; ?>

</div>

<div class="modal-footer">
    <button class="btn btn-outline-info legitRipple btn-sm" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>Закрыть</button>
</div>
