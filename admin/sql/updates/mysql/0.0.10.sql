/* fix constraint */
ALTER TABLE `#__questions`
MODIFY COLUMN `last_update` DATETIME DEFAULT NULL;

UPDATE `#__questions`
SET `last_update` = NULL
WHERE CAST(`last_update` AS CHAR(20)) = '0000-00-00 00:00:00';

ALTER TABLE `#__questions`
DROP FOREIGN KEY `fk_quiz`,
ADD CONSTRAINT `fk_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `#__quizzes` (`id`) ON DELETE CASCADE;