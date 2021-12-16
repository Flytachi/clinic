<?php

namespace Mixin;

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