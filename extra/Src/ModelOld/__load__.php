<?php

try {
    include 'Include/Model.php';
} catch (\Throwable $th) {
    dieConnection($th); 
}

?>