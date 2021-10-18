<?php
require_once '../../tools/warframe.php';
$session->is_auth();

$pk = $_GET['pk'];
$object = $db->query("SELECT * FROM visits WHERE id = $pk AND completed IS NULL AND is_active IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
?>
<div class="<?= $classes['modal-global_header'] ?>">
    <h6 class="modal-title">Дневник</h6>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

    <div class="listbock">

        <h5 class="text-center text-muted mt-3">Начало</h5>
        <div class="content" id="listbock">

            <?php $tb = (new Table($db, "visit_journals"))->where("visit_id = $pk")->order_by("add_date ASC"); ?>
            <?php foreach ($tb->get_table() as $row): ?>
                <?php 
                if ($row->last_update) $dt = date_f($row->last_update, 1);
                else $dt = date_f($row->add_date, 1);
                ?>
                <blockquote class="blockquote blockquote-bordered py-2 pl-3 mb-0">
                    <div class="row">
                        <div class="col-md-11"><p class="mb-2 font-size-base" id="record_pk-<?= $row->id ?>"><?= preg_replace("#\r?\n#", "<br />", $row->record) ?></p></div>
                    </div>
                    <footer class="blockquote-footer"><?= get_full_name($row->responsible_id) ?>, <cite title="Source Title"><?= $dt ?></cite></footer>
                </blockquote>
            <?php endforeach; ?>

        </div>
        <h6 class="text-center text-muted">Конец</h6>

    </div>
    
</div>

<div class="modal-footer">
    <!-- <button onclick="Print()" type="button" class="btn btn-sm"><i class="icon-printer2"></i></button> -->
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>