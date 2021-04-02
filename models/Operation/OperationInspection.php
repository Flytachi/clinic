<?php

class OperationInspectionModel extends Model
{
    public $table = 'operation_inspection';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="operation_id" value="<?= $patient->pk ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-header bg-info">
                <?php if (!permission(11)): ?>
                    <h5 class="modal-title">Добавить протокол операции</h5>
                    <input type="hidden" name="status" value="1">
                <?php else: ?>
                    <h5 class="modal-title">Добавить протокол анестезии</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


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
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" id="submit"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            </div>

        </form>
        <script type="text/javascript">

            $("#<?= __CLASS__ ?>_form").submit(function( events ) {
                events.preventDefault();
                $.ajax({
                    type: $(events.target).attr("method"),
                    url: $(events.target).attr("action"),
                    data: $(events.target).serializeArray(),
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('#modal_add_inspection').modal('toggle');
                        if (result.status == "success") {
                            new Noty({
                                text: result.message,
                                type: 'success'
                            }).show();
                        }else {
                            new Noty({
                                text: result.message,
                                type: 'error'
                            }).show();
                        }

                        Title_up();
                    },
                });
            });

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
            document.getElementById( 'submit' ).onclick = () => {
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
        echo json_encode(array(
            'status' => "success",
            'message' => "Успешно"
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => "error",
            'message' => $message
        ));
        exit;
    }
}

?>