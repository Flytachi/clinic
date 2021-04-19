<?php
require_once '../../tools/warframe.php';
is_auth();
is_module('module_laboratory');
?>
<div class="modal-header bg-info">
    <h5 class="modal-title">Анализы: <?= get_full_name($_GET['id']) ?> </h5>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div id="modal_result_show_content">

    <?php VisitAnalyzeModel::table_form(); ?>

</div>
