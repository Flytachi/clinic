<?php

// Extra
require_once dirname(__FILE__).'/Connection/__load__.php';
require_once dirname(__FILE__).'/Credo/__load__.php';
require_once dirname(__FILE__).'/functions/tag.php';

// Подключение Моделей
if (is_dir(dirname(__DIR__)."/model")) foreach (get_dir_contents(dirname(__DIR__)."/model/") as $filename) require_once $filename;
?>
