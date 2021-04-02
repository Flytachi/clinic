<?php

class OperationServiceModel extends Model
{
    public $table = 'operation_service';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="operation_id" value="<?= $patient->pk ?>">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
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
                                <!-- <th>Отдел</th> -->
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="6" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

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

                        $('#modal_add_service').modal('toggle');
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

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: [
                            "<?php
                            foreach($db->query("SELECT * from division WHERE level = 11") as $row) {
                                echo $row['id'];
                            }
                            ?>"
                        ],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: [
                                "<?php
                                foreach($db->query("SELECT * from division WHERE level = 11") as $row) {
                                    echo $row['id'];
                                }
                                ?>"
                            ],
                        selected: service,
                        types: "1",
                        cols: 2
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
        if (is_array($this->post['service'])) {
            $this->save_rows();
        }
    }

    public function save_rows()
    {
        global $db;
        foreach ($this->post['service'] as $key => $value) {

            $serv = $db->query("SELECT name, price FROM service WHERE id = $value")->fetch();
            $post['operation_id'] = $this->post['operation_id'];
            $post['parent_id'] = $this->post['parent_id'][$key];
            $post['item_id'] = $value;
            $post['item_name'] = $serv['name'];
            $post['item_cost'] = $serv['price'];

            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $object = Mixin\insert($this->table, $post);
                if (!intval($object)){
                    $this->error($object);
                }
            }

        }
        $this->success();
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