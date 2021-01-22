CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_push` varchar(255) DEFAULT NULL,
  `id_pull` varchar(255) DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `activity` int(11) DEFAULT 0,
  `type_message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4