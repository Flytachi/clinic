<?php

namespace Mixin;

class HellTable
{
    static function T_create(String $sql)
    {
        global $db;
        $db->exec($sql);
    }

}

?>