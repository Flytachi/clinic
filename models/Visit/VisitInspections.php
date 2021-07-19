<?php

class VisitInspectionsModel extends Model
{
    public $table = 'visit_inspections';

    public function get_or_404(int $pk)
    {
        /**
         * Данные о записи!
         * если не найдёт запись то выдаст 404 
         */
        global $db;
        // $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        // if($object){
        //     $this->set_post($object);
        //     return $this->{$_GET['form']}($object['id']);
        // }else{
        //     Mixin\error('404');
        //     exit;
        // }
        $this->form($pk);

    }

    public function form($pk = null)
    {
        global $classes, $session;
        ?>
        <div class="<?= $classes['modal-global_header'] ?>">
            <h6 class="modal-title">Осмотр</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="post" action="<?= add_url() ?>">
            <div class="modal-body">
                <?php if(!config('document_autosave')): ?>
                    <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                    <input type="hidden" name="visit_id" value="<?= $pk ?>">
                    <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">
                <?php endif; ?>
                
                <div id="document_<?= __CLASS__ ?>">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template"></div>
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

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

                </div>
                
            </div>
            <div class="modal-footer">
                <?php if(!config('document_autosave')): ?>
                    <button type="submit" id="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Сохранить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                    <?php endif; ?>
                </div>
        </form>
        <script type="text/javascript">
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
        <?php if(config('document_autosave')): ?>
            <script type="text/javascript">

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');
                    const Div = document.querySelector( '#document-editor__footer' );
                    const Indicator = document.querySelector( '#document-editor__footer-status' );

                    var data_ajax = {
                        model: "<?= __CLASS__ ?>",
                        visit_id: "<?= $pk ?>",
                        parent_id: "<?= $session->session_id ?>",
                        report: params,
                    };

                    Textarea.value = params;
                    Indicator.classList.add( 'text-muted' );
                    Indicator.innerHTML = "Loading...";

                    $.ajax({
                        type: "POST",
                        url: "<?= add_url() ?>",
                        data: data_ajax,
                        success: function (result) {
                            var data = JSON.parse(result);

                            if (data.status == "success") {
                                
                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-success' );
                                Indicator.innerHTML = "&#10004 Saved!";
                                
                            }else{

                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-danger' );
                                Indicator.innerHTML = "&#10006; Error!";

                            }
                        },
                    });
                }

            </script>
        <?php else: ?>
            <script type="text/javascript">

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');

                    Textarea.value = params;
                }

            </script>
        <?php endif; ?>
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
        if (config('document_autosave')) {
            echo json_encode(array(
                'status' => 'success',
            ));
            exit;
        } else {
            $_SESSION['message'] = '
            <div class="alert alert-primary" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>
            ';
            render();
        }
        
        
    }

    public function error($message)
    {
        if (config('document_autosave')) {
            echo json_encode(array(
                'status' => 'error',
            ));
            exit;
        } else {
            $_SESSION['message'] = '
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                '.$message.'
            </div>
            ';
            render();
        }
        
    }
}

?>