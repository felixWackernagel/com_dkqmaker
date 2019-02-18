/* add quiz to messages */
ALTER TABLE `#__dkq_messages`
ADD `quiz_id` INT NOT NULL DEFAULT 0,
ADD CONSTRAINT `fk_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `#__quizzes` (`id`);