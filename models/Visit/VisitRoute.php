<?php

class VisitRoute extends Model
{
    public $table = 'visit_services';
    public $table2 = 'beds';
    public $_prices = 'visit_prices';
    public $_orders = 'visit_orders';
    public $_beds = 'visit_beds';
    public $_visits = 'visits';
    public $_user = 'users';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить визит</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 5 AND id != $session->session_division") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-base text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span class="ladda-label">Отправить</span>
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
                                    <th>Отдел</th>
                                    <th>Услуга</th>
                                    <th>Cпециалист</th>
                                    <th style="width: 100px">Кол-во</th>
                                    <th class="text-right">Цена</th>
                                </tr>
                            </thead>
                            <tbody id="table_form">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </form>
        <script type="text/javascript">

            BootstrapMultiselect.init();
            FormLayouts.init();

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function TableChangeServices(params) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        selected: service,
                        types: "1,2",
                        cols: 1
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

    public function form_diagnostic($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить визит</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
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
                                    <th>Отдел</th>
                                    <th>Услуга</th>
                                    <th>Cпециалист</th>
                                    <th style="width: 100px">Кол-во</th>
                                    <th class="text-right">Цена</th>
                                </tr>
                            </thead>
                            <tbody id="table_form">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </form>
        <script type="text/javascript">

            BootstrapMultiselect.init();
            FormLayouts.init();

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function TableChangeServices(params) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        selected: service,
                        types: "1",
                        cols: 1
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

    public function form_labaratory($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить анализ</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 6") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
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
                                    <th>Отдел</th>
                                    <th>Услуга</th>
                                    <th>Cпециалист</th>
                                    <th style="width: 100px">Кол-во</th>
                                    <th class="text-right">Цена</th>
                                </tr>
                            </thead>
                            <tbody id="table_form">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </form>
        <script type="text/javascript">

            BootstrapMultiselect.init();
            FormLayouts.init();

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function TableChangeServices(params) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        selected: service,
                        types: "1",
                        cols: 1
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

    public function form_physio($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить физиотерапию</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label>Отделы</label>
                    <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="<?= $classes['form-multiselect'] ?>" onchange="TableChangeServices(this)" required>
                        <?php foreach ($db->query("SELECT * FROM divisions WHERE level = 12") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group-feedback form-group-feedback-right row">

                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
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
                                    <th>Отдел</th>
                                    <th>Услуга</th>
                                    <th>Cпециалист</th>
                                    <th style="width: 100px">Кол-во</th>
                                    <th class="text-right">Цена</th>
                                </tr>
                            </thead>
                            <tbody id="table_form">

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </form>
        <script type="text/javascript">

            BootstrapMultiselect.init();
            FormLayouts.init();

            var service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        var service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function TableChangeServices(params) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        selected: service,
                        types: "1",
                        cols: 1
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

    public function form_second($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить услугу</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="parent_id" value="<?= $session->session_id ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">
                <input type="hidden" name="status" value="3">
                
                <!-- <input type="hidden" name="status" value="2">
                <input type="hidden" name="accept_date" value="1"> -->
    
                <div class="form-group-feedback form-group-feedback-right row">
    
                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input" placeholder="Поиск..." title="Введите назване отдела или услуги">
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-base text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                                <span class="ladda-label">Отправить</span>
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
                                    <th>Услуга</th>
                                    <th style="width: 100px">Кол-во</th>
                                    <th class="text-right">Цена</th>
                                </tr>
                            </thead>
                            <tbody id="table_form">
                                <tr>
                                    <td colspan="4" class="text-center" onclick="table_change()">услуги</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_package($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h6 class="modal-title">Назначить пакет</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="direction" value="<?= $patient->direction ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label>Пакеты:</label>
                    <select data-placeholder="Выбрать пакет" class="<?= $classes['form-select'] ?>" required onchange="Change_Package_list(this)">
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM packages WHERE autor_id = $session->session_id ORDER BY name DESC") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="div_form"></div>
                
            </div>

        </form>
        <script type="text/javascript">

            function Change_Package_list(params) {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('card_package_items') ?>",
                    data: { 
                        pk:params.value,
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_order: "<?= $patient->order ?>",
                    },
                    success: function (result) {
                        $('#div_form').html(result);
                    },
                });
            }

            FormLayouts.init();
            
        </script>
        <?php
    }

    public function clean()
    {
        if (isset($this->post['division_id']) and is_array($this->post['division_id']) and empty($this->post['direction']) and !$this->post['service']) {
            $this->error("Не назначены услуги!");
        }
        return True;
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $db->beginTransaction();

            $this->create_or_update_visit();
            if (is_array($this->post['service'])) {

                foreach ($this->post['service'] as $key => $value) {
                    
                    $this->add_visit_service($key, $value);
                    
                }

            }

            $db->commit();
            $this->success();
        }
    }

    public function create_or_update_visit()
    {
        global $db;
        $this->visit_pk = $this->post['visit_id'];
        $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_user WHERE id = {$this->post['user_id']}")->fetchColumn();
        $this->chek_order();
    }

    public function chek_order()
    {
        global $db;
        if ($db->query("SELECT id FROM $this->_orders WHERE visit_id = $this->visit_pk")->fetchColumn()) {
            $this->is_order = True;
        }
    }

    public function add_visit_service($key = null, $value)
    {
        global $db, $session;
        $data = $db->query("SELECT * FROM services WHERE id = $value")->fetch();

        if ( isset($this->post['division_id'][$key]) and $this->post['division_id'][$key] ) {
            $post['division_id'] = $this->post['division_id'][$key];
        }
        if (isset($this->post['status'])) {
            $post['status'] = $this->post['status'];
            $post['accept_date'] = date("Y-m-d H:i:s");
        } else {
            $post['status'] = ($this->post['direction'] or (isset($this->is_order) and $this->is_order) ) ? 2 : 1;
        }
        $post['visit_id'] = $this->visit_pk;
        $post['user_id'] = $this->post['user_id'];
        $post['route_id'] = $session->session_id;
        $post['parent_id'] = (is_array($this->post['parent_id'])) ? $this->post['parent_id'][$key] : $this->post['parent_id'];
        $post['guide_id'] = (isset($this->post['guide_id'])) ? $this->post['guide_id'] : null;
        $post['level'] = ( isset($post['division_id']) and $post['division_id'] ) ? $db->query("SELECT level FROM divisions WHERE id = {$post['division_id']}")->fetchColumn() : $this->post['level'][$key];
        $post['service_id'] = $data['id'];
        $post['service_name'] = $data['name'];
        
        $count = ($this->post['direction']) ? 1 : $this->post['count'][$key];
        for ($i=0; $i < $count; $i++) {
            $post = Mixin\clean_form($post);
            $post = Mixin\to_null($post);
            $object = Mixin\insert($this->table, $post);
            if (!intval($object)){
                $this->error("Ошибка при создании услуги!");
                $db->rollBack();
            }

            if ( empty($this->is_order) or (isset($this->is_order) and !$this->is_order) ) {
                if (!$this->post['direction'] or (!permission([2, 32]) and $this->post['direction'])) {
                    $post_price['visit_id'] = $this->visit_pk;
                    $post_price['visit_service_id'] = $object;
                    $post_price['user_id'] = $this->post['user_id'];
                    $post_price['item_type'] = 1;
                    $post_price['item_id'] = $data['id'];
                    $post_price['item_cost'] = ($this->is_foreigner) ? $data['price_foreigner'] : $data['price'];
                    $post_price['item_name'] = $data['name'];
                    $post_price['is_visibility'] = ($this->post['direction']) ? null : 1;
                    $object = Mixin\insert($this->_prices, $post_price);
                    if (!intval($object)){
                        $this->error("Ошибка при создании платежа услуги!");
                        $db->rollBack();
                    }
                }
            }
            
        }
        unset($post);
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