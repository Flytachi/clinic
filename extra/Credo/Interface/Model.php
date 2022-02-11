<?php

namespace Mixin;

interface ModelInterface
{
    public function setPost(Array $data);
    public function setGet(Array $data);
    public function setFiles(Array $data);
    public function getGet();
    public function getPost();
    public function getFiles();
    public function call(String $action = null, Array $get = null, Array $post = null, Array $files = null);
    public function saveBefore();
    public function saveBody();
    public function saveAfter();
    public function updateBefore();
    public function updateBody();
    public function updateAfter();
    public function deleteBefore();
    public function deleteBody();
    public function deleteAfter();
}

?>