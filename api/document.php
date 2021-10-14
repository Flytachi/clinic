<?php
include '../tools/warframe.php';

if ( !function_exists( 'hex2bin' ) ) {
    $url = sodium_hex2bin($_GET['code']);
    unset($_GET['code']);
    $data = url_to_array($url);
    foreach ($data['get'] as $key => $value) $_GET[$key] = $value;
    include "../prints/{$data['url']}.php";
}else{
    Mixin\error('403');
}
?>