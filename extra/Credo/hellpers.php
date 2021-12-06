<?php

namespace Mixin;

class Hell
{
    static function error($url){
        if(explode('/', $_SERVER['PHP_SELF'])[1] != 'error'){
            header("location:".DIR."/error/$url".EXT);
            exit;
        }
    }

    static function array_to_ini(array $a, array $parent = array())
    {
        $out = '';
        foreach ($a as $k => $v)
        {
            if (is_array($v))
            {
                //subsection case
                $sec = array_merge((array) $parent, (array) $k);
                $out .= PHP_EOL;
                $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
                $out .= Hell::array_to_ini($v, $sec);
            }
            else
            {
                //plain key->value case
                $out .= "$k=$v" . PHP_EOL;
            }
        }
        return $out;
    }
}

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

    static function clean_form($array){
        foreach ($array as $key => $value) {
            $array[$key] = HellCrud::clean($value);
        };
        return $array;
    }

    static function to_null($post){
        foreach ($post as $key => $value) {
            if(!$value){
                $post[$key] = null;
            }
        }
        return $post;
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

class HellTable
{
    static function T_create($sql)
    {
        global $db;
        $db->exec($sql);
    }

    static function T_flush($table)
    {
        global $db;
        $db->exec("TRUNCATE TABLE $table;");
    }

    static function T_DELETE_database()
    {
        global $db, $ini;
        foreach ($db->query("SHOW TABlES") as $table) $db->exec("DROP TABLE ". $table['Tables_in_'.$ini['DATABASE']['NAME']]);
        return 200;
    }

    static function T_FLUSH_database()
    {
        global $db, $ini;

        foreach ($db->query("SHOW TABlES") as $table) {
            if ($table['Tables_in_'.$ini['DATABASE']['NAME']] != "sessions") {
                HellTable::T_flush($table['Tables_in_'.$ini['DATABASE']['NAME']]);
            }
        }
        return 200;
    }
}

?>