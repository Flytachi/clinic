<?php

require_once dirname(__FILE__).'/temp.php';
require_once dirname(__DIR__).'/extra/warframe.php';
require_once dirname(__FILE__).'/constant.php';
require_once dirname(__FILE__).'/functions.php';
require_once dirname(__FILE__).'/classes.php';

$session = new MySession($db, $ini['GLOBAL_SETTING']['SESSION_LIFE']); 
?>
