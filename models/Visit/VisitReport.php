<?php

use Mixin\Hell;
use Mixin\HellCrud;
use Mixin\Model;

class VisitReport extends Model
{
    public $table = 'visit_services';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">

                <?php if(config("template")): ?>
                    <div class="col-md-4 offset-md-8">
                        <select data-placeholder="Выбрать пациента" class="<?= $classes['form-select'] ?>" onchange="ChangePack(this)">
                            <option value="0">Шаблоны</option>
                            <?php foreach ($db->query("SELECT * FROM templates WHERE autor_id = $session->session_id ORDER BY name DESC") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <h1>
                    <div class="col-md-8 offset-md-2">
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="text" style="font-size: 1.3rem;" id="service_title" name="service_title" value="<?= ($this->value('service_title')) ? $this->value('service_title') : $this->value('service_name') ?>" class="form-control" placeholder="Названия отчета" data-is_new="<?= ($this->value('service_title')) ? '' : 1 ?>">
                            <div class="form-control-feedback">
                                <span style="font-size: 1.3rem;" id="service_title_indicator"></span>
                            </div>
                        </div>
                    </div>
                </h1>
                
                <div id="document_<?= __CLASS__ ?>">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template">
                                <?= ($this->value('service_report')) ? $this->value('service_report') : "<br><strong>Рекомендация:</strong>" ?>
                            </div>
                        </div>
                        <?php if(config('document_autosave')): ?>
                            <!-- Avtosave -->
                            <div class="document-editor__footer row" id="document-editor__footer">
                                <div class="col-md-6 ml-3 mt-2 mb-2" style="font-size: 1rem;">
                                    <b>Status:</b>
                                    <span id="document-editor__footer-status" class="text-muted">Unknown</span>
                                </div>
                            </div>
                            <!-- Avtosave -->
                        <?php endif; ?>
                    </div>

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="service_report" rows="1"><?= ($this->value('service_report')) ? $this->value('service_report') : '' ?></textarea>

                </div>

            </div>

            <div class="modal-footer">
                <?php if (permission(12)): ?>
                    <?php if (division_assist() == 2): ?>
                        <input type="hidden" name="responsible_id" value="<?= $session->session_id ?>">
                    <?php endif; ?>
                    <input style="display:none;" id="btn_end_submit" type="submit" value="Завершить" name="end"></input>
                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="Verification()">Завершить</button>
                    <script type="text/javascript">
                        function Verification() {
                            event.preventDefault();

                            if ( !document.querySelector("#document-editor__area").value ) {
                                swal({
                                    position: 'top',
                                    title: 'Невозможно завершить!',
                                    text: 'Не написан отчёт.',
                                    type: 'error',
                                    padding: 30
                                });
                                return 0;
                            }

                            swal({
                                position: 'top',
                                title: 'Внимание!',
                                text: 'Вы точно хотите завершить визит пациента?',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Да'
                            }).then(function(ivi) {
                                if (ivi.value) {
                                    $('#btn_end_submit').click();
                                }
                            });
                        }
                    </script>
                <?php endif; ?>
                <?php if (permission([14])): ?>
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <?php else: ?>
                    <?php if(!config('document_autosave')): ?>
                        <button type="submit" id="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                            <span class="ladda-label">Сохранить</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </form>

        <script type="text/javascript">

            function ChangePack(params) {

                $.ajax({
                    type: "POST",
                    url: "<?= ajax('change_templates') ?>",
                    data: {
                        pk: params.value,
                    },
                    success: function (result) {
                        $('#document_<?= __CLASS__ ?>').html(result);
                    },
                });

            }

            DecoupledEditor
                .create( document.querySelector( '.document-editor__editable' ))
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                    window.editor = editor;
                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        SaveData(data, editor.getData());
                    } );

                } )
                .catch( err => {
                    console.error( err );
                } 
            );

        </script>
        <?php if(config('document_autosave')): ?>
            <script type="text/javascript">

                $("#service_title").keyup(function() {
                    const Indicator = document.querySelector( '#service_title_indicator' );

                    Indicator.classList.add( 'text-muted' );
                    Indicator.innerHTML = "!";
                    $.ajax({
                        type: "POST",
                        url: "<?= add_url() ?>",
                        data: {
                            model: "VisitServiceModel",
                            id: "<?= $pk ?>",
                            service_title: this.value,
                        },
                        success: function (result) {
                            var data = JSON.parse(result);
                            
                            if (data.status == "success") {

                                try {
                                    var tr = document.querySelector( `#VisitService_tr_${data.pk}` );
                                
                                    Indicator.classList.remove( 'text-muted' );
                                    Indicator.classList.add( 'text-success' );
                                    Indicator.innerHTML = "&#10004";

                                    if (tr.dataset.is_new) {
                                        tr.innerHTML = '<button onclick="location.reload();" type="button" class="btn btn-outline-primary btn-sm legitRipple">Обновите страницу</button>';
                                    }
                                } catch (error) {
                                    
                                }
                                

                            }else{

                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-danger' );
                                Indicator.innerHTML = "&#10006;";

                            }
                        },
                    });
                });

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');
                    const Div = document.querySelector( '#document-editor__footer' );
                    const Indicator = document.querySelector( '#document-editor__footer-status' );

                    var data_ajax = {
                        model: "VisitServiceModel",
                        id: "<?= $pk ?>",
                        service_report: params,
                    };                    
                    if ("<?= division_assist() == 2 ?>" && document.querySelector(`#service_title`).dataset.is_new) {
                        data_ajax.responsible_id = "<?= $session->session_id ?>";
                    }

                    Textarea.value = params;
                    Indicator.classList.add( 'text-muted' );
                    Indicator.innerHTML = "Loading...";

                    $.ajax({
                        type: "POST",
                        url: "<?= add_url() ?>",
                        data: data_ajax,
                        success: function (result) {
                            var data = JSON.parse(result);

                            if (data.status == "success") {
                                
                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-success' );
                                Indicator.innerHTML = "&#10004 Saved!";

                                if (document.querySelector(`<?= (permission(12)) ? '#service_title' : '#VisitService_tr_${data.pk}' ?>`).dataset.is_new) {
                                    $("#service_title").keyup();
                                }
                                
                            }else{

                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-danger' );
                                Indicator.innerHTML = "&#10006; Error!";

                            }
                        },
                    });
                }

            </script>
        <?php else: ?>
            <script type="text/javascript">

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');

                    Textarea.value = params;
                }

            </script>
        <?php endif; ?>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function form_finish($pk = null)
    {
        global $classes;
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="<?= $classes['modal-global_header'] ?>">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <?php if(!config('document_autosave')): ?>
                    <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                    <input type="hidden" name="id" value="<?= $pk ?>">
                    <input type="hidden" name="service_title" value="<?= $this->post['service_name'] ?>">
                <?php endif; ?>

                <div id="document_<?= __CLASS__ ?>">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template">
                                <?php if ($this->value('service_report')): ?>
                                    <?= $this->value('service_report') ?>
                                <?php else: ?>
                                    <span class="text-big"><strong>Клинический диагноз:</strong></span><br>
                                    <span class="text-big"><strong>Сопутствующие заболевания:</strong></span><br>
                                    <span class="text-big"><strong>Жалобы:</strong></span><br>
                                    <span class="text-big"><strong>Anamnesis morbi:</strong></span><br>
                                    <span class="text-big"><strong>Объективно:</strong></span><br>
                                    <span class="text-big"><strong>Рекомендация:</strong></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(config('document_autosave')): ?>
                            <!-- Avtosave -->
                            <div class="document-editor__footer row" id="document-editor__footer">
                                <div class="col-md-6 ml-3 mt-2 mb-2" style="font-size: 1rem;">
                                    <b>Status:</b>
                                    <span id="document-editor__footer-status" class="text-muted">Unknown</span>
                                </div>
                            </div>
                            <!-- Avtosave -->
                        <?php endif; ?>
                    </div>

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="service_report" rows="1"><?= ($this->value('service_report')) ? $this->value('service_report') : '' ?></textarea>

                </div>

            </div>

            <div class="modal-footer">
                <?php if(!config('document_autosave')): ?>
                    <button type="submit" id="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                        <span class="ladda-label">Сохранить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                <?php endif; ?>
            </div>

        </form>
        
        <script type="text/javascript">

            DecoupledEditor
                .create( document.querySelector( '.document-editor__editable' ))
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.document-editor__toolbar' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                    window.editor = editor;
                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        SaveData(data, editor.getData());
                    } );

                } )
                .catch( err => {
                    console.error( err );
                } 
            );

        </script>
        <?php if(config('document_autosave')): ?>
            <script type="text/javascript">

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');
                    const Div = document.querySelector( '#document-editor__footer' );
                    const Indicator = document.querySelector( '#document-editor__footer-status' );

                    var data_ajax = {
                        model: "VisitServiceModel",
                        id: "<?= $pk ?>",
                        service_title: "<?= $this->post['service_name'] ?>",
                        service_report: params,
                    };

                    Textarea.value = params;
                    Indicator.classList.add( 'text-muted' );
                    Indicator.innerHTML = "Loading...";

                    $.ajax({
                        type: "POST",
                        url: "<?= add_url() ?>",
                        data: data_ajax,
                        success: function (result) {
                            var data = JSON.parse(result);

                            if (data.status == "success") {
                                
                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-success' );
                                Indicator.innerHTML = "&#10004 Saved!";
                                
                            }else{

                                Indicator.classList.remove( 'text-muted' );
                                Indicator.classList.add( 'text-danger' );
                                Indicator.innerHTML = "&#10006; Error!";

                            }
                        },
                    });
                }

            </script>
        <?php else: ?>
            <script type="text/javascript">

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');

                    Textarea.value = params;
                }

            </script>
        <?php endif; ?>
        <?php
    }

    public function get_or_404($pk)
    {
        global $db, $session;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk AND status = 3")->fetch();

        if($object){
            
            if (division_assist() == 2) {
                // Diagnostic
                if (is_null($object['responsible_id']) or $object['responsible_id'] == $session->session_id) {
                    $this->set_post($object);
                    return $this->form($object['id']);
                }else {
                    Hell::error('report_permissions_false');
                }

            } else {
                // Others
                $this->set_post($object);
                if ($object['service_id'] == 1) {
                    return $this->form_finish($object['id']);
                }else {
                    return $this->form($object['id']);
                }

            }

        }else{
            Hell::error('report_permissions_false');
        }

    }              

    public function update()
    {
        global $db;
        $end = (isset($this->post['end'])) ? true : false;
        unset($this->post['end']);
        if($this->clean()){
            $db->beginTransaction();
            $pk = $this->post['id']; unset($this->post['id']);
            $object = HellCrud::update($this->table, $this->post, $pk);
            if ($end) {

                $VisitFinish = new VisitFinish();
                $VisitFinish->set_post(array('status' => 7, 'completed' => date('Y-m-d H:i:s')));
                $VisitFinish->update_service($pk);
                $VisitFinish->status_update($db->query("SELECT visit_id FROM $this->table WHERE id = $pk")->fetchColumn());

            }else {
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
        
        $db->commit();
        $this->success();
    }

    public function clean()
    {
        if (empty($this->post['service_report'])) {
            unset($this->post['service_report']);
        }else {
            $report = $this->post['service_report'];
        }
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
        if ( isset($report) ) {
            $this->post['service_report'] = $report;
        }
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