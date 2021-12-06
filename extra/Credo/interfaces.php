<?php

namespace Mixin;

// Model

interface ModelInterface
{
    public function set_post($post);
    public function set_table($table);
    public function get_post();
    public function get_table();
    public function get_or_404(Int $pk);
    public function clear_post();
    public function save();
    public function update();
    public function delete(Int $pk);
    public function file_download();
    public function file_clean(String $row_name, $pk = null);
}

// Credo

interface CredoInterface
{
    public function byId(int $id);
    public function panel();
    public function list(Bool $counter = false);
    public function showError(Bool $status = false);
    public function returnPath(String $uri = null);
    public function Limit(Int $limit = 0);
    public function Data(String $context = "*");
    public function Join(String $context = null);
    public function Where(Mixed $context = null);
    public function Order(String $context = null);

    public function get();
    public function getId();
    public function getSql();
    public function getSearch();
}

?>