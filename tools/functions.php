<?php

/* 
    My Functions
*/

function module($value = null)
{
    global $db;
    $mark = "module_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            return $db->query("SELECT const_value FROM company_constants WHERE const_label = '$mark$value'")->fetchColumn();
        } else {
            foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

function config($value = null, $group = null)
{
    global $db;
    $mark = "constant_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            if ($group) {
                foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE '$mark$value%'") as $row) {
                    $modules[$row['const_label']] = $row['const_value'];
                }
                return $modules;
            } else {
                return $db->query("SELECT const_value FROM company_constants WHERE const_label = '$mark$value'")->fetchColumn();
            }
            
        } else {
            foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

function is_config($value = null){
    if (!config($value)) {
        Mixin\error('404');
    }
}

function is_module($value = null){
    if (!module($value)) {
        Mixin\error('404');
    }
}

// if (!module('module_pharmacy')) {
//     unset($PERSONAL[4]);
// }

// if (!module('module_laboratory')) {
//     unset($PERSONAL[6]);
// }

// if (!module('module_diet')) {
//     unset($PERSONAL[9]);
// }

// if (!module('module_diagnostic')) {
//     unset($PERSONAL[10]);
// }

// if (!module('module_physio')) {
//     unset($PERSONAL[12]);
// }

// Добавляет нули к числам, чьи значаения меньше пятизначных
function addZero($number){

    $max_item = 6;
    $strNumber = strval($number);
    $newNumber = "";

    if(strlen($strNumber) < $max_item){

        $countZero = $max_item - strlen($strNumber);

        for ($i=0; $i < $countZero; $i++) {

            $newNumber .= "0";
        }
        $newNumber .= $strNumber;
        return $newNumber;
    }

    return $strNumber;
}

function zeTTa_data()
{
    global $db, $session;
    $company = new stdClass();
    $data = new stdClass();
    $stmt = $db->query("SELECT pacs_login, pacs_password from users where id = $session->session_id")->fetch(PDO::FETCH_OBJ);
    $comp = $db->query("SELECT * FROM company_constants WHERE const_label LIKE 'constant_zetta_pacs_%'")->fetchAll(PDO::FETCH_OBJ);
    foreach ($comp as $value) {
        $company->{$value->const_label} = $value->const_value;
    }
    $data->IP = ( isset($company->constant_zetta_pacs_IP) ) ? $company->constant_zetta_pacs_IP : '';
    $data->LID = $stmt->pacs_login;
    $data->LPW = $stmt->pacs_password;
    $data->LICD = ( isset($company->constant_zetta_pacs_LICD) ) ? $company->constant_zetta_pacs_LICD : '';
    $data->VTYPE = ( isset($company->constant_zetta_pacs_VTYPE) ) ? $company->constant_zetta_pacs_VTYPE : '';
    return $data;
}

// Divisions
function division(Int $id = null) {
    global $db, $session;
    if (!$id) {
        return $session->get_division();
    } else {
        $pk = (Int) $db->query("SELECT division_id FROM users WHERE id = $id")->fetchColumn();
        try{
            $stmt = $db->query("SELECT id FROM divisions WHERE id = $pk")->fetchColumn();
        }
        catch (PDOException $ex) {
            $stmt = null;
        }
        return $stmt;
    }
    
}

function division_name($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT name FROM divisions WHERE id =".(int) division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}

function division_title($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT title FROM divisions WHERE id =".(int) division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}

function division_assist($id = null) {
    global $db;
    try{
        $stmt = $db->query("SELECT assist FROM divisions WHERE id =".(int) division($id))->fetchColumn();
    }
    catch (PDOException $ex) {
        $stmt = null;
    }
    return $stmt;
}
// END Divisions

function icd($pk = null, $title = 'code,decryption')
{
    global $db;
    if ($pk) {
        $stmt = $db->query("SELECT $title FROM international_classification_diseases WHERE id = $pk")->fetch();
    }else{
        $stmt = null;
    }
    return $stmt;
}
?>