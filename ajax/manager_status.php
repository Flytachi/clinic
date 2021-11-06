<?php
require_once '../tools/warframe.php';
$session->is_auth(3);

if ( isset($_GET) ) {
    $post = Mixin\clean_form($_GET);
    $post = Mixin\to_null($post);
    $query = Mixin\update($post['table'], array('is_active' => $post['is_active']), $post['id']);
    echo $_GET['is_active'];
}
?>
