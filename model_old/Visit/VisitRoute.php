<?php

use Mixin\ModelOld;

class VisitRoute extends ModelOld
{
    public $table = 'visit_services';
    public $_patient = 'patients';
    public $table2 = 'beds';
    public $_visits = 'visits';
    public $_beds = 'visit_beds';
    public $_status = 'visit_status';
    public $_transactions = 'visit_service_transactions';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        importModel('VisitStatus');
        $status = ($patient->status_id) ? (new VisitStatus)->byId($patient->status_id, 'free_service_1')->free_service_1 : null;
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
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

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
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input_service" placeholder="Поиск..." title="Введите назване отдела или услуги">
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

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
                        search: this.value,
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
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
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

    public function form_labaratory($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        importModel('VisitStatus');
        $status = ($patient->status_id) ? (new VisitStatus)->byId($patient->status_id, 'free_laboratory')->free_laboratory : null;
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
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

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
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input_service" placeholder="Поиск..." title="Введите назване отдела или услуги">
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

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
                        search: this.value,
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
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
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

    public function form_diagnostic($pk = null)
    {
        global $db, $classes, $session;
        $patient = json_decode($_GET['patient']);
        importModel('VisitStatus');
        $status = ($patient->status_id) ? (new VisitStatus)->byId($patient->status_id, 'free_diagnostic')->free_diagnostic : null;
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
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

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
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input_service" placeholder="Поиск..." title="Введите назване отдела или услуги">
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

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
                        search: this.value,
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
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
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
        importModel('VisitStatus');
        $status = ($patient->status_id) ? (new VisitStatus)->byId($patient->status_id, 'free_physio')->free_physio : null;
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
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

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
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input_service" placeholder="Поиск..." title="Введите назване отдела или услуги">
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

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
                        search: this.value,
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
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: $(params).val(),
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
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
        importModel('VisitStatus');
        $status = ($patient->status_id) ? (new VisitStatus)->byId($patient->status_id, 'free_service_1')->free_service_1 : null;
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
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">
                <input type="hidden" name="status" value="3">
                
                <!-- <input type="hidden" name="status" value="2">
                <input type="hidden" name="accept_date" value="1"> -->
    
                <div class="form-group-feedback form-group-feedback-right row">
    
                    <div class="col-md-10">
                        <input type="text" class="<?= $classes['input-service_search'] ?>" id="search_input_service" placeholder="Поиск..." title="Введите назване отдела или услуги">
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

            $("#search_input_service").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
                        search: this.value,
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
                    type: "POST",
                    url: "<?= up_url(1, 'ServicePanel') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
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
        importModel('VisitStatus');
        $status = ($patient->status_id) ? (new VisitStatus)->byId($patient->status_id, 'free_service_1')->free_service_1 : null;
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
                <input type="hidden" name="patient_id" value="<?= $patient->id ?>">

                <div class="form-group">
                    <label>Пакеты:</label>
                    <select data-placeholder="Выбрать пакет" class="<?= $classes['form-select'] ?>" required onchange="Change_Package_list(this)">
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM package_services WHERE is_active IS NOT NULL AND autor_id = $session->session_id ORDER BY name DESC") as $row): ?>
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
                    type: "POST",
                    url: "<?= up_url(1, 'PackagePanel') ?>",
                    data: { 
                        pk:params.value,
                        is_foreigner: "<?= $patient->is_foreigner ?>",
                        is_free: "<?= $status ?>",
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
        Mixin\update($this->_visits, array('last_update' => date("Y-m-d H:i:s")), $this->visit_pk);
        $this->is_foreigner = $db->query("SELECT is_foreigner FROM $this->_patient WHERE id = {$this->post['patient_id']}")->fetchColumn();
        $this->chek_status();
    }

    public function chek_status()
    {
        global $db;
        $this->status_is = $db->query("SELECT * FROM $this->_status WHERE visit_id = $this->visit_pk")->fetch();
    }

    public function service_is_free($service = null)
    {
        if(isset($this->status_is) and $this->status_is){
            if($service['user_level'] == 1 and $service['type'] == 101) return true;
            elseif($service['user_level'] == 5) {
                if($this->status_is['free_service_1'] and $service['type'] == 1) return true;
                elseif($this->status_is['free_service_2'] and $service['type'] == 2) return true;
                elseif($this->status_is['free_service_3'] and $service['type'] == 3) return true;
            }
            elseif($service['user_level'] == 6 and $this->status_is['free_laboratory']) return true;
            elseif($service['user_level'] == 10 and $this->status_is['free_diagnostic']) return true;
            elseif($service['user_level'] == 12 and $this->status_is['free_physio']) return true;
            return false;
        }
        return false;
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
            $post['status'] = ($this->post['direction'] or $this->service_is_free($data) ) ? 2 : 1;
        }
        $post['visit_id'] = $this->visit_pk;
        $post['patient_id'] = $this->post['patient_id'];
        $post['route_id'] = $session->session_id;
        $post['parent_id'] = (is_array($this->post['parent_id'])) ? $this->post['parent_id'][$key] : $this->post['parent_id'];
        $post['guide_id'] = (isset($this->post['guide_id'])) ? $this->post['guide_id'] : null;
        $post['level'] = ( isset($post['division_id']) and $post['division_id'] ) ? $db->query("SELECT level FROM divisions WHERE id = {$post['division_id']}")->fetchColumn() : $this->post['level'][$key];
        $post['service_id'] = $data['id'];
        $post['service_name'] = $data['name'];
        
        for ($i=0; $i < $this->post['count'][$key]; $i++) {
            $post = Mixin\clean_form($post);
            $post = Mixin\to_null($post);
            $object = Mixin\insert($this->table, $post);
            if (!intval($object)){
                $this->error("Ошибка при создании услуги!");
                $db->rollBack();
            }

            if ( !$this->service_is_free($data) ) {
                $post_price['visit_id'] = $this->visit_pk;
                $post_price['visit_service_id'] = $object;
                $post_price['patient_id'] = $this->post['patient_id'];
                $post_price['item_type'] = $data['type'];
                $post_price['item_id'] = $data['id'];
                $post_price['item_cost'] = ($this->is_foreigner) ? $data['price_foreigner'] : $data['price'];
                $post_price['item_name'] = $data['name'];
                $post_price['is_visibility'] = ($this->post['direction']) ? null : 1;
                $object = Mixin\insert($this->_transactions, $post_price);
                if (!intval($object)){
                    $this->error("Ошибка при создании платежа услуги!");
                    $db->rollBack();
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