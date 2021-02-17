<?php
    namespace Mixin;
    
    require_once '../../tools/warframe.php';

    $id = $_GET['id'];

    delete('customer', $id );

    header("location: customer.php");