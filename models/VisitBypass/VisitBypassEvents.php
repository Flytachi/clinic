<?php

class VisitBypassEventsModel extends Model
{
    public $table = 'visit_bypass_events';
    public $_visit_bypass = 'visit_bypass';
    public $_event_applications = 'visit_bypass_event_applications';

    public function clean()
    {
        if ( isset($this->post['is_time']) ) {
            $is_time = $this->post['is_time']; 
            unset($this->post['is_time']);
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);

        if ( isset($is_time) ) {
            $this->post['event_start'] = ($is_time) ? date("Y-m-d H:i", $this->post['event_start']) : date("Y-m-d", $this->post['event_start']);
        }else {
            $this->post['event_start'] = ( isset($this->post['event_start']) and $this->post['event_start'] ) ? date("Y-m-d H:i", $this->post['event_start']) : null;
        }
        $this->post['event_end'] = ( isset($this->post['event_end']) and $this->post['event_end'] ) ? date("Y-m-d H:i", $this->post['event_end']) : null;
        return True;
    }

    public function save()
    {
        global $db;
        if($this->clean()){

            $db->beginTransaction();
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
                exit;
            }

            $bypass = (new Table($db, $this->_visit_bypass))->where("id = {$this->post['visit_bypass_id']}")->get_row();
            foreach (json_decode($bypass->items) as $item) {
                if( isset($item->item_name_id) ){
                    $post = array(
                        'visit_id' => $this->post['visit_id'],
                        'visit_bypass_event_id' => $object,
                        'user_id' => $this->post['user_id'],
                        'warehouse_id' => 4,
                        'item_name_id' => $item->item_name_id,
                        'item_manufacturer_id' => ($item->item_manufacturer_id) ? $item->item_manufacturer_id : null,
                        'item_supplier_id' => ($item->item_supplier_id) ? $item->item_supplier_id : null,
                        'item_qty' => $item->item_qty,
                    );

                    Mixin\insert($this->_event_applications, $post);
                    unset($post);
                }
            } 

            $db->commit();
            $this->success($object);

        }
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            $this->post['last_update'] = date("Y-m-d H:i:s");
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->success("success");
        }
    }

    public function delete(int $pk)
    {
        global $db;
        $db->beginTransaction();
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            Mixin\delete($this->_event_applications, $pk, "visit_bypass_event_id");
            $db->commit();
            $this->success("success");
        } else {
            $this->error("Не найден объект для удаления!");
            exit;
        }

    }

    public function success($pk = null)
    {
        echo $pk;
    }

    public function error($message)
    {
        echo $message;
    }
    
}
        
?>