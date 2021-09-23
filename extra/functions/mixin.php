<?php
namespace Mixin;


function array_to_ini(array $a, array $parent = array())
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
            $out .= array_to_ini($v, $sec);
        }
        else
        {
            //plain key->value case
            $out .= "$k=$v" . PHP_EOL;
        }
    }
    return $out;
}

function clean($value = "") {
    if (!is_array($value)) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
    }
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

function insert_or_update($tb, $post, $name_pk = null, $defwhere = null)
{
    global $db;

    $table_an_exception = array(
        "sessions",
        "company_constants",
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

function update(string $tb, array $post, $pk)
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

function delete($tb, $pk, $name_pk = null){
    global $db;
    $name_pk = ($name_pk) ? $name_pk : "id";
    $stmt = $db->prepare("DELETE FROM $tb WHERE $name_pk = :item");
    $stmt->bindValue(':item', $pk);
    $stmt->execute();
    return $stmt->rowCount();

}

function error($url){
    header("location:".DIR."/error/$url".EXT);
    exit;
}

function T_create($sql)
{
    global $db;
    $db->exec($sql);
}

function T_flush($table)
{
    global $db;
    $db->exec("TRUNCATE TABLE $table;");
}

function T_DELETE_database()
{
    global $db, $ini;

    try {
        $db->beginTransaction();

        foreach ($db->query("SHOW TABlES") as $table) {
            $db->exec("DROP TABLE ". $table['Tables_in_'.$ini['DATABASE']['NAME']]);
        }

        $db->commit();
        return 200;
    } catch (\Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }

}

function T_FLUSH_database()
{
    global $db, $ini;

    try {
        $db->beginTransaction();

        foreach ($db->query("SHOW TABlES") as $table) {
            if ($table['Tables_in_'.$ini['DATABASE']['NAME']] != "sessions") {
                T_flush($table['Tables_in_'.$ini['DATABASE']['NAME']]);
            }
        }

        $db->commit();
        return 200;
    } catch (\Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }

}

function T_INITIALIZE_database($data)
{
    global $db;
    try {
        $db->beginTransaction();
        foreach ($data as $table_sql) {
            $db->exec($table_sql);
        }
        $db->commit();
        return 200;
    } catch (\Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

?>
