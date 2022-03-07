<?php

use Mixin\HellCrud;

require_once '../../tools/warframe.php';

HellCrud::delete("users", 15, 'user_level');

echo "success";
?>