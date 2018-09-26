CREATE TABLE IF NOT EXISTS `#__dkq_quizzers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(255),
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;