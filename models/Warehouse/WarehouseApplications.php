<?php

class WarehouseApplicationsModel extends Model
{
    public $table = 'warehouse_applications';

    public function store($status = 1)
    {
        global $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <div class="form-group-feedback form-group-feedback-right">

            <input type="text" class="<?= $classes['input-product_search'] ?>" id="search_input_product" placeholder="Поиск..." title="Введите название препарата">
            <div class="form-control-feedback">
                <i class="icon-search4 font-size-base text-muted"></i>
            </div>

        </div>

        <div class="form-group">

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr class="bg-dark">
                            <th>Наименование</th>
                            <th style="width:370px">Производитель</th>
                            <th style="width:370px">Поставщик</th>
                            <th class="text-center" style="width:150px">На складе</th>
                            <th style="width:100px">Кол-во</th>
                            <th class="text-center" style="width:50px">#</th>
                        </tr>
                    </thead>
                    <tbody id="table_form">

                    </tbody>
                </table>
            </div>

        </div>
        <script type="text/javascript">

            $("#search_input_product").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'WarehouseCommonPanel') ?>",
                    data: {
                        warehouse_id: "<?= $_GET['pk'] ?>", 
                        status: <?= $status ?>,
                        search: this.value, 
                    },
                    success: function (result) {
                        $('#table_form').html(result);
                    },
                });
            });

        </script>
        <?php
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


class WarehouseApplications extends WarehouseApplicationsModel
{
    public function success()
    {
        echo "success";
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>