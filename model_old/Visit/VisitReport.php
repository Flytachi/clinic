<?php

use Mixin\HellCrud;
use Mixin\ModelOld;

class VisitReport extends ModelOld
{
    public $table = 'visit_services';

    public function form($pk = null)
    {
        global $db, $classes, $session;
        importModel('VisitServiceReport');
        $report = (new VisitServiceReport)->Where("visit_service_id=".$this->value('id'))->get();
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
                            <?php foreach ($db->query("SELECT * FROM templates WHERE autor_id = {$_SESSION['session_id']} ORDER BY name DESC") as $row): ?>
                                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <h1>
                    <div class="col-md-8 offset-md-2">
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="text" style="font-size: 1.3rem;" id="service_title" name="reports[title]" value="<?= ($report and $report->title) ? $report->title : $this->value('service_name') ?>" class="form-control" placeholder="Названия отчета" data-is_new="<?= ($this->value('service_title')) ? '' : 1 ?>">
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
                                <?= ($report) ? $report->body : "<br><strong>Рекомендация:</strong>" ?>
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

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="reports[body]" rows="1"><?= ($report->body) ? $report->body : '' ?></textarea>

                </div>

            </div>

            <div class="modal-footer">
                <?php if (permission(10)): ?>
                    <?php if (division_assist() == 2): ?>
                        <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
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
                <?php if (permission([12, 13])): ?>
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

                $("#service_title").keyup(() => {SaveData()});

                function SaveData(data, params) {
                    const Textarea = document.querySelector('#document-editor__area');
                    const Div = document.querySelector( '#document-editor__footer' );
                    const Indicator = document.querySelector( '#document-editor__footer-status' );

                    var data_ajax = {
                        model: "VisitServicesModel",
                        id: "<?= $pk ?>",
                        reports: {
                            title: $("#service_title").val(),
                        }
                    };                    
                    if ("<?= division_assist() == 2 ?>" && document.querySelector(`#service_title`).dataset.is_new) {
                        data_ajax.parent_id = "<?= $session->session_id ?>";
                    }

                    if(params) {
                        data_ajax.reports.body = params;
                        Textarea.value = params;
                    }
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
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function form_finish($pk = null)
    {
        global $classes;
        importModel('VisitServiceReport');
        $report = (new VisitServiceReport)->Where("visit_service_id=".$this->value('id'))->get();
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
                    <input type="hidden" name="reports[title]" value="<?= $this->post['service_name'] ?>">
                <?php endif; ?>

                <div id="document_<?= __CLASS__ ?>">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template">
                                <?php if ($report): ?>
                                    <?= $report->body ?>
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

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="reports[body]" rows="1"><?= ($report) ? $report->body : '' ?></textarea>

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
                        model: "VisitServicesModel",
                        id: "<?= $pk ?>",
                        reports: {
                            title: "<?= $this->post['service_name'] ?>",
                            body: params
                        }
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
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk AND status = 3")->fetch();

        if($object){
            
            if (division_assist() == 2) {
                // Diagnostic
                if (is_null($object['parent_id']) or $object['parent_id'] == $_SESSION['session_id']) {
                    $this->set_post($object);
                    return $this->form($object['id']);
                }else {
                    Mixin\error('report_permissions_false');
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
            Mixin\error('report_permissions_false');
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
            $object = Mixin\update($this->table, $this->post, $pk);
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
        if (isset($this->post['reports']) and $this->post['reports']) {
            importModel('VisitServiceReport');
            $record = new VisitServiceReport;
            $record->Where("visit_service_id=" . $this->post['id']);
            if ($r = $record->get()) {
                HellCrud::update("visit_service_reports", $this->post['reports'], $r->id);
            } else {
                HellCrud::insert("visit_service_reports", array_merge(array('visit_service_id'=>$this->post['id']), $this->post['reports']) );
            }
            unset($this->post['reports']);
        }
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