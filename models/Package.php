<?php

class PackageModel extends Model
{
    public $table = 'package';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
            $post['items'] = json_decode($post['items']);
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="autor_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group">
                <label>Название пакета:</label>
                <input type="text" name="name" value="<?= $post['name'] ?>" class="form-control" placeholder="Введите название пакета" required>
            </div>

            <?php
            prit($post['items']);
            ?>

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <optgroup label="Врачи">
                        <?php foreach ($db->query("SELECT * from division WHERE level = 5") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Диогностика">
                        <?php foreach ($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Лаборатория">
                        <?php foreach ($db->query("SELECT * from division WHERE level = 6") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Остальные">
                        <?php foreach ($db->query("SELECT * from division WHERE level IN (12, 13) AND (assist IS NULL OR assist = 1)") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                </select>
            </div>


            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-11">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <th>Тип</th>
                                <th>Доктор</th>
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

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 0
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 0
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function clean()
    {
        $this->post['name'] = Mixin\clean($this->post['name']);
        foreach ($this->post['service'] as $key => $value) {
            $items[$value] = array(
                'parent_id' => $this->post['parent_id'][$key],
                'division_id' => $this->post['division_id'][$key],
                'count' => $this->post['count'][$key],
            );
        }
        $this->post['items'] = json_encode($items);
        unset($this->post['service']);
        unset($this->post['division_id']);
        unset($this->post['parent_id']);
        unset($this->post['count']);
        $this->mod('test');
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
