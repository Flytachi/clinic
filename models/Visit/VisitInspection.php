<?php

class VisitInspectionModel extends Model
{
    public $table = 'visit_inspection';

    public function form($pk = null)
    {
        global $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="document-editor">
                    <div class="document-editor__toolbar"></div>
                    <div class="document-editor__editable-container">
                        <div class="document-editor__editable">
                        </div>
                    </div>
                </div>

                <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <button type="submit" id="submit_insp" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script type="text/javascript">
            DecoupledEditor
                .create( document.querySelector( '.document-editor__editable' ))
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
                    const textarea = document.querySelector('#document-editor__area');

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    window.editor = editor;

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        textarea.value = editor.getData();
                    } );
                } )
                .catch( err => {
                    console.error( err );
                } 
            );
            document.getElementById( 'submit_insp' ).onclick = () => {
                textarea.value = editor.getData();
            }
        </script>
        <?php
    }

    public function clean()
    {
        if (empty($this->post['report'])) {
            unset($this->post['report']);
        }else {
            $report = $this->post['report'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ($report) {
            $this->post['report'] = $report;
        }
        return True;
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}

?>