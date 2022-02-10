<?php

namespace Mixin;

/*abstract*/ 
class Cluster extends Credo implements ClusterInterface
{
    use ModelTrait, ClusterTraitResponce, ClusterTSave, ClusterTUpdate, ClusterTDelete;
    /**
     * 
     * Model + PDO
     * 
     * 
     * @version 12.0
     */

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

    public function call(Array $get = null, Array $post = null, Array $files = null, String $action = null)
    {
        if ($get != null) $this->setGet($get);
        if ($post != null) $this->setPost($post);
        if ($files != null) $this->setFiles($files);
        $this->action($action);
    }

    private function action(String $action = null){
        if ($action == "delete") $this->delete();
        elseif ($action == "save") $this->save();
        elseif ($action == "update") $this->update();
        else $this->error("NOT ACTION!");
    }

    private function clean()
    {
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
    }

    private function save(){
        $this->saveBefore();
        $this->saveBody();
        $this->saveAfter();
    }


    private function update(){
        $this->updateBefore();
        $this->updateBody();
        $this->updateAfter();
    }

    private function delete(){
        $this->deleteBefore();
        $this->deleteBody();
        $this->deleteAfter();
    }

}

?>