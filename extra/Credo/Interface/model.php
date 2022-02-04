<?php

namespace Mixin;

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

?>