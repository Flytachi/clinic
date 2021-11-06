<?php


class VisitBypassEventsModel extends Model
{
    public $table = 'visit_bypass_events';
    public $_visit_bypass = 'visit_bypass';
    public $_ware_custom = 'warehouse_custom';
    public $_ware_orders = 'warehouse_orders';
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
        
        if ( date("Y-m-d H:i") >= $this->post['event_start'] ) {
            $this->error("Нет доступа к этой дате.");
        }
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
                        'branch_id' => $this->post['branch_id'],
                        'visit_id' => $this->post['visit_id'],
                        'visit_bypass_event_id' => $object,
                        'client_id' => $this->post['client_id'],
                        'item_name_id' => $item->item_name_id,
                    );

                    if ($item->warehouse_id == "order") {
                        // Orders
                        $where = "branch_id = {$this->post['branch_id']} AND item_die_date > CURRENT_DATE() AND item_name_id = $item->item_name_id";
                        $order = "item_die_date ASC";
                        if($item->item_manufacturer_id) $where .= " AND item_manufacturer_id = $item->item_manufacturer_id";
                        $qty = $item->item_qty;

                        foreach ((new Table($db, $this->_ware_orders))->where($where)->order_by($order)->get_table() as $source) {
                            $status = $source->item_qty >= $qty;
                            //
                            $post['warehouse_order'] = true;
                            $post['item_qty'] = ($status) ? $qty : $source->item_qty;
                            $post['item_manufacturer_id'] = $source->item_manufacturer_id;

                            Mixin\insert($this->_event_applications, $post);
                            unset($post['item_manufacturer_id']);
                            unset($post['item_qty']);
                            //
                            if(!$status) $qty -= $source->item_qty;
                            if($status) break;
                        }

                    } else {
                        // Custom
                        $where = "warehouse_id = $item->warehouse_id AND item_die_date > CURRENT_DATE() AND item_name_id = $item->item_name_id";
                        $order = "item_die_date ASC, item_price ASC";
                        if($item->item_manufacturer_id) $where .= " AND item_manufacturer_id = $item->item_manufacturer_id";
                        if($item->item_price) $where .= " AND item_price = $item->item_price";
                        $qty = $item->item_qty;

                        foreach ((new Table($db, $this->_ware_custom))->where($where)->order_by($order)->get_table() as $source) {
                            $status = $source->item_qty >= $qty;
                            //
                            $post['warehouse_id'] = $item->warehouse_id;
                            $post['item_qty'] = ($status) ? $qty : $source->item_qty;
                            $post['item_manufacturer_id'] = $source->item_manufacturer_id;
                            $post['item_price'] = $source->item_price;
                            
                            Mixin\insert($this->_event_applications, $post);
                            unset($post['item_manufacturer_id']);
                            unset($post['item_price']);
                            unset($post['item_qty']);
                            //
                            if(!$status) $qty -= $source->item_qty;
                            if($status) break;
                        }

                    }
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
        exit;
    }
    
}


class VisitBypassEventsApplication extends VisitBypassEventsModel
{
    public function delete(int $pk)
    {
        global $db;
        Mixin\delete($this->_event_applications, $pk, "visit_bypass_event_id");
        $this->success("success");

    }
}

        
?>