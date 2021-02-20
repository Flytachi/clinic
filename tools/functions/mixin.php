<?php
namespace Mixin;


function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function clean_form($array){
    foreach ($array as $key => $value) {
        $array[$key] = clean($value);
    };
    return $array;
}

function to_null($post){
    foreach ($post as $key => $value) {
        if(!$value){
            $post[$key] = null;
        }
    }
    return $post;
}

function insert($tb, $post)
{
    global $db;
    $col = implode(",", array_keys($post));
    $val = ":".implode(", :", array_keys($post));
    $sql = "INSERT INTO $tb ($col) VALUES ($val)";
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $db->lastInsertId();
    }
    catch (\PDOException $ex) {
        return $ex->getMessage();
    }
}

function insert_or_update($tb, $post)
{
    global $db;
    if ($post['id'] > 0) {
        // connect
        $pk = $post['id'];
        unset($post['id']);

        // select
        if ($db->query("SELECT id FROM $tb WHERE id = $pk")->fetchColumn()) {
            // update
            foreach (array_keys($post) as $key) {
                if (isset($col)) {
                    $col .= ", ".$key."=:".$key;
                }else{
                    $col = $key."=:".$key;
                }
            }
            if (is_array($pk)) {
                foreach ($pk as $key => $value) {
                    if (isset($filter)) {
                        $filter .= ", ".$key."=".$value;
                    }else{
                        $filter = $key."=".$value;
                    }
                }
                $sql = "UPDATE $tb SET $col WHERE $filter";
            }else {
                $sql = "UPDATE $tb SET $col WHERE id = $pk";
            }
            try{
                $stm = $db->prepare($sql)->execute($post);
                return $stm;
            }
            catch (\PDOException $ex) {
                return $ex->getMessage();
            }
        } else {
            // insert
            global $db;
            $col = implode(",", array_keys($post));
            $val = ":".implode(", :", array_keys($post));
            $sql = "INSERT INTO $tb ($col) VALUES ($val)";
            try{
                $stm = $db->prepare($sql)->execute($post);
                return $db->lastInsertId();
            }
            catch (\PDOException $ex) {
                return $ex->getMessage();
            }

        }

    } else {
        // insert
        global $db;
        $col = implode(",", array_keys($post));
        $val = ":".implode(", :", array_keys($post));
        $sql = "INSERT INTO $tb ($col) VALUES ($val)";
        try{
            $stm = $db->prepare($sql)->execute($post);
            return $db->lastInsertId();
        }
        catch (\PDOException $ex) {
            return $ex->getMessage();
        }

    }
}

function update($tb, $post, $pk)
{
    global $db;
    foreach (array_keys($post) as $key) {
        if (isset($col)) {
            $col .= ", ".$key."=:".$key;
        }else{
            $col = $key."=:".$key;
        }
    }
    if (is_array($pk)) {
        foreach ($pk as $key => $value) {
            if (isset($filter)) {
                $filter .= ", ".$key."=".$value;
            }else{
                $filter = $key."=".$value;
            }
        }
        $sql = "UPDATE $tb SET $col WHERE $filter";
    }else {
        $sql = "UPDATE $tb SET $col WHERE id = $pk";
    }
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $stm;
    }
    catch (\PDOException $ex) {
        return $ex->getMessage();
    }
}

function updatePro($tb, $post, $pk)
{
    global $db;
    foreach (array_keys($post) as $key) {
        if (isset($col)) {
            $col .= ", ".$key."=:".$key;
        }else{
            $col = $key."=:".$key;
        }
    }
    foreach ($pk as $key => $value) {
        if (isset($filter)) {
            $filter .= ", ".$key."=".$value;
        }else{
            $filter = $key."=".$value;
        }
    }
    $sql = "UPDATE $tb SET $col WHERE $filter";
    try{
        $stm = $db->prepare($sql)->execute($post);
        return $stm;
    }
    catch (\PDOException $ex) {
        return $ex->getMessage();
    }
}

function delete($tb, $pk){
    global $db;
    $stmt = $db->prepare("DELETE FROM $tb WHERE id = :id");
    $stmt->bindValue(':id', $pk);
    $stmt->execute();
    return $stmt->rowCount();

}

function error($url){
    header("location:".DIR."/error/$url".EXT);
    exit;
}

function T_create($sql)
{
    global $db;
    $db->exec($sql);
}

function T_flush($table)
{
    global $db;
    $db->exec("TRUNCATE TABLE $table;");
}

