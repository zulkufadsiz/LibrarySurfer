-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 24 Oca 2019, 11:50:06
-- Sunucu sürümü: 5.7.23
-- PHP Sürümü: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `lib_surfer`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sp_author`
--

DROP TABLE IF EXISTS `sp_author`;
CREATE TABLE IF NOT EXISTS `sp_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` datetime DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordering` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sp_author`
--

INSERT INTO `sp_author` (`id`, `title`, `nationality`, `create_date`, `last_update`, `description`, `ordering`, `status`, `image`) VALUES
(2, 'Arthur Conan Doyle', 221, '2019-01-23 23:06:21', '2019-01-23 08:08:33', '<p><span style=\"color: #222222; font-family: arial, sans-serif; font-size: small;\">Sir Arthur Ignatius Conan Doyle KStJ DL was a British writer best known for his detective fiction featuring the character Sherlock Holmes. </span></p>', 1, 1, '56ac5b29b476dc5f58f9cf111cf7abea.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sp_books`
--

DROP TABLE IF EXISTS `sp_books`;
CREATE TABLE IF NOT EXISTS `sp_books` (
  `isbn` bigint(13) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `description` varchar(800) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`isbn`),
  UNIQUE KEY `isbn` (`isbn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sp_books`
--

INSERT INTO `sp_books` (`isbn`, `title`, `category_id`, `author_id`, `description`, `create_date`, `last_update`, `image`, `ordering`, `status`) VALUES
(6055420796, 'Sherlock Holmes Akıl Oyunlarının Gölgesinde', 2, 2, '<p>Sherlock Holmes</p>\r\n<p>Dünyaca ünlü dedektif Sherlock Holmes, kendine özgü karakteri ve yaşadığı birbirinden farklı</p>\r\n<p>maceralarıyla uzun yıllardan beri siz okurları etkisi altında tutmaya devam ediyor. Toplam 56</p>\r\n<p>çarpıcı hikâyeden oluşan eserin bu ilk kitabı, sizi insan zekâsını zorlayan tuhaf suçlar ve cinayetler</p>\r\n<p>dünyasında gezdirirken, gerçeğe giden bir yolda yalnız olmadığınızı da hissettiriyor..</p>', '2019-01-24 08:38:47', NULL, 'b9dda6f0c9a2c5da258c2b0600e7ea42.jpg', 1, 1),
(6053480563, 'Aklın Şüphesi Suçun Gerçeğidir', 2, 2, '<p>Sherlock Holmes</p>\r\n<p>Unutulmaz dedektif Sherlock Holmes’un keskin zekâsını kullanarak çözdüğü, birbirinden ilginç ve esrarengiz 12 hikâyenin anlatıldığı serinin son kitabı Aklın Şüphesi Suçun Gerçeğidir, suç dünyasına bambaşka bir açıdan bakmanızı sağlayacak.</p>', '2019-01-24 08:47:03', NULL, 'b19a426b732b83c596dd0c151ac5ce9e.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sp_book_pictures`
--

DROP TABLE IF EXISTS `sp_book_pictures`;
CREATE TABLE IF NOT EXISTS `sp_book_pictures` (
  `picture_id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_ordering` int(11) DEFAULT '0',
  `isbn` bigint(20) NOT NULL,
  `picture_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture_status` int(11) NOT NULL,
  PRIMARY KEY (`picture_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sp_book_pictures`
--

INSERT INTO `sp_book_pictures` (`picture_id`, `picture_ordering`, `isbn`, `picture_path`, `picture_status`) VALUES
(4, 0, 6055420796, '884b64a833f729b50ee643ca55289a452.jpg', 1),
(3, 0, 6055420796, '6db105c7082880ba499cbfef67a3f71a1.jpg', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sp_categories`
--

DROP TABLE IF EXISTS `sp_categories`;
CREATE TABLE IF NOT EXISTS `sp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sp_categories`
--

INSERT INTO `sp_categories` (`id`, `title`, `description`, `status`, `ordering`) VALUES
(2, 'Polisiye', '<p><span style=\"color: #222222; font-family: arial, sans-serif; font-size: small;\">Polisiye suç ve suçlularla ilgili edebiyata verilen genel addır.</span></p>', 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sp_nationality`
--

DROP TABLE IF EXISTS `sp_nationality`;
CREATE TABLE IF NOT EXISTS `sp_nationality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sp_nationality`
--

INSERT INTO `sp_nationality` (`id`, `title`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Aruba'),
(13, 'Australia'),
(14, 'Austria'),
(15, 'Azerbaijan'),
(16, 'Bahamas'),
(17, 'Bahrain'),
(18, 'Bangladesh'),
(19, 'Barbados'),
(20, 'Belarus'),
(21, 'Belgium'),
(22, 'Belize'),
(23, 'Benin'),
(24, 'Bermuda'),
(25, 'Bhutan'),
(26, 'Bolivia'),
(27, 'Bosnia and Herzegowina'),
(28, 'Botswana'),
(29, 'Bouvet Island'),
(30, 'Brazil'),
(31, 'British Indian Ocean Territory'),
(32, 'Brunei Darussalam'),
(33, 'Bulgaria'),
(34, 'Burkina Faso'),
(35, 'Burundi'),
(36, 'Cambodia'),
(37, 'Cameroon'),
(38, 'Canada'),
(39, 'Cape Verde'),
(40, 'Cayman Islands'),
(41, 'Central African Republic'),
(42, 'Chad'),
(43, 'Chile'),
(44, 'China'),
(45, 'Christmas Island'),
(46, 'Cocos (Keeling) Islands'),
(47, 'Colombia'),
(48, 'Comoros'),
(49, 'Congo'),
(50, 'Congo, the Democratic Republic of the'),
(51, 'Cook Islands'),
(52, 'Costa Rica'),
(53, 'Croatia (Hrvatska)'),
(54, 'Cuba'),
(55, 'Cyprus'),
(56, 'Czech Republic'),
(57, 'Denmark'),
(58, 'Djibouti'),
(59, 'Dominica'),
(60, 'Dominican Republic'),
(61, 'East Timor'),
(62, 'Ecuador'),
(63, 'Egypt'),
(64, 'El Salvador'),
(65, 'Equatorial Guinea'),
(66, 'Eritrea'),
(67, 'Estonia'),
(68, 'Ethiopia'),
(69, 'Falkland Islands (Malvinas)'),
(70, 'Faroe Islands'),
(71, 'Fiji'),
(72, 'Finland'),
(73, 'France'),
(74, 'France Metropolitan'),
(75, 'French Guiana'),
(76, 'French Polynesia'),
(77, 'French Southern Territories'),
(78, 'Gabon'),
(79, 'Gambia'),
(80, 'Georgia'),
(81, 'Germany'),
(82, 'Ghana'),
(83, 'Gibraltar'),
(84, 'Greece'),
(85, 'Greenland'),
(86, 'Grenada'),
(87, 'Guadeloupe'),
(88, 'Guam'),
(89, 'Guatemala'),
(90, 'Guinea'),
(91, 'Guinea-Bissau'),
(92, 'Guyana'),
(93, 'Haiti'),
(94, 'Heard and Mc Donald Islands'),
(95, 'Holy See (Vatican City State)'),
(96, 'Honduras'),
(97, 'Hong Kong'),
(98, 'Hungary'),
(99, 'Iceland'),
(100, 'India'),
(101, 'Indonesia'),
(102, 'Iran (Islamic Republic of)'),
(103, 'Iraq'),
(104, 'Ireland'),
(105, 'Israel'),
(106, 'Italy'),
(107, 'Jamaica'),
(108, 'Japan'),
(109, 'Jordan'),
(110, 'Kazakhstan'),
(111, 'Kenya'),
(112, 'Kiribati'),
(113, 'Korea, Republic of'),
(114, 'Kuwait'),
(115, 'Kyrgyzstan'),
(116, 'Latvia'),
(117, 'Lebanon'),
(118, 'Lesotho'),
(119, 'Liberia'),
(120, 'Libyan Arab Jamahiriya'),
(121, 'Liechtenstein'),
(122, 'Lithuania'),
(123, 'Luxembourg'),
(124, 'Macau'),
(125, 'Macedonia, The Former Yugoslav Republic of'),
(126, 'Madagascar'),
(127, 'Malawi'),
(128, 'Malaysia'),
(129, 'Maldives'),
(130, 'Mali'),
(131, 'Malta'),
(132, 'Marshall Islands'),
(133, 'Martinique'),
(134, 'Mauritania'),
(135, 'Mauritius'),
(136, 'Mayotte'),
(137, 'Mexico'),
(138, 'Micronesia, Federated States of'),
(139, 'Moldova, Republic of'),
(140, 'Monaco'),
(141, 'Mongolia'),
(142, 'Montserrat'),
(143, 'Morocco'),
(144, 'Mozambique'),
(145, 'Myanmar'),
(146, 'Namibia'),
(147, 'Nauru'),
(148, 'Nepal'),
(149, 'Netherlands'),
(150, 'Netherlands Antilles'),
(151, 'New Caledonia'),
(152, 'New Zealand'),
(153, 'Nicaragua'),
(154, 'Niger'),
(155, 'Nigeria'),
(156, 'Niue'),
(157, 'Norfolk Island'),
(158, 'Northern Mariana Islands'),
(159, 'Norway'),
(160, 'Oman'),
(161, 'Pakistan'),
(162, 'Palau'),
(163, 'Panama'),
(164, 'Papua New Guinea'),
(165, 'Paraguay'),
(166, 'Peru'),
(167, 'Philippines'),
(168, 'Pitcairn'),
(169, 'Poland'),
(170, 'Portugal'),
(171, 'Puerto Rico'),
(172, 'Qatar'),
(173, 'Reunion'),
(174, 'Romania'),
(175, 'Russian Federation'),
(176, 'Rwanda'),
(177, 'Saint Kitts and Nevis'),
(178, 'Saint Lucia'),
(179, 'Saint Vincent and the Grenadines'),
(180, 'Samoa'),
(181, 'San Marino'),
(182, 'Sao Tome and Principe'),
(183, 'Saudi Arabia'),
(184, 'Senegal'),
(185, 'Seychelles'),
(186, 'Sierra Leone'),
(187, 'Singapore'),
(188, 'Slovakia (Slovak Republic)'),
(189, 'Slovenia'),
(190, 'Solomon Islands'),
(191, 'Somalia'),
(192, 'South Africa'),
(193, 'South Georgia and the South Sandwich Islands'),
(194, 'Spain'),
(195, 'Sri Lanka'),
(196, 'St. Helena'),
(197, 'St. Pierre and Miquelon'),
(198, 'Sudan'),
(199, 'Suriname'),
(200, 'Svalbard and Jan Mayen Islands'),
(201, 'Swaziland'),
(202, 'Sweden'),
(203, 'Switzerland'),
(204, 'Syrian Arab Republic'),
(205, 'Taiwan, Province of China'),
(206, 'Tajikistan'),
(207, 'Tanzania, United Republic of'),
(208, 'Thailand'),
(209, 'Togo'),
(210, 'Tokelau'),
(211, 'Tonga'),
(212, 'Trinidad and Tobago'),
(213, 'Tunisia'),
(214, 'Turkey'),
(215, 'Turkmenistan'),
(216, 'Turks and Caicos Islands'),
(217, 'Tuvalu'),
(218, 'Uganda'),
(219, 'Ukraine'),
(220, 'United Arab Emirates'),
(221, 'United Kingdom'),
(222, 'United States'),
(223, 'United States Minor Outlying Islands'),
(224, 'Uruguay'),
(225, 'Uzbekistan'),
(226, 'Vanuatu'),
(227, 'Venezuela'),
(228, 'Vietnam'),
(229, 'Virgin Islands (British)'),
(230, 'Virgin Islands (U.S.)'),
(231, 'Wallis and Futuna Islands'),
(232, 'Western Sahara'),
(233, 'Yemen'),
(234, 'Yugoslavia'),
(235, 'Zambia'),
(236, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sp_users`
--

DROP TABLE IF EXISTS `sp_users`;
CREATE TABLE IF NOT EXISTS `sp_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `status` int(1) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Tablo döküm verisi `sp_users`
--

INSERT INTO `sp_users` (`id`, `email`, `password`, `image`, `create_date`, `last_login`, `status`, `full_name`) VALUES
(2, 'zulkufadsiz@gmail.com', 'df2cd7104536553afde9f7d66133d578eccb4606', NULL, '2019-01-23 18:30:35', NULL, 1, 'Zülküf ADSIZ'),
(6, 'joshuajackson@gmail.com', '0937afa17f4dc08f3c0e5dc908158370ce64df86', NULL, '2019-01-24 13:47:11', NULL, 1, 'Joshua Jackson');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
