ALTER TABLE `Group_JT` 
ADD COLUMN IF NOT EXISTS `contactId` INT(11) NOT NULL AFTER `groupId`;

ALTER TABLE `Group_JT` 
ADD FOREIGN KEY IF NOT EXISTS (`contactId`)
  REFERENCES `Person` (`uniqueId`);

ALTER TABLE `Message` 
CHANGE COLUMN `lastSent` `lastSent` DATETIME NULL;

ALTER TABLE `Message` 
DROP FOREIGN KEY `Message_ibfk_2`;

ALTER TABLE `Message` 
DROP INDEX `groupId`;

ALTER TABLE `Person` 
CHANGE COLUMN `passwordHash` `passwordHash` VARCHAR(500) NULL DEFAULT NULL;