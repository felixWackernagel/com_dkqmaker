DROP TABLE IF EXISTS `#__quizzes`;
 
CREATE TABLE IF NOT EXISTS `#__quizzes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  `location` VARCHAR(100) NULL,
  `address` VARCHAR(255) NULL,
  `quiz_date` DATETIME DEFAULT '0000-00-00 00:00:00',
  `quiz_master` VARCHAR(45) NULL,
  `latitude` DOUBLE NOT NULL DEFAULT 0,
  `longitude` DOUBLE NOT NULL DEFAULT 0,
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;

DROP TABLE IF EXISTS `#__questions`;

CREATE TABLE IF NOT EXISTS `#__questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `quiz_id` INT NOT NULL DEFAULT 0,
  `question` LONGTEXT NULL,
  `answer` TEXT NULL,
  `number` INT NOT NULL CHECK (number >= 1 AND number <= 60),
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME DEFAULT '0000-00-00 00:00:00',
  UNIQUE INDEX `number_UNIQUE` (`number` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz`
  FOREIGN KEY (`id`)
  REFERENCES `#__quizzes` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;

INSERT INTO `#__quizzes` (`number`, `location`, `address`, `quiz_date`, `quiz_master`, `latitude`, `longitude`, `published`) VALUES 
(35, 'Zapfanstalt', 'Sebnitzer Str. 15, 01099 Dresden', '2018-06-30 20:00:00', 'Martin', 51.0689046, 13.7556929, 1),
(34, 'Barneby - Die Spielebar', 'Görlitzer Straße 11, 01099 Dresden', '2018-03-30 20:00:00', 'Martin', 51.0671455, 13.7541441, 1);

INSERT INTO `#__questions` (`quiz_id`, `number`, `question`, `answer`, `published`) VALUES 
(1, 1, '1+1=', '2', 1),
(1, 2, 'Wofür ist Per Anhalter durch die Galaxis bekannt?', '42', 1),
(1, 3, 'Was essen Ben und Leon zum Frühstück?', 'Brötchen', 1),
(1, 4, 'Wie ist die Farbe unseres Autos?', 'Rot', 1),
(1, 5, 'Was liebt Maria?', 'Kartoffeln', 1),
(1, 6, 'Avengers', 'Captain America, Iron Man, Hulk, Hank Pym, Thor', 1),
(1, 7, 'Wer ist bei Detektiv Comics?', 'Batman', 1),
(1, 8, 'Was war der beste Jahrgang?', '1988', 1),
(1, 9, 'Wer bringt die Babys?', 'Störche', 1),
(1, 10, 'Ein Hobbit aus Der Herr der Ringe?', 'Frodo Beutlin', 1);
