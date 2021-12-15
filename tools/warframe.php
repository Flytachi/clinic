<?php

require_once dirname(__FILE__).'/temp.php';
require_once dirname(__DIR__).'/extra/warframe.php';
require_once dirname(__FILE__).'/constant.php';
require_once dirname(__FILE__).'/functions.php';
require_once dirname(__FILE__).'/classes.php';

$session = new MySession($db, $ini['GLOBAL_SETTING']['SESSION_LIFE']);

function module($value = null)
{
    global $db;
    $mark = "module_";
    try {
        if ($value) {
            $value = str_replace($mark, '', $value);
            return $db->query("SELECT const_value FROM corp_constants WHERE const_label = '$mark$value'")->fetchColumn();
        } else {
            foreach ($db->query("SELECT * FROM corp_constants WHERE const_label LIKE '$mark%'") as $row) {
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
                foreach ($db->query("SELECT * FROM corp_constants WHERE const_label LIKE '$mark$value%'") as $row) {
                    $modules[$row['const_label']] = $row['const_value'];
                }
                return $modules;
            } else {
                return $db->query("SELECT const_value FROM corp_constants WHERE const_label = '$mark$value'")->fetchColumn();
            }
            
        } else {
            foreach ($db->query("SELECT * FROM corp_constants WHERE const_label LIKE '$mark%'") as $row) {
                $modules[$row['const_label']] = $row['const_value'];
            }
            return $modules;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}

// Module 
if (!module('diagnostic')) unset($PERSONAL[12]);
if (!module('laboratory')) unset($PERSONAL[13]);
if (!module('physio')) unset($PERSONAL[14]);
if (!module('pharmacy')) unset($PERSONAL[24]);
if (!module('anesthesia')) unset($PERSONAL[15]);
?>
