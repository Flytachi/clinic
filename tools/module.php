<?php
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

function config($value = null)
{
    global $db;
    $mark = "constant_";
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

function is_module($value = null){
    if (!module($value)) {
        Mixin\error('404');
    }
}

if (!module('module_pharmacy')) {
    unset($PERSONAL[4]);
}

if (!module('module_laboratory')) {
    unset($PERSONAL[6]);
}

if (!module('module_diet')) {
    unset($PERSONAL[9]);
}

if (!module('module_diagnostic')) {
    unset($PERSONAL[10]);
}
?>