-- DROP TABLE `users`;
-- DROP TABLE `beds`;
-- DROP TABLE `bed_type`;

CREATE TABLE `clinic`.`users`
    (
        `id` INT(11) NOT NULL AUTO_INCREMENT ,
        `username` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
        `password` VARCHAR(70) NOT NULL ,
        `first_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
        `last_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
        `father_name` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
        `user_level` TINYINT NOT NULL,
        `activity` TINYINT(1) NOT NULL DEFAULT '1',
        `share` FLOAT NULL DEFAULT '0',
        `add_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `clinic`.`beds`
    (
        `id` INT(11) NOT NULL AUTO_INCREMENT ,
        `floor` TINYINT NOT NULL ,
        `ward` INT NOT NULL ,
        `num` INT NOT NULL ,
        `types` BOOLEAN NULL DEFAULT FALSE,
        `status` TINYINT NULL DEFAULT NULL ,
        `user_id` INT(11) NULL DEFAULT NULL ,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `clinic`.`bed_type`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL ,
  `price` DECIMAL(35) NULL DEFAULT NULL , PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;





CREATE TABLE `clinic`.`service_group`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_bin NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;


CREATE TABLE `clinic`.`service_category`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `group_id` INT(11) NULL ,
  `name` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_bin NULL ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `clinic`.`service`
(
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `group_id` INT(11) NULL ,
  `category_id` INT(11) NULL ,
  `user_level` TINYINT NULL ,
  `name` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_bin NULL ,
  `price` DECIMAL(65,1) NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;


INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `father_name`, `user_level`)
VALUES (NULL, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Jasur', 'Rakhmatov', 'Ilhomovich', '1');
