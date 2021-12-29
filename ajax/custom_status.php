<?php
require_once '../tools/warframe.php';
$session->is_auth();

if ( isset($_GET) ) {
    $post = Mixin\clean_form($_GET);
    $post = Mixin\to_null($post);
    if (in_array($post['table'], ["package_services", "package_bypass"])) {
        $query = Mixin\update($post['table'], array('is_active' => $post['is_active']), $post['id']);
        echo $_GET['is_active'];
    }
}
?>
