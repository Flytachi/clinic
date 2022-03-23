<?php

try {
    
    include 'Include/Hell.php';
    include 'Include/Crud.php';
    include 'Include/Table.php';

} catch (\Throwable $th) {
    dieConnection($th); 
}

?>