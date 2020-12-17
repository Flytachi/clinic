<?php
namespace Mixin;

function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function clean_form($array){
    foreach ($array as $key => $value) {
        $array[$key] = clean($value);
    };
    return $array;
}

function to_null($post){
    foreach ($post as $key => $value) {
        if(!$value){
            $post[$key] = null;
        }
    }
    return $post;
}

function insert($tb, $post)
{
    global $db;
    $col = implode(",", array_keys($post));
    $val = ":".implode(", :", array_keys($post));
    $sql = "INSERT INTO $tb ($col) VALUES ($val)";
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $db->lastInsertId();
    }
    catch (\PDOException $ex) {
        return $ex->getMessage();
    }
}

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
    if (is_array($pk)) {
        foreach ($pk as $key => $value) {
            if (isset($filter)) {
                $filter .= ", ".$key."=".$value;
            }else{
                $filter = $key."=".$value;
            }
        }
        $sql = "UPDATE $tb SET $col WHERE $filter";
    }else {
        $sql = "UPDATE $tb SET $col WHERE id = $pk";
    }
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $stm;
    }
    catch (\PDOException $ex) {
        return $ex->getMessage();
    }
}

function updatePro($tb, $post, $pk)
{
    global $db;
    foreach (array_keys($post) as $key) {
        if (isset($col)) {
            $col .= ", ".$key."=:".$key;
        }else{
            $col = $key."=:".$key;
        }
    }
    foreach ($pk as $key => $value) {
        if (isset($filter)) {
            $filter .= ", ".$key."=".$value;
        }else{
            $filter = $key."=".$value;
        }
    }
    $sql = "UPDATE $tb SET $col WHERE $filter";
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $stm;
    }
    catch (\PDOException $ex) {
        return $ex->getMessage();
    }
}

function delete($tb, $pk){
    global $db;
    $stmt = $db->prepare("DELETE FROM $tb WHERE id = :id");
    $stmt->bindValue(':id', $pk);
    $stmt->execute();
    return $stmt->rowCount();

}

function error($url){
    header("location:".DIR."/error/$url.php");
    exit;
}
