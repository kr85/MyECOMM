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

CREATE TABLE `sections` (
  `id`               INT(11)      NOT NULL AUTO_INCREMENT,
  `name`             VARCHAR(150) NOT NULL,
  `identity`         VARCHAR(200)          DEFAULT NULL,
  `meta_title`       VARCHAR(255)          DEFAULT NULL,
  `meta_description` VARCHAR(255)          DEFAULT NULL,
  PRIMARY KEY (`id`)
);

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
  `section`          INT(11)      NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `section` (`section`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 4;

INSERT INTO `sections` (`id`, `name`, `identity`, `meta_title`, `meta_description`)
  VALUES (0, 'Default', 'default', 'Default', 'Default section.');
INSERT INTO `sections` (`id`, `name`, `identity`, `meta_title`, `meta_description`)
  VALUES (1, 'Books', 'books', 'Books', 'This section has a variety books in various categories.');
INSERT INTO `sections` (`id`, `name`, `identity`, `meta_title`, `meta_description`)
  VALUES (2, 'Textbooks', 'textbooks', 'Textbooks', 'This section has a variety textbooks in various categories.');
INSERT INTO `sections` (`id`, `name`, `identity`, `meta_title`, `meta_description`)
  VALUES (3, 'Audiobooks', 'audiobooks', 'Audiobooks', 'This section has a variety audiobooks in various categories.');
INSERT INTO `sections` (`id`, `name`, `identity`, `meta_title`, `meta_description`)
  VALUES (4, 'Children\'s', 'childrens', 'Children\'s', 'This section has a variety children\'s books in various categories.');
INSERT INTO `sections` (`id`, `name`, `identity`, `meta_title`, `meta_description`)
  VALUES (5, 'Used & Out of Print', 'used-out-of-print', 'Used & Out of Print', 'This section has a variety used & out of print books in various categories.');

INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (0, 'No Category', 'no-category', 'No Category', 'No Category', 0);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (1, 'Biographies & Memoirs', 'biographies-memoirs', 'Biographies & Memoirs', 'Biographies & Memoirs', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (2, 'Computers & Technology', 'computers-technology', 'Computers & Technology', 'Computers & Technology', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (3, 'Health, Fitness & Dieting', 'health-fitness-dieting', 'Health, Fitness & Dieting', 'Health, Fitness & Dieting', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (4, 'History', 'history', 'History', 'History', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (5, 'Science & Math', 'science-math', 'Science & Math', 'Science & Math', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (6, 'Arts & Photography', 'arts-photography', 'Arts & Photography', 'Arts & Photography', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (7, 'Engineering & Transportation', 'engineering-transportation', 'Engineering & Transportation', 'Engineering & Transportation', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (8, 'Sports & Outdoors', 'sports-outdoors', 'Sports & Outdoors', 'Sports & Outdoors', 1);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (9, 'Science & Math', 'science-math', 'Science & Math', 'Science & Math', 2);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (10, 'Business & Money', 'business-money', 'Business & Money', 'Business & Money', 2);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (11, 'Medical', 'medical', 'Medical', 'Medical', 2);
INSERT INTO `categories` (`id`, `name`, `identity`, `meta_title`, `meta_description`, `section`)
  VALUES (12, 'Test Prep & Study Guides', 'test-prep-study-guides', 'Test Prep & Study Guides', 'Test Prep & Study Guides', 2);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id`                  INT(11)             NOT NULL AUTO_INCREMENT,
  `first_name`          VARCHAR(150)        NOT NULL,
  `last_name`           VARCHAR(150)        NOT NULL,
  `address_1`           VARCHAR(255)        NOT NULL,
  `address_2`           VARCHAR(255)        NULL,
  `city`                VARCHAR(255)        NOT NULL,
  `state`               VARCHAR(255)        NOT NULL,
  `zip_code`            VARCHAR(10)         NOT NULL,
  `country`             INT(11)             NOT NULL,
  `same_address`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `shipping_first_name` VARCHAR(150)        NULL,
  `shipping_last_name`  VARCHAR(150)        NULL,
  `shipping_address_1`  VARCHAR(255)        NULL,
  `shipping_address_2`  VARCHAR(255)        NULL,
  `shipping_city`       VARCHAR(255)        NULL,
  `shipping_state`      VARCHAR(255)        NULL,
  `shipping_zip_code`   VARCHAR(255)        NULL,
  `shipping_country`    INT(11)             NULL     DEFAULT '0',
  `email`               VARCHAR(255)        NOT NULL,
  `shipping_email`      VARCHAR(255)        NULL,
  `password`            VARCHAR(255)        NOT NULL,
  `date`                DATETIME            NOT NULL,
  `active`              TINYINT(1)          NOT NULL DEFAULT '0',
  `hash`                VARCHAR(255)                 DEFAULT NULL,
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
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id`      INT(11)      NOT NULL  AUTO_INCREMENT,
  `country` INT(11)      NOT NULL  DEFAULT '0',
  `name`    VARCHAR(255) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id`                  INT(11)       NOT NULL AUTO_INCREMENT,
  `token`               VARCHAR(255)  NOT NULL,
  `client`              INT(11)       NOT NULL,
  `first_name`          VARCHAR(150)  NOT NULL,
  `last_name`           VARCHAR(150)  NOT NULL,
  `address_1`           VARCHAR(255)  NOT NULL,
  `address_2`           VARCHAR(255)  NULL,
  `city`                VARCHAR(255)  NOT NULL,
  `state`               VARCHAR(255)  NOT NULL,
  `zip_code`            VARCHAR(10)   NOT NULL,
  `country`             INT(11)       NOT NULL,
  `shipping_first_name` VARCHAR(150)  NULL,
  `shipping_last_name`  VARCHAR(150)  NULL,
  `shipping_address_1`  VARCHAR(255)  NULL,
  `shipping_address_2`  VARCHAR(255)  NULL,
  `shipping_city`       VARCHAR(255)  NULL,
  `shipping_state`      VARCHAR(255)  NULL,
  `shipping_zip_code`   VARCHAR(255)  NULL,
  `shipping_country`    INT(11)       NULL     DEFAULT '0',
  `shipping_cost`       DECIMAL(8, 2) NOT NULL DEFAULT '0',
  `shipping_type`       VARCHAR(100)  NULL,
  `tax_number`          VARCHAR(20)   NULL,
  `tax_rate`            DECIMAL(5, 2) NOT NULL,
  `tax`                 DECIMAL(8, 2) NOT NULL,
  `subtotal_items`      DECIMAL(8, 2) NOT NULL DEFAULT '0',
  `subtotal`            DECIMAL(8, 2) NOT NULL,
  `total`               DECIMAL(8, 2) NOT NULL,
  `date`                DATETIME      NOT NULL,
  `status`              INT(11)       NOT NULL DEFAULT '1',
  `pp_status`           TINYINT(1)    NOT NULL DEFAULT '0',
  `txn_id`              VARCHAR(100)           DEFAULT NULL,
  `payment_status`      VARCHAR(100)           DEFAULT NULL,
  `ipn`                 TEXT,
  `response`            TEXT,
  `notes`               TEXT,
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
  `date`             TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `section`          INT(11)       NOT NULL,
  `category`         INT(11)       NOT NULL,
  `weight`           DECIMAL(8, 2) NOT NULL DEFAULT '0.00',
  `image`            VARCHAR(255)           DEFAULT NULL,
  `identity`         VARCHAR(255)           DEFAULT NULL,
  `meta_title`       VARCHAR(255)           DEFAULT NULL,
  `meta_description` VARCHAR(255)           DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `section` (`section`),
  KEY `category` (`category`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;


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
  `zone`    INT(11)       NULL  DEFAULT '0',
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
ADD CONSTRAINT `shipping_ibfk_2` FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `states`
--
ALTER TABLE `states`
ADD CONSTRAINT `states_ibfk_1` FOREIGN KEY (`country`) REFERENCES `countries` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

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
-- Constraints for table `categories`
--
ALTER TABLE `categories`
ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`section`) REFERENCES `sections` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`section`) REFERENCES `sections` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
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
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (1, 'The Autobiography of Benjamin Franklin', 'The Autobiography of Benjamin Franklin is the traditional name for the unfinished record of his own life written by Benjamin Franklin from 1771 to 1790; however, Franklin himself appears to have called the work his Memoirs. Although it had a tortuous publication history after Franklin''s death, this work has become one of the most famous and influential examples of an autobiography ever written.', '15.99', 0.5, NOW(), 1, 1, 'ben-franklin_cover.jpg', 'autobiography-benjamin-franklin', 'The Autobiography of Benjamin Franklin', 'The Autobiography of Benjamin Franklin');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (2, 'Rocky Marciano: Biography of a First Son', 'Spirited, fast-paced, and rich in detail, Rocky Marciano: The Rock of His Times is the first book to tell the full story of the man, his sport, and his era. Emerging from obscurity to win the heavyweight crown in the early 1950s, Marciano fought until 1955, retiring with a perfect 49-0 record - a feat still unmatched today. Yet as much as he embodied the wholesome, rags-to-riches patriotism of a true American hero, Marciano also reflected the racial and ethnic tensions festering beneath the country''s benevolent facade. In this captivating portrait of a complex American sports legend, Russell Sullivan confirms Rocky Marciano''s place as a symbol and cultural icon of his era. Russell Sullivan lives in the Boston area and is senior vice president and general counsel of Linkage, Inc., a corporate education company headquartered in Burlington, Massachusetts. He is the author, coauthor, or editor of several books and articles on business-related topics. A volume in the series Sport and Society, edited by Benjamin G. Rader and Randy Roberts', '17.99', 0.5, NOW(), 1, 1, 'rocky-marciano-bio.jpg', 'rocky-marciano-biography', 'Rocky Marciano: Biography of a First Son', 'Rocky Marciano: Biography of a First Son');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (3, 'The Greatest: Muhammad Ali', 'Gr 7 Up-An introduction to Ali''s life from his childhood to the present day, focusing on his career and the controversies surrounding him. Both his talent in the boxing ring and his showmanship earned him international fame, while his refusal to accept the stereotypical role of a black athletic star in the 1960s and his membership in the Nation of Islam brought him notoriety. Myers interweaves fight sequences with the boxer''s life story and the political events and issues of the day. He doesn''t shy away from reporting on the brutality of the sport and documents the toll it has taken on its many stars. Ample black-and-white photographs of the subject in and out of the ring illustrate the book. Covering Ali is a daunting task, especially since dozens of books and hundreds of articles have been written about him in the last 40 years. Fortunately, young adults have their own award-winning author, one with the perspective of being a young African American in Harlem during the height of the boxer''s fame, to tell his story. Myers''s writing flows while describing the boxing action and the legend''s larger-than-life story.-Michael McCullough, Byron-Bergen Middle School, Bergen, NY', '15.99', 0.5, NOW(), 1, 1, 'muhammad-ali-the-greatest.jpg', 'greatest-muhammad-ali', 'The Greatest: Muhammad Ali', 'The Greatest: Muhammad Ali');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (4, 'Raging Bull: My Story', 'Meet Jake La Motta: thief, rapist, killer. Raised in the Bronx slums, he fought on the streets, got sent to reform school, and served time in prison. Trusting no one, slugging everyone, he beat his wife, his best friends, even the mobsters who kept the title just out of reach. But the same forces that made him a criminal—fear, rage, jealousy, self-hate, guilt—combined with his drive and intelligence to make him a winner in the ring. At age twenty-seven, after eight years of fighting, he became Middleweight Champion of the World, a hero to thousands. Then, at the peak of success, he fell apart and began a swift, harrowing descent into nightmare. Raging Bull, the Bronx Bull''s brutally candid memoir, tells it all—fights, jails, sex, money—surpassing, in hard-hitting prose, even the movie that immortalized it.', '27.01', 0.5, '1997-08-22 00:00:00', 1, 1, 'jake-lamotta-bio.jpg', 'raging-bull-my-story', 'Raging Bull: My Story', 'Raging Bull: My Story');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (5, 'For the Love of the Game: My Story', 'In For the Love of the Game, Jordan takes us through the wonder of his career on the court and away from the game. From the dream that preceded the game-winning shot against Georgetown in the 1982 NCAA Finals to the methodical dissection of the Utah Jazz prior to his game-winning shot in Game 6 of the 1998 Finals, Jordan pulls back the curtain on one of the most remarkable lives this century.', '15.00', 0.5, '1998-10-27 00:00:00', 1, 1, 'michael-jordan-autobio.jpg', 'for-the-love-of-the-game-my-story', 'For the Love of the Game: My Story', 'For the Love of the Game: My Story');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (6, 'Washington: A Life', 'Celebrated biographer Ron Chernow provides a richly nuanced portrait of the father of our nation and the first president of the United States. With a breadth and depth matched by no other one volume biography of George Washington, this crisply paced narrative carries the reader through his adventurous early years, his heroic exploits with the Continental Army during the Revolutionary War, his presiding over the Constitutional Convention, and his magnificent performance as America''s first president. In this groundbreaking work, based on massive research, Chernow shatters forever the stereotype of George Washington as a stolid, unemotional figure and brings to vivid life a dashing, passionate man of fiery opinions and many moods.', '27.58', 0.5, '2011-09-27 00:00:00', 1, 1, 'washington-a-life.jpg', 'washington-a-life', 'Washington: A Life', 'Washington: A Life');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (7, 'The Epic Life of Cornelius Vanderbilt', 'In this groundbreaking biography, T.J. Stiles tells the dramatic story of Cornelius “Commodore” Vanderbilt, the combative man and American icon who, through his genius and force of will, did more than perhaps any other individual to create modern capitalism. Meticulously researched and elegantly written, The First Tycoon describes an improbable life, from Vanderbilt’s humble birth during the presidency of George Washington to his death as one of the richest men in American history. In between we see how the Commodore helped to launch the transportation revolution, propel the Gold Rush, reshape Manhattan, and invent the modern corporation. Epic in its scope and success, the life of Vanderbilt is also the story of the rise of America itself.', '28.59', 0.5, '2010-04-20 00:00:00', 1, 1, 'the-first-tycoon.jpg', 'the-first-tycoon', 'The First Tycoon: The Epic Life of Cornelius Vanderbilt', 'The First Tycoon: The Epic Life of Cornelius Vanderbilt');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (8, 'The Triumph and Tragedy of J. Robert Oppenheimer', 'J. Robert Oppenheimer is one of the iconic figures of the twentieth century, a brilliant physicist who led the effort to build the atomic bomb for his country in a time of war, and who later found himself confronting the moral consequences of scientific progress. In this magisterial, acclaimed biography twenty-five years in the making, Kai Bird and Martin Sherwin capture Oppenheimer’s life and times, from his early career to his central role in the Cold War. This is biography and history at its finest, riveting and deeply informative.', '5.75', 0.5, '2006-04-11 00:00:00', 1, 1, 'american-prometheus.jpg', 'american-prometheus', 'American Prometheus: The Triumph and Tragedy of J. Robert Oppenheimer', 'American Prometheus: The Triumph and Tragedy of J. Robert Oppenheimer');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (9, 'American Lion: Andrew Jackson in the White House', 'Andrew Jackson, his intimate circle of friends, and his tumultuous times are at the heart of this remarkable book about the man who rose from nothing to create the modern presidency. Beloved and hated, venerated and reviled, Andrew Jackson was an orphan who fought his way to the pinnacle of power, bending the nation to his will in the cause of democracy. Jackson’s election in 1828 ushered in a new and lasting era in which the people, not distant elites, were the guiding force in American politics. Democracy made its stand in the Jackson years, and he gave voice to the hopes and the fears of a restless, changing nation facing challenging times at home and threats abroad. To tell the saga of Jackson’s presidency, acclaimed author Jon Meacham goes inside the Jackson White House. Drawing on newly discovered family letters and papers, he details the human drama–the family, the women, and the inner circle of advisers–that shaped Jackson’s private world through years of storm and victory.', '14.60', 0.5, '2009-04-30 00:00:00', 1, 1, 'american-lion-andrew-jackson.jpg', 'american-lion-andrew-jackson', 'American Lion: Andrew Jackson in the White House', 'American Lion: Andrew Jackson in the White House');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (10, 'Girl in a Band: A Memoir', 'Kim Gordon, founding member of Sonic Youth, fashion icon, and role model for a generation of women, now tells her story—a memoir of life as an artist, of music, marriage, motherhood, independence, and as one of the first women of rock and roll, written with the lyricism and haunting beauty of Patti Smith''s Just Kids. Often described as aloof, Kim Gordon opens up as never before in Girl in a Band. Telling the story of her family, growing up in California in the ''60s and ''70s, her life in visual art, her move to New York City, the men in her life, her marriage, her relationship with her daughter, her music, and her band, Girl in a Band is a rich and beautifully written memoir.', '21.16', 0.5, '2015-02-27 00:00:00', 1, 1, 'girl-in-a-band.jpg', 'girl-in-a-band', 'Girl in a Band: A Memoir', 'Girl in a Band: A Memoir');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (11, 'Napoleon: A Life', 'Austerlitz, Borodino, Waterloo: his battles are among the greatest in history, but Napoleon Bonaparte was far more than a military genius and astute leader of men. Like George Washington and his own hero Julius Caesar, he was one of the greatest soldier-statesmen of all times. Andrew Roberts’s Napoleon is the first one-volume biography to take advantage of the recent publication of Napoleon’s thirty-three thousand letters, which radically transform our understanding of his character and motivation. At last we see him as he was: protean multitasker, decisive, surprisingly willing to forgive his enemies and his errant wife Josephine. Like Churchill, he understood the strategic importance of telling his own story, and his memoirs, dictated from exile on St. Helena, became the single bestselling book of the nineteenth century.', '27.00', 0.5, NOW(), 1, 1, 'napoleon-a-life.jpg', 'napoleon-a-life', 'Napoleon: A Life', 'Napoleon: A Life');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (12, 'God, Guns, Grits, and Gravy', 'In God, Guns, Grits and Gravy, Mike Huckabee asks, “Have I been taken to a different planet than the one on which I grew up?”  The New York Times bestselling author explores today’s fractious American culture, where divisions of class, race, politics, religion, gender, age, and other fault lines make polite conversation dicey, if not downright dangerous. As Huckabee notes, the differences of opinion between the “Bubble-villes” of the big power centers and the “Bubba-villes” where most people live are profound, provocative, and sometimes pretty funny. Where else but in Washington, D.C. could two presidential golf outings cost the American taxpayers $2.9 million in travel expenses?', '26.99', 0.5, NOW(), 1, 1, 'god-guns-grits-and-gravy.jpg', 'god-guns-grits-and-gravy', 'God, Guns, Grits, and Gravy', 'God, Guns, Grits, and Gravy');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (13, 'Into the Wild', 'In April 1992 a young man from a well-to-do family hitchhiked to Alaska and walked alone into the wilderness north of Mt. McKinley. His name was Christopher Johnson McCandless. He had given $25,000 in savings to charity, abandoned his car and most of his possessions, burned all the cash in his wallet, and invented a new life for himself. Four months later, his decomposed body was found by a moose hunter.  How McCandless came to die is the unforgettable story of Into the Wild.', '14.95', 0.5, NOW(), 1, 1, 'into-the-wild.jpg', 'into-the-wild', 'Into the Wild', 'Into the Wild');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (14, 'Sam Walton: Made In America', 'Meet a genuine American folk hero cut from the homespun cloth of America''s heartland: Sam Walton, who parlayed a single dime store in a hardscrabble cotton town into Wal-Mart, the largest retailer in the world.  The undisputed merchant king of the late twentieth century, Sam never lost the common touch.  Here, finally, inimitable words.  Genuinely modest, but always sure if his ambitions and achievements.  Sam shares his thinking in a candid, straight-from-the-shoulder style. In a story rich with anecdotes and the "rules of the road" of both Main Street and Wall Street, Sam Walton chronicles the inspiration, heart, and optimism that propelled him to lasso the American Dream.', '7.99', 0.5, NOW(), 1, 1, 'sam-walton-made-in-america.jpg', 'sam-walton-made-in-america', 'Sam Walton: Made In America', 'Sam Walton: Made In America');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (15, 'Yes Please', 'Do you want to get to know the woman we first came to love on Comedy Central''s Upright Citizens Brigade? Do you want to spend some time with the lady who made you howl with laughter on Saturday Night Live, and in movies like Baby Mama, Blades of Glory, and They Came Together? Do you find yourself daydreaming about hanging out with the actor behind the brilliant Leslie Knope on Parks and Recreation? Did you wish you were in the audience at the last two Golden Globes ceremonies, so you could bask in the hilarity of Amy''s one-liners?', '17.79', 0.5, NOW(), 1, 1, 'yes-please.jpg', 'yes-please', 'Yes Please', 'Yes Please');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (16, 'Beginning PHP and MySQL', 'Beginning PHP and MySQL: From Novice to Professional, Fourth Edition is a major update of W. Jason Gilmore''s authoritative book on PHP and MySQL. The fourth edition includes complete coverage of PHP 5.3 features, including namespacing, an update of AMP stack installation and configuration, updates to Zend Framework, coverage of MySQL Workbench, and much more.', '25.99', 0.5, NOW(), 1, 2, 'beginning-php.jpg', 'begging-php-mysql', 'Beginning PHP and MySQL', 'Beginning PHP and MySQL');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (17, 'jQuery Mobile Web Development Essentials', 'jQuery Mobile is a unified, HTML5-based user interface system for all popular mobile device platforms. It is compatible with all major mobile, tablet, e-reader and desktop platforms like iOS, Android, Blackberry, Palm WebOS, Nokia/Symbian, and Windows Phone 7. jQuery Mobile Web Development Essentials will explain how to create mobile-optimized sites with the easiest, most practical HTML/JavaScript framework available and to add the framework to your HTML pages to create rich, mobile-optimized web pages with minimal effort. Throughout the book, you''ll learn details that help you become a pro at mobile web development. You begin with simple HTML and quickly enhance it using jQuery Mobile for incredible mobile-optimized sites. Start by learning the building blocks of jQuery Mobile''s component-driven design. Dig into forms, events, and styling, then finish by building native mobile applications. You will learn how to build websites and apps for touch devices such as iPhone, iPad, Android, and BlackBerry with the recently developed jQuery Mobile library through sample applications of increasing complexity.', '21.99', 0.5, NOW(), 1, 2, 'jquery-mobile-web.jpg', 'jquery-mobile-web-dev-ess', 'jQuery Mobile Web Development Essentials', 'jQuery Mobile Web Development Essentials');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (18, 'Spring Web Flow 2 Web Development', 'This book is a tutorial, with plenty of step-by-step instructions beginning with ''getting started'' material, followed by advanced coverage of this technology. The book has a practical approach towards the Spring MVC framework and is packed with practical examples and code. This book is targeted at Java web application developers who want to work on Spring Web Flow. This book is a must-read for those who desire to bridge the gap between the popular web framework and the popular application framework. It requires prior knowledge of the Spring framework, but no prior knowledge of Spring Web Flow.', '29.99', 0.5, NOW(), 1, 2, 'spring-web-dev.jpeg', 'spring-web-flow-2-dev', 'Spring Web Flow 2 Web Development', 'Spring Web Flow 2 Web Development');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (19, 'HTML and CSS: Design and Build Websites', 'A full-color introduction to the basics of HTML and CSS from the publishers of Wrox! Every day, more and more people want to learn some HTML and CSS. Joining the professional web designers and programmers are new audiences who need to know a little bit of code at work (update a content management system or e-commerce store) and those who want to make their personal blogs more attractive. Many books teaching HTML and CSS are dry and only written for those who want to become programmers, which is why this book takes an entirely new approach.', '17.39', 0.5, NOW(), 1, 2, 'html-css-design-websites.jpg', 'html-css-design-websites', 'HTML and CSS: Design and Build Websites', 'HTML and CSS: Design and Build Websites');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (20, 'The Pragmatic Programmer: From Journeyman to Master', 'Programmers are craftspeople trained to use a certain set of tools (editors, object managers, version trackers) to generate a certain kind of product (programs) that will operate in some environment (operating systems on hardware assemblies). Like any other craft, computer programming has spawned a body of wisdom, most of which isn''t taught at universities or in certification classes. Most programmers arrive at the so-called tricks of the trade over time, through independent experimentation. In The Pragmatic Programmer, Andrew Hunt and David Thomas codify many of the truths they''ve discovered during their respective careers as designers of software and writers of code.', '35.22', 0.5, NOW(), 1, 2, 'from-journeyman-to-master.jpg', 'from-journeyman-to-master', 'The Pragmatic Programmer: From Journeyman to Master', 'The Pragmatic Programmer: From Journeyman to Master');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (21, 'JavaScript: The Good Parts', 'Most programming languages contain good and bad parts, but JavaScript has more than its share of the bad, having been developed and released in a hurry before it could be refined. This authoritative book scrapes away these bad features to reveal a subset of JavaScript that''s more reliable, readable, and maintainable than the language as a whole—a subset you can use to create truly extensible and efficient code.', '21.35', 0.5, NOW(), 1, 2, 'javaScript-good-parts.jpg', 'javaScript-good-parts', 'JavaScript: The Good Parts', 'JavaScript: The Good Parts');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (22, 'Head First Java, 2nd Edition', 'The fact is your brain craves novelty. It''s constantly searching, scanning, waiting for something unusual to happen. After all, that''s the way it was built to help you stay alive. It takes all the routine, ordinary, dull stuff and filters it to the background so it won''t interfere with your brain''s real work--recording things that matter. How does your brain know what matters? It''s like the creators of the Head First approach say, suppose you''re out for a hike and a tiger jumps in front of you, what happens in your brain? Neurons fire. Emotions crank up. Chemicals surge. That''s how your brain knows.', '28.95', 0.5, NOW(), 1, 2, 'head-first-java-2-edition.jpg', 'head-first-java-2-edition', 'Head First Java, 2nd Edition', 'Head First Java, 2nd Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (23, 'Head First Design Patterns', 'At any given moment, someone struggles with the same software design problems you have. And, chances are, someone else has already solved your problem. This edition of Head First Design Patterns—now updated for Java 8—shows you the tried-and-true, road-tested patterns used by developers to create functional, elegant, reusable, and flexible software. By the time you finish this book, you’ll be able to take advantage of the best design practices and experiences of those who have fought the beast of software design and triumphed.', '41.16', 0.5, NOW(), 1, 2, 'head-first-design-patterns.jpg', 'head-first-design-patterns', 'Head First Design Patterns', 'Head First Design Patterns');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (24, 'Introduction to Algorithms, 3rd Edition', 'Some books on algorithms are rigorous but incomplete; others cover masses of material but lack rigor. Introduction to Algorithms uniquely combines rigor and comprehensiveness. The book covers a broad range of algorithms in depth, yet makes their design and analysis accessible to all levels of readers. Each chapter is relatively self-contained and can be used as a unit of study. The algorithms are described in English and in a pseudocode designed to be readable by anyone who has done a little programming. The explanations have been kept elementary without sacrificing depth of coverage or mathematical rigor.', '79.13', 0.5, NOW(), 1, 2, 'intro-algorithms-3-ed.jpg', 'intro-algorithms-3-ed', 'Introduction to Algorithms, 3rd Edition', 'Introduction to Algorithms, 3rd Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (25, 'Algorithms Unlocked', 'Have you ever wondered how your GPS can find the fastest way to your destination, selecting one route from seemingly countless possibilities in mere seconds? How your credit card account number is protected when you make a purchase over the Internet? The answer is algorithms. And how do these mathematical formulations translate themselves into your GPS, your laptop, or your smart phone? This book offers an engagingly written guide to the basics of computer algorithms. In Algorithms Unlocked, Thomas Cormen -- coauthor of the leading college textbook on the subject -- provides a general explanation, with limited mathematics, of how algorithms enable computers to solve problems. ', '22.50', 0.5, NOW(), 1, 2, 'algorithms-unlocked.jpg', 'algorithms-unlocked', 'Algorithms Unlocked', 'Algorithms Unlocked');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (26, 'Practical, Server-Side JavaScript That Scales', 'Get to the forefront of server-side JavaScript programming by writing compact, robust, fast, networked Node applications that scale. Ready to take JavaScript beyond the browser, explore dynamic languages features and embrace evented programming? Explore the fun, growing repository of Node modules provided by npm. Work with multiple protocols, load-balanced RESTful web services, express, 0MQ, Redis, CouchDB, and more. Develop production-grade Node applications fast.', '15.60', 0.5, NOW(), 1, 2, 'server-side-javascript-that-scales.jpg', 'server-side-javascript-that-scales', 'Node.js the Right Way: Practical, Server-Side JavaScript That Scales', 'Node.js the Right Way: Practical, Server-Side JavaScript That Scales');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (27, 'The Rails 4 Way (3rd Edition)', ' The Rails™ 4 Way is the only comprehensive, authoritative guide to delivering production-quality code with Rails 4. Kevin Faustino joins pioneering Rails developer Obie Fernandez to illuminate the entire Rails 4 API, including its most powerful and modern idioms, design approaches, and libraries. They present extensive new and updated content on security, performance, caching, Haml, RSpec, Ajax, the Asset Pipeline, and more.', '33.67', 0.5, NOW(), 1, 2, 'rails-4-way-3-ed.jpg', 'rails-4-way-3-ed', 'The Rails 4 Way (3rd Edition)', 'The Rails 4 Way (3rd Edition)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (28, 'PHP: Learn PHP Programming FAST!', 'PHP is a powerful development tool allowing more elegant access to databases and records on websites. With the explosion of corporate use of big data, PHP is only becoming more useful. Soon any developer who doesn’t know PHP will be like a mechanic without a wrench.', '12.35', 0.5, NOW(), 1, 2, 'learn-php-programming-fast.jpg', 'learn-php-programming-fast', 'PHP: Learn PHP Programming FAST!', 'PHP: Learn PHP Programming FAST!');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (29, 'Instant Debian - Build a Web Server', 'Debian: Build a Web Server How-To will help you effectively setup and deploy a Debian-based Web server with strong foundations for the future of your Web application. It teaches concepts such as library and framework availability and suitability under the APT system, how to read and process logs and events and how to respond to security incidents. Additionally it also covers planning and executing a backup and restore strategy and how to deploy clusters and proxies.', '24.99', 0.5, NOW(), 1, 2, 'instant-debian-web-server.jpg', 'instant-debian-web-server', 'Instant Debian - Build a Web Server', 'Instant Debian - Build a Web Server');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (30, 'Drupal 7 Module Development', 'This book takes a hands-on, practical approach to software development. The authors, all professional Drupal developers and contributors to the Drupal project, provide accessible coding samples designed to exhibit not only the technical merits and abilities of Drupal, but also proper architectural and stylistic approaches to coding on one of the world''s most popular content management systems. Every chapter provides fully functional code samples illustrating the APIs and strategies discussed in the chapter. With this foundation, developers can quickly build sophisticated tools on their own by making use of the strategies and techniques exemplified in this book.', '40.49', 0.5, NOW(), 1, 2, 'drupal-7-module-dev.jpg', 'drupal-7-module-dev', 'Drupal 7 Module Development', 'Drupal 7 Module Development');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (31, 'Starting Strength, 3rd edition', 'tarting Strength has been called the best and most useful of fitness books. The second edition, Starting Strength: Basic Barbell Training, sold over 80,000 copies in a competitive global market for fitness education. Along with Practical Programming for Strength Training 2nd Edition, they form a simple, logical, and practical approach to strength training. Now, after six more years of testing and adjustment with thousands of athletes in seminars all over the country, the updated third edition expands and improves on the previous teaching methods and biomechanical analysis.', '27.95', 0.5, NOW(), 1, 3, 'starting-strength-3-ed.jpg', 'starting-strength-3-ed', 'Starting Strength, 3rd edition', 'Starting Strength, 3rd edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (32, 'Yoga Anatomy-2nd Edition', ' The best-selling anatomy guide for yoga is now updated, expanded, and better than ever! With more asanas, vinyasas, full-color anatomical illustrations, and in-depth information, the second edition of Yoga Anatomy provides you with a deeper understanding of the structures and principles underlying each movement and of yoga itself. From breathing to inversions to standing poses, see how specific muscles respond to the movements of the joints; how alterations of a pose can enhance or reduce effectiveness; and how the spine, breathing, and body position are all fundamentally linked. ', '13.19', 0.5, NOW(), 1, 3, 'yoga-anatomy-2-ed.jpg', 'yoga-anatomy-2-ed', 'Yoga Anatomy-2nd Edition', 'Yoga Anatomy-2nd Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (33, 'The Bible of Bodybuilding, Fully Updated and Revised', 'From elite bodybuilding competitors to gymnasts, from golfers to fitness gurus, anyone who works out with weights must own this book -- a book that only Arnold Schwarzenegger could write, a book that has earned its reputation as "the bible of bodybuilding." Inside, Arnold covers the very latest advances in both weight training and bodybuilding competition, with new sections on diet and nutrition, sports psychology, the treatment and prevention of injuries, and methods of training, each illustrated with detailed photos of some of bodybuilding''s newest stars.', '63.73', 0.5, NOW(), 1, 3, 'bible-of-bodybuilding-updated-revised.jpg', 'bible-of-bodybuilding-updated-revised', 'The Bible of Bodybuilding, Fully Updated and Revised', 'The Bible of Bodybuilding, Fully Updated and Revised');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (34, 'Strength Training Anatomy, 3rd Edition', 'With new exercises, additional stretches, and more of Frédéric Delavier’s signature illustrations, you’ll gain a whole new understanding of how muscles perform during strength exercises. This one-of-a-kind best-seller combines the visual detail of top anatomy texts with the best of strength training advice. Many books explain what muscles are used during exercise, but no other resource brings the anatomy to life like Strength Training Anatomy. Over 600 full-color illustrations reveal the primary muscles worked along with all the relevant surrounding structures, including bones, ligaments, tendons, and connective tissue.', '13.63', 0.5, NOW(), 1, 3, 'strength-training-anatomy-3-ed.jpg', 'strength-training-anatomy-3-ed', 'Strength Training Anatomy, 3rd Edition', 'Strength Training Anatomy, 3rd Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (35, 'Bigger Leaner Stronger', 'If you want to be muscular, lean, and strong as quickly as possible without steroids, good genetics, or wasting ridiculous amounts of time in the gym and money on supplements...then you want to read this  book.', '12.38', 0.5, NOW(), 1, 3, 'bigger-leaner-stronger.jpg', 'bigger-leaner-stronger', 'Bigger Leaner Stronger', 'Bigger Leaner Stronger');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (36, 'Why We Get Fat: And What to Do About It', 'Building upon his critical work in Good Calories, Bad Calories and presenting fresh evidence for his claim, Gary Taubes revisits the urgent question of what’s making us fat—and how we can change. He reveals the bad nutritional science of the last century—none more damaging or misguided than the “calories-in, calories-out” model of why we get fat—and the good science that has been ignored. He also answers the most persistent questions: Why are some people thin and others fat? What roles do exercise and genetics play in our weight? What foods should we eat, and what foods should we avoid? Persuasive, straightforward, and practical, Why We Get Fat is an essential guide to nutrition and weight management.', '19.28', 0.5, NOW(), 1, 3, 'why-we-get-fat-what-to-do-about-it.jpg', 'why-we-get-fat-what-to-do-about-it', 'Why We Get Fat: And What to Do About It', 'Why We Get Fat: And What to Do About It');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (37, 'Burn the Fat, Feed the Muscle', 'A no-nonsense plan that has been proven and tested by more than 300,000 people in 154 countries. Whether you want to shed 10 pounds or 100, whether you want to build muscle or just look more toned, this book is the original “bible of fitness” that shows you how to get permanent results the safe, healthy, and natural way.', '18.60', 0.5, NOW(), 1, 3, 'burn-fat-feed-muscle.jpg', 'burn-fat-feed-muscle', 'Burn the Fat, Feed the Muscle', 'Burn the Fat, Feed the Muscle');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (38, 'Jiu-Jitsu University', 'Saulo Ribeiro—six-time Brazilian Jiu-Jitsu World Champion—is world-renowned for his functional jiu-jitsu knowledge and flawless technique. In Jiu-Jitsu University, Ribeiro shares with the public for the first time his revolutionary system of grappling, mapping out more than 200 techniques that carry you from white to black belt. Illuminating common jiu-jitsu errors and then illustrating practical remedies, this book is a must for all who train in jiu-jitsu. Not your run-of-the-mill technique book, Jiu-Jitsu University is a detailed training manual that will ultimately change the way jiu-jitsu is taught around the globe.', '26.63', 0.5, NOW(), 1, 3, 'jiu-jitsu-university.jpg', 'jiu-jitsu-university', 'Jiu-Jitsu University', 'Jiu-Jitsu University');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (39, 'Stretching: 30th Anniversary Edition', 'This is the book that people tell their friends about, that trainers suggest for virtually every sport and activity, and that medical professionals recommend to people just starting to get back in shape. Stretching first appeared in 1980 as a new generation of Americans became committed to running, cycling, aerobic training, and workouts in the gym — all of which are commonplace now.', '13.07', 0.5, NOW(), 1, 3, 'stretching-30th-anniversary.jpg', 'stretching-30th-anniversary', 'Stretching: 30th Anniversary Edition', 'Stretching: 30th Anniversary Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (40, 'Practical Paleo', 'Our great-grandmothers didn''t need nutrition lessons—then again, they weren''t forced to wade through aisle after aisle of packaged foods touting outlandish health claims and confusing marketing jargon. Over the last few decades, we''ve forgotten what "real food" is—and we''re left desperately seeking foods that will truly nourish our bodies. We''re disillusioned with the "conventional wisdom" for good reason—it''s gotten us nowhere.', '23.36', 0.5, NOW(), 1, 3, 'practical-paleo.jpg', 'practical-paleo', 'Practical Paleo', 'Practical Paleo');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (41, 'Paleo for Beginners', 'Paleo for Beginners will show you how to adopt a Paleo lifestyle in order to feel healthy, lose weight, and increase your energy level. With Paleo for Beginners, start enjoying the best health of your life today--all while losing weight and decreasing your odds of diabetes, hypertension, heart disease, cancer, osteoporosis, and many other modern health maladies.', '6.66', 0.5, NOW(), 1, 3, 'paleo-for-beginners.jpg', 'paleo-for-beginners', 'Paleo for Beginners', 'Paleo for Beginners');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (42, 'Eat Right 4 Your Type', '"What would you say if I told you that the secret to healthy, vigorous, and disease-free living might be as simple as knowing your blood type," ask Dr. Peter D''Adamo and Catherine Whitney, and in Eat Right 4 Your Type, they shows us the simple answer. If you''ve ever suspected that not everyone should eat the same thing or do the same exercise, you''re right. In fact, what foods we absorb well and how our bodies handle stress differ with each blood type.', '15.64', 0.5, NOW(), 1, 3, 'eat-right-4-your-type.jpg', 'eat-right-4-your-type', 'Eat Right 4 Your Type', 'Eat Right 4 Your Type');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (43, 'SuperLife', 'In Superlife, Darin Olien provides us with an entirely new way of thinking about health and wellbeing by identifying what he calls the life forces: Quality Nutrition, Hydration, Detoxification, Oxygenation, and Alkalization. Olien demonstrates in great detail how to maintain these processes, thereby allowing our bodies to do the rest. He tells us how we can maintain healthy weight, prevent even the most serious of diseases, and feel great. He explains that all of this is possible without any of the restrictive or gimmicky diet plans that never work in the long term.', '17.24', 0.5, NOW(), 1, 3, 'superlife.jpg', 'superlife', 'SuperLife', 'SuperLife');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (44, 'The Paleo Cookbook', 'Simply put, the Paleo diet is the diet that humans were intended to eat. The Paleo Cookbook will make it easy to start your Paleo journey. Low carb, high protein, and full of wholesome, natural foods, the Paleo diet has gained rapid popularity for those who truly savor good cooking, but no longer want to be weighed down by processed or unhealthy food. THE PALEO COOKBOOK simplifies the transition into the Paleo lifestyle. This comprehensive Paleo cookbook has 300 mouthwatering recipes for every meal and occasion, all gluten free and full of whole, unprocessed ingredients.', '22.99', 0.5, NOW(), 1, 3, 'paleo-cookbook.jpg', 'paleo-cookbook', 'The Paleo Cookbook', 'The Paleo Cookbook');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (45, 'The Magnesium Miracle', 'Magnesium is an essential nutrient, indispensable to your health and well-being. By adding this mineral to your diet, you are guarding against—and helping to alleviate—such threats as heart disease, stroke, osteoporosis, diabetes, depression, arthritis, and asthma. But despite magnesium’s numerous benefits, many Americans remain dangerously deficient. Updated and revised throughout with the latest research, featuring an all-new Introduction, this amazing guide explains the vital role that magnesium plays in your body and life.', '10.12', 0.5, NOW(), 1, 3, 'magnesium-miracle.jpg', 'magnesium-miracle', 'The Magnesium Miracle', 'The Magnesium Miracle');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (46, 'How the World Became Modern', 'Nearly six hundred years ago, a short, genial, cannily alert man in his late thirties took a very old manuscript off a library shelf, saw with excitement what he had discovered, and ordered that it be copied. That book was the last surviving manuscript of an ancient Roman philosophical epic, On the Nature of Things, by Lucretius—a beautiful poem of the most dangerous ideas: that the universe functioned without the aid of gods, that religious fear was damaging to human life, and that matter was made up of very small particles in eternal motion, colliding and swerving in new directions.', '10.28', 0.5, NOW(), 1, 4, 'the-swerve.jpg', 'the-swerve', 'How the World Became Modern', 'How the World Became Modern');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (47, 'The Sistine Secrets', 'The recent cleaning of the Sistine Chapel frescoes removed layer after layer of centuries of accumulated tarnish and darkness. The Sistine Secrets endeavors to remove the centuries of prejudice, censorship, and ignorance that blind us to the truth about one of the world''s most famous and beloved art treasures.', '18.87', 0.5, NOW(), 1, 4, 'the-sistine-secrets.jpg', 'the-sistine-secrets', 'The Sistine Secrets', 'The Sistine Secrets');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (48, 'The History of the World', 'In this new edition, Bancroft Prize-winning historian Odd Arne Westad has completely revised this landmark work to bring the narrative up to the twenty-first century, including the 9/11 attacks and the wars in the Middle East. Westad utilizes the remarkable gains in scholarship in recent decades to enhance the book''s coverage of early human life and vastly improve the treatment of India and China, Central Eurasia, early Islam, and the late Byzantine Empire, as well as the history of science, technology, and economics.', '28.93', 0.5, NOW(), 1, 4, 'history-of-the-world.jpg', 'history-of-the-world', 'The History of the World', 'The History of the World');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (49, 'Maimonides: Life and Thought', 'Maimonides was the greatest Jewish philosopher and legal scholar of the medieval period, a towering figure who has had a profound and lasting influence on Jewish law, philosophy, and religious consciousness. This book provides a comprehensive and accessible introduction to his life and work, revealing how his philosophical sensibility and outlook informed his interpretation of Jewish tradition.', '30.98', 0.5, NOW(), 1, 4, 'maimonides-life-and-thought.jpg', 'maimonides-life-and-thought', 'Maimonides: Life and Thought', 'Maimonides: Life and Thought');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (50, 'To Explain the World: The Discovery of Modern Science', 'In this rich, irreverent, and compelling history, Nobel Prize-winning physicist Steven Weinberg takes us across centuries from ancient Miletus to medieval Baghdad and Oxford, from Plato’s Academy and the Museum of Alexandria to the cathedral school of Chartres and the Royal Society of London. He shows that the scientists of ancient and medieval times not only did not understand what we understand about the world—they did not understand what there is to understand, or how to understand it.', '21.79', 0.5, NOW(), 1, 4, 'to-explain-the-world.jpg', 'to-explain-the-world', 'To Explain the World: The Discovery of Modern Science', 'To Explain the World: The Discovery of Modern Science');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (51, 'A Little History of the World', 'In 1935, with a doctorate in art history and no prospect of a job, the 26-year-old Ernst Gombrich was invited to attempt a history of the world for younger readers. Amazingly, he completed the task in an intense six weeks, and "Eine kurze Weltgeschichte fur junge Leser" was published in Vienna to immediate success, and is now available in twenty-five languages across the world. In forty concise chapters, Gombrich tells the story of man from the stone age to the atomic bomb. In between emerges a colourful picture of wars and conquests, grand works of art, and the spread and limitations of science.', '18.24', 0.5, NOW(), 1, 4, 'little-history-of-the-world.jpg', 'little-history-of-the-world', 'A Little History of the World', 'A Little History of the World');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (52, 'The Egyptian Book of the Dead: The Book of Going Forth by Day: The Complete Papyrus of Ani Featuring Integrated Text and Full-Color Images', 'The Papyrus of Ani is the most beautiful, best-preserved, and complete example of ancient Egyptian philosophical and religious thought. Written and illustrated some 3,300 years ago, The Egyptian Book of the Dead is an integral part of the world''s spiritual heritage. It is an artistic rendering of the mysteries of life and death. For the first time since its creation, this ancient papyrus is now available in full color with an integrated English translation directly below each image.', '25.82', 0.5, NOW(), 1, 4, 'egyptian-book-of-the-dead.jpg', 'egyptian-book-of-the-dead', 'The Egyptian Book of the Dead', 'The Egyptian Book of the Dead');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (53, 'The Spartacus War', 'An authoritative account from an expert author: The Spartacus War is the first popular history of the revolt in English. A leading authority on classical military history, Barry Strauss has used recent archaeological discoveries, ancient documents, and on-site investigations to create the most accurate and detailed account of the Spartacus rebellion ever written—and it reads like a first-rate novel.', '13.89', 0.5, NOW(), 1, 4, 'the-spartacus-war.jpg', 'the-spartacus-war', 'The Spartacus War', 'The Spartacus War');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (54, 'Europe Between the Oceans: 9000 BC-AD 1000', 'In this magnificent book, distinguished archaeologist Barry Cunliffe reframes our entire conception of early European history, from prehistory through the ancient world to the medieval Viking period. Cunliffe views Europe not in terms of states and shifting political land boundaries but as a geographical niche particularly favored in facing many seas. These seas, and Europe’s great transpeninsular rivers, ensured a rich diversity of natural resources while also encouraging the dynamic interaction of peoples across networks of communication and exchange.', '21.93', 0.5, NOW(), 1, 4, 'europe-between-the-oceans.jpg', 'europe-between-the-oceans', 'Europe Between the Oceans: 9000 BC-AD 1000', 'Europe Between the Oceans: 9000 BC-AD 1000');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (55, 'The Histories', 'Herodotus of Halicarnassus—who was hailed by Cicero as “the father of history”—wrote his histories around 440 BC. It is the earliest surviving work of nonfiction and a thrilling narrative account of (among other things) the war between the Persian Empire and the Greek city-states in the fifth century BC.', '27.79', 0.5, NOW(), 1, 4, 'the-histories.jpg', 'the-histories', 'The Histories', 'The Histories');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (56, 'The Inheritance of Rome: Illuminating the Dark Ages 400-1000', 'Defying the conventional Dark Ages view of European history between A.D. 400 and 1000, award-winning historian Chris Wickham presents The Inheritance of Rome, a work of remarkable scope and rigorous yet accessible scholarship. Drawing on a wealth of new material and featuring a thoughtful synthesis of historical and archaeological approaches, Wickham agues that these centuries were critical in the formulation of European identity. From Ireland to Constantinople, the Baltic to the Mediterranean, the narrative constructs a vivid portrait of the vast and varied world of Goths, Franks, Vandals, Arabs, Saxons, and Vikings.', '13.43', 0.5, NOW(), 1, 4, 'the-inheritance-of-rome.jpg', 'the-inheritance-of-rome', 'The Inheritance of Rome: Illuminating the Dark Ages 400-1000', 'The Inheritance of Rome: Illuminating the Dark Ages 400-1000');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (57, 'The World of Myth: An Anthology', 'Since its publication in 1991, The World of Myth has provided thousands of students with a fascinating, wide-ranging introduction to world mythology. Building on the bestselling tradition of the first edition, the long-awaited second edition offers a uniquely comprehensive collection of myths from numerous cultures around the globe. Featuring a thematic organization, it helps students understand world mythology as a metaphor for humanity''s search for meaning in a complex world. Author David Leeming presents a sweeping variety of myths whose origins range from ancient Egypt and Greece to the Polynesian islands and modern science.', '22.94', 0.5, NOW(), 1, 4, 'the-world-of-myth.jpg', 'the-world-of-myth', 'The World of Myth: An Anthology', 'The World of Myth: An Anthology');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (58, 'Savage Anxieties: The Invention of Western Civilization', 'From one of the world''s leading experts on Native American law and indigenous peoples'' human rights comes an original and striking intellectual history of the tribe and Western civilization that sheds new light on how we understand ourselves and our contemporary society. Throughout the centuries, conquest, war, and unspeakable acts of violence and dispossession have all been justified by citing civilization''s opposition to these differences represented by the tribe. Robert Williams, award winning author, legal scholar, and member of the Lumbee Indian Tribe, proposes a wide-ranging reexamination of the history of the Western world, told from the perspective of civilization''s war on tribalism as a way of life. Williams shows us how what we thought we knew about the rise of Western civilization over the tribe is in dire need of reappraisal.', '19.44', 0.5, NOW(), 1, 4, 'savage-anxieties.jpg', 'savage-anxieties', 'Savage Anxieties: The Invention of Western Civilization', 'Savage Anxieties: The Invention of Western Civilization');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (59, 'The Egyptian Book of the Dead (Penguin Classics)', 'The Book of the Dead is a unique collection of funerary texts from a wide variety of sources, dating from the fifteenth to the fourth century BC. Consisting of spells, prayers and incantations, each section contains the words of power to overcome obstacles in the afterlife. The papyruses were often left in sarcophagi for the dead to use as passports on their journey from burial, and were full of advice about the ferrymen, gods and kings they would meet on the way. Offering valuable insights into ancient Egypt, The Book of the Dead has also inspired fascination with the occult and the afterlife in recent years.', '16.87', 0.5, NOW(), 1, 4, 'the-egyptian-book-of-the-dead.jpg', 'the-egyptian-book-of-the-dead', 'The Egyptian Book of the Dead', 'The Egyptian Book of the Dead');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (60, 'Early Christian Writings: The Apostolic Fathers', 'The writings in this volume cast a glimmer of light upon the emerging traditions and organization of the infant church, during an otherwise little-known period of its development. A selection of letters and small-scale theological treatises from a group known as the Apostolic Fathers, several of whom were probably disciples of the Apostles, they provide a first-hand account of the early Church and outline a form of early Christianity still drawing on the theology and traditions of its parent religion, Judaism.', '10.95', 0.5, NOW(), 1, 4, 'the-apostolic-fathers.jpg', 'the-apostolic-fathers', 'Early Christian Writings: The Apostolic Fathers', 'Early Christian Writings: The Apostolic Fathers');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (61, 'A Brief History of Time', 'A landmark volume in science writing by one of the great minds of our time, Stephen Hawking’s book explores such profound questions as: How did the universe begin—and what made its start possible? Does time always flow forward? Is the universe unending—or are there boundaries? Are there other dimensions in space? What will happen when it all ends?', '10.94', 0.5, NOW(), 1, 5, 'brief-history-of-time.jpg', 'brief-history-of-time', 'A Brief History of Time', 'A Brief History of Time');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (62, 'The Illustrated Brief History of Time, Updated and Expanded Edition', 'In the years since its publication in 1988, Stephen Hawking''s A Brief History Of Time has established itself as a landmark volume in scientific writing.  It has become an international publishing phenomenon, translated into forty languages and selling over nine million copies.  The book was on the cutting edge of what was then known about the nature of the universe, but since that time there have been extraordinary advances in the technology of macrocosmic worlds.  These observations have confirmed many of Professor Hawkin''s theoretical predictions in the first edition of his book, including the recent discoveries of the Cosmic Background Explorer satellite (COBE), which probed back in time to within 300,000 years of the fabric of space-time that he had projected.', '29.91', 0.5, NOW(), 1, 5, 'illustrated-brief-history-of-time.jpg', 'illustrated-brief-history-of-time', 'The Illustrated Brief History of Time, Updated and Expanded Edition', 'The Illustrated Brief History of Time, Updated and Expanded Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (63, 'Behold a Pale Horse', 'Bill Cooper, former United States Naval Intelligence Briefing Team member, reveals information that remains hidden from the public eye. This information has been kept in topsecret government files since the 1940s. His audiences hear the truth unfold as he writes about the assassination of John F. Kennedy, the war on drugs, the secret government, and UFOs. Bill is a lucid, rational, and powerful speaker whose intent is to inform and to empower his audience. Standing room only is normal. His presentation and information transcend partisan affiliations as he clearly addresses issues in a way that has a striking impact on listeners of all backgrounds and interests.', '16.48', 0.5, NOW(), 1, 5, 'behold-a-pale-horse.jpg', 'behold-a-pale-horse', 'Behold a Pale Horse', 'Behold a Pale Horse');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (64, 'Death by Black Hole: And Other Cosmic Quandaries', 'Loyal readers of the monthly "Universe" essays in Natural History magazine have long recognized Neil deGrasse Tyson''s talent for guiding them through the mysteries of the cosmos with clarity and enthusiasm. Bringing together more than forty of Tyson''s favorite essays, ?Death by Black Hole? explores a myriad of cosmic topics, from what it would be like to be inside a black hole to the movie industry''s feeble efforts to get its night skies right. One of America''s best-known astrophysicists, Tyson is a natural teacher who simplifies the complexities of astrophysics while sharing his infectious fascination for our universe.', '9.97', 0.5, NOW(), 1, 5, 'death-by-black-hole.jpg', 'death-by-black-hole', 'Death by Black Hole: And Other Cosmic Quandaries', 'Death by Black Hole: And Other Cosmic Quandaries');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (65, 'The Interstellar Age: Inside the Forty-Year Voyager Mission', 'In The Interstellar Age, award-winning planetary scientist Jim Bell reveals what drove and continues to drive the members of this extraordinary team, including Ed Stone, Voyager’s chief scientist and the one-time head of NASA’s Jet Propulsion Lab; Charley Kohlhase, an orbital dynamics engineer who helped to design many of the critical slingshot maneuvers around planets that enabled the Voyagers to travel so far;  and the geologist whose Earth-bound experience would prove of little help in interpreting the strange new landscapes revealed in the Voyagers’ astoundingly clear images of moons and planets.', '20.71', 0.5, NOW(), 1, 5, 'the-interstellar-age.jpg', 'the-interstellar-age', 'The Interstellar Age: Inside the Forty-Year Voyager Mission', 'The Interstellar Age: Inside the Forty-Year Voyager Mission');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (66, 'Outliers: The Story of Success', 'In this stunning new book, Malcolm Gladwell takes us on an intellectual journey through the world of "outliers"--the best and the brightest, the most famous and the most successful. He asks the question: what makes high-achievers different? His answer is that we pay too much attention to what successful people are like, and too little attention to where they are from: that is, their culture, their family, their generation, and the idiosyncratic experiences of their upbringing. Along the way he explains the secrets of software billionaires, what it takes to be a great soccer player, why Asians are good at math, and what made the Beatles the greatest rock band. ', '17.49', 0.5, NOW(), 1, 5, 'outliers-story-success.jpg', 'outliers-story-success', 'Outliers: The Story of Success', 'Outliers: The Story of Success');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (67, 'Barron''s SAT Subject Test Math Level 2, 11th Edition', 'This manual opens with a diagnostic test that includes explained answers to help students pinpoint their math strengths and weaknesses. In chapters that follow, detailed topic reviews cover polynomial, trigonometric, exponential, logarithmic, and rational functions; coordinate and three-dimensional geometry; numbers and operations; data analysis, statistics, and probability. Six full-length model tests with answers, explanations, and self-evaluation charts conclude this manual. The manual can be purchased alone or with an optional CD-ROM that presents two additional full-length practice tests with answers, explanations, and automatic scoring.', '10.47', 0.5, NOW(), 1, 5, 'barron-sat-test-math-2.jpg', 'barron-sat-test-math-2', 'Barron''s SAT Subject Test Math Level 2, 11th Edition', 'Barron''s SAT Subject Test Math Level 2, 11th Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (68, 'How We Got to Now: Six Innovations That Made the Modern World', 'In this illustrated history, Steven Johnson explores the history of innovation over centuries, tracing facets of modern life (refrigeration, clocks, and eyeglass lenses, to name a few) from their creation by hobbyists, amateurs, and entrepreneurs to their unintended historical consequences. Filled with surprising stories of accidental genius and brilliant mistakes—from the French publisher who invented the phonograph before Edison but forgot to include playback, to the Hollywood movie star who helped invent the technology behind Wi-Fi and Bluetooth—How We Got to Now investigates the secret history behind the everyday objects of contemporary life.', '20.04', 0.5, NOW(), 1, 5, 'how-we-got-to-now.jpg', 'how-we-got-to-now', 'How We Got to Now: Six Innovations That Made the Modern World', 'How We Got to Now: Six Innovations That Made the Modern World');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (69, 'An Illustrated Book of Bad Arguments', 'Have you read (or stumbled into) one too many irrational online debates? Ali Almossawi certainly had, so he wrote An Illustrated Book of Bad Arguments! This handy guide is here to bring the internet age a much-needed dose of old-school logic (really old-school, a la Aristotle). Here are cogent explanations of the straw man fallacy, the slippery slope argument, the ad hominem attack, and other common attempts at reasoning that actually fall short—plus a beautifully drawn menagerie of animals who (adorably) commit every logical faux pas. Rabbit thinks a strange light in the sky must be a UFO because no one can prove otherwise (the appeal to ignorance). And Lion doesn’t believe that gas emissions harm the planet because, if that were true, he wouldn’t like the result (the argument from consequences).', '11.07', 0.5, NOW(), 1, 5, 'illustrated-book-of-bad-arguments.jpg', 'illustrated-book-of-bad-arguments', 'An Illustrated Book of Bad Arguments', 'An Illustrated Book of Bad Arguments');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (70, 'Data Science for Business: What you need to know about data mining and data-analytic thinking', 'Written by renowned data science experts Foster Provost and Tom Fawcett, Data Science for Business introduces the fundamental principles of data science, and walks you through the "data-analytic thinking" necessary for extracting useful knowledge and business value from the data you collect. This guide also helps you understand the many data-mining techniques in use today.', '33.36', 0.5, NOW(), 1, 5, 'data-science-for-business.jpg', 'data-science-for-business', 'Data Science for Business', 'Data Science for Business: What you need to know about data mining and data-analytic thinking');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (71, 'An Introduction to Statistical Learning: with Applications in R (Springer Texts in Statistics)', 'An Introduction to Statistical Learning provides an accessible overview of the field of statistical learning, an essential toolset for making sense of the vast and complex data sets that have emerged in fields ranging from biology to finance to marketing to astrophysics in the past twenty years. This book presents some of the most important modeling and prediction techniques, along with relevant applications. Topics include linear regression, classification, resampling methods, shrinkage approaches, tree-based methods, support vector machines, clustering, and more. Color graphics and real-world examples are used to illustrate the methods presented. Since the goal of this textbook is to facilitate the use of these statistical learning techniques by practitioners in science, industry, and other fields, each chapter contains a tutorial on implementing the analyses and methods presented in R, an extremely popular open source statistical software platform.', '76.46', 0.5, NOW(), 1, 5, 'introduction-to-statistical-learning.jpg', 'introduction-to-statistical-learning', 'An Introduction to Statistical Learning', 'An Introduction to Statistical Learning: with Applications in R (Springer Texts in Statistics)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (72, 'Chemistry: A Molecular Approach (3rd Edition)', 'Chemistry: A Molecular Approach, Third Edition is an innovative, pedagogically driven text that explains challenging concepts in a student-oriented manner.  Nivaldo Tro creates a rigorous and accessible treatment of general chemistry in the context of relevance and the big picture. Chemistry is presented visually through multi-level images–macroscopic, molecular, and symbolic representations–helping students see the connections between the world they see around them (macroscopic), the atoms and molecules that compose the world (molecular), and the formulas they write down on paper (symbolic). The hallmarks of Dr. Tro’s problem-solving approach are reinforced through interactive media that provide students with an office-hour type of environment built around worked examples and expanded coverage on the latest developments in chemistry. Pioneering features allow students to sketch their ideas through new problems, and much more.', '220.07', 0.5, NOW(), 1, 5, 'molecular-approach.jpg', 'molecular-approach', 'A Molecular Approach', 'Chemistry: A Molecular Approach (3rd Edition)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (73, 'Bold: How to Go Big, Create Wealth and Impact the World', 'Bold unfolds in three parts. Part One focuses on the exponential technologies that are disrupting today’s Fortune 500 companies and enabling upstart entrepreneurs to go from "I’ve got an idea" to "I run a billion-dollar company" far faster than ever before. The authors provide exceptional insight into the power of 3D printing, artificial intelligence, robotics, networks and sensors, and synthetic biology. Part Two of the book focuses on the Psychology of Bold, drawing on insights from billionaire entrepreneurs Larry Page, Elon Musk, Richard Branson, and Jeff Bezos.', '21.17', 0.5, NOW(), 1, 5, 'how-to-go-big-create-wealth-impact-world.jpg', 'how-to-go-big-create-wealth-impact-world', 'Bold: How to Go Big, Create Wealth and Impact the World', 'Bold: How to Go Big, Create Wealth and Impact the World');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (74, 'Flashpoints: The Emerging Crisis in Europe', 'With remarkable accuracy, George Friedman has forecasted coming trends in global politics, technology, population, and culture. In Flashpoints, Friedman focuses on Europe—the world’s cultural and power nexus for the past five hundred years . . . until now. Analyzing the most unstable, unexpected, and fascinating borderlands of Europe and Russia—and the fault lines that have existed for centuries and have been ground zero for multiple catastrophic wars—Friedman highlights, in an unprecedentedly personal way, the flashpoints that are smoldering once again.', '18.09', 0.5, NOW(), 1, 5, 'emerging-crisis-in-europe.jpg', 'emerging-crisis-in-europe', 'Flashpoints: The Emerging Crisis in Europe', 'Flashpoints: The Emerging Crisis in Europe');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (75, 'Abundance: The Future Is Better Than You Think', 'In Abundance, space entrepreneur turned innovation pioneer Peter H. Diamandis and award-winning science writer Steven Kotler document how progress in artificial intelligence, robotics, digital manufacturing synthetic biology, and other exponentially growing technologies will enable us to make greater gains in the next two decades than we have in the previous 200 years. We will soon have the ability to meet and exceed the basic needs of every person on the planet. Abundance for all is within our grasp.', '11.98', 0.5, NOW(), 1, 5, 'future-is-better-than-you-think.jpg', 'future-is-better-than-you-think', 'Abundance: The Future Is Better Than You Think', 'Abundance: The Future Is Better Than You Think');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (76, 'One Zentangle A Day: A 6-Week Course in Creative Drawing for Relaxation, Inspiration, and Fun (One A Day) ', 'One Zentangle A Day is a beautiful interactive book teaching the principles of Zentangles as well as offering fun, related drawing exercises. Zentangles are a new trend in the drawing and paper arts world. The concept was started by Rick Roberts and Maria Thomas as a way to practice focus and meditation through drawing, by using repetitive lines, marks, circles, and shapes. Each mark is called a "tangle," and you combine various tangles into patterns to create "tiles" or small square drawings. This step-by-step book is divided into 6 chapters, each with 7 daily exercises. Each exercise includes new tangles to draw in sketchbooks or on tiepolo (an Italian-made paper), teaches daily tile design, and offers tips on related art principles, and contains an inspirational "ZIA" (Zentangle Inspired Art) project on a tile that incorporates patterns, art principals, and new techniques.', '12.98', 0.5, NOW(), 1, 6, 'one-zentangle-a-day.jpg', 'one-zentangle-a-day', 'One Zentangle A Day', 'One Zentangle A Day: A 6-Week Course in Creative Drawing for Relaxation, Inspiration, and Fun (One A Day) ');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (77, 'Color Me Calm: 100 Coloring Templates for Meditation and Relaxation (A Zen Coloring Book)', 'Our lives become busier with each passing day, and as technology escalates, so does our access to work, obligations, and stress. Constant stimulation and expectation have left us burnt out and distanced from the present moment. "Now" has become something that happens online, not in the space and time that we physically occupy. Color Me Calm is a guided coloring book designed for harried adults. Art therapist Lacy Mucklow and artist Angela Porter offer up 100 coloring templates all designed to help you get coloring and get relaxed. Organized into seven therapeutically-themed chapters including Mandalas, Water Scenes, Wooded Scenes, Geometric Patterns, Flora & Fauna, Natural Patterns, and Spirituality - the book examines the benefits of putting pencil to paper and offers adults an opportunity to channel their anxiety into satisfying, creative accomplishment. Color Me Calm is the perfect way step back from the stress of everyday life, color, and relax!', '12.16', 0.5, NOW(), 1, 6, 'color-me-calm.jpg', 'color-me-calm', 'Color Me Calm', 'Color Me Calm: 100 Coloring Templates for Meditation and Relaxation (A Zen Coloring Book)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (78, 'You Can Draw in 30 Days: The Fun, Easy Way to Learn to Draw in One Month or Less', 'Drawing is an acquired skill, not a talent—anyone can learn to draw! All you need is a pencil, a piece of paper, and the willingness to tap into your hidden artistic abilities. You Can Draw in 30 Days will teach you the rest. With Emmy award–winning, longtime PBS host Mark Kistler as your guide, you’ll learn the secrets of sophisticated three-dimensional renderings, and have fun along the way. Inside you’ll find: Quick and easy step-by-step instructions for drawing everything from simple spheres to apples, trees, buildings, and the human hand and face; More than 500 line drawings, illustrating each step; Time-tested tips, techniques, and tutorials for drawing in 3-D; The 9 Fundamental Laws of Drawing to create the illusion of depth in any drawing; 75 student examples to help gauge your own progress; In just 20 minutes a day for a month, you can learn to draw anything, whether from the world around you or from your own imagination. It’s time to embark on your creative journey. Pick up your pencil and begin today!', '12.87', 0.5, NOW(), 1, 6, 'you-can-draw-in-30-days.jpg', 'you-can-draw-in-30-days', 'You Can Draw in 30 Days', 'You Can Draw in 30 Days: The Fun, Easy Way to Learn to Draw in One Month or Less');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (79, 'The Legend of Zelda: Hyrule Historia', 'Dark Horse Books and Nintendo team up to bring you The Legend of Zelda: Hyrule Historia, containing an unparalleled collection of historical information on The Legend of Zelda franchise. This handsome hardcover contains never-before-seen concept art, the full history of Hyrule, the official chronology of the games, and much more! Starting with an insightful introduction by the legendary producer and video-game designer of Donkey Kong, Mario, and The Legend of Zelda, Shigeru Miyamoto, this book is crammed full of information about the storied history of Link''s adventures from the creators themselves! As a bonus, The Legend of Zelda: Hyrule Historia includes an exclusive comic by the foremost creator of The Legend of Zelda manga — Akira Himekawa!', '19.63', 0.5, NOW(), 1, 6, 'legend-of-zelda.jpg', 'legend-of-zelda', 'The Legend of Zelda: Hyrule Historia', 'The Legend of Zelda: Hyrule Historia');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (80, 'The Anatomy Coloring Book (4th Edition)', 'For more than 35 years, The Anatomy Coloring Book has been the #1 best-selling human anatomy coloring book! A useful tool for anyone with an interest in learning anatomical structures, this concisely written text features precise, extraordinary hand-drawn figures that were crafted especially for easy coloring and interactive study. Organized according to body systems, each of the 162 two-page spreads  featured in this book includes an ingenious color-key system where anatomical terminology is linked to detailed illustrations of the structures of the body. When you color to learn with The Anatomy Coloring Book, you make visual associations with key terminology, and assimilate information while engaging in kinesthetic learning. Studying anatomy is made easy and fun! ', '15.01', 0.5, NOW(), 1, 6, 'anatomy-coloring-book-4-ed.jpg', 'anatomy-coloring-book-4-ed', 'The Anatomy Coloring Book (4th Edition)', 'The Anatomy Coloring Book (4th Edition)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (81, 'Teach Yourself to Play Guitar: A Quick and Easy Introduction for Beginners', '(Guitar Educational). Teach Yourself to Play Guitar has been created specifically for the student with no music-reading background. With lesson examples presented in today''s most popular tab format, which also incorporates simple beat notation for accurate rhythm execution, Teach Yourself to Play Guitar offers the beginning guitarist not only a comprehensive introduction to essential guitar-playing fundamentals, but a quick, effective, uncomplicated and practical alternative to the multitude of traditional self-instructional method books. It also: covers power chords, barre chords, open position scales and chords (major and minor), and single-note patterns and fills; includes lesson examples and song excerpts in a variety of musical styles rock, folk, classical, country and more; familiarizes the student with fretboard organization, chord patterns, hand and finger positions, and guitar anatomy by way of easy-to-interpret diagrams, photos and illustrations; provides complete, concise explanations while keeping text to a minimum; and prepares the student for the option of further guitar instruction.', '3.99', 0.5, NOW(), 1, 6, 'teach-yourself-to-play-guitar.jpg', 'teach-yourself-to-play-guitar', 'Teach Yourself to Play Guitar', 'Teach Yourself to Play Guitar: A Quick and Easy Introduction for Beginners');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (82, 'Hal Leonard Guitar Method, Complete Edition', '(Guitar Method). The Hal Leonard Guitar Method is designed for anyone just learning to play acoustic or electric guitar. It is based on years of teaching guitar students of all ages, and reflects some of the best teaching ideas from around the world. This super-convenient Complete Edition features the new and improved method books 1, 2 and 3 spiral-bound together, available as a book only (00699040) or book with three CDs (00697342)!', '12.86', 0.5, NOW(), 1, 6, 'hal-leonard-guitar-method.jpg', 'hal-leonard-guitar-method', 'Hal Leonard Guitar Method, Complete Edition', 'Hal Leonard Guitar Method, Complete Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (83, 'Adult All-In-One Course: Lesson-Theory-Technic: Level 1', 'Alfred''s Basic Adult All-in-One Course is designed for use with a piano instructor for the beginning student looking for a truly complete piano course. It is a greatly expanded version of Alfred''s Basic Adult Piano Course that will include lesson, theory, technic and additional repertoire in a convenient, "all-in-one" format. This comprehensive course adds such features as isometric hand exercises, finger strengthening drills, and written assignments that reinforce each lesson''s concepts. There is a smooth, logical progression between each lesson, a thorough explanation of chord theory and playing styles, and outstanding extra songs, including folk, classical, and contemporary selections. At the completion of this course, the student will have learned to play some of the most popular music ever written and will have gained a good understanding of basic musical concepts and styles.', '19.98', 0.5, NOW(), 1, 6, 'adult-all-in-one-course.jpg', 'adult-all-in-one-course', 'Adult All-In-One Course', 'Adult All-In-One Course: Lesson-Theory-Technic: Level 1');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (84, 'Humans of New York', 'Now an instant #1 New York Times bestseller, Humans of New York began in the summer of 2010, when photographer Brandon Stanton set out to create a photographic census of New York City.  Armed with his camera, he began crisscrossing the city, covering thousands of miles on foot, all in an attempt to capture New Yorkers and their stories.  The result of these efforts was a vibrant blog he called "Humans of New York," in which his photos were featured alongside quotes and anecdotes. The blog has steadily grown, now boasting millions of devoted followers.  Humans of New York is the book inspired by the blog.  With four hundred color photos, including exclusive portraits and all-new stories, Humans of New York is a stunning collection of images that showcases the outsized personalities of New York.', '17.99', 0.5, NOW(), 1, 6, 'humans-of-new-york.jpg', 'humans-of-new-york', 'Humans of New York', 'Humans of New York');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (85, 'Drawing on the Right Side of the Brain: The Definitive, 4th Edition', 'Translated into more than seventeen languages, Drawing on the Right Side of the Brain is the world''s most widely used drawing instruction book. Whether you are drawing as a professional artist, as an artist in training, or as a hobby, this book will give you greater confidence in your ability and deepen your artistic perception, as well as foster a new appreciation of the world around you.', '23.83', 0.5, NOW(), 1, 6, 'drawing-on-the-right-side-of-the-brain.jpg', 'drawing-on-the-right-side-of-the-brain', 'Drawing on the Right Side of the Brain', 'Drawing on the Right Side of the Brain: The Definitive, 4th Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (86, 'Schubert''s Winter Journey: Anatomy of an Obsession', 'Completed in the last months of the young Schubert’s life, Winterreise has come to be considered the single greatest piece of music in the history of Lieder. Deceptively laconic—these twenty-four short poems set to music for voice and piano are performed uninterrupted in little more than an hour—it nonetheless has an emotional depth and power that no music of its kind has ever equaled. A young man, rejected by his beloved, leaves the house where he has been living and walks out into snow and darkness. As he wanders away from the village and into the empty countryside, he experiences a cascade of emotions—loss, grief, anger, and acute loneliness, shot through with only fleeting moments of hope—until the landscape he inhabits becomes one of alienation and despair. Originally intended to be sung to an intimate gathering, performances of Winterreise now pack the greatest concert halls around the world.', '18.12', 0.5, NOW(), 1, 6, 'schuberts-winter-journey-anatomy-of-an-obsession.jpg', 'schuberts-winter-journey-anatomy-of-an-obsession', 'Schubert''s Winter Journey: Anatomy of an Obsession', 'Schubert''s Winter Journey: Anatomy of an Obsession');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (87, 'India Hicks: Island Style', 'From India Hicks, a beautifully illustrated guide to achieving her famously undone, gloriously bohemian decorating style. Born from British and design royalty, India Hicks has forged a design empire from her family’s enclave in the Bahamas. In India Hicks: Island Style, she invites readers into her world, offering never-before-seen imagery and irresistible behind-the-scenes stories. Beginning with an uproarious reflection on India’s own design odyssey, the heart of the book is an in-depth exploration of her style. Timeless and under-decorated, her rooms combine carefree Caribbean culture with British colonial form and formality. In ten chapters, India walks the reader through the basics of capturing the look: the subtle palette of island life; the miracle of tablescaping; the warm anarchy of a family kitchen; the pleasure of porches; the drama of entertaining; bedrooms as places of self-expression; the "more is more" style of living with collections; the importance of repurposing; and creating spaces of sanctuary. Witty, richly prescriptive, beautifully photographed, this book will enchant readers with a glimpse of decorating in paradise.', '29.61', 0.5, NOW(), 1, 6, 'india-hicks-island-style.jpg', 'india-hicks-island-style', 'India Hicks: Island Style', 'India Hicks: Island Style');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (88, 'The Nesting Place: It Doesn''t Have to Be Perfect to Be Beautiful', 'Popular blogger and self-taught decorator Myquillyn Smith (The Nester) is all about embracing reality—especially when it comes to decorating a home bursting with boys, pets, and all the unpredictable messes of life.\n\nIn The Nesting Place, Myquillyn shares the secrets of decorating for real people—and it has nothing to do with creating a flawless look to wow your guests. It has everything to do with embracing the natural imperfection and chaos of daily living.\n\nDrawing on her years of experience creating beauty in her 13 different homes, Myquillyn will show you how to think differently about the true purpose of your home and simply and creatively tailor it to reflect you and your unique style—without breaking the bank or stressing over comparisons. Full of easy tips, simple steps, and practical advice, The Nesting Place will give you the courage to take risks with your home and transform it into a place that’s inviting and warm for family and friends.\n\nThere is beauty in the lived-in and loved-on and just-about-used-up, Myquillyn says, and welcoming that imperfection wholeheartedly just might be the most freeing thing you’ll ever do.', '15.92', 0.5, NOW(), 1, 6, 'the-nesting-place.jpg', 'the-nesting-place', 'The Nesting Place', 'The Nesting Place: It Doesn''t Have to Be Perfect to Be Beautiful');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (89, 'Nicky Haslam: A Designer''s Life', 'The enduring appeal of English-style interiors from the current master of the genre. Nicholas "Nicky" Haslam is one of the world’s most distinguished interior designers, and this career-crowning monograph explores his signature style. Haslam began designing in 1972 and has become known for opulent, original, and timeless interiors. With a prime motivation of creating interiors that are "flattering to their owners," his firm’s work is seductively glamorous, layered with a historical knowledge and an originality that belies the careful focus on practicality and livability. The mix of the deeply serious, grand, and impressive with charm and above all wit is Haslam’s trademark. With its fresh, lively, and spontaneous approach that reflects Haslam’s charisma, wit, and charm, this gorgeously illustrated volume reveals the influences, inspirations, and achievements that have been pivotal to his success. Haslam shares material from both his personal scrapbook and professional archive to highlight key moments in his colorful career, his most acclaimed designs, and the sources of his creative inspiration. Clients have included Ringo Starr, Mick Jagger, the Mandarin Oriental Hotel Hong Kong, Maurice and Charles Saatchi, Rupert Everett, Alec Wildenstein, Peter Soros, and Janet de Botton, among many others. He has also designed parties for the Prince of Wales, Lord Rothschild, Sir Evelyn and Lady de Rothschild, and Tina Brown.This beautiful and inspiring volume will appeal to anyone interested in interior design and the art of living well.', '38.86', 0.5, NOW(), 1, 6, 'nicky-haslam-designers-life.jpg', 'nicky-haslam-designers-life', 'Nicky Haslam: A Designer''s Life', 'Nicky Haslam: A Designer''s Life');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
  VALUES (90, 'ARE Review Manual (Architect Registration Exam)', 'Successful exam preparation requires the best resources, and the ARE Review Manual gives you the power to pass all seven divisions of the ARE. This one book, updated to the 2007 AIA documents and the 2009 International Building Code, provides you with a complete and comprehensive review of the content areas covered on the ARE divisions. Additional chapters covering basic mathematics, important building regulations, and barrier-free design supplement your preparation regime.', '267.70', 0.5, NOW(), 1, 6, 'are-review-manual.jpg', 'are-review-manual', 'ARE Review Manual', 'ARE Review Manual (Architect Registration Exam)');

INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (91, 'The Wright Brothers', 'Two-time winner of the Pulitzer Prize David McCullough tells the dramatic story-behind-the-story about the courageous brothers who taught the world how to fly: Wilbur and Orville Wright.\n\nOn a winter day in 1903, in the Outer Banks of North Carolina, two unknown brothers from Ohio changed history. But it would take the world some time to believe what had happened: the age of flight had begun, with the first heavier-than-air, powered machine carrying a pilot.\n\nWho were these men and how was it that they achieved what they did?\n\nDavid McCullough, two-time winner of the Pulitzer Prize, tells the surprising, profoundly American story of Wilbur and Orville Wright.\n\nFar more than a couple of unschooled Dayton bicycle mechanics who happened to hit on success, they were men of exceptional courage and determination, and of far-ranging intellectual interests and ceaseless curiosity, much of which they attributed to their upbringing. The house they lived in had no electricity or indoor plumbing, but there were books aplenty, supplied mainly by their preacher father, and they never stopped reading.\n\nWhen they worked together, no problem seemed to be insurmountable. Wilbur was unquestionably a genius. Orville had such mechanical ingenuity as few had ever seen. That they had no more than a public high school education, little money and no contacts in high places, never stopped them in their “mission” to take to the air. Nothing did, not even the self-evident reality that every time they took off in one of their contrivances, they risked being killed.\n\nIn this thrilling book, master historian David McCullough draws on the immense riches of the Wright Papers, including private diaries, notebooks, scrapbooks, and more than a thousand letters from private family correspondence to tell the human side of the Wright Brothers’ story, including the little-known contributions of their sister, Katharine, without whom things might well have gone differently for them.', '19.51', 0.5, NOW(), 1, 7, 'the-wright-brothers.jpg', 'the-wright-brothers', 'The Wright Brothers', 'The Wright Brothers');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (92, 'The Innovators: How a Group of Hackers, Geniuses, and Geeks Created the Digital Revolution', 'Following his blockbuster biography of Steve Jobs, The Innovators is Walter Isaacson’s revealing story of the people who created the computer and the Internet. It is destined to be the standard history of the digital revolution and an indispensable guide to how innovation really happens.\n\nWhat were the talents that allowed certain inventors and entrepreneurs to turn their visionary ideas into disruptive realities? What led to their creative leaps? Why did some succeed and others fail?\n\nIn his masterly saga, Isaacson begins with Ada Lovelace, Lord Byron’s daughter, who pioneered computer programming in the 1840s. He explores the fascinating personalities that created our current digital revolution, such as Vannevar Bush, Alan Turing, John von Neumann, J.C.R. Licklider, Doug Engelbart, Robert Noyce, Bill Gates, Steve Wozniak, Steve Jobs, Tim Berners-Lee, and Larry Page.\n\nThis is the story of how their minds worked and what made them so inventive. It’s also a narrative of how their ability to collaborate and master the art of teamwork made them even more creative.\n\nFor an era that seeks to foster innovation, creativity, and teamwork, The Innovators shows how they happen.', '22.05', 0.5, NOW(), 1, 7, 'The-Innovators-How-Group-of-Hackers-Geniuses-and-Geeks-Created-the-Digital-Revolution.jpg', 'The-Innovators-How-Group-of-Hackers-Geniuses-and-Geeks-Created-the-Digital-Revolution', 'The Innovators: How a Group of Hackers, Geniuses, and Geeks Created the Digital Revolution', 'The Innovators: How a Group of Hackers, Geniuses, and Geeks Created the Digital Revolution');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (93, 'Deep Down Dark: The Untold Stories of 33 Men Buried in a Chilean Mine, and the Miracle That Set Them Free', 'When the San José mine collapsed outside of Copiapó, Chile, in August 2010, it trapped thirty-three miners beneath thousands of feet of rock for a record-breaking sixty-nine days. The entire world watched what transpired above-ground during the grueling and protracted rescue, but the saga of the miners'' experiences below the Earth''s surface—and the lives that led them there—has never been heard until now.\n\nFor Deep Down Dark, the Pulitzer Prize–winning journalist Héctor Tobar received exclusive access to the miners and their tales. These thirty-three men came to think of the mine, a cavern inflicting constant and thundering aural torment, as a kind of coffin, and as a church where they sought redemption through prayer. Even while still buried, they all agreed that if by some miracle any of them escaped alive, they would share their story only collectively. Héctor Tobar was the person they chose to hear, and now to tell, that story.\n\nThe result is a masterwork or narrative journalism—a riveting, at times shocking, emotionally textured account of a singular human event. Deep Down Dark brings to haunting, tactile life the experience of being imprisoned inside a mountain of stone, the horror of being slowly consumed by hunger, and the spiritual and mystical elements that surrounded working in such a dangerous place. In its stirring final chapters, it captures the profound way in which the lives of everyone involved in the disaster were forever changed.', '19.45', 0.5, NOW(), 1, 7, 'Deep-Down-Dark-Stories-Chilean.jpg', 'Deep-Down-Dark-Stories-Chilean', 'Deep Down Dark: The Untold Stories of 33 Men Buried in a Chilean Mine, and the Miracle That Set Them Free', 'Deep Down Dark: The Untold Stories of 33 Men Buried in a Chilean Mine, and the Miracle That Set Them Free');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (94, 'Kaplan ASVAB Premier 2015 with 6 Practice Tests', 'Kaplan''s ASVAB Premier 2015 with 6 Practice Tests is an in-depth study system providing print, DVD and online practice and review for the ASVAB and AFQT.  Updated with DVD, mobile-ready online resources and new study sheets, you''ll find everything you need to get the results you want on the ASVAB and AFQT, including practice and review for Word Knowledge, Arithmetic Reasoning, General Science, Mechanical Comprehension, and more...', '22.20', 0.5, NOW(), 1, 7, 'Kaplan-ASVAB-Premier-Practice-Tests.jpg', 'Kaplan-ASVAB-Premier-Practice-Tests', 'Kaplan ASVAB Premier 2015 with 6 Practice Tests', 'Kaplan ASVAB Premier 2015 with 6 Practice Tests');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (95, 'Civil Engineering Reference Manual for the PE Exam', 'The Civil Engineering Reference Manual is the most comprehensive textbook for the NCEES Civil PE exam. This book’s time-tested organization and clear explanations start with the basics to help you quickly get up to speed with common civil engineering concepts. Together, the 90 chapters provide an in-depth review of all of the topics, codes, and standards listed in the NCEES Civil PE exam specifications. The extensive index contains thousands of entries, with multiple entries included for each topic, so you’ll find what you’re looking for no matter how you search.', '284.61', 0.5, NOW(), 1, 7, 'Civil-Engineering-Reference-Manual-Exam.jpg', 'Civil-Engineering-Reference-Manual-Exam', 'Civil Engineering Reference Manual for the PE Exam', 'Civil Engineering Reference Manual for the PE Exam');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (96, 'Practical Electronics for Inventors', '"If there is a successor to Make: Electronics, then I believe it would have to be Practical Electronics for Inventors....perfect for an electrical engineering student or maybe a high school student with a strong aptitude for electronics....I’ve been anxiously awaiting this update, and it was well worth the wait."--GeekDad (Wired.com)\n\nSpark your creativity and gain the electronics skills required to transform your innovative ideas into functioning gadgets. This hands-on, updated guide outlines electrical principles and provides thorough, easy-to-follow instructions, schematics, and illustrations. Find out how to select components, safely assemble circuits, perform error tests, and build plug-and-play prototypes. Practical Electronics for Inventors, Third Edition, features all-new chapters on sensors, microcontrollers, modular electronics, and the latest software tools.', '22.60', 0.5, NOW(), 1, 7, 'Practical-Electronics-Inventors.jpg', 'Practical-Electronics-Inventors', 'Practical Electronics for Inventors', 'Practical Electronics for Inventors');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (97, '2012 International Building Code (International Code Council Series)', 'Featuring time-tested safety concepts and the very latest industry standards in material design, the 2012 INTERNATIONAL BUILDING CODE SOFT COVER version offers up-to-date, comprehensive insight into the regulations surrounding the design and installation of building systems. It provides valuable structural, fire-, and life- safety provisions that cover means of egress, interior finish requirements, roofs, seismic engineering, innovative construction technology, and occupancy classifications for all types of buildings except those which are detached one and two family homes and townhouses not more than 3 stories high. The content in this code book is developed in the context of the broad-based principles that facilitate the use of new materials and building designs, making this an essential reference guide for anyone seeking a strong working knowledge of building systems. Check out our app, DEWALT Mobile Pro™. This free app is a construction calculator with integrated reference materials and access to hundreds of additional calculations as add-ons. To learn more, visit dewalt.com/mobilepro.', '115.54', 0.5, NOW(), 1, 7, '2012-International-Building-Code-Council.jpg', '2012-International-Building-Code-Council', '2012 International Building Code (International Code Council Series)', '2012 International Building Code (International Code Council Series)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (98, 'Pogue''s Basics: Essential Tips and Shortcuts (That No One Bothers to Tell You) for Simplifying the Technology in Your Life', 'Did you know that can you scroll a Web page just by tapping the space bar? How do you recover photos you’ve deleted by accident? What can you do if your cell phone’s battery is dead by dinnertime each day?\n\nWhen it comes to technology, there’s no driver’s ed class or government-issued pamphlet covering the essentials. Somehow, you’re just supposed to know how to use your phone, tablet, computer, camera, Web browser, e-mail, and social networks. Luckily, award-winning tech expert David Pogue comes to the rescue with Pogue’s Basics, a book that will change your relationship with all of the technology in your life.\n\nWith wit and authority, Pogue’s Basics collects every essential technique for making your gadgets seem easier, faster, and less of a hassle. Crystal-clear illustrations accompany these 225 easy-to-follow tips.', '15.21', 0.5, NOW(), 1, 7, 'Pogues-Basics-Essential-Simplifying-Technology.jpg', 'Pogues-Basics-Essential-Simplifying-Technology', 'Pogue''s Basics: Essential Tips and Shortcuts (That No One Bothers to Tell You) for Simplifying the Technology in Your Life', 'Pogue''s Basics: Essential Tips and Shortcuts (That No One Bothers to Tell You) for Simplifying the Technology in Your Life');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (99, 'Dead Wake: The Last Crossing of the Lusitania', 'On May 1, 1915, with WWI entering its tenth month, a luxury ocean liner as richly appointed as an English country house sailed out of New York, bound for Liverpool, carrying a record number of children and infants. The passengers were surprisingly at ease, even though Germany had declared the seas around Britain to be a war zone. For months, German U-boats had brought terror to the North Atlantic. But the Lusitania was one of the era’s great transatlantic “Greyhounds”—the fastest liner then in service—and her captain, William Thomas Turner, placed tremendous faith in the gentlemanly strictures of warfare that for a century had kept civilian ships safe from attack. ', '20.59', 0.5, NOW(), 1, 7, 'Dead-Wake-Last-Crossing-Lusitania.jpg', 'Dead-Wake-Last-Crossing-Lusitania', 'Dead Wake: The Last Crossing of the Lusitania', 'Dead Wake: The Last Crossing of the Lusitania');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (100, 'In the Heart of the Sea: The Tragedy of the Whaleship Essex', 'The ordeal of the whaleship Essex was an event as mythic in the nineteenth century as the sinking of the Titanic was in the twentieth. In 1819, the Essex left Nantucket for the South Pacific with twenty crew members aboard. In the middle of the South Pacific the ship was rammed and sunk by an angry sperm whale. The crew drifted for more than ninety days in three tiny whaleboats, succumbing to weather, hunger, disease, and ultimately turning to drastic measures in the fight for survival. Nathaniel Philbrick uses little-known documents-including a long-lost account written by the ship''s cabin boy-and penetrating details about whaling and the Nantucket community to reveal the chilling events surrounding this epic maritime disaster. An intense and mesmerizing read, In the Heart of the Sea is a monumental work of history forever placing the Essex tragedy in the American historical canon.', '13.30', 0.5, NOW(), 1, 7, 'Heart-Sea-Tragedy-Whaleship-Essex.jpg', 'Heart-Sea-Tragedy-Whaleship-Essex', 'In the Heart of the Sea: The Tragedy of the Whaleship Essex', 'In the Heart of the Sea: The Tragedy of the Whaleship Essex');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (101, 'The Powerhouse: Inside the Invention of a Battery to Save the World', 'A worldwide race is on to perfect the next engine of economic growth, the advanced lithium-ion battery. It will power the electric car, relieve global warming, and catapult the winner into a new era of economic and political mastery. Can the United States win?\n\nSteve LeVine was granted unprecedented access to a secure federal laboratory outside Chicago, where a group of geniuses is trying to solve this next monumental task of physics. But these scientists--almost all foreign born--are not alone. With so much at stake, researchers in Japan, South Korea, and China are in the same pursuit. The drama intensifies when a Silicon Valley start-up licenses the federal laboratory''s signature invention with the aim of a blockbuster sale to the world''s biggest carmakers.\n\nThe Powerhouse is a real-time, two-year account of big invention, big commercialization, and big deception. It exposes the layers of aspiration and disappointment, competition and ambition behind this great turning point in the history of technology.', '21.56', 0.5, NOW(), 1, 7, 'Powerhouse-Inside-Invention-Battery-World.jpg', 'Powerhouse-Inside-Invention-Battery-World', 'The Powerhouse: Inside the Invention of a Battery to Save the World', 'The Powerhouse: Inside the Invention of a Battery to Save the World');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (102, 'How To Weld (Motorbooks Workshop)', 'Welding is a skill that any do-it-yourself enthusiast needs in his arsenal. It’s only when you can join metal that you can properly repair and create. This book is the perfect introduction for neophytes and an excellent refresher for veteran welders, a work so comprehensive and so complete that most readers won’t need any further instruction.\n\nHow to Weld starts with a brief history of welding, an overview of the different types of welding, and a thorough discussion of safety practices. Longtime welding instructor Todd Bridigum describes various tools and types of metals, as well as techniques and types of joints. Bridigum discusses gas, stick, wire-feed (MIG and TIG), even brazing, completing each section with a series of exercises that fully illustrate the skills he has covered. ', '16.04', 0.5, NOW(), 1, 7, 'Weld-Motorbooks-Workshop.jpg', 'Weld-Motorbooks-Workshop', 'How To Weld (Motorbooks Workshop)', 'How To Weld (Motorbooks Workshop)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (103, 'How to Keep Your Volkswagen Alive: A Manual of Step-by-Step Procedures for the Compleat Idiot', 'First published in 1969, this classic manual of automotive repair equips VW owners with the knowledge to handle every situation they will come across with any air-cooled Volkswagen built through 1978, including Bugs, Karmann Ghias, vans, and campers. With easy-to-understand, fun-to-read information — for novice and veteran mechanics alike — anecdotal descriptions, and clear language, this book takes the mystery out of diagnostic, maintenance, and repair procedures, and offers some chuckles along the way. This edition features new information on troubleshooting, new photos, and an updated resource list.', '22.12', 0.5, NOW(), 1, 7, 'Keep-Volkswagen-Alive.jpg', 'Keep-Volkswagen-Alive', 'How to Keep Your Volkswagen Alive: A Manual of Step-by-Step Procedures for the Compleat Idiot', 'How to Keep Your Volkswagen Alive: A Manual of Step-by-Step Procedures for the Compleat Idiot');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (104, 'How Cars Work', 'An Illustrated Guide to the 250 Most Important Car Parts and how they work.', '20.57', 0.5, NOW(), 1, 7, 'How-Cars-Work.jpg', 'How-Cars-Work', 'How Cars Work', 'How Cars Work');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (105, 'Fast N'' Loud: Blood, Sweat and Beers', 'The breakout star of Discovery’s hit automotive restoration show Fast N’ Loud takes readers on an entertaining ride through his wild life and behind the scenes of his hit show in this memoir and automotive handbook, revving with outrageous details and jaw-dropping stories, and injected with the quick-witted, foul-mouthed charm viewers love.\n\n“If we’re gonna have fun, it better have a motor!”\n\nIn Fast N’ Loud, Richard Rawlings pushes into high gear, sharing the story of his rise to success, his show, and the automotive know-how that has made him famous. He begins with his own story—how he went from flat broke to a seat at the table with some of history’s most iconic car guys. His road to the top is full of dangerous twists and hilarious turns, with a few precipitous cliffs in between, including getting shot defending his beloved 1965 Mustang fastback from carjackers, blowing out of town Fear-and-Loathing style, and picking up chicks and vagrants along the way.\n\nRawlings then takes readers behind the scenes of Fast N’ Loud, the series, sharing details on everything from the toughest car to restore to the easiest, his favorite restorations, travel and war anecdotes, and the best and worst cars to make it to the small screen. He finishes with a handy guide for classic and antique car enthusiasts that includes insider tricks of the trade. Want to know how to find a Model-T in mint condition? Need a carburetor for your ’73 Ford Mustang? Want to meet other ’60s Porsche owners? The answers are all here.', '18.60', 0.5, NOW(), 1, 7, 'Fast-Loud-Blood-Sweat-Beers.jpg', 'Fast-Loud-Blood-Sweat-Beers', 'Fast N'' Loud: Blood, Sweat and Beers', 'Fast N'' Loud: Blood, Sweat and Beers');

INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (106, 'Tools for Survival: What You Need to Survive When You’re on Your Own', 'In his earlier bestselling nonfiction book, How to Survive the End of the World as We Know It, James Wesley, Rawles, outlined the foundations for survivalist living. Now, he details the tools needed to survive anything from a short-term disruption to a long-term, grid-down scenario.', '11.84', 0.5, NOW(), 1, 8, 'Tools-Survival-What-Survive-You.jpg', 'Tools-Survival-What-Survive-You', 'Tools for Survival: What You Need to Survive When You’re on Your Own', 'Tools for Survival: What You Need to Survive When You’re on Your Own');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (107, 'Sports Illustrated Almanac 2015 (Sports Illustrated Sports Almanac)', 'America''s best-selling sports almanac, now in its 24th year, is as fact-filled and fun as ever. Packed with stats, standings and historical data from Sports Illustrated''s award-winning staff, this is the essential reference book for every fan. From pro and college football to Major League Baseball and the NBA to NASCAR, Sports Illustrated Almanac 2015 features all-time records and year-by-year statistics.', '11.58', 0.5, NOW(), 1, 8, 'Sports-Illustrated-Almanac-2015.jpg', 'Sports-Illustrated-Almanac-2015', 'Sports Illustrated Almanac 2015 (Sports Illustrated Sports Almanac)', 'Sports Illustrated Almanac 2015 (Sports Illustrated Sports Almanac)');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (108, 'Dr. Jordan Metzl''s Running Strong: The Sports Doctor''s Complete Guide to Staying Healthy and Injury-Free for Life', 'Step into my office if you want to run faster, stronger, and pain-free. Whether you''re a new runner training for your first race or an experienced marathoner, this cutting-edge book will keep you on the road and running faster.\n\nWith comprehensive, illustrated information on running health and injury prevention, this book is the first to include embedded scan codes that lead readers to videos addressing such issues as shin splints, plantar fasciitis, stress fractures, and runner''s knee. Not only will runners be able to read about how they can treat and prevent hundreds of medical and nutritional issues, they''ll be able to walk into a top-level video consultation 24 hours per day, 7 days per week, from anywhere in the world!', '16.03', 0.5, NOW(), 1, 8, 'Dr-Jordan-Metzls-Running-Strong.jpg', 'Dr-Jordan-Metzls-Running-Strong', 'Dr. Jordan Metzl''s Running Strong: The Sports Doctor''s Complete Guide to Staying Healthy and Injury-Free for Life', 'Dr. Jordan Metzl''s Running Strong: The Sports Doctor''s Complete Guide to Staying Healthy and Injury-Free for Life');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (109, 'Developing Jin: Silk-Reeling Power in Tai Chi and the Internal Martial Arts', 'Developing Jin provides a complete and progressive training regimen for increasing and refining chansi-jin, also known as silk-reeling power or coiling power--the true power of the internal martial arts. With step-by-step instructions and photographs, experienced teacher Philip Starr walks readers through a variety of techniques designed to help practitioners feel and use jin in their martial arts training. While much of the existing writing on jin relies on cryptic and mystical descriptions of internal power, Starr takes a direct, no-nonsense approach that addresses commonly held myths and identifies the real body mechanics behind this unusual power. Useful for novices and advanced practitioners alike, Developing Jin is a crucial addition to any serious martial artist''s library.', '13.50', 0.5, NOW(), 1, 8, 'Developing-Jin-Silk-Reeling-Internal-Martial.jpg', 'Developing-Jin-Silk-Reeling-Internal-Martial', 'Developing Jin: Silk-Reeling Power in Tai Chi and the Internal Martial Arts', 'Developing Jin: Silk-Reeling Power in Tai Chi and the Internal Martial Arts');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (110, 'Advanced Gunsmithing: A Manual of Instruction in the Manufacture, Alteration, and Repair of Firearms', 'Widely regarded as one of the foremost bibles of gunsmithing of its time, Vickery’s Advanced Gunsmithing is still relevant to this day. With in-depth explanations on different gunsmithing tools, gun parts, and methods, this technical resource complements other modern titles in the contemporary gunsmithing book market.\n\nVickery’s passion for tools, and the firearms he could manipulate with them, gives this book its spirit of resourcefulness and experimentation. Different aspects of gunsmithing are highlighted in the book’s twenty chapters, such as barreling, chambering, action, and other kinds of metal-working. Vickery also attempts to reduce the gunsmither’s reliance on hard-to-find tools, and often describes alternate methods where possible. The informational text is supplemented by detailed illustrations, which are in turn accompanied by live photographs so that the reader can accurately compare his or her work to the text’s instruction.\n\nVickery’s clear and precise instruction covers gunsmithing essentials and techniques for both the amateur and professional smith. The book’s historical significance and previous rare editions make it a valuable collector’s item for any firearm enthusiast. Classic and practical, Advanced Gunsmithing is a noteworthy companion to the gunsmither’s workbench.', '11.28', 0.5, NOW(), 1, 8, 'Advanced-Gunsmithing-Instruction-Manufacture-Alteration.jpg', 'Advanced-Gunsmithing-Instruction-Manufacture-Alteration', 'Advanced Gunsmithing: A Manual of Instruction in the Manufacture, Alteration, and Repair of Firearms', 'Advanced Gunsmithing: A Manual of Instruction in the Manufacture, Alteration, and Repair of Firearms');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (111, 'Sports Marketing: A Practical Approach', 'Any sports marketing student or prospective sports marketer has to understand in detail genuine industry trends and be able to recognise solutions to real-world scenarios. Sports Marketing: A Practical Approach is the first textbook to offer a comprehensive, engaging and practice-focused bridge between academic theory and real-life, industry-based research and practice. Defining the primary role of the sports marketer as revenue generation, the book is structured around the three main channels through which this can be achieved — ticket sales, media and sponsorship — and explores key topics.', '144.80', 0.5, NOW(), 1, 8, 'Sports-Marketing-Practical.jpg', 'Sports-Marketing-Practical', 'Sports Marketing: A Practical Approach', 'Sports Marketing: A Practical Approach');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (112, 'Total Control: High Performance Street Riding Techniques, 2nd Edition', 'A completely revised version of one of the best-selling motorcycle riding skills books of all time. Today''s super high-performance bikes are the most potent vehicles ever sold to the public and they demand advanced riding skills. Get it right, and a modern motorcycle will provide you with the thrill of a lifetime; get it wrong and you''ll be carted off in a meat wagon. The line between ecstasy and agony is so thin that there is absolutely no margin for error. Total Control provides you with the information you need to stay on the healthy side of that line, providing a training course developed and perfected through decades of professional training in Lee Parks'' Total Control Advanced Riding Clinic. This is the perfect book for riders who want to take their street riding skills to a higher level. Total Control explains the ins and outs of high-performance street riding. Lee Parks, one of the most accomplished riders, racers, authors and instructors in the world, helps riders master the awe-inspiring performance potential of modern motorcycles. This book gives riders everything they need to develop the techniques and survival skills necessary to become a proficient, accomplished, and safer street rider. High quality photos, detailed instructions, and professional diagrams highlight the intricacies and proper techniques of street riding and the knowledge gained will apply to all brands of bikes from Harley-Davidson and Suzuki to Ducati and Kawaski to Honda and BMW and more! Readers will come away with a better understanding of everything from braking and cornering to proper throttle control, resulting in a more exhilarating yet safer ride.', '22.22', 0.5, NOW(), 1, 8, 'Total-Control-Performance-Street-Techniques.jpg', 'Total-Control-Performance-Street-Techniques', 'Total Control: High Performance Street Riding Techniques, 2nd Edition', 'Total Control: High Performance Street Riding Techniques, 2nd Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (113, 'Periodization Training for Sports-3rd Edition', 'Sport conditioning has advanced tremendously since the era when a “no pain, no gain” philosophy guided the training regimens of athletes. Dr. Tudor Bompa pioneered most of these breakthroughs, proving long ago that it''s not only how much and how hard an athlete works but also when and what work is done that determine an athlete''s conditioning level. Periodization Training for Sports goes beyond the simple application of bodybuilding or powerlifting programs to build strength in athletes.', '18.32', 0.5, NOW(), 1, 8, 'Periodization-Training-Sports-3rd.jpg', 'Periodization-Training-Sports-3rd', 'Periodization Training for Sports-3rd Edition', 'Periodization Training for Sports-3rd Edition');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (114, 'Total Foam Rolling Techniques: Trade Secrets of a Personal Trainer', 'The ultimate ''one stop'' guide to using foam rollers. A relative newcomer to the fitness scene, lots of us don''t know how to use foam rollers effectively as part of an exercise or training routine.\n\nOriginally used only by physiotherapists and exercise therapists, this ''new'' piece of kit has become a mainstay of workouts. Foam rollers work by releasing muscle tension to relieve pain, aid injury recovery and improve flexibility-all through massaging and manipulating muscles.\n\nPractical and easily accessible, Total Foam Rolling Techniques is perfect for the fitness enthusiast or fitness professional who wants to lightly improve their knowledge and heavily improve the range of exercises they can use in their training. Tried and tested exercises are accompanied by clear photos and illustrations.\n\nThis book is brimming with ideas for using foam rollers not just in the gym, but at home too. Packed with clear and easy to use exercises, this how-to reference book also provides adaptations of basic and advanced workouts, making it ideal for anyone who wants to get the most out of their fitness gear.', '18.63', 0.5, NOW(), 1, 8, 'Total-Foam-Rolling-Techniques-Personal.jpg', 'Total-Foam-Rolling-Techniques-Personal', 'Total Foam Rolling Techniques: Trade Secrets of a Personal Trainer', 'Total Foam Rolling Techniques: Trade Secrets of a Personal Trainer');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (115, 'Concussion Inc.: The End of Football As We Know It', 'Traumatic brain injury in football is not incidental, but an inevitable and central aspect of the sport. Starting in high school, through college, and into the NFL, young players face repeated head trauma, and those sustained injuries create lifelong cognitive and functional difficulties.\n\nMuchnick’s Concussion Inc. blog exposed the decades-long cover-up of scientific research into sports concussions and the ongoing denial to radically reform football in North America. This compilation from Muchnick’s no-holds-barred investigative website reveals the complete head injury story as it developed, from the doctor who played fast and loose with the facts about the efficacy of the state-mandated concussion management system for high school football players, to highly touted solutions that are more self-serving cottage industry than of any genuine benefit.\n\nKnown for extensive reporting on the tragic story of the Chris Benoit murder-suicide, Muchnick turns his investigative analysis to traumatic brain injury and probes deep into the corporate, government, and media corruption that has enabled the $10-billion-a-year National Football League to trigger a public health crisis.', '15.16', 0.5, NOW(), 1, 8, 'Concussion-Inc-End-Football-Know.jpg', 'Concussion-Inc-End-Football-Know', 'Concussion Inc.: The End of Football As We Know It', 'Concussion Inc.: The End of Football As We Know It');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (116, 'Championship Fighting: Explosive Punching and Aggressive Defense', 'Fighting techniques and strategies from World Champion and Hall of Fame Boxer, Jack Dempsey.\n\nJack Dempsey, one of the greatest and most popular boxers of all time, reveals the techniques behind his unparalleled success in the ring. Straightforward and with detailed illustrations, Championship Boxing instructs the reader in the theory, training, and application of powerful punching, aggressive defense, proper stance, feinting, and footwork. The methods Dempsey reveals will prove useful to both amateurs and professionals.\n\n“I was confident that I could take the rawest beginner, or even an experienced fighter, and teach him exactly what self-defense was all about.” —Jack Dempsey', '13.80', 0.5, NOW(), 1, 8, 'Championship-Fighting-Explosive-Punching-Aggressive.jpg', 'Championship-Fighting-Explosive-Punching-Aggressive', 'Championship Fighting: Explosive Punching and Aggressive Defense', 'Championship Fighting: Explosive Punching and Aggressive Defense');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (117, 'The Race Within: Passion, Courage, and Sacrifice at the Ultraman Triathlon', 'The Ultraman Triathlon, one of the most remarkable endurance races in the world, is a three-day, 320-mile race that circumnavigates the Big Island of Hawaii. With only 40 competitors allowed in each year, this invitation-only event hosts some of the most superlative athletes on the planet. The Race Within discusses the 30-year history of the sport and race director Jane Bockus, former Pan Am flight attendant who has never done a triathlon, yet has dedicated herself to keeping the event true to its founding spirit for decades. This book follows Jane, her assistants, and a small cast of athletes through an entire year—from the end of the 2012 Ultraman to the 2013 event—and shows how they faced new challenges to the growth and well-being of the event, and were forced to question if old traditions could survive in a world of constantly-evolving sports entertainment. Granted full access to the race and the athletes, author Jim Gourley presents a look at this unique event and examines what it means to truly love sports.', '12.71', 0.5, NOW(), 1, 8, 'Race-Within-Sacrifice-Ultraman-Triathlon.jpg', 'Race-Within-Sacrifice-Ultraman-Triathlon', 'The Race Within: Passion, Courage, and Sacrifice at the Ultraman Triathlon', 'The Race Within: Passion, Courage, and Sacrifice at the Ultraman Triathlon');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (118, 'The Kenpo Karate Compendium: The Forms and Sets of American Kenpo', 'The Kenpo Karate Compendium details the forms of American Kenpo as prescribed by the “Father of American Karate,” Ed Parker. Author Lee Wedlake, 9th degree black belt, world-class instructor and competitor, brings his acclaimed training and teaching experience to bear in this unique resource for all who practice and teach American Kenpo and its offshoot systems. The American Kenpo system is taught worldwide and this reference will become a standard for thousands of Kenpo practitioners in various lineages. It will also serve as a stimulus for all martial artists by providing a sense of the logical framework of American Kenpo. Having collected the general rules of motion and the numerous fine points of Kenpo, the book is a standout in the genre.', '13.42', 0.5, NOW(), 1, 8, 'Kenpo-Karate-Compendium-Forms-American.jpg', 'Kenpo-Karate-Compendium-Forms-American', 'The Kenpo Karate Compendium: The Forms and Sets of American Kenpo', 'The Kenpo Karate Compendium: The Forms and Sets of American Kenpo');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (119, 'Ninja Secrets of Invisibility', 'Like the ninja warrior, you too can walk unobserved, penetrating forbidden areas unseen, departing at will without leaving a trace. Now this classic work’s secrets of invisibility, known to the ninja of old, can be part of your self-defense repertoire.\n\nThe training a student must undergo in order to become a practicing ninja involves tasks that are not to be taken lightly; indeed, attaining the higher stages demands an intensity of effort and perseverance greater than that required for any other pursuit. The training process necessitates the disintegration and reintegration of the student’s own personality. As a result, one may become a ninja.\n\nBe invincible once you learn to become part of your surroundings and employ the deadly moves of ninjitsu. Ashida Kim, author of the noted Secrets of the Ninja, also tells you how to vanish from your opponent’s sight and make his instinctive reactions works for you. And should you be seized, learn which deadly fighting techniques will make you the undeniable victor!', '9.95', 0.5, NOW(), 1, 8, 'Ninja-Secrets-Invisibility.jpg', 'Ninja-Secrets-Invisibility', 'Ninja Secrets of Invisibility', 'Ninja Secrets of Invisibility');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `weight`, `date`, `section`, `category`, `image`, `identity`, `meta_title`, `meta_description`)
VALUES (120, 'Racing the Sunset: Lessons on How Athletes Survive, Thrive, or Fail After Sport', 'A seventh-generation Californian, Scott Tinley led the quintessential Golden State dream. As he grew from beach rat to lifeguard to a recreational administration major, it seemed only natural to him that he would try to parlay the athletic skills gleaned from this idyllic lifestyle into a profession as one of the best triathletes in the world. For twenty years, his skill, tenacity, and devil-may-care attitude guided him along the path.\nBut when age took hold of his legs, and no amount of training would help, his athletic gold rush went bust. Cracks in his psyche began to show, as if beneath it all—like much of California itself—his athletic life had been built on a fault. Always introspective and inquiring, Tinley threw himself headlong into athlete retirement and the larger issues of life transition and change. His new journey, driven by his quest for personal growth and healing, was filled with pain, false starts, and heartrending intimacies. It led him to hundreds of other retired professional athletes who would openly discuss their own triumphs and tragedies. With much discipline, Tinley completed one of the most thorough athlete research projects ever attempted, and befriended such superstars as Bill Walton, Eric Heiden, Greg LeMond, Jerry Sherk, Steve Scott, and Rick Sutcliffe. Along the way he uncovered secrets about himself and the process of change, turmoil, and final acceptance, all shared openly and eloquently in Racing the Sunset. This book will do for athletes of every level what Passages did for an entire generation.', '14.81', 0.5, NOW(), 1, 8, 'Racing-Sunset-Lessons-Athletes-Survive.jpg', 'Racing-Sunset-Lessons-Athletes-Survive', 'Racing the Sunset: Lessons on How Athletes Survive, Thrive, or Fail After Sport', 'Racing the Sunset: Lessons on How Athletes Survive, Thrive, or Fail After Sport');

--
-- Dumping data for table `zones_country_codes`
--
INSERT INTO `zones_country_codes` VALUES (1, 1, 'US');
INSERT INTO `zones_country_codes` VALUES (2, 2, 'CA');
INSERT INTO `zones_country_codes` VALUES (3, 2, 'MX');
INSERT INTO `zones_country_codes` VALUES (4, 3, 'BG');
INSERT INTO `zones_country_codes` VALUES (5, 3, 'PL');
INSERT INTO `zones_country_codes` VALUES (6, 1, '94086');
INSERT INTO `zones_country_codes` VALUES (7, 1, '95192');

--
-- Dumping data for table `shipping`
--
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (1, 1, 230, 10.00, 15.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (2, 1, 230, 10.00, 12.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (3, 1, 230, 10.00, 9.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (4, 1, 230, 10.00, 5.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (1, 2, 230, 10.00, 17.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (2, 2, 230, 10.00, 15.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (3, 2, 230, 10.00, 10.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (4, 2, 230, 10.00, 7.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (1, 3, 230, 10.00, 18.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (2, 3, 230, 10.00, 16.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (3, 3, 230, 10.00, 12.50);
INSERT INTO `shipping` (`type`, `zone`, `country`, `weight`, `cost`)
    VALUES (4, 3, 230, 10.00, 8.50);