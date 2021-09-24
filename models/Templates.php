<?php

class TemplateModel extends Model
{
    public $table = 'templates';

    public function form($pk = null)
    {
        global $session;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="autor_id" value="<?= $session->session_id ?>">

            <div class="row">

                <div class="col-md-8 offset-md-2 mb-3">
                    <label class="col-form-label">Название шаблона:</label>
                    <input name="name" class="form-control" placeholder="Введите название" value="<?= $this->value('name') ?>" required>
                </div>

                <div class="col-md-12">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template">
                                <?= ($this->value('description')) ? $this->value('description') : "<br><strong>Рекомендация:</strong>" ?>
                            </div>
                        </div>
                    </div>

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="description" rows="1"><?= ($this->value('description')) ? $this->value('description') : '' ?></textarea>

                </div>

            </div>

            <div class="text-right mt-2">
                <button type="submit" id="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <script>
            DecoupledEditor
                .create( document.querySelector( '.document-editor__editable' ))
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    window.editor = editor;

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        $('textarea#document-editor__area').html( editor.getData() );
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
        if (empty($this->post['description'])) {
            unset($this->post['description']);
        }else {
            $description = $this->post['description'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ($description) {
            $this->post['description'] = $description;
        }
        return True;
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Ошибка при создании шаблона!
        </div>
        ';
        render();
    }
}
        
?>