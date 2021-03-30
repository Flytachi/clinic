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
                <!-- <div id="document-editor__editable_template"></div> -->
                <?= $db->query("SELECT description FROM templates WHERE id = {$_POST['pk']}")->fetchColumn(); ?>
            </div>
        </div>
    </div>
    <script>
        DecoupledEditor
            .create( document.querySelector( '.document-editor__editable' ))
            .then( editor => {
                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                window.editor = editor;

                editor.model.document.on( 'change:data', ( evt, data ) => {
                    console.log( data );
                    $('textarea#document-editor__area').html( editor.getData() );
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
