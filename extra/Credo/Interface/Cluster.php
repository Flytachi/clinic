<?php

namespace Mixin;

interface ClusterInterface
{
    public function setPost(Array $data);
    public function setGet(Array $data);
    public function setFiles(Array $data);
    public function getGet();
    public function getPost();
    public function getFiles();

    public function call(Array $get = null, Array $post = null, Array $files = null, String $action = null);
    // public function getElement(Int $pk);
    
    public function saveBefore();
    public function saveBody();
    public function saveAfter();
    // public function update();
    // public function deleteBefore();
    // public function deleteAfter();
    // public function fileDownload();
    // public function fileClean(String $row_name, $pk = null);
}

?>