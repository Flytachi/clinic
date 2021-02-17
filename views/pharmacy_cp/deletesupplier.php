<?php

    require_once '../../tools/warframe.php';

    function delete($tb, $pk){
        global $db;
        $stmt = $db->prepare("DELETE FROM $tb WHERE suplier_id = :id");
        $stmt->bindValue(':id', $pk);
        $stmt->execute();
        return $stmt->rowCount();

    }

    $id = $_GET['id'];

    delete('supliers', $id );

    header("location: supplier.php");