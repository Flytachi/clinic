<?php

namespace Mixin;

trait ModelSetter
{
    public function setGet($data)
    {
        /**
         * Устанавливаем данные о записи!
         * GET
         */
        $this->get = $data;
    }

    public function setPost($data)
    {
        /**
         * Устанавливаем данные о записи!
         * POST
         */
        $this->post = $data;
    }

    public function setFiles($data)
    {
        /**
         * Устанавливаем данные о записи!
         * FILES
         */
        $this->files = $data;
    }
}

trait ModelGetter
{
    public function getGet()
    {
        /**
         * Данные о записи!
         * GET
         */
        return $this->get;
    }

    public function getPost()
    {
        /**
         * Данные о записи!
         * POST
         */
        return $this->post;
    }

    public function getFiles()
    {
        /**
         * Данные о записи!
         * FILES
         */
        return $this->files;
    }
}

trait ModelTSave
{
    public function saveBefore(){
        $this->db->beginTransaction();
        $this->cleanPost();
    }

    public function saveBody(){
        $object = HellCrud::insert($this->table, $this->post);
        if (!is_numeric($object)) $this->error($object);
    }

    public function saveAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ModelTUpdate
{
    public function updateBefore(){
        $this->db->beginTransaction();
        $this->cleanGet();
        $this->cleanPost();
    }

    public function updateBody(){
        $object = HellCrud::update($this->table, $this->post, $this->get);
        if (!$object) $this->error($object);
    }

    public function updateAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ModelTDelete
{
    public function deleteBefore(){
        $this->db->beginTransaction();
        $this->cleanGet();
    }

    public function deleteBody(){
        $object = HellCrud::delete($this->table,  $this->get['id']);
        if ($object <= 0) $this->error($object);
    }

    public function deleteAfter(){
        $this->db->commit();
        $this->success();
    }
}

trait ModelTResponce
{
    public function success()
    {
        /**
         * Действие в случае успеха операции!
         */
        echo 1;
        exit;
    }

    public function error($message)
    {
        /**
         * Действие в случае ошибки операции!
         * Возвращает ошибку!
         */
        echo $message;
        exit;
    }
}

?>