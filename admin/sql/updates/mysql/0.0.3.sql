CREATE TABLE IF NOT EXISTS `#__dkq_messages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  `title` VARCHAR(100) NULL,
  `content` VARCHAR(512) NULL,
  `online_date` DATE DEFAULT NULL,
  `offline_date` DATE DEFAULT NULL,
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;