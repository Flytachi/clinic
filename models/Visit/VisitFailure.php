<?php

class VisitFailure extends Model
{
    public $table = 'visit_services';
    public $_prices = 'visit_prices';
    public $_orders = 'visit_orders';
    public $_visits = 'visits';

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <div class="form-group row">

                    <input type="hidden" id="vis_id" name="id" value="">
                    <input type="hidden" name="status" value="5">

                    <div class="col-md-12">
                        <label>Причина:</label>
                        <textarea rows="4" cols="4" name="failure" class="form-control" placeholder="Введите причину ..." required></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button id="renouncement" onclick="deletPatient(this);" data-userid="" data-parentid="" type="submit" id="button_<?= __CLASS__ ?>" class="btn btn-outline-danger btn-sm">Отказаться</button>
            </div>

        </form>

        <script type="text/javascript">

            $('#<?= __CLASS__ ?>_form').submit(function (events) {
                events.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: $(this).serializeArray(),
                    success: function (result) {
                        console.log(result);
                        $('#modal_failure').modal('hide');
                        $(result.replace("1#", "#")).css("background-color", "rgb(244, 67, 54)");
                        $(result.replace("1#", "#")).css("color", "white");
                        $(result.replace("1#", "#")).fadeOut(900, function() {
                            $(this).remove();
                        });
                    },
                });
            });
        </script>
        <?php
    }

    // public function update()
    // {
    //     if($this->clean()){
    //         $pk = $this->post['id'];
    //         unset($this->post['id']);
    //         $object = Mixin\update($this->table, $this->post, $pk);
    //         if (!intval($object)){
    //             $this->error($object);
    //         }
    //         $this->success($pk);
    //     }
    // }

    // public function clean()
    // {
    //     global $db;
    //     $visit = $db->query("SELECT direction, bed_id FROM visit WHERE id = {$this->post['id']}")->fetch();
    //     if ($visit['direction']) {
    //         $form = new VisitModel;
    //         ob_start();
    //         $form->delete($this->post['id']);
    //         ob_clean();

    //         Mixin\delete('visit_analyze', $this->post['id'], 'visit_id');
    //         $this->success($this->post['id']);
    //     }else {
    //         $this->post = Mixin\clean_form($this->post);
    //         $this->post = Mixin\to_null($this->post);
    //         return True;
    //     }

    // }

    public function status_update($pk)
    {
        return (new VisitModel())->is_delete($pk);
    }

    public function delete(int $pk)
    {
        global $db, $session;
        $data = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch();
        $visit = $db->query("SELECT * FROM $this->_visits WHERE id = {$data['visit_id']}")->fetch();

        if ($visit['direction']) {

            # Стационар
            if ( $db->query("SELECT id FROM $this->_orders WHERE visit_id = {$visit['id']}")->fetchColumn() ) {
                    
                $this->error("Функция отказа стационара с ордером не сделана!");
                return 1;

            }

            if ($data['service_id'] == 1) {

                // Проверка прав
                if ( $visit['grant_id'] == $session->session_id ) {
            
                    $this->error("Функция отказа \"Полного стационара\" не сделана!");
                    return 1;
        
                }else {
                    $this->error("Отказано в доступе!");
                    return 1;
                }
                
            } else {
                
                // Проверка прав
                if ( in_array($data['status'], [2,3]) and ($data['parent_id'] == $session->session_id or $data['route_id'] == $session->session_id)) {
                    
                    $db->beginTransaction();
                    // Visit prices 
                    $object = Mixin\delete($this->_prices, $pk, "visit_service_id");
                    if(!intval($object)){
                        $this->error("Произошла ошибка на сервере!");
                        $db->rollBack();
                    }
                    // Visit service 
                    $object = Mixin\delete($this->table, $pk);
                    if(!intval($object)){
                        $this->error("Произошла ошибка на сервере!");
                        $db->rollBack();
                    }

                    $this->status_update($visit['id']);
                    
                    $db->commit();
                    $this->success($pk);
                    return 1;

                }else{
                    $this->error("Отказано в доступе!");
                    return 1;
                }
                
            }

        } else {

            // Абулатор
            if ( ( $session->session_id == $data['parent_id'] ) or ( ($data['level'] == 6 and permission(6)) ) or ( ($data['level'] == 12 and permission(12)) ) or permission([2, 32]) ) {
            
                // Is order
                if ( $db->query("SELECT id FROM $this->_orders WHERE visit_id = {$visit['id']}")->fetchColumn() ) {
                    
                    // Visit service 
                    $object = Mixin\delete($this->table, $pk);
                    if(!intval($object)){
                        $this->error("Произошла ошибка на сервере!");
                        $db->rollBack();
                    }

                    $this->status_update($visit['id']);
                    $this->success($pk);

                }else{

                    $object = Mixin\update($this->table, array('failure_id' => $session->session_id, 'status' => 5), $pk);
                    if (!intval($object)){
                        $this->error($object);
                    }
                    
                    $this->success($pk);

                }
                
    
            }else {
                $this->error("Отказано в доступе!");
                return 1;
            }

        }
        

    }

    public function success($pk = null)
    {
        echo json_encode(array(
            'status' => 'success', 
            'pk' => $pk
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => 'error', 
            'message' => $message
        ));
        exit;
    }

}

?>