function T_FLUSH_database()
{
    global $db;

    try {
        $db->beginTransaction();
        T_flush('beds');
        T_flush('bed_type');
        T_flush('bypass');
        T_flush('bypass_date');
        T_flush('bypass_time');
        T_flush('bypass_preparat');
        T_flush('chat');
        T_flush('division');
        T_flush('guides');
        T_flush('investment');
        T_flush('laboratory_analyze');
        T_flush('laboratory_analyze_type');
        T_flush('members');
        T_flush('multi_accounts');
        T_flush('notes');
        T_flush('operation');
        T_flush('operation_inspection');
        T_flush('operation_member');
        T_flush('operation_stats');
        // Mixin\T_flush('province');
        // Mixin\T_flush('region');
        T_flush('service');

        T_flush('storage');
        T_flush('storage_home');
        T_flush('storage_orders');
        T_flush('storage_product_name');
        T_flush('storage_sales');
        T_flush('storage_supplier_name');

        T_flush('templates');
        T_flush('users');
        T_flush('user_card');
        T_flush('user_stats');
        T_flush('visit');
        T_flush('visit_price');
        T_flush('visit_inspection');
        T_flush('wards');
        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }

}

function T_INITIALIZE_database()
{
    global $db;
    try {
        $db->beginTransaction();

        $sql = <<<EOSQL
            CREATE TABLE IF NOT EXISTS `beds` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `ward_id` int(11) DEFAULT NULL,
                `bed` int(11) NOT NULL,
                `types` tinyint(1) DEFAULT 0,
                `user_id` int(11) DEFAULT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `bed` (`ward_id`,`bed`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `bed_type` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `price` decimal(35,0) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `bypass` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) DEFAULT NULL,
                `visit_id` int(11) DEFAULT NULL,
                `parent_id` int(11) DEFAULT NULL,
                `method` tinyint(4) DEFAULT NULL,
                `description` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `update_date` datetime DEFAULT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `bypass_date` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `bypass_id` int(11) DEFAULT NULL,
                `bypass_time_id` int(11) DEFAULT NULL,
                `parent_id` int(11) DEFAULT NULL,
                `custom_time` time DEFAULT NULL,
                `date` date NOT NULL,
                `comment` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `status` tinyint(1) DEFAULT NULL,
                `completed` tinyint(1) DEFAULT NULL,
                `add_date` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `bypass_preparat` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `bypass_id` int(11) DEFAULT NULL,
                `preparat_id` int(11) DEFAULT NULL,
                `add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `bypass_time` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `bypass_id` int(11) DEFAULT NULL,
                `time` time DEFAULT NULL,
                `add_date` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `chat` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_push` varchar(255) DEFAULT NULL,
                `id_pull` varchar(255) DEFAULT NULL,
                `message` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `date` varchar(255) DEFAULT NULL,
                `time` varchar(255) DEFAULT NULL,
                `activity` int(11) DEFAULT 0,
                `type_message` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

            CREATE TABLE IF NOT EXISTS `division` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `level` tinyint(4) DEFAULT NULL,
                `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `assist` tinyint(1) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `guides` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(350) COLLATE utf8mb4_unicode_ci NOT NULL,
                `price` decimal(65,1) DEFAULT 0.0,
                `share` float DEFAULT 0,
                `add_date` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `investment` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `pricer_id` int(11) DEFAULT NULL,
                `user_id` int(11) DEFAULT NULL,
                `balance_cash` decimal(65,1) NOT NULL DEFAULT 0.0,
                `balance_card` decimal(65,1) NOT NULL DEFAULT 0.0,
                `balance_transfer` decimal(65,1) NOT NULL DEFAULT 0.0,
                `status` tinyint(1) DEFAULT 1,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `laboratory_analyze` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) DEFAULT NULL,
                `visit_id` int(11) DEFAULT NULL,
                `service_id` int(11) DEFAULT NULL,
                `analyze_id` int(11) DEFAULT NULL,
                `result` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `deviation` tinyint(1) DEFAULT NULL,
                `description` varchar(300) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `laboratory_analyze_type` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `service_id` int(11) DEFAULT NULL,
                `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `standart` text NOT NULL,
                `unit` varchar(50) DEFAULT NULL,
                `status` tinyint(1) DEFAULT 1,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `members` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
                `price` decimal(65,1) NOT NULL DEFAULT 0.0,
                `add_date` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `multi_accounts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slot` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
                `user_id` int(11) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `notes` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `parent_id` int(11) DEFAULT NULL,
                `visit_id` int(11) DEFAULT NULL,
                `date_text` varchar(255) COLLATE utf8_bin NOT NULL,
                `description` varchar(255) COLLATE utf8_bin NOT NULL,
                `status` int(11) DEFAULT 0,
                `time_text` varchar(100) COLLATE utf8_bin NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

            CREATE TABLE IF NOT EXISTS `operation` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `visit_id` int(11) NOT NULL,
                `user_id` int(11) NOT NULL,
                `grant_id` int(11) DEFAULT NULL,
                `parent_id` int(11) DEFAULT NULL,
                `division_id` int(11) DEFAULT NULL,
                `service_id` int(11) DEFAULT NULL,
                `oper_date` datetime DEFAULT NULL,
                `add_date` datetime DEFAULT current_timestamp(),
                `priced_date` datetime DEFAULT NULL,
                `completed` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `operation_inspection` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `operation_id` int(11) NOT NULL,
                `parent_id` int(11) NOT NULL,
                `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                `diagnostic` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `recommendation` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL,
                `status` tinyint(1) DEFAULT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `operation_member` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `operation_id` int(11) NOT NULL,
                `member_id` int(11) NOT NULL,
                `status` tinyint(1) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `operation_stats` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `parent_id` int(11) DEFAULT NULL,
                `operation_id` int(11) DEFAULT NULL,
                `time` time NOT NULL,
                `pressure` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `pulse` smallint(11) DEFAULT NULL,
                `temperature` float DEFAULT NULL,
                `saturation` tinyint(4) DEFAULT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `province` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `region` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `province_id` int(11) NOT NULL,
                `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `service` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_level` tinyint(4) DEFAULT NULL,
                `division_id` int(11) DEFAULT NULL,
                `code` varchar(30) DEFAULT NULL,
                `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `price` decimal(65,1) DEFAULT NULL,
                `type` smallint(1) NOT NULL DEFAULT 1,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `storage` (
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `parent_id` int(11) NOT NULL,
                 `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `name` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `supplier` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `category` tinyint(4) DEFAULT NULL,
                 `qty` int(11) NOT NULL,
                 `qty_sold` int(11) NOT NULL DEFAULT 0,
                 `cost` decimal(65,1) NOT NULL DEFAULT 0.0,
                 `price` decimal(65,1) NOT NULL DEFAULT 0.0,
                 `faktura` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `add_date` date NOT NULL,
                 `die_date` date NOT NULL,
                 PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `storage_home` (
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `preparat_id` int(11) NOT NULL,
                 `status` tinyint(4) DEFAULT NULL,
                 `parent_id` int(11) NOT NULL,
                 `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `name` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `supplier` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `category` tinyint(4) DEFAULT NULL,
                 `qty` int(11) NOT NULL,
                 `qty_sold` int(11) NOT NULL DEFAULT 0,
                 `cost` decimal(65,1) NOT NULL DEFAULT 0.0,
                 `price` decimal(65,1) NOT NULL DEFAULT 0.0,
                 `faktura` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `die_date` date NOT NULL,
                 PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

             CREATE TABLE IF NOT EXISTS `storage_orders` (
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `user_id` int(11) DEFAULT NULL,
                 `parent_id` int(11) NOT NULL,
                 `preparat_id` int(11) NOT NULL,
                 `qty` smallint(6) NOT NULL,
                 `date` date NOT NULL,
                 PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

             CREATE TABLE IF NOT EXISTS `storage_product_name` (
                 `name` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

             CREATE TABLE IF NOT EXISTS `storage_sales` (
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `name` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `supplier` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                 `qty` int(11) NOT NULL,
                 `price` decimal(65,1) NOT NULL DEFAULT 0.0,
                 `amount` decimal(65,1) DEFAULT 0.0,
                 `parent_id` int(11) DEFAULT NULL,
                 `user_id` int(11) DEFAULT NULL,
                 `operation_id` int(11) DEFAULT NULL,
                 `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                 PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `storage_supplier_name` (
                `name` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `templates` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `autor_id` int(11) NOT NULL,
                `name` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
                `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `diagnostic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `recommendation` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `parent_id` int(11) DEFAULT NULL,
                `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `password` varchar(70) DEFAULT NULL,
                `first_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `last_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `father_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                `dateBith` date DEFAULT NULL,
                `region` varchar(255) DEFAULT NULL,
                `passport` varchar(255) DEFAULT NULL,
                `placeWork` varchar(1000) DEFAULT NULL,
                `position` varchar(1000) DEFAULT NULL,
                `numberPhone` varchar(255) DEFAULT NULL,
                `residenceAddress` varchar(1000) DEFAULT NULL,
                `registrationAddress` varchar(1000) DEFAULT NULL,
                `gender` tinyint(1) DEFAULT NULL,
                `user_level` tinyint(4) NOT NULL,
                `division_id` int(11) DEFAULT NULL,
                `status` tinyint(1) DEFAULT 1,
                `share` float DEFAULT 0,
                `resident` tinyint(1) DEFAULT NULL,
                `room` smallint(6) DEFAULT NULL,
                `token_telegramm` varchar(250) DEFAULT NULL,
                `add_date` datetime(6) DEFAULT current_timestamp(6),
                PRIMARY KEY (`id`),
                UNIQUE KEY `username` (`username`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `user_card` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `weight` float DEFAULT NULL,
                `update_date` datetime NOT NULL DEFAULT current_timestamp(),
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `user_stats` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `parent_id` int(11) DEFAULT NULL,
                `visit_id` int(11) DEFAULT NULL,
                `stat` tinyint(1) DEFAULT NULL,
                `pressure` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `pulse` smallint(11) DEFAULT NULL,
                `temperature` float DEFAULT NULL,
                `saturation` tinyint(4) DEFAULT NULL,
                `breath` float DEFAULT NULL,
                `urine` float DEFAULT NULL,
                `description` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `visit` (
                 `id` int(11) NOT NULL AUTO_INCREMENT,
                 `user_id` int(11) NOT NULL,
                 `grant_id` int(11) DEFAULT NULL,
                 `parent_id` int(11) DEFAULT NULL,
                 `route_id` int(11) DEFAULT NULL,
                 `assist_id` int(11) DEFAULT NULL,
                 `division_id` int(11) DEFAULT NULL,
                 `service_id` int(11) DEFAULT NULL,
                 `bed_id` int(11) DEFAULT NULL,
                 `direction` tinyint(1) DEFAULT NULL,
                 `status` tinyint(1) DEFAULT 0,
                 `diagnostic` tinyint(1) DEFAULT NULL,
                 `laboratory` tinyint(1) DEFAULT NULL,
                 `anesthesia` tinyint(1) DEFAULT NULL,
                 `physio` tinyint(1) DEFAULT NULL,
                 `manipulation` tinyint(1) DEFAULT NULL,
                 `guide_id` int(11) DEFAULT NULL,
                 `complaint` varchar(700) DEFAULT NULL,
                 `failure` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
                 `report_title` varchar(200) DEFAULT NULL,
                 `report_description` text DEFAULT NULL,
                 `report_diagnostic` text DEFAULT NULL,
                 `report_recommendation` text DEFAULT NULL,
                 `add_date` datetime DEFAULT current_timestamp(),
                 `accept_date` datetime DEFAULT NULL,
                 `priced_date` datetime DEFAULT NULL,
                 `discharge_date` date DEFAULT NULL,
                 `completed` datetime DEFAULT NULL,
                 PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=962 DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `visit_inspection` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `visit_id` int(11) NOT NULL,
                `parent_id` int(11) NOT NULL,
                `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
                `diagnostic` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `recommendation` varchar(700) COLLATE utf8mb4_unicode_ci NOT NULL,
                `add_date` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `visit_price` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `visit_id` int(11) DEFAULT NULL,
                `user_id` int(11) DEFAULT NULL,
                `pricer_id` int(11) DEFAULT NULL,
                `operation_id` int(11) DEFAULT NULL,
                `price_cash` decimal(65,1) NOT NULL DEFAULT 0.0,
                `price_card` decimal(65,1) NOT NULL DEFAULT 0.0,
                `price_transfer` decimal(65,1) NOT NULL DEFAULT 0.0,
                `sale` float DEFAULT 0,
                `status` tinyint(1) NOT NULL DEFAULT 1,
                `item_type` tinyint(4) NOT NULL,
                `item_id` int(11) NOT NULL,
                `item_cost` decimal(65,1) NOT NULL,
                `item_name` varchar(500) NOT NULL,
                `price_date` datetime DEFAULT NULL,
                `add_date` datetime DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            CREATE TABLE IF NOT EXISTS `wards` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `floor` tinyint(4) DEFAULT NULL,
                `ward` smallint(6) DEFAULT NULL,
                `add_date` datetime DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `floor` (`floor`,`ward`) USING BTREE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            EOSQL;
        $db->exec($sql);

        $db->commit();
        return 200;
    } catch (Exception $e) {
        $db->rollBack();
        return "Ошибка: " . $e->getMessage();
    }
}

?>
