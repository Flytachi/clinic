<?php
require_once '../tools/warframe.php';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $_SERVER['HTTP_HOST'].prints("document-1")."?id={$_GET['pk']}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
?>