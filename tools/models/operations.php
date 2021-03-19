<?php

class OperationModel extends Model
{
    public $table = 'operation';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * from division WHERE level = 5") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Дата:</label>
                    <input type="date" class="form-control" name="oper_date">
                </div>

                <div class="col-md-2">
                    <label>Время:</label>
                    <input type="time" class="form-control" name="oper_time">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="item_id" id="item_id" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php foreach ($db->query("SELECT * from service WHERE user_level = 5 AND type = 3") as $row): ?>
                            <option class="text-danger" value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#item_id").chained("#division_id");
            });
        </script>
        <?php
    }

    public function form_oper_update($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" id="oper_id">

            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Дата:</label>
                        <input type="date" class="form-control" name="oper_date" id="oper_date">
                    </div>

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="oper_time" id="oper_time">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form_finish($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="Chek_fin_date()" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" id="finish_id">
            <input type="hidden" name="visit_id" id="visit_id">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Дата завершения операции</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label>Дата:</label>
                        <input type="date" class="form-control" name="finish_date" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="finish_time">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            function Chek_fin_date() {
                if (event.target.dataset.c_date > event.target.finish_date.value +" "+ event.target.finish_time.value) {
                    event.preventDefault();
                    new Noty({
                        text: 'Дата завершения не может быть меньше даты операции!',
                        type: 'error'
                    }).show();
                }
            }
        </script>
        <?php
    }

    public function clean()
    {
        if ($this->post['finish_date']) {
            $this->post['completed'] = $this->post['finish_date']." ".$this->post['finish_time'];
            unset($this->post['finish_date']);
            unset($this->post['finish_time']);
        }elseif ($this->post['oper_date']){
            $this->post['oper_date'] .= " ".$this->post['oper_time'];
            unset($this->post['oper_time']);
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function update()
    {
        global $db;
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $db->beginTransaction();

            if ($this->post['completed']) {
                $post_price = $db->query("SELECT id, item_cost FROM visit_price WHERE operation_id = {$pk} AND visit_id = {$this->post['visit_id']}")->fetch();
                unset($this->post['visit_id']);
                $post_price_pk = $post_price['id']; unset($post_price['id']);
                $post_price['item_cost'] = $db->query("SELECT SUM(item_cost) FROM operation WHERE id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(price) FROM operation_member WHERE operation_id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(item_cost) FROM operation_service WHERE operation_id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(item_cost*item_qty) FROM operation_preparat WHERE operation_id = {$pk}")->fetchColumn();
                $post_price['item_cost'] += $db->query("SELECT SUM(item_cost) FROM operation_consumables WHERE operation_id = {$pk}")->fetchColumn();
                $this->storage_sales($pk);
                // обновление цены
                $object = Mixin\update('visit_price', $post_price, $post_price_pk);
                if (!intval($object)){
                    $this->error($object);
                }
            }

            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }
            $db->commit();
            $this->success();

        }
    }

    public function storage_sales($pk)
    {
        global $db;
        $sql = "SELECT st.id, st.code,
                    st.name, st.supplier,
                    opp.item_qty 'qty',
                    (st.qty - opp.item_qty) 'storage_qty',
                    (st.qty_sold + opp.item_qty) 'storage_qty_sold',
                    (st.price * opp.item_qty) 'amount',
                    st.price, $pk 'operation_id'
                FROM operation_preparat opp
                    LEFT JOIN storage st ON(st.id=opp.item_id)
                WHERE opp.operation_id = $pk";
        foreach ($db->query($sql) as $post) {
            $object = Mixin\update('storage', array('qty' => $post['storage_qty'], 'qty_sold' => $post['storage_qty_sold']), $post['id']);
            if (!intval($object)) {
                $this->error('storage '.$object);
                $db->rollBack();
            }
            unset($post['id'], $post['storage_qty'], $post['storage_qty_sold']);
            $this->add_sales($post);
        }
    }

    public function add_sales($arr)
    {
        global $db;
        $object = Mixin\insert('storage_sales', $arr);
        if (!intval($object)) {
            $this->error('storage_sales '.$object);
            $db->rollBack();
        }
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $db->beginTransaction();
            $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['item_id']}")->fetch();
            $this->post['item_name'] = $service['name'];
            $this->post['item_cost'] = $service['price'];
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
            }
            $post['visit_id'] = $this->post['visit_id'];
            $post['operation_id'] = $object;
            $post['user_id'] = $this->post['user_id'];
            $post['item_type'] = 5;
            $post['item_id'] = $this->post['item_id'];
            $post['item_cost'] = $service['price'];
            $post['item_name'] = $service['name'];
            $object = Mixin\insert('visit_price', $post);
            if (!intval($object)){
                $this->error($object);
            }
            $db->commit();
            $this->success();
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

class OperationStatsModel extends Model
{
    public $table = 'operation_stats';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="operation_id" value="<?= $patient->pk ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Добавить показатель состояния</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="time">
                    </div>

                    <div class="col-md-6">
                        <label>Давление:</label>
                        <input type="text" class="form-control" name="pressure" placeholder="Введите давление">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-4">
                        <label>Пульс:</label>
                        <input type="number" class="form-control" name="pulse" min="40" step="1" max="150" value="85" placeholder="Введите пульс" required>
                    </div>

