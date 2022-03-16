<?php

namespace Mixin;

trait ModelSetter
{
    final public function setGet($data)
    {
        $this->get = $data;
    }

    final public function setPost($data)
    {
        $this->post = $data;
    }

    final public function setFiles($data)
    {
        $this->files = $data;
    }

    final public function setPostItem(String $item, $value = null)
    {
        $this->post[$item] = $value;
    }
}

trait ModelGetter
{
    final public function getGet(String $item = null)
    {
        return ($item == null) ? $this->get : $this->get[$item] ?? null;
    }

    final public function getPost(String $item = null)
    {
        return ($item == null) ? $this->post : $this->post[$item] ?? null;
    }

    final public function getFiles(String $item = null)
    {
        return ($item == null) ? $this->files : $this->files[$item] ?? null;
    }
}

trait ModelTSave
{
    public function saveBefore(){
        $this->db->beginTransaction();
        $this->cleanPost();
    }

    public function saveBody(){
        $object = HellCrud::insert($this->table, $this->getPost());
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
        $object = HellCrud::update($this->table, $this->getPost(), $this->getGet());
        if (!is_numeric($object) and $object <= 0) $this->error($object);
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
        $object = HellCrud::delete($this->table, $this->getGet()['id']);
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
        echo 1;
        exit;
    }

    public function error($message)
    {
        echo $message;
        if($this->db->inTransaction()) $this->db->rollBack();
        exit;
    }
}

trait ModelHook
{
    final public function urlHook()
    {
        return Hell::apiHook( array_merge( array("model" =>  get_class($this)), $this->getGet() ) );
    }
}

?>