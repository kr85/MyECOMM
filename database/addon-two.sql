CREATE TABLE `reset_password` (
  `id`    INT(11)      NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(150) NOT NULL,
  `hash`  VARCHAR(255) NOT NULL,
  `date`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `count` INT(11)      NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB;