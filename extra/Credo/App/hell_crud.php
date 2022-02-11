<?php

namespace Mixin;

class HellCrud
{
    static function clean($value = "") {
        if (!is_array($value)) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
        }
        return $value;
    }

    static function clean_form(Array $array){
        foreach ($array as $key => $value) {
            $array[$key] = HellCrud::clean($value);
        };
        return $array;
    }

    static function to_null(Array $array){
        foreach ($array as $key => $value) {
            if(!$value){
                $array[$key] = null;
            }
        }
        return $array;
    }
    
    static function insert($tb, $post){
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
    
    static function insert_or_update($tb, $post, $name_pk = null, $defwhere = null){
        global $db;
    
        $table_an_exception = array(
            "sessions",
            "corp_constants",
        );
        $lb = ($name_pk) ? $name_pk : "id";
    
    
        if (isset($post[$lb]) and $post[$lb]) {
            // connect
            $pk = $post[$lb];
            unset($post[$lb]);
            $where = "$lb = $pk";
            
            if ($name_pk and !is_int($pk)) {
                $where = "$lb = \"$pk\"";
            }
    
            if ($defwhere) {
                $defwhere = "AND $defwhere";
            }
    
            if (!in_array($tb, $table_an_exception)) {
                $pc = $db->query("SELECT id FROM $tb WHERE $where $defwhere")->fetchColumn();
            }else{
                $pc = $db->query("SELECT $lb FROM $tb WHERE $where $defwhere")->fetchColumn();
            }
            
            // select
            if ($pc) {
                // update
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
                            $filter .= " AND ".$key."=".$value;
                        }else{
                            $filter = $key."=".$value;
                        }
                    }
                    $sql = "UPDATE $tb SET $col WHERE $filter";
                }else {
                    $sql = "UPDATE $tb SET $col WHERE ".$where;
                }
                try{
                    $stm = $db->prepare($sql)->execute($post);
                    return $pc;
                }
                catch (\PDOException $ex) {
                    return $ex->getMessage();
                }
            } else {
                // insert
                global $db;
                $post[$lb] = $pk;
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
    
        } else {
            // insert
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
    }
    
    static function update(string $tb, array $post, $pk)
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
                if (is_array($value)) {
                    if (isset($filter)) {
                        $filter .= " AND ".$key." IN (".implode(',', $value).")";
                    }else{
                        $filter = $key." IN (".implode(',', $value).")";
                    }
                } else {
                    if (isset($filter)) {
                        $filter .= " AND ".$key."=".$value;
                    }else{
                        $filter = $key."=".$value;
                    }
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
    
    static function delete($tb, $pk, $name_pk = null){
        global $db;
        $name_pk = ($name_pk) ? $name_pk : "id";
        $stmt = $db->prepare("DELETE FROM $tb WHERE $name_pk = :item");
        $stmt->bindValue(':item', $pk);
        $stmt->execute();
        return $stmt->rowCount();
    
    }
}

?>