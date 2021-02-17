<?php

    require_once '../../tools/warframe.php';

    function update($tb, $post, $pk)
    {
        global $db;
        foreach (array_keys($post) as $key) {
            if (isset($col)) {
                $col .= ", ".$key."=:".$key;
            }else{
                $col = $key."=:".$key;
            }
        }
        $sql = "UPDATE $tb SET $col WHERE suplier_id = $pk";
        // echo $sql;
        try{
            $stm = $db->prepare($sql)->execute($post);
            return $stm;
        }
        catch (\PDOException $ex) {
            return $ex->getMessage();
        }
    }

    $id = $_POST['id'];

    var_dump($_POST);

    unset($_POST['id']);

    update('supliers', $_POST, $id );

    header("location: supplier.php");