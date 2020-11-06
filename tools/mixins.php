<?php


// function FORM(){

// }

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
    $post = clean_arr($post);
    $col = implode(",", array_keys($post));
    $val = ":".implode(", :", array_keys($post));
    $sql = "INSERT INTO $tb ($col) VALUES ($val)";
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $stm;
    }
    catch (PDOException $ex) {
        return $ex->getMessage();
    }
}

function update($tb, $post, $pk)
{
    global $db;
    $post = clean_arr($post);
    $post = to_null($post);
    foreach (array_keys($post) as $key) {
        if (isset($col)) {
            $col .= ", ".$key."=:".$key;
        }else{
            $col = $key."=:".$key;
        }
    }
    $sql = "UPDATE $tb SET $col WHERE id = $pk";
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $stm;
    }
    catch (PDOException $ex) {
        return $ex->getMessage();
    }
}
