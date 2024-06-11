<?php
require_once '../tools/warframe.php';
$session->is_auth();

// prit($_POST);
if ($_POST['pk']) {
    ?>
    <div class="document-editor">
        <div class="document-editor__toolbar"></div>
        <div class="document-editor__editable-container">
            <div class="document-editor__editable" id="document-editor__editable_template">
                <?= $db->query("SELECT description FROM templates WHERE id = {$_POST['pk']}")->fetchColumn(); ?>
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

    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="reports[body]" rows="1"></textarea>

    <script>
        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ))
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                window.editor = editor;
                editor.model.document.on( 'change:data', ( evt, data ) => {
                    SaveData(data, editor.getData());
                } );

            } )
            .catch( err => {
                console.error( err );
            } 
        );
    </script>
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

    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="reports[body]" rows="1"></textarea>


    <script>
        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ))
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                window.editor = editor;
                editor.model.document.on( 'change:data', ( evt, data ) => {
                    SaveData(data, editor.getData());
                } );

            } )
            .catch( err => {
                console.error( err );
            } 
        );
    </script>
    <?php
}
?>
