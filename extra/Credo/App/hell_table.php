<?php

namespace Mixin;

class HellTable
{
    static function T_create($sql)
    {
        global $db;
        $db->exec($sql);
    }

    static function T_flush($table)
    {
        global $db;
        $db->exec("TRUNCATE TABLE $table;");
    }

    static function T_DELETE_database()
    {
        global $db;
        foreach ($db->query("SHOW TABlES") as $table) $db->exec("DROP TABLE ". $table['Tables_in_'.ini['DATABASE']['NAME']]);
        return 200;
    }

    static function T_FLUSH_database()
    {
        global $db;

        foreach ($db->query("SHOW TABlES") as $table) {
            if ($table['Tables_in_'.ini['DATABASE']['NAME']] != "sessions") {
                HellTable::T_flush($table['Tables_in_'.ini['DATABASE']['NAME']]);
            }
        }
        return 200;
    }
}

?>