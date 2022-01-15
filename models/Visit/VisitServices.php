<?php

class VisitServicesModel extends Model
{
    public $table = 'visit_services';
    public $_visits = 'visits';
    public $_transactions = 'visit_service_transactions';

    public function clean()
    {
        if ( isset($this->post['service_report']) ) {
            $report = $this->post['service_report'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ( isset($report) ) {
            $this->post['service_report'] = $report;
        }
        return True;
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            if (is_array($pk)) {
                foreach ($pk as $pkis) {
                    $object = Mixin\update($this->table, $this->post, $pkis);
                    if (!intval($object)){
                        $this->error($object);
                        exit;
                    }
                }
            } else {
                $object = Mixin\update($this->table, $this->post, $pk);
                if (!intval($object)){
                    $this->error($object);
                    exit;
                }
            }
            $this->pk = $pk;
            $this->success();
        }
    }

    public function delete(int $pk)
    {
        global $db, $session;
        $data = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch();
        $this->visit_pk = $data['visit_id'];

        if ($this->visit_pk) {
            $visit = $db->query("SELECT * FROM $this->_visits WHERE id = $this->visit_pk")->fetch();
            
            // --------------------------------
            // Права амбулаторного удаления
            $permission_amb = $data['status'] == 1 && permission([32, 3]) | (permission(5) && $data['route_id'] == $session->session_id);
            // Права стационарного удаления
            $permission_sta = $data['status'] == 2 && ($visit['grant_id'] == $session->session_id | $data['route_id'] == $session->session_id);
            // --------------------------------

            // Права распределенние
            $permission = ($visit['direction']) ? $permission_sta : $permission_amb;

            // Контроллер
            if ( $permission ) {

                // Начало Транкзации
                $db->beginTransaction();
                // Visit prices 
                $object = Mixin\delete($this->_transactions, $pk, "visit_service_id");
                if(!intval($object)){
                    $this->error("Произошла ошибка на сервере!");
                    $db->rollBack();
                    exit;
                }
                // Visit service 
                $object = Mixin\delete($this->table, $pk);
                if(!intval($object)){
                    $this->error("Произошла ошибка на сервере!");
                    $db->rollBack();
                    exit;
                }

                $this->status_update();
                
                $db->commit();
                $this->success($db->query("SELECT * FROM $this->table WHERE visit_id = $this->visit_pk AND status = 1")->rowCount());
                // Конец Транкзации

            }else {
                $this->error("Отказано в доступе!");
                exit;
            }

        }else {
            $this->error("Невозможно удалить!");
            exit;
        }

    }

    public function status_update()
    {
        return (new VisitModel())->is_delete($this->visit_pk);
    }

    public function success($stat = null)
    {
        $mess = 'Успешно';
        echo json_encode(array(
            'status' => 'success',
            'count' => $stat,
            'visit_pk' => ( isset($this->visit_pk) ) ? $this->visit_pk : null,
            'pk' => ( isset($this->pk) ) ? $this->pk : null,
            'message' => $mess,
        ));
        exit;
    }

    public function error($message)
    {
        // $mess = '<div class="alert bg-danger alert-styled-left alert-dismissible">
        //     <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        //     <span class="font-weight-semibold"> '.$message.'</span>
        // </div>';

        $mess = $message;
        echo json_encode(array(
            'status' => 'error',
            'message' => $mess,
        ));
        exit;
    }
}


class VisitServiceUp extends VisitServicesModel
{
    public function clean()
    {
        if (module('queue')) $this->queue();
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function queue()
    {
        global $db, $session;
        if (isset($this->post['queue_user']) and $this->post['queue_user']) {
            $user_id = $this->post['queue_user']; unset($this->post['queue_user']);
        }else $user_id = $db->query("SELECT user_id FROM visit_services WHERE id = {$this->post['id']}")->fetchColumn();
        if ($old = $db->query("SELECT id FROM queue WHERE room_id = {$session->data->room_id} AND is_accept IS NOT NULL LIMIT 1")->fetchColumn()) {
            Mixin\update("queue", array('is_accept' => null, 'is_delete' => 1), $old);
        }
        Mixin\update("queue", array('is_queue' => null, 'is_accept' => 1), array('room_id' => $session->data->room_id, 'user_id' => $user_id));
    }
}
        
?>