                    <div class="col-md-4">
                        <label>Температура:</label>
                        <input type="number" class="form-control" name="temperature" min="35" step="0.1" max="42" value="36.6" placeholder="Введите температура" required>
                    </div>

                    <div class="col-md-4">
                        <label>Сатурация:</label>
                        <input type="number" class="form-control" name="saturation" min="25" max="100" placeholder="Введите cатурация" required>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
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

                        $('#modal_add').modal('toggle');
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
        </script>
        <?php
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

                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container"></div>

                <!-- This container will become the editable. -->
                <div id="editor"></div>

                <textarea id="tickets-editor" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

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
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    const toolbarContainer = document.querySelector( '#toolbar-container' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        $('textarea#tickets-editor').html( editor.getData() );
                    } );
                } )
                .catch( error => {
                    console.error( error );
                } );

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

class OperationMemberModel extends Model
{
    public $table = 'operation_member';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
            $operation_id = $post['operation_id'];
        }else{
            $post = array();
            $operation_id = $patient->pk;
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="operation_id" value="<?= $operation_id ?>">

            <div class="modal-header bg-info">
                <?php if ($pk): ?>
                    <h5 class="modal-title">Изменить данные персонала: "<?= $post['member_name'] ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить члена персонала</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Член персонала:</label>
                    <select placeholder="Введите члена персонала" class="form-control form-control-select2" onchange="$('#member_name').val(this.value)">
                        <option>Введите члена персонала</option>
                        <?php foreach ($db->query("SELECT us.id, IFNULL(opm.id, NULL) 'opm_id' FROM users us LEFT JOIN operation_member opm ON(opm.member_name=us.first_name AND opm.operation_id=$operation_id) WHERE us.user_level = 5 AND us.id != {$_SESSION['session_id']}") as $row): ?>
                            <option value="<?= get_full_name($row['id']) ?>"><?= get_full_name($row['id']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Имя специолиста:</label>
                    <input type="text" class="form-control" name="member_name" id="member_name" placeholder="Введите имя специолиста" required value="<?= $post['member_name'] ?>">
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Оператор</label>
                    <div class="col-md-3">
                        <input type="checkbox" class="swit" name="member_operator" <?= ($post['member_operator']==1) ? "checked" : "" ?>>
                    </div>

                    <div class="col-md-5">
                        <label>Сумма:</label>
                        <input type="number" class="form-control" name="price" step="0.1" value="<?= ($post['price']) ? $post['price'] : "0"?>" placeholder="Введите сумму">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            </div>

        </form>
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <script type="text/javascript">
            $("#<?= __CLASS__ ?>_form").submit(function( events ) {
                events.preventDefault();
                $.ajax({
                    type: $(events.target).attr("method"),
                    url: $(events.target).attr("action"),
                    data: $(events.target).serializeArray(),
                    success: function (data) {
                        var result = JSON.parse(data);

                        $('#modal_add_member').modal('toggle');
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
        </script>
        <?php
    }

    public function clean()
    {
        if ($this->post['member_operator']) {
            $this->post['member_operator'] = 1;
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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

class OperationPreparatModel extends Model
{
    public $table = 'operation_preparat';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
            $operation_id = $post['operation_id'];
        }else{
            $post = array();
            $operation_id = $patient->pk;
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="operation_id" value="<?= $operation_id ?>">

            <div class="modal-header bg-info">
                <?php if ($pk): ?>
                    <h5 class="modal-title">Изменить препарат: "<?= $post['item_name'] ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить препарат</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Препарат:</label>
                        <select data-placeholder="Выберите материал" name="item_id" class="form-control select-price" required>
                            <option></option>
                            <?php $sql = "SELECT st.id, st.price, st.name,
                                            (
                                                st.qty -
                                                IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0)
                                            ) 'qty'
                                            FROM storage st WHERE st.category AND st.qty != 0 ORDER BY st.name"; ?>
                            <?php foreach ($db->query($sql) as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" <?= ($post['item_id'] == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?> (в наличии - <?= $row['qty'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Количество:</label>
                        <input type="number" name="item_qty" value="<?= ($post['item_qty']) ? $post['item_qty'] : "1" ?>" class="form-control" required>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
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

                        $('#modal_add_preparat').modal('toggle');
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

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $prep = $db->query("SELECT name, price FROM storage WHERE id = {$this->post['item_id']}")->fetch();
        $this->post['item_name'] = $prep['name'];
        $this->post['item_cost'] = $prep['price'];
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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

class OperationConsumablesModel extends Model
{
    public $table = 'operation_consumables';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
            $operation_id = $post['operation_id'];
        }else{
            $post = array();
            $operation_id = $patient->pk;
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="operation_id" value="<?= $operation_id ?>">

            <div class="modal-header bg-info">
                <?php if ($pk): ?>
                    <h5 class="modal-title">Изменить дополнительный расход: "<?= $post['item_name'] ?>"</h5>
                <?php else: ?>
                    <h5 class="modal-title">Добавить дополнительный расход</h5>
                <?php endif; ?>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Наименование:</label>
                        <input type="text" placeholder="Введите наименование" name="item_name" value="<?= $post['item_name'] ?>" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label>Сумма:</label>
                        <input type="number" name="item_cost" step="0.1" value="<?= ($post['item_cost']) ? $post['item_cost'] : "0" ?>" class="form-control" required>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
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

                        $('#modal_add_consumables').modal('toggle');
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

        </script>
        <?php
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
