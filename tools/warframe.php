<?php

include dirname(__FILE__).'/temp.php';
require dirname(__DIR__).'/extra/warframe.php';

// Подключение Моделей
if (is_dir(dirname(__DIR__)."/model_old")) foreach (getDirContent(dirname(__DIR__)."/model_old/") as $filename) require_once $filename;
//


include dirname(__FILE__).'/libs/lib.php';
include dirname(__FILE__).'/constants.php';
include dirname(__FILE__).'/functions.php';
include dirname(__FILE__).'/classes.php';
include dirname(__FILE__).'/mixin.php';

date_default_timezone_set(ini['GLOBAL_SETTING']['TIME_ZONE']);

new Connect;
$session = new MySession($db, ini['GLOBAL_SETTING']['SESSION_LIFE']);

if (!module('module_pharmacy')) unset($PERSONAL[4]);
if (!module('module_laboratory')) unset($PERSONAL[6]);
if (!module('module_diet')) unset($PERSONAL[9]);
if (!module('module_diagnostic')) unset($PERSONAL[10]);
if (!module('module_physio')) unset($PERSONAL[12]);

?>