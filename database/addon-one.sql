CREATE TABLE `wishlist` (
  `id`      INT(11)   NOT NULL AUTO_INCREMENT,
  `client`  INT(11)   NOT NULL,
  `product` INT(11)   NOT NULL,
  `date`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client`( `client`),
  KEY `product` (`product`)
)
  ENGINE = InnoDB;

ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

INSERT INTO `wishlist` (`client`, `product`, `date`)
    VALUES (1, 55, NOW());
INSERT INTO `wishlist` (`client`, `product`, `date`)
    VALUES (1, 105, NOW());
INSERT INTO `wishlist` (`client`, `product`, `date`)
    VALUES (1, 5, NOW());