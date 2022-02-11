<?php

namespace Mixin;

abstract class Model extends Credo implements ModelInterface
{
    /**
     * 
     * Model
     * 
     * @version 15.0
     */

    private $get = [];
    private $post = [];
    private $files = [];
    protected $table = '';

    use 
        ModelSetter, 
        ModelGetter,
        ModelTSave, 
        ModelTUpdate, 
        ModelTDelete,
        ModelTResponce,
        ModelHook;


    public function call(String $action = null, Array $get = null, Array $post = null, Array $files = null)
    {
        if ($get != null) $this->setGet($get);
        if ($post != null) $this->setPost($post);
        if ($files != null) $this->setFiles($files);
        $this->action($action);
    }

    private function action(String $action = null){
        if ($action == "get") $this->getElement();
        elseif ($action == "save") $this->save();
        elseif ($action == "delete") $this->delete();
        elseif ($action == "update") $this->update();
        else $this->error("NOT ACTION!");
    }

    private function getElement()
    {
        $object = $this->byId($this->get['id']);
        if ($object) {

            if(isset($this->get['form'])) {

                $this->setPost($object);
                $form = $this->get['form'];
                unset($this->get['form']);
                if (method_exists(get_class($this), $form)) $this->{$form}();
                else Hell::error("403");

            }else echo json_encode($object);

        } else Hell::error("404");
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

    private function cleanGet()
    {
        $this->get = HellCrud::clean_form($this->get);
        $this->get = HellCrud::to_null($this->get);
    }

    private function cleanPost()
    {
        $this->post = HellCrud::clean_form($this->post);
        $this->post = HellCrud::to_null($this->post);
    }

    protected function value(String $column = null)
    {
        return (isset($this->getPost()->{$column})) ? $this->getPost()->{$column} : null;
    }

    private function stop()
    {
        /**
         * Остановка операции!
         */
        exit;
    }

    private function dd()
    {
        /**
         * Мод для тестов!
         */
        dd($this);
        exit;
    }

}

?>