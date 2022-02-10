<?php

namespace Mixin;

trait ClusterTraitResponce
{

    protected function success()
    {
        /**
         * Действие в случае успеха операции!
         */
        echo 1;
        exit;
    }

    protected function error($message)
    {
        /**
         * Действие в случае ошибки операции!
         * Возвращает ошибку!
         */
        echo $message;
        $this->db->rollBack();
    }
}

trait ClusterTSave
{
    public function saveBefore(){
        $this->db->beginTransaction();
        $this->clean();
        dd($this->db->isTransactionActive());
    }

    public function saveBody(){
        dd("2");
        $object = HellCrud::insert($this->table, $this->post);
        if (!is_numeric($object)) $this->error($object);
    }

    public function saveAfter(){
        dd("save");
        $this->db->commit();
        $this->success();
    }
}

trait ClusterTUpdate
{
    public function updateBefore(){
        $this->db->beginTransaction();
        $this->clean();
    }

    public function updateBody(){
        $object = HellCrud::update($this->table, $this->post, $this->get);
        if (!is_numeric($object)) $this->error($object);
    }

    public function updateAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ClusterTDelete
{
    public function deleteBefore(){
        $this->db->beginTransaction();
        $this->clean();
    }

    public function deleteBody(){
        $object = HellCrud::delete($this->table,  $this->get['id']);
        if (!$object) $this->error($object);
    }

    public function deleteAfter(){
        $this->db->commit();
        $this->success();
    }
}

?>