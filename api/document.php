<?php
include '../tools/warframe.php';

try {
    $url = sodium_hex2bin($_GET['code']);
    unset($_GET['code']);
    $data = url_to_array($url);
    foreach ($data['get'] as $key => $value) $_GET[$key] = $value;
    include "../prints/{$data['url']}.php";
} catch (\Throwable $e) {
    dd($e);
    // Mixin\error('403');
}
?>