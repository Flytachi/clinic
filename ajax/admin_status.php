<?php

use Mixin\HellCrud;

require_once '../tools/warframe.php';
$session->is_auth(1);

if ( isset($_GET) ) {
    $post = HellCrud::clean_form($_GET);
    $post = HellCrud::to_null($post);
    $query = HellCrud::update($post['table'], array('is_active' => $post['is_active']), $post['id']);
    echo $_GET['is_active'];
}
?>
