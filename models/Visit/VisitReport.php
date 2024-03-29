<?php

class VisitReport extends Model
{
    public $table = 'visit';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">

                <div class="col-md-4 offset-md-8">
                    <select data-placeholder="Выбрать пациента" class="form-control form-control-select2" onchange="ChangePack(this)">
                        <option value="0">Шаблоны</option>
                        <?php foreach ($db->query("SELECT * FROM templates WHERE autor_id = {$_SESSION['session_id']} ORDER BY name DESC") as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <h1>
                    <div class="col-md-8 offset-md-2">
                        <input type="text" style="font-size:1.3rem;" name="report_title" value="<?= ($post['report_title']) ? $post['report_title'] : $post['name'] ?>" class="form-control" placeholder="Названия отчета">
                    </div>
                </h1>
                
                <div id="document_<?= __CLASS__ ?>">

                    <div class="document-editor">
                        <div class="document-editor__toolbar"></div>
                        <div class="document-editor__editable-container">
                            <div class="document-editor__editable" id="document-editor__editable_template">
                                <?= ($post['report']) ? $post['report'] : "<br><strong>Рекомендация:</strong>" ?>
                            </div>
                        </div>
                    </div>

                    <textarea id="document-editor__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

                    <script>
                        DecoupledEditor
                            .create( document.querySelector( '.document-editor__editable' ))
                            .then( editor => {
                                const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
                                const textarea = document.querySelector('#document-editor__area');

                                toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                                window.editor = editor;

                                editor.model.document.on( 'change:data', ( evt, data ) => {
                                    console.log( data );
                                    textarea.value = editor.getData();
                                } );
                            } )
                            .catch( err => {
                                console.error( err );
                            } 
                        );
                    </script>

                </div>

            </div>

            <div class="modal-footer">
                <?php if (permission(10)): ?>
                    <?php if (division_assist() == 2): ?>
                        <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                    <?php endif; ?>
                    <input style="display:none;" id="btn_end_submit" type="submit" value="Завершить" name="end" id="end"></input>
                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="Verification()">Завершить</button>
                    <script type="text/javascript">
                        function Verification() {
                            event.preventDefault();

                            if ($('#editor').html() == `<p><br data-cke-filler="true"></p>`) {
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
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end" id="end"></input>
                <?php else: ?>
                    <button type="submit" class="btn btn-outline-info btn-sm" id="submit">Сохранить</button>
                <?php endif; ?>
            </div>

        </form>
        <script>
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
            document.getElementById( 'submit' ).onclick = () => {
                textarea.value = editor.getData();
            }
        </script>
        <?php if (permission([10,12,13])): ?>
        <script type="text/javascript">
            document.getElementById( 'end' ).onclick = () => {
                textarea.value = editor.getData();
            }
        </script>
        <?php endif; ?>
        <?php
    }

    public function form_finish($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">
                <input type="hidden" name="report_title" value="<?= $post['name'] ?>">

                <div class="document-editor2">
                    <div class="document-editor2__toolbar"></div>
                    <div class="document-editor2__editable-container">
                        <div class="document-editor2__editable">
                            <?php if ($post['report']): ?>
                                <?= $post['report'] ?>
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
                </div>

                <textarea id="document-editor2__area" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <?php if (level() == 10): ?>
                    <!-- <a href="<?= up_url($_GET['user_id'], 'VisitFinish') ?>" onclick="return confirm('Вы точно хотите завершить визит пациента!')" class="btn btn-outline-danger">Завершить</a> -->
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <?php endif; ?>
                <button type="submit" class="btn btn-outline-info btn-sm" id="submit">Сохранить</button>
            </div>

        </form>
        <script>
            DecoupledEditor
                .create( document.querySelector( '.document-editor2__editable' ))
                .then( editor => {
                    const toolbarContainer = document.querySelector( '.document-editor2__toolbar' );
                    const textarea2 = document.querySelector('#document-editor2__area');

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    window.editor = editor;

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        textarea2.value = editor.getData();
                    } );
                } )
                .catch( err => {
                    console.error( err );
                } 
            );
            document.getElementById( 'submit' ).onclick = () => {
                textarea2.value = editor.getData();
            }
        </script>
        <?php
    }

    public function get_or_404($pk)
    {
        global $db;
        $object = $db->query("SELECT vs.*, sc.name FROM $this->table vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.id = $pk")->fetch();
        if(division_assist() == 2){
            if ($object['parent_id'] = $object['assist_id'] or $object['parent_id'] == $_SESSION['session_id']) {
                if($object){
                    $this->set_post($object);
                    return $this->form($object['id']);
                }else{
                    Mixin\error('404');
                }
            }else {
                Mixin\error('404');
            }
        }else {
            if($object){
                $this->set_post($object);
                if ($object['service_id'] == 1) {
                    return $this->form_finish($object['id']);
                }else {
                    return $this->form($object['id']);
                }
            }else{
                Mixin\error('404');
            }
        }
    }

    public function update()
    {
        global $db;
        $end = ($this->post['end']) ? true : false;
        unset($this->post['end']);
        if($this->clean()){
            $db->beginTransaction();
            $pk = $this->post['id']; unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if ($end) {
                $row = $db->query("SELECT * FROM visit WHERE id = {$pk}")->fetch();
                if ($row['assist_id']) {
                    if ($row['grant_id'] != $row['route_id'] or !$db->query("SELECT * FROM visit WHERE id != {$pk} AND user_id = {$row['user_id']} AND completed IS NULL")->fetchColumn()) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }else {
                    if ($row['grant_id'] == $row['parent_id'] and 1 == $db->query("SELECT * FROM visit WHERE user_id={$row['user_id']} AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }
                $this->clear_post();
                $this->set_post(array(
                    'status' => ($row['direction']) ? 0 : null,
                    'completed' => date('Y-m-d H:i:s')
                ));
                $object = Mixin\update($this->table, $this->post, $pk);
                if (!intval($object)){
                    $this->error($object);
                }
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
        render();
    }

}

?>