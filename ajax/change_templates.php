<?php
require_once '../tools/warframe.php';
$session->is_auth();

if ($_POST['pk']) {
    ?>
    <div class="document-editor">
        <div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
            <div class="document-editor__editable" id="document-editor__editable_template">
                <?= $desc = (new TemplateModel())->byId($_POST['pk'])->description; ?>
            </div>
        </div>
        <?php if(config('document_autosave')): ?>
            <!-- Avtosave -->
            <div class="document-editor__footer row" id="document-editor__footer">
                <div class="col-md-6 ml-3 mt-2 mb-2" style="font-size: 1rem;">
                    <b>Status:</b>
                    <span id="document-editor__footer-status" class="text-muted">Unknown</span>
                </div>
            </div>
            <!-- Avtosave -->
        <?php endif; ?>
    </div>

    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="service_report" rows="1"><?= $desc ?></textarea>
    <?php
}else {
    ?>
    <div class="document-editor">
        <div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
            <div class="document-editor__editable" id="document-editor__editable_template">
                <br><strong>Рекомендация:</strong>
            </div>
        </div>
        <?php if(config('document_autosave')): ?>
            <!-- Avtosave -->
            <div class="document-editor__footer row" id="document-editor__footer">
                <div class="col-md-6 ml-3 mt-2 mb-2" style="font-size: 1rem;">
                    <b>Status:</b>
                    <span id="document-editor__footer-status" class="text-muted">Unknown</span>
                </div>
            </div>
            <!-- Avtosave -->
        <?php endif; ?>
    </div>

    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="service_report" rows="1"></textarea>
    <?php
}
?>
