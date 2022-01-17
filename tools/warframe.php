<?php

require_once dirname(__FILE__).'/temp.php';
require_once dirname(__DIR__).'/extra/warframe.php';
require_once dirname(__FILE__).'/constants.php';
require_once dirname(__FILE__).'/functions.php';
require_once dirname(__FILE__).'/classes.php';

new Connect;
$session = new MySession($db, ini['GLOBAL_SETTING']['SESSION_LIFE']);

function module($branch, $value = null)
{
    global $db, $session;
    $mark = "module_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            return $db->query("SELECT const_value FROM corp_constants WHERE branch_id = $branch AND const_label = '$mark$value'")->fetchColumn();
        } else {
            foreach ($db->query("SELECT * FROM corp_constants WHERE branch_id = $branch AND const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

function config($branch, $value = null, $group = null)
{
    global $db;
    $mark = "constant_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            if ($group) {
                foreach ($db->query("SELECT * FROM corp_constants WHERE branch_id = $branch AND const_label LIKE '$mark$value%'") as $row) {
                    $modules[$row['const_label']] = $row['const_value'];
                }
                return $modules;
            } else {
                return $db->query("SELECT const_value FROM corp_constants WHERE branch_id = $branch AND const_label = '$mark$value'")->fetchColumn();
            }
            
        } else {
            foreach ($db->query("SELECT * FROM corp_constants WHERE branch_id = $branch AND const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

// Module 
if ($_SESSION and isset($_SESSION['session_branch'])) {
    if (!module($_SESSION['session_branch'], 'diagnostic')) unset($PERSONAL[12]);
    if (!module($_SESSION['session_branch'], 'laboratory')) unset($PERSONAL[13]);
    if (!module($_SESSION['session_branch'], 'physio')) unset($PERSONAL[14]);
    if (!module($_SESSION['session_branch'], 'pharmacy')) unset($PERSONAL[24]);
    if (!module($_SESSION['session_branch'], 'anesthesia')) unset($PERSONAL[15]);
}
?>
