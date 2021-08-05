<?php

class DivisionModel extends Model
{
    public $table = 'divisions';
    public $file_format = array('php');

    public function form($pk = null)
    {
        global $db, $PERSONAL, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <script src="<?= stack("assets/js/custom.js") ?>"></script>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label>Выбирите Роль:</label>
                <select data-placeholder="Выбрать роль" id="level_use" name="level" class="<?= $classes['form-select'] ?>" onchange="TableChange(this)" required>
                    <option></option>
                    <?php foreach ($PERSONAL as $key => $value): ?>
                        <?php if(!in_array($key, [1,2,3,4,7,8,32])): ?>
                            <option value="<?= $key ?>"<?= ($this->value('level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Название отдела:</label>
                <input type="text" class="form-control" name="title" placeholder="Введите название отдела" required value="<?= $this->value('title') ?>">
            </div>

            <div class="form-group">
                <label>Название специолиста:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название специолиста" required value="<?= $this->value('name') ?>">
            </div>

            <div id="change_table_div"></div>
            <div id="change_table_div_2"></div>
        
            <div class="text-right">
                <button onclick="AddDoc()" type="button" class="btn btn-outline-success btn-sm">Привязать документ</button>
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <script type="text/javascript">
            function TableChange(the) {
                if (the.value == 10) {
                    var div = `
                        <div class="form-group row">
                            <label class="col-form-label col-md-1">Ассистент</label>
                            <div class="col-md-3">
                                <input type="checkbox" class="swit" name="assist" <?= ($this->value('assist') == 1) ? "checked" : "" ?>>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-1">Радиолог</label>
                            <div class="col-md-3">
                                <input type="checkbox" class="swit" name="assist_2" <?= ($this->value('assist') == 2) ? "checked" : "" ?>>
                            </div>
                        </div>
                    `;
                    document.querySelector('#change_table_div').innerHTML = div;
                    Swit.init();
                }else{
                    document.querySelector('#change_table_div').innerHTML = '';
                }
            }

            function AddDoc() {
                document.querySelector('#change_table_div_2').innerHTML = `
                    <div class="form-group">
                        <label>Документ:</label>
                        <input type="file" class="form-control" name="is_document">
                        <?php if($this->value('is_document')): ?>
                            <label>Удалить документ?</label>
                            <input type="checkbox" name="is_document" value="clean">
                        <?php endif; ?>
                    </div>
                `;
            }
        </script>

        <?php if($this->value('is_document')): ?>
            <script>
                AddDoc();
            </script>
        <?php endif; ?>

        <?php if($this->value('level') == 10): ?>
            <script>
                TableChange(document.querySelector("#level_use"));
            </script>
        <?php endif; ?>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function clean()
    {
        if( isset($this->post['is_document']) and $this->post['is_document'] == "clean" ){
            $this->post['is_document'] = null;
            $this->file_clean("is_document");
        }
        if ( isset($this->post['assist_2']) ) {
            $this->post['assist'] = 2;
            unset($this->post['assist_2']);
        }elseif ( isset($this->post['assist']) ) {
            $this->post['assist'] = 1;
        }else {
            $this->post['assist'] = False;
        }
        $this->file_download();
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
            '.$message.'
        </div>
        ';
        render();
    }
}

?>