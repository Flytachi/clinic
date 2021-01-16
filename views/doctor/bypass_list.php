<?php
require_once '../../tools/warframe.php';
is_auth();

$pk = $_GET['pk'];
?>
<!-- <script src="<?= stack("vendors/js/custom.js") ?>"></script> -->

<div class="modal-header bg-info">
    <h5 class="modal-title">Лист назначений</h5>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<div class="modal-body">

    <div class="table-responsive">
        <table class="table table-xs table-bordered">
            <thead>
                <tr class="bg-info">
                    <th style="width: 50px">№</th>
                    <th>Препарат</th>
                </tr>
            </thead>

            <tbody>
                <?php $i=1;foreach ($db->query("SELECT * FROM bypass WHERE visit_id = $pk") as $bypass): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td>
                            <?php
                            foreach ($db->query("SELECT pt.product_code FROM bypass_preparat bp LEFT JOIN products pt ON(bp.preparat_id=pt.product_id) WHERE bp.bypass_id = {$bypass['id']}") as $serv) {
                                echo $serv['product_code']."<br>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-outline-info legitRipple btn-sm" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>Закрыть</button>
</div>
