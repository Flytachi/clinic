<?php
function module($value = null)
{
    global $db;
    if ($value) {
        return $db->query("SELECT const_value FROM company WHERE const_label = '$value'")->fetchColumn();
    } else {
        foreach ($db->query("SELECT * FROM company WHERE const_label LIKE 'module_%'") as $row) {
            $modules[$row['const_label']] = $row['const_value'];
        }
        return $modules;
    }

}

function is_module($value = null){
    if (!module($value)) {
        Mixin\error('404');
    }
}

if (!module('module_laboratory')) {
    unset($PERSONAL[6]);
}
?>