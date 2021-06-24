<?php
require_once '../tools/warframe.php';
$session->is_auth();

$data = $db->query("SELECT * FROM visit_documents WHERE id={$_GET['pk']}")->fetch();
?>

<div class="<?= $classes['modal-global_header'] ?>">
    <h5 class="modal-title">Файл "<?= $data['mark'] ?>"</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body ml-3 mr-3 text-justify">

    <div class="row">
    
        <div class="col-8">
            <object id="ScannerFile" type="<?= $data['file_format'] ?>" data="<?= $data['location'] ?>" style="width: 100%;min-height: 70vh;">
                <p>The DOC can not display </p>
            </object>
        </div>
        <div class="col-4">
            <h4 class="text-center"><b><?= $data['mark'] ?></b></h4>
            <?= $data['description'] ?>
            <p><b><?= date_f($data['add_date'], 1) ?></b></p>
        </div>

        <div class="col-12 text-center">
            <b>Автор: </b><?= get_full_name($data['parent_id']) ?>
        </div>

    </div>
    
    

</div>

<div class="modal-footer">
    <button type="button" class="<?= $classes['modal-global_btn_close'] ?>" data-dismiss="modal">Закрыть</button>
</div>


