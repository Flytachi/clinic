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

function insert_or_update($tb, $post)
{
    global $db;
    if ($post['id'] > 0) {
        // connect
        $pk = $post['id'];
        unset($post['id']);
        // select
        if ($db->query("SELECT id FROM $tb WHERE id = $pk")->fetchColumn()) {
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
        } else {
            // insert
            global $db;
            $post['id'] = $pk;
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

function T_FLUSH_database()
{
    global $db;

    try {
        $db->beginTransaction();
        T_flush('beds');
        T_flush('bed_type');
        T_flush('bypass');
        T_flush('bypass_date');
        T_flush('bypass_time');
        T_flush('bypass_preparat');
        T_flush('chat');
        T_flush('division');
        T_flush('guides');
        T_flush('investment');
        T_flush('laboratory_analyze');
        T_flush('laboratory_analyze_type');
        T_flush('members');
        T_flush('multi_accounts');
        T_flush('notes');
        T_flush('operation');
        T_flush('operation_inspection');
        T_flush('operation_member');
        T_flush('operation_stats');
        // Mixin\T_flush('province');
        // Mixin\T_flush('region');
        T_flush('service');

        T_flush('storage');
        T_flush('storage_home');
        T_flush('storage_orders');
        T_flush('storage_sales');

        T_flush('templates');
        T_flush('users');
        T_flush('user_card');
        T_flush('user_stats');
        T_flush('visit');
        T_flush('visit_price');
        T_flush('visit_inspection');
        T_flush('wards');
        $db->commit();
        return 200;
    } catch (Exception $e) {
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
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

?>
