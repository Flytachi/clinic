<?php
// Database Constants
define("DRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_NAME", "clinic");
define("DB_USER", "clinic");
define("DB_PASS", "clin_pik27");
$DNS = "".DRIVER.":host=".DB_HOST.";dbname=".DB_NAME.";user=".DB_USER.";password=".DB_PASS."";

// print_r(PDO::getAvailableDrivers()); 
try {
    $db = new PDO($DNS);
    $db->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

// foreach($db->query('SELECT * from users') as $row) {
//  print code..
// }

/*
    ? SQL

    CREATE TABLE `clinic`.`users` 
    ( 
        `id` INT(11) NOT NULL AUTO_INCREMENT , 
        `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
        `password` VARCHAR(70) NOT NULL , 
        `first_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
        `last_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
        `father_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
        `user_level` TINYINT NOT NULL , 
        `status` BOOLEAN NULL DEFAULT FALSE , 
        `add_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP , 
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci; 

    INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `father_name`, `user_level`, `add_date`) 
        VALUES (NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Jasur', 'Rakhmatov', 'Ilhomovich', '1');

*/
?>