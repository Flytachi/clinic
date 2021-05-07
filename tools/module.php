<?php
function module($value = null)
{
    global $db;
    try {
        if ($value) {
            return $db->query("SELECT const_value FROM company_constants WHERE const_label = '$value'")->fetchColumn();
        } else {
            foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE 'module_%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

// function module($value = null)
// {
//     global $db;
//     $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//     try {
//         if ($value) {
//             $module = $db->query("SELECT const_value FROM company_constants WHERE const_label = '$value'")->fetchColumn();
//             $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//             return $module;
//         } else {
//             foreach ($db->query("SELECT * FROM company_constants WHERE const_label LIKE 'module_%'") as $row) {
//                 $modules[$row->const_label] = $row->const_value;
//             }
//             $db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//             return $modules;
//         }
//     } catch (\Throwable $th) {
//         //throw $th;
//     }
// }

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