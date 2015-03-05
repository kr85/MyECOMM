CREATE TABLE `states` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `country` INT(11)       NOT NULL  DEFAULT '0',
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
);

INSERT INTO `states` (`country`, `name`) VALUES (230, 'Alabama');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Alaska');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Arizona');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Arkansas');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'California');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Colorado');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Connecticut');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Delaware');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'District Of Columbia');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Florida');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Georgia');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Hawaii');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Idaho');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Illinois');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Indiana');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Iowa');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Kansas');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Kentucky');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Louisiana');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Maine');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Maryland');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Massachusetts');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Michigan');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Minnesota');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Mississippi');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Missouri');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Montana');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Nebraska');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Nevada');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'New Hampshire');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'New Jersey');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'New Mexico');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'New York');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'North Carolina');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'North Dakota');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Ohio');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Oklahoma');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Oregon');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Pennsylvania');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Rhode Island');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'South Carolina');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'South Dakota');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Tennessee');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Texas');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Utah');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Vermont');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Virginia');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Washington');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'West Virginia');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Wisconsin');
INSERT INTO `states` (`country`, `name`) VALUES (230, 'Wyoming');

ALTER TABLE `states`
ADD CONSTRAINT `states_ibfk_1` FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;