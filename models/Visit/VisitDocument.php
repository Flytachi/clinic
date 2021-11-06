<?php

class VisitDocumentModel extends Model
{
    public $table = 'visit_documents';
    protected $file_directory = "/storage/documents/";
    protected $file_format = array('pdf', 'mp4', 'jpg', 'png', 'dox', 'doxc', 'xlsx', 'csv', 'txt');

    public function form($pk = null)
    {
        global $session, $classes;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить визит</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">
                <input type="hidden" name="branch_id" value="<?= $session->branch ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">

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

            </div>
            <div class="modal-footer">
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
        if ( isset($this->post['location']) and $this->post['location'] == "clean") {
            $this->file_clean('location');
            $this->post['location'] = null;
            $this->post['file_extension'] = null;
            $this->post['file_size'] = null;
            $this->post['file_format'] = null;
        }
        $this->file_download();
        if ( isset($this->file['extension']) ) $this->post['file_extension'] = $this->file['extension'];
        if ( isset($this->file['size']) ) $this->post['file_size'] = $this->file['size'];
        if ( isset($this->file['type']) ) $this->post['file_format'] = $this->file['type'];
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function delete(int $pk)
    {
        $this->file_clean('location', $pk);
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            $this->success();
        } else {
            Mixin\error('404');
            exit;
        }

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
            '.$message.'
        </div>
        ';
        render();
    }
}
        
?>