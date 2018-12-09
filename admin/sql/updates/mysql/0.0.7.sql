ALTER TABLE `#__quizzes`
MODIFY COLUMN `quiz_date` DATETIME DEFAULT NULL,
MODIFY COLUMN `last_update` DATETIME DEFAULT NULL;

UPDATE `#__quizzes` 
SET `quiz_date` = NULL
WHERE CAST(`quiz_date` AS CHAR(20)) = '0000-00-00 00:00:00';

UPDATE `#__quizzes` 
SET `last_update` = NULL
WHERE CAST(`last_update` AS CHAR(20)) = '0000-00-00 00:00:00';

/* add winner to quiz */
ALTER TABLE `#__quizzes` 
ADD `winner_id` INT NOT NULL DEFAULT 0, 
ADD CONSTRAINT `fk_winner` FOREIGN KEY (`winner_id`) REFERENCES `#__dkq_quizzers` (`id`);

INSERT INTO `#__dkq_quizzers`(`number`,`name`,`last_update`)
VALUES (1,'Andrea Danz',NOW()),
(2,'Christian Schulze',NOW()),
(3,'Felix Wackernagel',NOW()),
(4,'Holger Lippert',NOW()),
(5,'Jessica Wenzel',NOW()),
(6,'Julia Schöne',NOW()),
(7,'Katja Engelhardt',NOW()),
(8,'Marcus Riedel',NOW()),
(9,'Mareike Straßburger',NOW()),
(10,'Maria Ringel',NOW()),
(11,'Martin Rosenburg',NOW()),
(12,'Michael Keller',NOW()),
(13,'Mirco Steudtner',NOW()),
(14,'Nathalie Reisert',NOW()),
(15,'Nicole Lippert',NOW()),
(16,'Nicole Stange',NOW()),
(17,'Sophia Michalsky',NOW()),
(18,'Tim Sackmann',NOW()),
(19,'Tina Nowak',NOW()),
(20,'Tobias Kunz',NOW());

/* add quiz master to quiz */
ALTER TABLE `#__quizzes` 
DROP COLUMN `quiz_master`, 
ADD `quiz_master_id` INT NOT NULL DEFAULT 0, 
ADD CONSTRAINT `fk_quiz_master` FOREIGN KEY (`quiz_master_id`) REFERENCES `#__dkq_quizzers` (`id`);

UPDATE `#__quizzes` SET `quiz_master_id` = 11 WHERE `id` = 1;
UPDATE `#__quizzes` SET `quiz_master_id` = 19 WHERE `id` = 2;
UPDATE `#__quizzes` SET `quiz_master_id` = 20 WHERE `id` = 3;
UPDATE `#__quizzes` SET `quiz_master_id` = 12 WHERE `id` = 4;
UPDATE `#__quizzes` SET `quiz_master_id` = 20 WHERE `id` = 5;
UPDATE `#__quizzes` SET `quiz_master_id` = 18 WHERE `id` = 6;
UPDATE `#__quizzes` SET `quiz_master_id` = 20 WHERE `id` = 7;
UPDATE `#__quizzes` SET `quiz_master_id` = 13 WHERE `id` = 8;
UPDATE `#__quizzes` SET `quiz_master_id` = 20 WHERE `id` = 9;
UPDATE `#__quizzes` SET `quiz_master_id` = 6 WHERE `id` = 10;
UPDATE `#__quizzes` SET `quiz_master_id` = 11 WHERE `id` = 11;
UPDATE `#__quizzes` SET `quiz_master_id` = 18 WHERE `id` = 12;
UPDATE `#__quizzes` SET `quiz_master_id` = 5 WHERE `id` = 13;
UPDATE `#__quizzes` SET `quiz_master_id` = 3 WHERE `id` = 14;
UPDATE `#__quizzes` SET `quiz_master_id` = 10 WHERE `id` = 15;
UPDATE `#__quizzes` SET `quiz_master_id` = 14 WHERE `id` = 16;
UPDATE `#__quizzes` SET `quiz_master_id` = 9 WHERE `id` = 17;
UPDATE `#__quizzes` SET `quiz_master_id` = 1 WHERE `id` = 18;
UPDATE `#__quizzes` SET `quiz_master_id` = 11 WHERE `id` = 19;
UPDATE `#__quizzes` SET `quiz_master_id` = 1 WHERE `id` = 20;
UPDATE `#__quizzes` SET `quiz_master_id` = 20 WHERE `id` = 21;
UPDATE `#__quizzes` SET `quiz_master_id` = 18 WHERE `id` = 22;
UPDATE `#__quizzes` SET `quiz_master_id` = 11 WHERE `id` = 23;
UPDATE `#__quizzes` SET `quiz_master_id` = 7 WHERE `id` = 24;
UPDATE `#__quizzes` SET `quiz_master_id` = 1 WHERE `id` = 25;
UPDATE `#__quizzes` SET `quiz_master_id` = 2 WHERE `id` = 26;
UPDATE `#__quizzes` SET `quiz_master_id` = 11 WHERE `id` = 27;
UPDATE `#__quizzes` SET `quiz_master_id` = 18 WHERE `id` = 28;
UPDATE `#__quizzes` SET `quiz_master_id` = 20 WHERE `id` = 29;
UPDATE `#__quizzes` SET `quiz_master_id` = 6 WHERE `id` = 30;
UPDATE `#__quizzes` SET `quiz_master_id` = 18 WHERE `id` = 31;
UPDATE `#__quizzes` SET `quiz_master_id` = 2 WHERE `id` = 32;
UPDATE `#__quizzes` SET `quiz_master_id` = 18 WHERE `id` = 33;
UPDATE `#__quizzes` SET `quiz_master_id` = 8 WHERE `id` = 34;
UPDATE `#__quizzes` SET `quiz_master_id` = 16 WHERE `id` = 35;
UPDATE `#__quizzes` SET `quiz_master_id` = 17 WHERE `id` = 36;
UPDATE `#__quizzes` SET `quiz_master_id` = 15 WHERE `id` = 37;
UPDATE `#__quizzes` SET `quiz_master_id` = 4 WHERE `id` = 38;