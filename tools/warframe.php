<?php

// Extentions
ini_set('session.sid_length', 48);
ini_set('session.sid_bits_per_character', 7);
ini_set('session.use_trans_sid', 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_lifetime', 0);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', "SameSite");
ini_set('session.cache_limiter', "nocache");
ini_set('session.hash_function', "sha512");
//

require_once dirname(__FILE__).'/temp.php';
require_once dirname(__DIR__).'/extra/warframe.php';


// Подключение Моделей
if (is_dir(dirname(__DIR__)."/model")) foreach (getDirContent(dirname(__DIR__)."/model/") as $filename) require_once $filename;
//


require_once dirname(__FILE__).'/libs/lib.php';
require_once dirname(__FILE__).'/constants.php';
require_once dirname(__FILE__).'/functions.php';
require_once dirname(__FILE__).'/classes.php';
require_once dirname(__FILE__).'/mixin.php';

date_default_timezone_set(ini['GLOBAL_SETTING']['TIME_ZONE']);

new Connect;
$session = new MySession($db, ini['GLOBAL_SETTING']['SESSION_LIFE']);

if (!module('module_pharmacy')) unset($PERSONAL[4]);
if (!module('module_laboratory')) unset($PERSONAL[6]);
if (!module('module_diet')) unset($PERSONAL[9]);
if (!module('module_diagnostic')) unset($PERSONAL[10]);
if (!module('module_physio')) unset($PERSONAL[12]);

?>