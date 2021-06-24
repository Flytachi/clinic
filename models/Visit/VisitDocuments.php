<?php

class VisitDocumentsModel extends Model
{
    public $table = 'visit_documents';
    public $file_directory = "/storage/documents/";

    public function form($pk = null)
    {
        global $session, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">

            <div class="form-group row">

                <div class="col-8">
                    <label>Метка:</label>
                    <input type="text" name="mark" placeholder="Метка..." class="form-control" value="<?= $this->value('mark') ?>" required>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label>Документ:</label>
                        <input type="file" class="form-control" name="location">
                        <?php if($this->value('location')): ?>
                            <label>Удалить документ?</label>
                            <input type="checkbox" name="location" value="clean">
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>

            <div class="form-group">
                <label>Описание:</label>
                <textarea class="form-control" name="description" rows="2" cols="2" placeholder="Описание"><?= $this->value('description') ?></textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    protected function clean()
    {
        $this->file_download();
        $this->post['file_name'] = ( isset($this->file['name']) ) ? $this->file['name'] : null;
        $this->post['file_size'] = ( isset($this->file['size']) ) ? $this->file['size'] : null;
        $this->post['file_format'] = ( isset($this->file['type']) ) ? $this->file['type'] : null;
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>