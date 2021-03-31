<?php
require_once '../tools/warframe.php';
is_auth();

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
    </div>

    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

    <script>
        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ))
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
                const textarea = document.querySelector('#document-editor__area');

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                window.editor = editor;

                textarea.value = editor.getData();
                editor.model.document.on( 'change:data', ( evt, data ) => {
                    console.log( data );
                    textarea.value = editor.getData();
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
            </div>
        </div>
    </div>

    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

    <script>
        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ))
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
                const textarea = document.querySelector('#document-editor__area');

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                window.editor = editor;

                textarea.value = editor.getData();
                editor.model.document.on( 'change:data', ( evt, data ) => {
                    console.log( data );
                    textarea.value = editor.getData();
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
