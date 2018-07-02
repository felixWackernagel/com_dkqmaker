DROP INDEX `number_UNIQUE` ON `#__questions`;
ALTER TABLE `#__questions` ADD INDEX `quiz_id_number_UNIQUE` (`quiz_id`, `number`);