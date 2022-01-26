<?php

class PanelModel extends Model
{
    public $table = 'panels';

    public function form($pk = null)
    {
        global $db, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <?php if($pk): ?>
                <input type="hidden" name="is_active" value="0">
            <?php endif;?>

            <div class="form-group row">
    
                <div class="col-md-4">
                    <label>IP:</label>
                    <input type="text" class="form-control" name="ip" placeholder="xxx.xxx.xxx.xxx" required value="<?= $this->value('ip') ?>">
                </div>

                <div class="col-md-5">
                    <label>Кабинеты:</label>
                    <select data-placeholder="Выбрать кабинет" name="rooms[]" multiple="multiple" class="form-control selm">
                        <?php foreach ($db->query("SELECT * FROM rooms") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($this->value("rooms") and in_array($row['id'], json_decode($this->value("rooms")))) ? "selected" : "" ?>><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-3 mb-md-2">
                        <label class="d-block font-weight-semibold">Запись</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="title" value="id" id="custom_radio_inline_unchecked" <?php if(!$this->value('title') or "id" == $this->value('title')){echo "checked";} ?>>
                            <label class="custom-control-label" for="custom_radio_inline_unchecked">ID</label>
                        </div>

                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="title" value="name" id="custom_radio_inline_checked" <?php if("name" == $this->value('title')){echo "checked";} ?>>
                            <label class="custom-control-label" for="custom_radio_inline_checked">Ф.И.О.</label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
        $this->jquery_init();
    }

    protected function jquery_init()
    {
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                FormLayouts.init();
                $(".selm").multiselect({
                    includeSelectAllOption: false,
                    enableFiltering: true,
                });
            });
        </script>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if (isset($this->post['rooms'])) $this->post['rooms'] = json_encode($this->post['rooms']);
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}
        
?>