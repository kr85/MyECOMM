SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50)  NOT NULL,
  `last_name`  VARCHAR(50)  NOT NULL,
  `email`      VARCHAR(150) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `admins`
--
INSERT INTO `admins` VALUES (1, 'Kosta', 'Rashev', 'kosta.rashev@gmail.com', 'bd2b1aaf7ef4f09be9f52ce2d8d599674d81aa9d6a4421696dc4d93dd0619d682ce56b4d64a9ef097761ced99e0f67265b5f76085e5b0ee7ca4696b2ad6fe2b2'); -- Password = 'secret'

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `id`         INT(11)       NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(150)  NOT NULL,
  `address`    TEXT          NOT NULL,
  `country`    INT(11)       NOT NULL DEFAULT '0',
  `telephone`  VARCHAR(100)  NOT NULL,
  `email`      VARCHAR(200)  NOT NULL,
  `website`    VARCHAR(200)  NOT NULL,
  `tax_number` VARCHAR(20)   NULL,
  `tax_rate`   DECIMAL(5, 2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `business`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id`               INT(11)      NOT NULL AUTO_INCREMENT,
  `name`             VARCHAR(150) NOT NULL,
  `identity`         VARCHAR(200)          DEFAULT NULL,
  `meta_title`       VARCHAR(255)          DEFAULT NULL,
  `meta_description` VARCHAR(255)          DEFAULT NULL,
  `meta_keywords`    VARCHAR(255)          DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES (1, 'Biographies & Autobiographies');
INSERT INTO `categories` (`id`, `name`) VALUES (2, 'Computers & IT');
INSERT INTO `categories` (`id`, `name`) VALUES (3, 'Art & Architecture');

UPDATE `categories` SET `meta_title`  = `name`, `meta_description` = `name`, `meta_keywords` = `name`;
UPDATE `categories` SET `identity` = 'biographies-autobiographies' WHERE `id` = 1;
UPDATE `categories` SET `identity` = 'computers-it' WHERE `id` = 2;
UPDATE `categories` SET `identity` = 'art-architecture' WHERE `id` = 3;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id`                 INT(11)             NOT NULL AUTO_INCREMENT,
  `first_name`         VARCHAR(150)        NOT NULL,
  `last_name`          VARCHAR(150)        NOT NULL,
  `address_1`          VARCHAR(255)        NOT NULL,
  `address_2`          VARCHAR(255)        NULL,
  `city`               VARCHAR(255)        NOT NULL,
  `state`              VARCHAR(255)        NOT NULL,
  `zip_code`           VARCHAR(10)         NOT NULL,
  `country`            INT(11)             NOT NULL,
  `same_address`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `shipping_address_1` VARCHAR(255)        NULL,
  `shipping_address_2` VARCHAR(255)        NULL,
  `shipping_city`      VARCHAR(255)        NULL,
  `shipping_state`     VARCHAR(255)        NULL,
  `shipping_zip_code`  VARCHAR(255)        NULL,
  `shipping_country`   INT(11)             NULL     DEFAULT '0',
  `email`              VARCHAR(255)        NOT NULL,
  `password`           VARCHAR(255)        NOT NULL,
  `date`               DATETIME            NOT NULL,
  `active`             TINYINT(1)          NOT NULL DEFAULT '0',
  `hash`               VARCHAR(255)                 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `clients`
--


-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id`   INT(11)      NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(3)            DEFAULT NULL,
  `include` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 244;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` VALUES (1, 'Afghanistan', 'AF', 1);
INSERT INTO `countries` VALUES (2, 'Ãland Islands', 'AX', 1);
INSERT INTO `countries` VALUES (3, 'Albania', 'AL', 1);
INSERT INTO `countries` VALUES (4, 'Algeria', 'DZ', 1);
INSERT INTO `countries` VALUES (5, 'American Samoa', 'AS', 1);
INSERT INTO `countries` VALUES (6, 'Andorra', 'AD', 1);
INSERT INTO `countries` VALUES (7, 'Angola', 'AO', 1);
INSERT INTO `countries` VALUES (8, 'Anguilla', 'AI', 1);
INSERT INTO `countries` VALUES (9, 'Antarctica', 'AQ', 1);
INSERT INTO `countries` VALUES (10, 'Antigua And Barbuda', 'AG', 1);
INSERT INTO `countries` VALUES (11, 'Argentina', 'AR', 1);
INSERT INTO `countries` VALUES (12, 'Armenia', 'AM', 1);
INSERT INTO `countries` VALUES (13, 'Aruba', 'AW', 1);
INSERT INTO `countries` VALUES (14, 'Australia', 'AU', 1);
INSERT INTO `countries` VALUES (15, 'Austria', 'AT', 1);
INSERT INTO `countries` VALUES (16, 'Azerbaijan', 'AZ', 1);
INSERT INTO `countries` VALUES (17, 'Bahamas', 'BS', 1);
INSERT INTO `countries` VALUES (18, 'Bahrain', 'BH', 1);
INSERT INTO `countries` VALUES (19, 'Bangladesh', 'BD', 1);
INSERT INTO `countries` VALUES (20, 'Barbados', 'BB', 1);
INSERT INTO `countries` VALUES (21, 'Belarus', 'BY', 1);
INSERT INTO `countries` VALUES (22, 'Belgium', 'BE', 1);
INSERT INTO `countries` VALUES (23, 'Belize', 'BZ', 1);
INSERT INTO `countries` VALUES (24, 'Benin', 'BJ', 1);
INSERT INTO `countries` VALUES (25, 'Bermuda', 'BM', 1);
INSERT INTO `countries` VALUES (26, 'Bhutan', 'BT', 1);
INSERT INTO `countries` VALUES (27, 'Bolivia', 'BO', 1);
INSERT INTO `countries` VALUES (28, 'Bosnia And Herzegovina', 'BA', 1);
INSERT INTO `countries` VALUES (29, 'Botswana', 'BW', 1);
INSERT INTO `countries` VALUES (30, 'Bouvet Island', 'BV', 1);
INSERT INTO `countries` VALUES (31, 'Brazil', 'BR', 1);
INSERT INTO `countries` VALUES (32, 'British Indian Ocean Territory', 'IO', 1);
INSERT INTO `countries` VALUES (33, 'Brunei Darussalam', 'BN', 1);
INSERT INTO `countries` VALUES (34, 'Bulgaria', 'BG', 1);
INSERT INTO `countries` VALUES (35, 'Burkina Faso', 'BF', 1);
INSERT INTO `countries` VALUES (36, 'Burundi', 'BI', 1);
INSERT INTO `countries` VALUES (37, 'Cambodia', 'KH', 1);
INSERT INTO `countries` VALUES (38, 'Cameroon', 'CM', 1);
INSERT INTO `countries` VALUES (39, 'Canada', 'CA', 1);
INSERT INTO `countries` VALUES (40, 'Cape Verde', 'CV', 1);
INSERT INTO `countries` VALUES (41, 'Cayman Islands', 'KY', 1);
INSERT INTO `countries` VALUES (42, 'Central African Republic', 'CF', 1);
INSERT INTO `countries` VALUES (43, 'Chad', 'TD', 1);
INSERT INTO `countries` VALUES (44, 'Chile', 'CL', 1);
INSERT INTO `countries` VALUES (45, 'China', 'CN', 1);
INSERT INTO `countries` VALUES (46, 'Christmas Island', 'CX', 1);
INSERT INTO `countries` VALUES (47, 'Cocos (keeling) Islands', 'CC', 1);
INSERT INTO `countries` VALUES (48, 'Colombia', 'CO', 1);
INSERT INTO `countries` VALUES (49, 'Comoros', 'KM', 1);
INSERT INTO `countries` VALUES (50, 'Congo', 'CG', 1);
INSERT INTO `countries` VALUES (51, 'Congo, The Democratic Republic Of', 'CD', 1);
INSERT INTO `countries` VALUES (52, 'Cook Islands', 'CK', 1);
INSERT INTO `countries` VALUES (53, 'Costa Rica', 'CR', 1);
INSERT INTO `countries` VALUES (54, 'Cote D''ivoire', 'CI', 1);
INSERT INTO `countries` VALUES (55, 'Croatia', 'HR', 1);
INSERT INTO `countries` VALUES (56, 'Cuba', 'CU', 1);
INSERT INTO `countries` VALUES (57, 'Cyprus', 'CY', 1);
INSERT INTO `countries` VALUES (58, 'Czech Republic', 'CZ', 1);
INSERT INTO `countries` VALUES (59, 'Denmark', 'DK', 1);
INSERT INTO `countries` VALUES (60, 'Djibouti', 'DJ', 1);
INSERT INTO `countries` VALUES (61, 'Dominica', 'DM', 1);
INSERT INTO `countries` VALUES (62, 'Dominican Republic', 'DO', 1);
INSERT INTO `countries` VALUES (63, 'Ecuador', 'EC', 1);
INSERT INTO `countries` VALUES (64, 'Egypt', 'EG', 1);
INSERT INTO `countries` VALUES (65, 'El Salvador', 'SV', 1);
INSERT INTO `countries` VALUES (66, 'Equatorial Guinea', 'GQ', 1);
INSERT INTO `countries` VALUES (67, 'Eritrea', 'ER', 1);
INSERT INTO `countries` VALUES (68, 'Estonia', 'EE', 1);
INSERT INTO `countries` VALUES (69, 'Ethiopia', 'ET', 1);
INSERT INTO `countries` VALUES (70, 'Falkland Islands (malvinas)', 'FK', 1);
INSERT INTO `countries` VALUES (71, 'Faroe Islands', 'FO', 1);
INSERT INTO `countries` VALUES (72, 'Fiji', 'FJ', 1);
INSERT INTO `countries` VALUES (73, 'Finland', 'FI', 1);
INSERT INTO `countries` VALUES (74, 'France', 'FR', 1);
INSERT INTO `countries` VALUES (75, 'French Guiana', 'GF', 1);
INSERT INTO `countries` VALUES (76, 'French Polynesia', 'PF', 1);
INSERT INTO `countries` VALUES (77, 'French Southern Territories', 'TF', 1);
INSERT INTO `countries` VALUES (78, 'Gabon', 'GA', 1);
INSERT INTO `countries` VALUES (79, 'Gambia', 'GM', 1);
INSERT INTO `countries` VALUES (80, 'Georgia', 'GE', 1);
INSERT INTO `countries` VALUES (81, 'Germany', 'DE', 1);
INSERT INTO `countries` VALUES (82, 'Ghana', 'GH', 1);
INSERT INTO `countries` VALUES (83, 'Gibraltar', 'GI', 1);
INSERT INTO `countries` VALUES (84, 'Greece', 'GR', 1);
INSERT INTO `countries` VALUES (85, 'Greenland', 'GL', 1);
INSERT INTO `countries` VALUES (86, 'Grenada', 'GD', 1);
INSERT INTO `countries` VALUES (87, 'Guadeloupe', 'GP', 1);
INSERT INTO `countries` VALUES (88, 'Guam', 'GU', 1);
INSERT INTO `countries` VALUES (89, 'Guatemala', 'GT', 1);
INSERT INTO `countries` VALUES (90, 'Guernsey', 'GG', 1);
INSERT INTO `countries` VALUES (91, 'Guinea', 'GN', 1);
INSERT INTO `countries` VALUES (92, 'Guinea-bissau', 'GW', 1);
INSERT INTO `countries` VALUES (93, 'Guyana', 'GY', 1);
INSERT INTO `countries` VALUES (94, 'Haiti', 'HT', 1);
INSERT INTO `countries` VALUES (95, 'Heard Island And Mcdonald Islands', 'HM', 1);
INSERT INTO `countries` VALUES (96, 'Holy See (vatican City State)', 'VA', 1);
INSERT INTO `countries` VALUES (97, 'Honduras', 'HN', 1);
INSERT INTO `countries` VALUES (98, 'Hong Kong', 'HK', 1);
INSERT INTO `countries` VALUES (99, 'Hungary', 'HU', 1);
INSERT INTO `countries` VALUES (100, 'Iceland', 'IS', 1);
INSERT INTO `countries` VALUES (101, 'India', 'IN', 1);
INSERT INTO `countries` VALUES (102, 'Indonesia', 'ID', 1);
INSERT INTO `countries` VALUES (103, 'Iran, Islamic Republic Of', 'IR', 1);
INSERT INTO `countries` VALUES (104, 'Iraq', 'IQ', 1);
INSERT INTO `countries` VALUES (105, 'Ireland', 'IE', 1);
INSERT INTO `countries` VALUES (106, 'Isle Of Man', 'IM', 1);
INSERT INTO `countries` VALUES (107, 'Israel', 'IL', 1);
INSERT INTO `countries` VALUES (108, 'Italy', 'IT', 1);
INSERT INTO `countries` VALUES (109, 'Jamaica', 'JM', 1);
INSERT INTO `countries` VALUES (110, 'Japan', 'JP', 1);
INSERT INTO `countries` VALUES (111, 'Jersey', 'JE', 1);
INSERT INTO `countries` VALUES (112, 'Jordan', 'JO', 1);
INSERT INTO `countries` VALUES (113, 'Kazakhstan', 'KZ', 1);
INSERT INTO `countries` VALUES (114, 'Kenya', 'KE', 1);
INSERT INTO `countries` VALUES (115, 'Kiribati', 'KI', 1);
INSERT INTO `countries` VALUES (116, 'Korea, Democratic People''s Republic Of', 'KP', 1);
INSERT INTO `countries` VALUES (117, 'Korea, Republic Of', 'KR', 1);
INSERT INTO `countries` VALUES (118, 'Kuwait', 'KW', 1);
INSERT INTO `countries` VALUES (119, 'Kyrgyzstan', 'KG', 1);
INSERT INTO `countries` VALUES (120, 'Lao People''s Democratic Republic', 'LA', 1);
INSERT INTO `countries` VALUES (121, 'Latvia', 'LV', 1);
INSERT INTO `countries` VALUES (122, 'Lebanon', 'LB', 1);
INSERT INTO `countries` VALUES (123, 'Lesotho', 'LS', 1);
INSERT INTO `countries` VALUES (124, 'Liberia', 'LR', 1);
INSERT INTO `countries` VALUES (125, 'Libyan Arab Jamahiriya', 'LY', 1);
INSERT INTO `countries` VALUES (126, 'Liechtenstein', 'LI', 1);
INSERT INTO `countries` VALUES (127, 'Lithuania', 'LT', 1);
INSERT INTO `countries` VALUES (128, 'Luxembourg', 'LU', 1);
INSERT INTO `countries` VALUES (129, 'Macao', 'MO', 1);
INSERT INTO `countries` VALUES (130, 'Macedonia, The Former Yugoslav Republic Of', 'MK', 1);
INSERT INTO `countries` VALUES (131, 'Madagascar', 'MG', 1);
INSERT INTO `countries` VALUES (132, 'Malawi', 'MW', 1);
INSERT INTO `countries` VALUES (133, 'Malaysia', 'MY', 1);
INSERT INTO `countries` VALUES (134, 'Maldives', 'MV', 1);
INSERT INTO `countries` VALUES (135, 'Mali', 'ML', 1);
INSERT INTO `countries` VALUES (136, 'Malta', 'MT', 1);
INSERT INTO `countries` VALUES (137, 'Marshall Islands', 'MH', 1);
INSERT INTO `countries` VALUES (138, 'Martinique', 'MQ', 1);
INSERT INTO `countries` VALUES (139, 'Mauritania', 'MR', 1);
INSERT INTO `countries` VALUES (140, 'Mauritius', 'MU', 1);
INSERT INTO `countries` VALUES (141, 'Mayotte', 'YT', 1);
INSERT INTO `countries` VALUES (142, 'Mexico', 'MX', 1);
INSERT INTO `countries` VALUES (143, 'Micronesia, Federated States Of', 'FM', 1);
INSERT INTO `countries` VALUES (144, 'Moldova, Republic Of', 'MD', 1);
INSERT INTO `countries` VALUES (145, 'Monaco', 'MC', 1);
INSERT INTO `countries` VALUES (146, 'Mongolia', 'MN', 1);
INSERT INTO `countries` VALUES (147, 'Montserrat', 'MS', 1);
INSERT INTO `countries` VALUES (148, 'Morocco', 'MA', 1);
INSERT INTO `countries` VALUES (149, 'Mozambique', 'MZ', 1);
INSERT INTO `countries` VALUES (150, 'Myanmar', 'MM', 1);
INSERT INTO `countries` VALUES (151, 'Namibia', 'NA', 1);
INSERT INTO `countries` VALUES (152, 'Nauru', 'NR', 1);
INSERT INTO `countries` VALUES (153, 'Nepal', 'NP', 1);
INSERT INTO `countries` VALUES (154, 'Netherlands', 'NL', 1);
INSERT INTO `countries` VALUES (155, 'Netherlands Antilles', 'AN', 1);
INSERT INTO `countries` VALUES (156, 'New Caledonia', 'NC', 1);
INSERT INTO `countries` VALUES (157, 'New Zealand', 'NZ', 1);
INSERT INTO `countries` VALUES (158, 'Nicaragua', 'NI', 1);
INSERT INTO `countries` VALUES (159, 'Niger', 'NE', 1);
INSERT INTO `countries` VALUES (160, 'Nigeria', 'NG', 1);
INSERT INTO `countries` VALUES (161, 'Niue', 'NU', 1);
INSERT INTO `countries` VALUES (162, 'Norfolk Island', 'NF', 1);
INSERT INTO `countries` VALUES (163, 'Northern Mariana Islands', 'MP', 1);
INSERT INTO `countries` VALUES (164, 'Norway', 'NO', 1);
INSERT INTO `countries` VALUES (165, 'Oman', 'OM', 1);
INSERT INTO `countries` VALUES (166, 'Pakistan', 'PK', 1);
INSERT INTO `countries` VALUES (167, 'Palau', 'PW', 1);
INSERT INTO `countries` VALUES (168, 'Palestinian Territory, Occupied', 'PS', 1);
INSERT INTO `countries` VALUES (169, 'Panama', 'PA', 1);
INSERT INTO `countries` VALUES (170, 'Papua New Guinea', 'PG', 1);
INSERT INTO `countries` VALUES (171, 'Paraguay', 'PY', 1);
INSERT INTO `countries` VALUES (172, 'Peru', 'PE', 1);
INSERT INTO `countries` VALUES (173, 'Philippines', 'PH', 1);
INSERT INTO `countries` VALUES (174, 'Pitcairn', 'PN', 1);
INSERT INTO `countries` VALUES (175, 'Poland', 'PL', 1);
INSERT INTO `countries` VALUES (176, 'Portugal', 'PT', 1);
INSERT INTO `countries` VALUES (177, 'Puerto Rico', 'PR', 1);
INSERT INTO `countries` VALUES (178, 'Qatar', 'QA', 1);
INSERT INTO `countries` VALUES (179, 'Reunion', 'RE', 1);
INSERT INTO `countries` VALUES (180, 'Romania', 'RO', 1);
INSERT INTO `countries` VALUES (181, 'Russian Federation', 'RU', 1);
INSERT INTO `countries` VALUES (182, 'Rwanda', 'RW', 1);
INSERT INTO `countries` VALUES (183, 'Saint Helena', 'SH', 1);
INSERT INTO `countries` VALUES (184, 'Saint Kitts And Nevis', 'KN', 1);
INSERT INTO `countries` VALUES (185, 'Saint Lucia', 'LC', 1);
INSERT INTO `countries` VALUES (186, 'Saint Pierre And Miquelon', 'PM', 1);
INSERT INTO `countries` VALUES (187, 'Saint Vincent And The Grenadines', 'VC', 1);
INSERT INTO `countries` VALUES (188, 'Samoa', 'WS', 1);
INSERT INTO `countries` VALUES (189, 'San Marino', 'SM', 1);
INSERT INTO `countries` VALUES (190, 'Sao Tome And Principe', 'ST', 1);
INSERT INTO `countries` VALUES (191, 'Saudi Arabia', 'SA', 1);
INSERT INTO `countries` VALUES (192, 'Senegal', 'SN', 1);
INSERT INTO `countries` VALUES (193, 'Serbia And Montenegro', 'CS', 1);
INSERT INTO `countries` VALUES (194, 'Seychelles', 'SC', 1);
INSERT INTO `countries` VALUES (195, 'Sierra Leone', 'SL', 1);
INSERT INTO `countries` VALUES (196, 'Singapore', 'SG', 1);
INSERT INTO `countries` VALUES (197, 'Slovakia', 'SK', 1);
INSERT INTO `countries` VALUES (198, 'Slovenia', 'SI', 1);
INSERT INTO `countries` VALUES (199, 'Solomon Islands', 'SB', 1);
INSERT INTO `countries` VALUES (200, 'Somalia', 'SO', 1);
INSERT INTO `countries` VALUES (201, 'South Africa', 'ZA', 1);
INSERT INTO `countries` VALUES (202, 'South Georgia And The South Sandwich Islands', 'GS', 1);
INSERT INTO `countries` VALUES (203, 'Spain', 'ES', 1);
INSERT INTO `countries` VALUES (204, 'Sri Lanka', 'LK', 1);
INSERT INTO `countries` VALUES (205, 'Sudan', 'SD', 1);
INSERT INTO `countries` VALUES (206, 'Suriname', 'SR', 1);
INSERT INTO `countries` VALUES (207, 'Svalbard And Jan Mayen', 'SJ', 1);
INSERT INTO `countries` VALUES (208, 'Swaziland', 'SZ', 1);
INSERT INTO `countries` VALUES (209, 'Sweden', 'SE', 1);
INSERT INTO `countries` VALUES (210, 'Switzerland', 'CH', 1);
INSERT INTO `countries` VALUES (211, 'Syrian Arab Republic', 'SY', 1);
INSERT INTO `countries` VALUES (212, 'Taiwan, Province Of China', 'TW', 1);
INSERT INTO `countries` VALUES (213, 'Tajikistan', 'TJ', 1);
INSERT INTO `countries` VALUES (214, 'Tanzania, United Republic Of', 'TZ', 1);
INSERT INTO `countries` VALUES (215, 'Thailand', 'TH', 1);
INSERT INTO `countries` VALUES (216, 'Timor-leste', 'TL', 1);
INSERT INTO `countries` VALUES (217, 'Togo', 'TG', 1);
INSERT INTO `countries` VALUES (218, 'Tokelau', 'TK', 1);
INSERT INTO `countries` VALUES (219, 'Tonga', 'TO', 1);
INSERT INTO `countries` VALUES (220, 'Trinidad And Tobago', 'TT', 1);
INSERT INTO `countries` VALUES (221, 'Tunisia', 'TN', 1);
INSERT INTO `countries` VALUES (222, 'Turkey', 'TR', 1);
INSERT INTO `countries` VALUES (223, 'Turkmenistan', 'TM', 1);
INSERT INTO `countries` VALUES (224, 'Turks And Caicos Islands', 'TC', 1);
INSERT INTO `countries` VALUES (225, 'Tuvalu', 'TV', 1);
INSERT INTO `countries` VALUES (226, 'Uganda', 'UG', 1);
INSERT INTO `countries` VALUES (227, 'Ukraine', 'UA', 1);
INSERT INTO `countries` VALUES (228, 'United Arab Emirates', 'AE', 1);
INSERT INTO `countries` VALUES (229, 'United Kingdom', 'GB', 1);
INSERT INTO `countries` VALUES (230, 'United States', 'US', 1);
INSERT INTO `countries` VALUES (231, 'United States Minor Outlying Islands', 'UM', 1);
INSERT INTO `countries` VALUES (232, 'Uruguay', 'UY', 1);
INSERT INTO `countries` VALUES (233, 'Uzbekistan', 'UZ', 1);
INSERT INTO `countries` VALUES (234, 'Vanuatu', 'VU', 1);
INSERT INTO `countries` VALUES (235, 'Venezuela', 'VE', 1);
INSERT INTO `countries` VALUES (236, 'Viet Nam', 'VN', 1);
INSERT INTO `countries` VALUES (237, 'Virgin Islands, British', 'VG', 1);
INSERT INTO `countries` VALUES (238, 'Virgin Islands, U.S.', 'VI', 1);
INSERT INTO `countries` VALUES (239, 'Wallis And Futuna', 'WF', 1);
INSERT INTO `countries` VALUES (240, 'Western Sahara', 'EH', 1);
INSERT INTO `countries` VALUES (241, 'Yemen', 'YE', 1);
INSERT INTO `countries` VALUES (242, 'Zambia', 'ZM', 1);
INSERT INTO `countries` VALUES (243, 'Zimbabwe', 'ZW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id`                 INT(11)       NOT NULL AUTO_INCREMENT,
  `token`              VARCHAR(255)  NOT NULL,
  `client`             INT(11)       NOT NULL,
  `first_name`         VARCHAR(150)  NOT NULL,
  `last_name`          VARCHAR(150)  NOT NULL,
  `address_1`          VARCHAR(255)  NOT NULL,
  `address_2`          VARCHAR(255)  NULL,
  `city`               VARCHAR(255)  NOT NULL,
  `state`              VARCHAR(255)  NOT NULL,
  `zip_code`           VARCHAR(10)   NOT NULL,
  `country`            INT(11)       NOT NULL,
  `shipping_address_1` VARCHAR(255)  NULL,
  `shipping_address_2` VARCHAR(255)  NULL,
  `shipping_city`      VARCHAR(255)  NULL,
  `shipping_state`     VARCHAR(255)  NULL,
  `shipping_zip_code`  VARCHAR(255)  NULL,
  `shipping_country`   INT(11)       NULL     DEFAULT '0',
  `shipping_cost`      DECIMAL(8, 2) NOT NULL DEFAULT '0',
  `shipping_type`      VARCHAR(100)  NULL,
  `tax_number`         VARCHAR(20)   NULL,
  `tax_rate`           DECIMAL(5, 2) NOT NULL,
  `tax`                DECIMAL(8, 2) NOT NULL,
  `subtotal_items`     DECIMAL(8, 2) NOT NULL DEFAULT '0',
  `subtotal`           DECIMAL(8, 2) NOT NULL,
  `total`              DECIMAL(8, 2) NOT NULL,
  `date`               DATETIME      NOT NULL,
  `status`             INT(11)       NOT NULL DEFAULT '1',
  `pp_status`          TINYINT(1)    NOT NULL DEFAULT '0',
  `txn_id`             VARCHAR(100)           DEFAULT NULL,
  `payment_status`     VARCHAR(100)           DEFAULT NULL,
  `ipn`                TEXT,
  `notes`              TEXT,
  PRIMARY KEY (`id`),
  KEY `client` (`client`),
  KEY `fk_stage` (`status`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `orders_items`
--

CREATE TABLE `orders_items` (
  `id`      INT(11)       NOT NULL AUTO_INCREMENT,
  `order`   INT(11)       NOT NULL,
  `product` INT(11)       NOT NULL,
  `price`   DECIMAL(8, 2) NOT NULL,
  `qty`     INT(11)       NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `order` (`order`, `product`),
  KEY `FK_PRODUCT` (`product`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `orders_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id`               INT(11)       NOT NULL AUTO_INCREMENT,
  `name`             VARCHAR(255)  NOT NULL,
  `description`      TEXT          NOT NULL,
  `price`            DECIMAL(8, 2) NOT NULL,
  `date`             DATETIME      NOT NULL,
  `category`         INT(11)       NOT NULL,
  `weight`           DECIMAL(8, 2) NOT NULL DEFAULT '0.00',
  `image`            VARCHAR(100)           DEFAULT NULL,
  `identity`         VARCHAR(200)           DEFAULT NULL,
  `meta_title`       VARCHAR(255)           DEFAULT NULL,
  `meta_description` VARCHAR(255)           DEFAULT NULL,
  `meta_keywords`    VARCHAR(255)           DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `products`
--


-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id`   INT(11)     NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 4;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` VALUES (1, 'Pending');
INSERT INTO `statuses` VALUES (2, 'Processing');
INSERT INTO `statuses` VALUES (3, 'Dispatched');
INSERT INTO `statuses` VALUES (4, 'Cancelled');

--
-- Table structure for table `shipping_type`
--

CREATE TABLE `shipping_type` (
  `id`      INT(11)      NOT NULL AUTO_INCREMENT,
  `name`    VARCHAR(255) NOT NULL,
  `order`   INT(11)      NOT NULL DEFAULT '0',
  `local`   TINYINT(1)   NOT NULL DEFAULT '0',
  `default` TINYINT(1)   NOT NULL DEFAULT '0',
  `active`  TINYINT(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `shipping_type`
--
INSERT INTO `shipping_type` VALUES (1, 'Next Day', 1, 1, 0, 1);
INSERT INTO `shipping_type` VALUES (2, 'Speedy 1-2 Days', 2, 1, 0, 1);
INSERT INTO `shipping_type` VALUES (3, 'Standard 3-5 Days', 3, 1, 1, 1);
INSERT INTO `shipping_type` VALUES (4, 'Economy 5-7 Days', 4, 1, 0, 1);
INSERT INTO `shipping_type` VALUES (5, 'Standard International', 2, 0, 0, 1);
INSERT INTO `shipping_type` VALUES (6, 'Express International', 1, 0, 1, 1);

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id`   INT(11)     NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Dumping data for table `zones`
--
INSERT INTO `zones` VALUES (1, 'Local');
INSERT INTO `zones` VALUES (2, 'Zone 1');
INSERT INTO `zones` VALUES (3, 'Zone 2');

--
-- Table structure for table `zones_country_codes`
--

CREATE TABLE `zones_country_codes` (
  `id`           INT(11)    NOT NULL AUTO_INCREMENT,
  `zone`         INT(11)    NOT NULL DEFAULT '0',
  `country_code` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Constraints for table `zones_country_codes`
--
ALTER TABLE `zones_country_codes`
ADD CONSTRAINT `zones_country_codes_ibfk_1` FOREIGN KEY (`zone`) REFERENCES `zones` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id`      INT(11)       NOT NULL  AUTO_INCREMENT,
  `type`    INT(11)       NOT NULL  DEFAULT '0',
  `zone`    INT(11)       NOT NULL  DEFAULT '0',
  `country` INT(11)       NOT NULL  DEFAULT '0',
  `weight`  DECIMAL(8, 2) NOT NULL  DEFAULT '0.00',
  `cost`    DECIMAL(8, 2) NOT NULL  DEFAULT '0.00',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`type`) REFERENCES `shipping_type` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE,
ADD CONSTRAINT `shipping_ibfk_2` FOREIGN KEY (`zone`) REFERENCES `zones` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE,
ADD CONSTRAINT `shipping_ibfk_3` FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`id`)
  ON UPDATE CASCADE,
ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`)
  ON UPDATE CASCADE;

--
-- Constraints for table `orders_items`
--
ALTER TABLE `orders_items`
ADD CONSTRAINT `orders_items_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `orders_items_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`)
  ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Constraints for table `business`
--
ALTER TABLE `business`
ADD CONSTRAINT `business_ibfk_1` FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

--
-- Dumping data for table `business`
--
INSERT INTO `business` VALUES (1, 'MyECOMM', '123 Way Street\nSan Jose, CA 95192', 230, '408-505-0000', ' support@myecomm.com', 'www.MyECOMM.com', NULL, 10.00);

--
-- Dumping data for table `products`
--
INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`)
VALUES (1, 'Beginning PHP and MySQL',
        'Beginning PHP and MySQL: From Novice to Professional, Fourth Edition is a major update of W. Jason Gilmore''s authoritative book on PHP and MySQL. The fourth edition includes complete coverage of PHP 5.3 features, including namespacing, an update of AMP stack installation and configuration, updates to Zend Framework, coverage of MySQL Workbench, and much more.',
        '25.99', NOW(), 2, 'beginning-php.jpg');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`)
VALUES (2, 'jQuery Mobile Web Development Essentials',
        'jQuery Mobile is a unified, HTML5-based user interface system for all popular mobile device platforms. It is compatible with all major mobile, tablet, e-reader and desktop platforms like iOS, Android, Blackberry, Palm WebOS, Nokia/Symbian, and Windows Phone 7. jQuery Mobile Web Development Essentials will explain how to create mobile-optimized sites with the easiest, most practical HTML/JavaScript framework available and to add the framework to your HTML pages to create rich, mobile-optimized web pages with minimal effort. Throughout the book, you''ll learn details that help you become a pro at mobile web development. You begin with simple HTML and quickly enhance it using jQuery Mobile for incredible mobile-optimized sites. Start by learning the building blocks of jQuery Mobile''s component-driven design. Dig into forms, events, and styling, then finish by building native mobile applications. You will learn how to build websites and apps for touch devices such as iPhone, iPad, Android, and BlackBerry with the recently developed jQuery Mobile library through sample applications of increasing complexity.',
        '21.99', NOW(), 2, 'jquery-mobile-web.jpg');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`)
VALUES (3, 'Spring Web Flow 2 Web Development',
        'This book is a tutorial, with plenty of step-by-step instructions beginning with ''getting started'' material, followed by advanced coverage of this technology. The book has a practical approach towards the Spring MVC framework and is packed with practical examples and code. This book is targeted at Java web application developers who want to work on Spring Web Flow. This book is a must-read for those who desire to bridge the gap between the popular web framework and the popular application framework. It requires prior knowledge of the Spring framework, but no prior knowledge of Spring Web Flow.',
        '29.99', NOW(), 2, 'spring-web-dev.jpeg');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`)
VALUES (4, 'The Autobiography of Benjamin Franklin',
        'The Autobiography of Benjamin Franklin is the traditional name for the unfinished record of his own life written by Benjamin Franklin from 1771 to 1790; however, Franklin himself appears to have called the work his Memoirs. Although it had a tortuous publication history after Franklin''s death, this work has become one of the most famous and influential examples of an autobiography ever written.',
        '15.99', NOW(), 1, 'ben-franklin_cover.jpg');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`)
VALUES (5, 'Rocky Marciano: Biography of a First Son',
        'Spirited, fast-paced, and rich in detail, Rocky Marciano: The Rock of His Times is the first book to tell the full story of the man, his sport, and his era. Emerging from obscurity to win the heavyweight crown in the early 1950s, Marciano fought until 1955, retiring with a perfect 49-0 record - a feat still unmatched today. Yet as much as he embodied the wholesome, rags-to-riches patriotism of a true American hero, Marciano also reflected the racial and ethnic tensions festering beneath the country''s benevolent facade. In this captivating portrait of a complex American sports legend, Russell Sullivan confirms Rocky Marciano''s place as a symbol and cultural icon of his era. Russell Sullivan lives in the Boston area and is senior vice president and general counsel of Linkage, Inc., a corporate education company headquartered in Burlington, Massachusetts. He is the author, coauthor, or editor of several books and articles on business-related topics. A volume in the series Sport and Society, edited by Benjamin G. Rader and Randy Roberts',
        '17.99', NOW(), 1, 'rocky-marciano-bio.jpg');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`)
VALUES (6, 'The Greatest: Muhammad Ali',
        'Gr 7 Up-An introduction to Ali''s life from his childhood to the present day, focusing on his career and the controversies surrounding him. Both his talent in the boxing ring and his showmanship earned him international fame, while his refusal to accept the stereotypical role of a black athletic star in the 1960s and his membership in the Nation of Islam brought him notoriety. Myers interweaves fight sequences with the boxer''s life story and the political events and issues of the day. He doesn''t shy away from reporting on the brutality of the sport and documents the toll it has taken on its many stars. Ample black-and-white photographs of the subject in and out of the ring illustrate the book. Covering Ali is a daunting task, especially since dozens of books and hundreds of articles have been written about him in the last 40 years. Fortunately, young adults have their own award-winning author, one with the perspective of being a young African American in Harlem during the height of the boxer''s fame, to tell his story. Myers''s writing flows while describing the boxing action and the legend''s larger-than-life story.-Michael McCullough, Byron-Bergen Middle School, Bergen, NY',
        '15.99', NOW(), 1, 'muhammad-ali-the-greatest.jpg');

UPDATE `products` SET `meta_title`  = `name`, `meta_description` = `name`,   `meta_keywords` = `name`;
UPDATE `products` SET `identity` = 'begging-php-mysql' WHERE `id` = 1;
UPDATE `products` SET `identity` = 'jquery-mobile-web-dev-ess' WHERE `id` = 2;
UPDATE `products` SET `identity` = 'spring-web-flow-2-dev' WHERE `id` = 3;
UPDATE `products` SET `identity` = 'autobiography-benjamin-franklin' WHERE `id` = 4;
UPDATE `products` SET `identity` = 'rocky-marciano-biography' WHERE `id` = 5;
UPDATE `products` SET `identity` = 'greatest-muhammad-ali' WHERE `id` = 6;
UPDATE `products` SET `weight` = 0.5 WHERE `id` = 1;
UPDATE `products` SET `weight` = 0.5 WHERE `id` = 2;
UPDATE `products` SET `weight` = 0.5 WHERE `id` = 3;
UPDATE `products` SET `weight` = 0.5 WHERE `id` = 4;
UPDATE `products` SET `weight` = 0.5 WHERE `id` = 5;
UPDATE `products` SET `weight` = 0.5 WHERE `id` = 6;
--
-- Dumping data for table `shipping`
--


--
-- Dumping data for table `zones_country_codes`
--
INSERT INTO `zones_country_codes` VALUES (1, 1, 'US');
INSERT INTO `zones_country_codes` VALUES (2, 2, 'CA');
INSERT INTO `zones_country_codes` VALUES (3, 2, 'MX');
INSERT INTO `zones_country_codes` VALUES (4, 3, 'BG');
INSERT INTO `zones_country_codes` VALUES (5, 3, 'PL');