<?php

// Extentions
ini_set('session.cookie_lifetime', 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', "SameSite");
ini_set('session.cache_limiter', "nocache");
ini_set('session.use_trans_sid', 0);
ini_set('session.sid_length', 48);
ini_set('session.sid_bits_per_character', 7);
ini_set('session.hash_function', "sha512");
ini_set('session.save_path', dirname(__DIR__)."/session");

// Extra
require_once dirname(__FILE__).'/Connection/__load__.php';
require_once dirname(__FILE__).'/Credo/__load__.php';
require_once dirname(__FILE__).'/functions/tag.php';
require_once dirname(__DIR__).'/libs/lib.php';

// Проверка сессий
if (!is_dir(dirname(__DIR__)."/session")) Mixin\Hell::error('403');

// Подключение Моделей
if (is_dir(dirname(__DIR__)."/model")) foreach (get_dir_contents(dirname(__DIR__)."/model/") as $filename) require_once $filename;

?>
