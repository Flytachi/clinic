<?php

use Mixin\ModelOld;

class VisitInspectionModel extends ModelOld
{
    public $table = 'visit_inspections';
    public $_visit = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object and permission(5)){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
            exit;
        }
    }

    public function form($pk = null)
    {
        global $classes;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Осмотр</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="visit_id" value="<?= $_GET['visit_id'] ?>">
            <input type="hidden" name="response_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div id="document_<?= __CLASS__ ?>">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template">
                                <?= ($this->value('report')) ? $this->value('report') : "" ?>
                            </div>
                        </div>
                    </div>

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"><?= ($this->value('report')) ? $this->value('report') : '' ?></textarea>

                </div>

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