<?php
    require_once '../../tools/warframe.php';

    function delete($tb, $pk){
        global $db;
        $stmt = $db->prepare("DELETE FROM $tb WHERE id = :id");
        $stmt->bindValue(':id', $pk);
        $stmt->execute();
        return $stmt->rowCount();

    }

    $id = $_GET['id'];

    delete('goods', $id );

    header("location: all_prep.php");