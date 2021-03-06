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

CREATE TABLE IF NOT EXISTS `#__quizzes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` INT NOT NULL,
  `location` VARCHAR(100) NULL,
  `address` VARCHAR(255) NULL,
  `quiz_date` DATETIME DEFAULT NULL,
  `quiz_master_id` INT NOT NULL DEFAULT 0,
  `winner_id` INT NOT NULL DEFAULT 0,
  `latitude` DOUBLE NOT NULL DEFAULT 0,
  `longitude` DOUBLE NOT NULL DEFAULT 0,
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number`),
  CONSTRAINT `fk_quiz_master` FOREIGN KEY (`quiz_master_id`) REFERENCES `#__dkq_quizzers` (`id`),
  CONSTRAINT `fk_winner` FOREIGN KEY (`winner_id`) REFERENCES `#__dkq_quizzers` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `#__questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `quiz_id` INT NOT NULL DEFAULT 0,
  `question` LONGTEXT NULL,
  `answer` TEXT NULL,
  `number` INT NOT NULL,
  `image` VARCHAR(255),
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME DEFAULT '0000-00-00 00:00:00',
  UNIQUE INDEX `quiz_id_number_UNIQUE` (`quiz_id`, `number`),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `#__quizzes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `#__dkq_messages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `quiz_id` INT NOT NULL DEFAULT 0,
  `number` INT NOT NULL,
  `title` VARCHAR(100),
  `content` VARCHAR(1024),
  `image` VARCHAR(255),
  `online_date` DATE DEFAULT NULL,
  `offline_date` DATE DEFAULT NULL,
  `version` INT(10) unsigned NOT NULL DEFAULT 1,
  `last_update` DATETIME DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `number_UNIQUE` (`number`),
  CONSTRAINT `fk_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `#__quizzes` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  AUTO_INCREMENT=0;

INSERT INTO `#__dkq_quizzers` (`number`, `name`, `last_update`) VALUES
(1, 'Felix W.', NOW()),
(2, 'Tim S.', NOW());

INSERT INTO `#__quizzes` (`number`, `location`, `address`, `quiz_date`, `quiz_master_id`, `winner_id`, `latitude`, `longitude`, `published`) VALUES
(35, 'Zapfanstalt', 'Sebnitzer Str. 15, 01099 Dresden', '2018-06-30 20:00:00', 1, 2, 51.0689046, 13.7556929, 1),
(34, 'Barneby - Die Spielebar', 'Görlitzer Straße 11, 01099 Dresden', '2018-03-30 20:00:00', 2, 1, 51.0671455, 13.7541441, 1);

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

INSERT INTO `#__dkq_messages` (`number`, `title`, `content`, `online_date`, `offline_date`) VALUES
(1, 'Online', 'ABC', '2018-01-31', 'null'),
(2, 'Offline', 'ABC', 'null', 'null'),
(3, 'Offline', 'ABC', 'null', '2020-01-31'),
(4, 'Noch Online', 'ABC', '2018-01-31', '2020-01-31'),
(5, 'Bereits Offline', 'ABC', '2018-01-31', '2018-07-31'),
(6, 'Immer Online', 'ABC', '2018-01-31', 'null');