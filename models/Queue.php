<?php

class Queue extends Model
{
    public $table = 'queue';

    public function form($pk = null)
    {
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
}

class QueueUp extends Queue
{
    public function clean()
    {
        global $db;
        if ($old = $db->query("SELECT id FROM queue WHERE room_id = {$this->post['room_id']} AND is_accept IS NOT NULL LIMIT 1")->fetchColumn()) {
            Mixin\update("queue", array('is_accept' => null, 'is_delete' => 1), $old);
        }
        Mixin\update("queue", array('is_queue' => null, 'is_accept' => 1), array('room_id' => $this->post['room_id'], 'user_id' => $this->post['user_id']));
    }
}
        
?>