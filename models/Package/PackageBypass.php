<?php

class PackageBypassModel extends Model
{
    public $table = 'package_bypass';

    public function form($pk = null)
    {
        global $session, $classes, $methods;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="autor_id" value="<?= $session->session_id ?>">

            <div class="form-group">
                <label>Название пакета:</label>
                <input type="text" name="name" value="<?= $this->value('name') ?>" class="form-control" placeholder="Введите название пакета" required>
            </div>

            <div class="form-group">
                <label>Метод:</label>
                <select data-placeholder="Выбрать метод" name="method" class="<?= $classes['form-select'] ?>" required>
                    <option></option>
                    <?php foreach ($methods as $key => $value): ?>
                        <option value="<?= $key ?>" <?= ($this->value('method') == $key) ? 'selected' : '' ?>><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Описание:</label>
                <textarea class="form-control" name="description" rows="2" cols="1" placeholder="Описание"><?= $this->value('description') ?></textarea>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-11">
                    <input type="text" class="<?= $classes['input-product_search'] ?>" id="search_input_product" placeholder="Поиск..." title="Введите название препарата">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Наименование</th>
                                <th>Поставщик</th>
                                <th>Производитель</th>
                                <th style="width:100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            /* var product = {};

            $("#search_input_product").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'WarehouseCustomPanel') ?>",
                    data: {
                        search: this.value,
                        selected: product,
                    },
                    success: function (result) {
                        var product = {};
                        $('#table_form').html(result);
                    },
                });
            }); */

        </script>
        <?php
        if ($pk) $this->jquery_init();
    }

    public function clean()
    {
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
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
    
}
        
?>