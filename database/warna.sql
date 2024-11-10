-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2021 at 02:14 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warna`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist_informations`
--

CREATE TABLE `artist_informations` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `type_id` int(255) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artist_informations`
--

INSERT INTO `artist_informations` (`id`, `user_id`, `type_id`, `description`, `status`, `created`) VALUES
(1, 4, 1, 'University of Moratuwa', 1, '2021-06-06 00:12:55'),
(2, 4, 1, 'Kalapola', 1, '2021-06-06 00:12:55'),
(4, 4, 3, 'award 2020', 1, '2021-06-06 00:22:01'),
(8, 4, 2, 'Kalapola 2018', 1, '2021-06-19 19:05:38'),
(9, 4, 1, 'Vibhavi Academy of Fine Arts', 1, '2021-06-19 19:13:25'),
(10, 4, 2, 'oluniopiunp0o', 1, '2021-06-23 20:35:15'),
(11, 33, 1, 'University of Moratuwa', 1, '2021-06-26 01:03:47'),
(12, 33, 3, 'Award 2015', 1, '2021-06-26 01:03:47'),
(13, 33, 2, 'Kalapola 2020', 1, '2021-06-26 01:03:47'),
(14, 35, 1, 'University of Moratuwa', 1, '2021-06-26 09:38:51'),
(15, 35, 3, 'award 2018', 1, '2021-06-26 09:38:51'),
(16, 35, 2, 'Kalapola 2020', 1, '2021-06-26 09:38:51');

-- --------------------------------------------------------

--
-- Table structure for table `artist_information_types`
--

CREATE TABLE `artist_information_types` (
  `id` int(255) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artist_information_types`
--

INSERT INTO `artist_information_types` (`id`, `type`, `icon`) VALUES
(1, 'Education', 'fa-mortar-board'),
(2, 'Exhibition', 'fa-newspaper-o'),
(3, 'Award', 'fa-trophy');

-- --------------------------------------------------------

--
-- Table structure for table `artist_payments`
--

CREATE TABLE `artist_payments` (
  `id` int(255) NOT NULL,
  `order_id` int(255) DEFAULT NULL,
  `artist_id` int(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `status_user_id` int(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artist_payments`
--

INSERT INTO `artist_payments` (`id`, `order_id`, `artist_id`, `amount`, `note`, `status`, `status_user_id`, `created`) VALUES
(1, 27, 4, 16000, 'Payment approval:: due amount - 16 000.00', 1, 1, '2021-07-14 19:52:16'),
(2, 27, 4, 12800, 'Artist Payment:: completed', 1, 1, '2021-07-14 19:59:50');

-- --------------------------------------------------------

--
-- Table structure for table `artist_services`
--

CREATE TABLE `artist_services` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `service_id` int(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artist_services`
--

INSERT INTO `artist_services` (`id`, `user_id`, `service_id`, `status`) VALUES
(1, 4, 1, 1),
(2, 4, 2, 1),
(4, 6, 1, 1),
(5, 6, 3, 1),
(6, 6, 4, 1),
(7, 6, 5, 1),
(8, 2, 3, 1),
(9, 2, 6, 1),
(10, 2, 7, 1),
(11, 10, 1, 1),
(12, 11, 1, 1),
(13, 12, 1, 1),
(14, 13, 1, 1),
(15, 14, 1, 1),
(16, 15, 2, 1),
(17, 17, 4, 1),
(18, 18, 4, 1),
(19, 19, 3, 1),
(20, 20, 3, 1),
(21, 21, 5, 1),
(22, 21, 7, 1),
(23, 10, 6, 1),
(24, 10, 7, 1),
(25, 10, 8, 1),
(26, 10, 9, 1),
(27, 11, 9, 1),
(33, 4, 3, 1),
(38, 4, 4, 1),
(42, 4, 5, 1),
(43, 33, 1, 1),
(44, 33, 3, 1),
(45, 33, 5, 1),
(46, 33, 9, 1),
(47, 35, 2, 1),
(48, 35, 4, 1),
(49, 39, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE `bid` (
  `id` int(255) NOT NULL,
  `product_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status_user_id` int(255) DEFAULT NULL,
  `status_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`id`, `product_id`, `user_id`, `amount`, `status`, `created`, `status_user_id`, `status_time`) VALUES
(1, 13, 1, 2100, 0, '2021-07-04 16:00:11', NULL, NULL),
(2, 13, 1, 2500, 0, '2021-07-04 16:37:57', NULL, NULL),
(3, 4, 5, 2100, 0, '2021-07-15 13:10:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(255) NOT NULL,
  `title` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_user_id` int(255) DEFAULT NULL,
  `status_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `image`, `created_time`, `updated_time`, `user_id`, `status`, `status_user_id`, `status_time`) VALUES
(1, 'How to recycle oil and white spirit medium for oil painting', '<p><b><font color=\"#FFD663\">Lorem ipsum dolor sit amet, consecte</font></b>tur adipiscing elit. Integer dapibus ante risus, sed iaculis ante varius vitae. Ut eu ante cursus, ultrices nisl mattis, aliquam tellus. Nunc eget eleifend dui, vel gravida lectus. Nullam consequat nibh urna, et scelerisque tortor scelerisque vitae. Praesent massa metus, luctus ac egestas vehicula, ornare in mi. Nam eget iaculis libero. Phasellus scelerisque eleifend erat, a consectetur nisl feugiat sed. Morbi et ante odio. Maecenas rhoncus nisl vel efficitur molestie. Donec rhoncus porta ligula sed vulputate. Donec aliquet dolor lacus, dignissim tristique lacus suscipit eget.<br><br>Nunc a purus vitae leo venenatis fermentum in hendrerit nibh. Nullam id bibendum quam. Nam suscipit pharetra felis nec mattis. Etiam sit amet sollicitudin ex, a fermentum libero. Maecenas pretium, libero quis dictum consectetur, dui purus maximus nibh, non tristique mauris justo id nulla. Nunc congue ut arcu eget convallis. Etiam nec diam eu quam sodales imperdiet. Curabitur posuere cursus ullamcorper. Aliquam erat volutpat. Nam hendrerit sollicitudin vehicula. Nunc egestas, urna quis dictum volutpat, mi sem iaculis ex, vel pellentesque enim purus a mi. Aliquam vulputate, mauris et maximus dictum, massa lectus gravida arcu, vel viverra justo lorem eu ligula. Vivamus egestas lectus eget enim dictum, ut vestibulum nulla ultrices. Pellentesque nec nisl finibus lacus faucibus convallis. In sodales ultrices leo, nec luctus magna luctus et.<br><br>Vivamus at euismod enim, non fermentum elit. Quisque hendrerit nunc purus, at faucibus mauris tempus sit amet. Praesent vitae dapibus augue, sed gravida ligula. Suspendisse dictum at est quis ornare. Donec hendrerit nulla neque, id lacinia ipsum ullamcorper sed. Vivamus ultricies felis id pretium ultrices. Sed elementum eu metus nec blandit. Nulla augue nulla, dapibus sed erat a, luctus accumsan arcu. Praesent ultricies neque eget risus interdum, eget semper tortor varius. Maecenas volutpat nibh at eros convallis, in tincidunt ante ornare. Etiam id est sit amet nunc vehicula hendrerit.<br><br>Integer odio lacus, ultricies et nisl nec, volutpat pellentesque nibh. Nam tincidunt egestas mauris, in tempus sem vehicula sit amet. Proin vehicula, elit non hendrerit commodo, nulla lorem pharetra ante, sit amet volutpat elit sapien non dolor. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sapien tortor, vestibulum eu suscipit eget, malesuada sit amet lorem. Suspendisse potenti. Mauris in pretium libero, eu hendrerit purus. Maecenas sit amet ante diam. Sed ut metus id ligula imperdiet dictum non quis nunc.<br><br>Aenean laoreet quam in ex faucibus eleifend. Proin pulvinar orci in massa consequat varius. Nulla lacus dui, consectetur quis lacus sed, tincidunt pellentesque ex. Nullam tempus sodales lorem in fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce bibendum leo vitae dapibus pulvinar. Mauris sagittis eros eget nunc ornare lacinia. Phasellus semper blandit erat. Nam venenatis metus nec efficitur vehicula. <br></p>', 'w_1625567039.jpg', '2021-01-18 18:03:39', '2021-07-06 15:54:00', 1, 1, NULL, NULL),
(2, 'Why do we use it?', 'ප්‍රාග් තිහාසික මානව ජනාවාස පිළිබඳ සාක්ෂි සහිතව අවම වශයෙන් අවුරුදු 125,000 ක් තරම් පැරණි ශ්‍රී ලංකාවේ ලේඛනගත ඉතිහාසය වසර 3,000 ක් පුරා දිව යයි. එය පොහොසත් සංස්කෘතික උරුමයක් ඇති අතර, ශ්‍රී ලංකාවේ ප්‍රථම බෞද්ධ ලියවිලි වන පාලි කැනනය ක්‍රි.පූ. 29 දී සිව්වන බෞද්ධ සභාව දක්වා දිව යයි. එහි භූගෝලීය පිහිටීම සහ ගැඹුරු වරායන් පුරාණ සේද යුගයේ සිට විශාල උපායමාර්ගික වැදගත්කමක් ලබා දුන්නේය. නවීන සමුද්‍ර සේද මාවත හරහා යන්න. ප්‍රධාන වෙළඳ මධ්‍යස්ථානයක් ලෙස එහි පිහිටීම එය අනුරාධපුර යුගය තරම් East ත පෙරදිග මෙන්ම යුරෝපයට ද දැන සිටියේය. රටේ සුඛෝපභෝගී භාණ්ඩ හා කුළුබඩු වෙළඳාම බොහෝ රටවල වෙළෙඳුන් ආකර්ෂණය කර ගනිමින් ශ්‍රී ලංකාවේ විවිධ ජනගහනය ඇති කළේය<br>', 'w_1625567024.jpg', '2021-01-18 18:04:32', '2021-07-06 15:53:46', 1, 1, NULL, NULL),
(3, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'w_1625567010.jpg', '2021-01-18 18:20:01', '2021-07-06 15:53:32', 1, 1, NULL, NULL),
(5, 'Blog 20210523', '<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volu tate velit esse cillum dolore e fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volu tate velit esse cillum dolore e fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br><br> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volu tate velit esse cillum dolore e fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br><br><br> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volu tate velit esse cillum dolore e fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br><br><br> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volu tate velit esse cillum dolore e fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br></p>', 'w_1625566966.jpg', '2021-01-19 00:22:58', '2021-07-06 15:52:48', 1, 1, NULL, NULL),
(6, 'How to Photograph your Artwork', '<b><font color=\"#FFD663\">Lorem ipsum dolor sit amet, consecte</font></b>tur\r\n adipiscing elit. Integer dapibus ante risus, sed iaculis ante varius \r\nvitae. Ut eu ante cursus, ultrices nisl mattis, aliquam tellus. Nunc \r\neget eleifend dui, vel gravida lectus. Nullam consequat nibh urna, et \r\nscelerisque tortor scelerisque vitae. Praesent massa metus, luctus ac \r\negestas vehicula, ornare in mi. Nam eget iaculis libero. Phasellus \r\nscelerisque eleifend erat, a consectetur nisl feugiat sed. Morbi et ante\r\n odio. Maecenas rhoncus nisl vel efficitur molestie. Donec rhoncus porta\r\n ligula sed vulputate. Donec aliquet dolor lacus, dignissim tristique \r\nlacus suscipit eget.<br><br>Nunc a purus vitae leo venenatis fermentum \r\nin hendrerit nibh. Nullam id bibendum quam. Nam suscipit pharetra felis \r\nnec mattis. Etiam sit amet sollicitudin ex, a fermentum libero. Maecenas\r\n pretium, libero quis dictum consectetur, dui purus maximus nibh, non \r\ntristique mauris justo id nulla. Nunc congue ut arcu eget convallis. \r\nEtiam nec diam eu quam sodales imperdiet. Curabitur posuere cursus \r\nullamcorper. Aliquam erat volutpat. Nam hendrerit sollicitudin vehicula.\r\n Nunc egestas, urna quis dictum volutpat, mi sem iaculis ex, vel \r\npellentesque enim purus a mi. Aliquam vulputate, mauris et maximus \r\ndictum, massa lectus gravida arcu, vel viverra justo lorem eu ligula. \r\nVivamus egestas lectus eget enim dictum, ut vestibulum nulla ultrices. \r\nPellentesque nec nisl finibus lacus faucibus convallis. In sodales \r\nultrices leo, nec luctus magna luctus et.<br><br>Vivamus at euismod \r\nenim, non fermentum elit. Quisque hendrerit nunc purus, at faucibus \r\nmauris tempus sit amet. Praesent vitae dapibus augue, sed gravida \r\nligula. Suspendisse dictum at est quis ornare. Donec hendrerit nulla \r\nneque, id lacinia ipsum ullamcorper sed. Vivamus ultricies felis id \r\npretium ultrices. Sed elementum eu metus nec blandit. Nulla augue nulla,\r\n dapibus sed erat a, luctus accumsan arcu. Praesent ultricies neque eget\r\n risus interdum, eget semper tortor varius. Maecenas volutpat nibh at \r\neros convallis, in tincidunt ante ornare. Etiam id est sit amet nunc \r\nvehicula hendrerit.<br><br>Integer odio lacus, ultricies et nisl nec, \r\nvolutpat pellentesque nibh. Nam tincidunt egestas mauris, in tempus sem \r\nvehicula sit amet. Proin vehicula, elit non hendrerit commodo, nulla \r\nlorem pharetra ante, sit amet volutpat elit sapien non dolor. Orci \r\nvarius natoque penatibus et magnis dis parturient montes, nascetur \r\nridiculus mus. Sed sapien tortor, vestibulum eu suscipit eget, malesuada\r\n sit amet lorem. Suspendisse potenti. Mauris in pretium libero, eu \r\nhendrerit purus. Maecenas sit amet ante diam. Sed ut metus id ligula \r\nimperdiet dictum non quis nunc.<br><br>Aenean laoreet quam in ex \r\nfaucibus eleifend. Proin pulvinar orci in massa consequat varius. Nulla \r\nlacus dui, consectetur quis lacus sed, tincidunt pellentesque ex. Nullam\r\n tempus sodales lorem in fringilla. Lorem ipsum dolor sit amet, \r\nconsectetur adipiscing elit. Fusce bibendum leo vitae dapibus pulvinar. \r\nMauris sagittis eros eget nunc ornare lacinia. Phasellus semper blandit \r\nerat. Nam venenatis metus nec efficitur vehicula. ', 'w_1625566937.jpg', '2021-01-19 00:26:09', '2021-07-06 15:52:19', 1, 1, NULL, NULL),
(7, 'How to start oil painting: 6 Top Tips for Beginners', '<b><font color=\"#FFD663\">Lorem ipsum dolor sit amet, consecte</font></b>tur\r\n adipiscing elit. Integer dapibus ante risus, sed iaculis ante varius \r\nvitae. Ut eu ante cursus, ultrices nisl mattis, aliquam tellus. Nunc \r\neget eleifend dui, vel gravida lectus. Nullam consequat nibh urna, et \r\nscelerisque tortor scelerisque vitae. Praesent massa metus, luctus ac \r\negestas vehicula, ornare in mi. Nam eget iaculis libero. Phasellus \r\nscelerisque eleifend erat, a consectetur nisl feugiat sed. Morbi et ante\r\n odio. Maecenas rhoncus nisl vel efficitur molestie. Donec rhoncus porta\r\n ligula sed vulputate. Donec aliquet dolor lacus, dignissim tristique \r\nlacus suscipit eget.<br><br>Nunc a purus vitae leo venenatis fermentum \r\nin hendrerit nibh. Nullam id bibendum quam. Nam suscipit pharetra felis \r\nnec mattis. Etiam sit amet sollicitudin ex, a fermentum libero. Maecenas\r\n pretium, libero quis dictum consectetur, dui purus maximus nibh, non \r\ntristique mauris justo id nulla. Nunc congue ut arcu eget convallis. \r\nEtiam nec diam eu quam sodales imperdiet. Curabitur posuere cursus \r\nullamcorper. Aliquam erat volutpat. Nam hendrerit sollicitudin vehicula.\r\n Nunc egestas, urna quis dictum volutpat, mi sem iaculis ex, vel \r\npellentesque enim purus a mi. Aliquam vulputate, mauris et maximus \r\ndictum, massa lectus gravida arcu, vel viverra justo lorem eu ligula. \r\nVivamus egestas lectus eget enim dictum, ut vestibulum nulla ultrices. \r\nPellentesque nec nisl finibus lacus faucibus convallis. In sodales \r\nultrices leo, nec luctus magna luctus et.<br><br>Vivamus at euismod \r\nenim, non fermentum elit. Quisque hendrerit nunc purus, at faucibus \r\nmauris tempus sit amet. Praesent vitae dapibus augue, sed gravida \r\nligula. Suspendisse dictum at est quis ornare. Donec hendrerit nulla \r\nneque, id lacinia ipsum ullamcorper sed. Vivamus ultricies felis id \r\npretium ultrices. Sed elementum eu metus nec blandit. Nulla augue nulla,\r\n dapibus sed erat a, luctus accumsan arcu. Praesent ultricies neque eget\r\n risus interdum, eget semper tortor varius. Maecenas volutpat nibh at \r\neros convallis, in tincidunt ante ornare. Etiam id est sit amet nunc \r\nvehicula hendrerit.<br><br>Integer odio lacus, ultricies et nisl nec, \r\nvolutpat pellentesque nibh. Nam tincidunt egestas mauris, in tempus sem \r\nvehicula sit amet. Proin vehicula, elit non hendrerit commodo, nulla \r\nlorem pharetra ante, sit amet volutpat elit sapien non dolor. Orci \r\nvarius natoque penatibus et magnis dis parturient montes, nascetur \r\nridiculus mus. Sed sapien tortor, vestibulum eu suscipit eget, malesuada\r\n sit amet lorem. Suspendisse potenti. Mauris in pretium libero, eu \r\nhendrerit purus. Maecenas sit amet ante diam. Sed ut metus id ligula \r\nimperdiet dictum non quis nunc.<br><br>Aenean laoreet quam in ex \r\nfaucibus eleifend. Proin pulvinar orci in massa consequat varius. Nulla \r\nlacus dui, consectetur quis lacus sed, tincidunt pellentesque ex. Nullam\r\n tempus sodales lorem in fringilla. Lorem ipsum dolor sit amet, \r\nconsectetur adipiscing elit. Fusce bibendum leo vitae dapibus pulvinar. \r\nMauris sagittis eros eget nunc ornare lacinia. Phasellus semper blandit \r\nerat. Nam venenatis metus nec efficitur vehicula. ', 'w_1625566920.jpg', '2021-01-19 00:27:40', '2021-07-06 15:52:02', 1, 1, NULL, NULL),
(8, '5 Essential Tips for Collecting Pop Art', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dapibus\r\n ante risus, sed iaculis ante varius vitae. Ut eu ante cursus, ultrices \r\nnisl mattis, aliquam tellus. Nunc eget eleifend dui, vel gravida lectus.\r\n Nullam consequat nibh urna, et scelerisque tortor scelerisque vitae. \r\nPraesent massa metus, luctus ac egestas vehicula, ornare in mi. Nam eget\r\n iaculis libero. Phasellus scelerisque eleifend erat, a consectetur nisl\r\n feugiat sed. Morbi et ante odio. Maecenas rhoncus nisl vel efficitur \r\nmolestie. Donec rhoncus porta ligula sed vulputate. Donec aliquet dolor \r\nlacus, dignissim tristique lacus suscipit eget.\r\n\r\nNunc a purus vitae leo venenatis fermentum in hendrerit nibh. Nullam id \r\nbibendum quam. Nam suscipit pharetra felis nec mattis. Etiam sit amet \r\nsollicitudin ex, a fermentum libero. Maecenas pretium, libero quis \r\ndictum consectetur, dui purus maximus nibh, non tristique mauris justo \r\nid nulla. Nunc congue ut arcu eget convallis. Etiam nec diam eu quam \r\nsodales imperdiet. Curabitur posuere cursus ullamcorper. Aliquam erat \r\nvolutpat. Nam hendrerit sollicitudin vehicula. Nunc egestas, urna quis \r\ndictum volutpat, mi sem iaculis ex, vel pellentesque enim purus a mi. \r\nAliquam vulputate, mauris et maximus dictum, massa lectus gravida arcu, \r\nvel viverra justo lorem eu ligula. Vivamus egestas lectus eget enim \r\ndictum, ut vestibulum nulla ultrices. Pellentesque nec nisl finibus \r\nlacus faucibus convallis. In sodales ultrices leo, nec luctus magna \r\nluctus et.\r\n\r\nVivamus at euismod enim, non fermentum elit. Quisque hendrerit nunc \r\npurus, at faucibus mauris tempus sit amet. Praesent vitae dapibus augue,\r\n sed gravida ligula. Suspendisse dictum at est quis ornare. Donec \r\nhendrerit nulla neque, id lacinia ipsum ullamcorper sed. Vivamus \r\nultricies felis id pretium ultrices. Sed elementum eu metus nec blandit.\r\n Nulla augue nulla, dapibus sed erat a, luctus accumsan arcu. Praesent \r\nultricies neque eget risus interdum, eget semper tortor varius. Maecenas\r\n volutpat nibh at eros convallis, in tincidunt ante ornare. Etiam id est\r\n sit amet nunc vehicula hendrerit.\r\nInteger odio lacus, ultricies et nisl nec, volutpat pellentesque nibh. \r\nNam tincidunt egestas mauris, in tempus sem vehicula sit amet. Proin \r\nvehicula, elit non hendrerit commodo, nulla lorem pharetra ante, sit \r\namet volutpat elit sapien non dolor. Orci varius natoque penatibus et \r\nmagnis dis parturient montes, nascetur ridiculus mus. Sed sapien tortor,\r\n vestibulum eu suscipit eget, malesuada sit amet lorem. Suspendisse \r\npotenti. Mauris in pretium libero, eu hendrerit purus. Maecenas sit amet\r\n ante diam. Sed ut metus id ligula imperdiet dictum non quis nunc.\r\n\r\nAenean laoreet quam in ex faucibus eleifend. Proin pulvinar orci in \r\nmassa consequat varius. Nulla lacus dui, consectetur quis lacus sed, \r\ntincidunt pellentesque ex. Nullam tempus sodales lorem in fringilla. \r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce bibendum \r\nleo vitae dapibus pulvinar. Mauris sagittis eros eget nunc ornare \r\nlacinia. Phasellus semper blandit erat. Nam venenatis metus nec \r\nefficitur vehicula</p>', 'w_1625566894.jpg', '2021-02-03 15:13:56', '2021-07-06 15:51:38', 1, 1, NULL, NULL),
(11, 'Lorem ipsum dolor sit amet,  sed do eiusmo ', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do \r\neiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad \r\nminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip \r\nex ea commodoconsequat. Duis aute irure dolor in reprehenderit in \r\nvoluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur \r\nsint occaecat cupidatat non proident, sunt in culpa qui officia deserunt\r\n mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum \r\ndolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor \r\nincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \r\ncommodoconsequat. Duis aute irure dolor in reprehenderit in voluptate \r\nvelit essecillum dolore eu fugiat nulla pariatur. Excepteur sint \r\noccaecat cupidatat non proident, sunt in culpa qui officia deserunt \r\nmollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum \r\ndolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor \r\nincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \r\ncommodoconsequat. Duis aute irure dolor in reprehenderit in voluptate \r\nvelit essecillum dolore eu fugiat nulla pariatur. Excepteur sint \r\noccaecat cupidatat non proident, sunt in culpa qui officia deserunt \r\nmollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br></p>', 'w_1625518941.jpg', '2021-06-16 15:26:52', '2021-07-06 02:33:39', 1, 1, NULL, NULL),
(12, 'Lorem ipsum dolor sit amet, sed do eiusmo  2', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do \r\neiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad \r\nminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip \r\nex ea commodoconsequat. Duis aute irure dolor in reprehenderit in \r\nvoluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur \r\nsint occaecat cupidatat non proident, sunt in culpa qui officia deserunt\r\n mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum \r\ndolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor \r\nincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \r\ncommodoconsequat. Duis aute irure dolor in reprehenderit in voluptate \r\nvelit essecillum dolore eu fugiat nulla pariatur. Excepteur sint \r\noccaecat cupidatat non proident, sunt in culpa qui officia deserunt \r\nmollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br></p>', 'w_1625567264.jpg', '2021-07-06 15:57:50', NULL, 1, 1, NULL, NULL),
(13, 'Lorem ipsum dolor sit amet, sed do eiusmo  3', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do \r\neiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad \r\nminim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip \r\nex ea commodoconsequat. Duis aute irure dolor in reprehenderit in \r\nvoluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur \r\nsint occaecat cupidatat non proident, sunt in culpa qui officia deserunt\r\n mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum \r\ndolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor \r\nincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \r\ncommodoconsequat. Duis aute irure dolor in reprehenderit in voluptate \r\nvelit essecillum dolore eu fugiat nulla pariatur. Excepteur sint \r\noccaecat cupidatat non proident, sunt in culpa qui officia deserunt \r\nmollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br>Lorem ipsum \r\ndolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor \r\nincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, \r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea \r\ncommodoconsequat. Duis aute irure dolor in reprehenderit in voluptate \r\nvelit essecillum dolore eu fugiat nulla pariatur. Excepteur sint \r\noccaecat cupidatat non proident, sunt in culpa qui officia deserunt \r\nmollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur \r\nadipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore \r\nmagna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco\r\n laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor \r\nin reprehenderit in voluptate velit essecillum dolore eu fugiat nulla \r\npariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa \r\nqui officia deserunt mollit anim id est laborum.<br><br><br><br><br><br></p>', 'w_1625567731.jpg', '2021-07-06 16:05:35', NULL, 1, 1, NULL, NULL),
(14, 'Vivamus at euismod enim, non fermentum elit. Quisque hendrerit nunc purus', '<p><b><font color=\"#FFD663\">Lorem ipsum dolor sit amet, consecte</font></b>tur\r\n adipiscing elit. Integer dapibus ante risus, sed iaculis ante varius \r\nvitae. Ut eu ante cursus, ultrices nisl mattis, aliquam tellus. Nunc \r\neget eleifend dui, vel gravida lectus. Nullam consequat nibh urna, et \r\nscelerisque tortor scelerisque vitae. Praesent massa metus, luctus ac \r\negestas vehicula, ornare in mi. Nam eget iaculis libero. Phasellus \r\nscelerisque eleifend erat, a consectetur nisl feugiat sed. Morbi et ante\r\n odio. Maecenas rhoncus nisl vel efficitur molestie. Donec rhoncus porta\r\n ligula sed vulputate. Donec aliquet dolor lacus, dignissim tristique \r\nlacus suscipit eget.<br><br>Nunc a purus vitae leo venenatis fermentum \r\nin hendrerit nibh. Nullam id bibendum quam. Nam suscipit pharetra felis \r\nnec mattis. Etiam sit amet sollicitudin ex, a fermentum libero. Maecenas\r\n pretium, libero quis dictum consectetur, dui purus maximus nibh, non \r\ntristique mauris justo id nulla. Nunc congue ut arcu eget convallis. \r\nEtiam nec diam eu quam sodales imperdiet. Curabitur posuere cursus \r\nullamcorper. Aliquam erat volutpat. Nam hendrerit sollicitudin vehicula.\r\n Nunc egestas, urna quis dictum volutpat, mi sem iaculis ex, vel \r\npellentesque enim purus a mi. Aliquam vulputate, mauris et maximus \r\ndictum, massa lectus gravida arcu, vel viverra justo lorem eu ligula. \r\nVivamus egestas lectus eget enim dictum, ut vestibulum nulla ultrices. \r\nPellentesque nec nisl finibus lacus faucibus convallis. In sodales \r\nultrices leo, nec luctus magna luctus et.<br><br>Vivamus at euismod \r\nenim, non fermentum elit. Quisque hendrerit nunc purus, at faucibus \r\nmauris tempus sit amet. Praesent vitae dapibus augue, sed gravida \r\nligula. Suspendisse dictum at est quis ornare. Donec hendrerit nulla \r\nneque, id lacinia ipsum ullamcorper sed. Vivamus ultricies felis id \r\npretium ultrices. Sed elementum eu metus nec blandit. Nulla augue nulla,\r\n dapibus sed erat a, luctus accumsan arcu. Praesent ultricies neque eget\r\n risus interdum, eget semper tortor varius. Maecenas volutpat nibh at \r\neros convallis, in tincidunt ante ornare. Etiam id est sit amet nunc \r\nvehicula hendrerit.<br><br>Integer odio lacus, ultricies et nisl nec, \r\nvolutpat pellentesque nibh. Nam tincidunt egestas mauris, in tempus sem \r\nvehicula sit amet. Proin vehicula, elit non hendrerit commodo, nulla \r\nlorem pharetra ante, sit amet volutpat elit sapien non dolor. Orci \r\nvarius natoque penatibus et magnis dis parturient montes, nascetur \r\nridiculus mus. Sed sapien tortor, vestibulum eu suscipit eget, malesuada\r\n sit amet lorem. Suspendisse potenti. Mauris in pretium libero, eu \r\nhendrerit purus. Maecenas sit amet ante diam. Sed ut metus id ligula \r\nimperdiet dictum non quis nunc.<br><br>Aenean laoreet quam in ex \r\nfaucibus eleifend. Proin pulvinar orci in massa consequat varius. Nulla \r\nlacus dui, consectetur quis lacus sed, tincidunt pellentesque ex. Nullam\r\n tempus sodales lorem in fringilla. Lorem ipsum dolor sit amet, \r\nconsectetur adipiscing elit. Fusce bibendum leo vitae dapibus pulvinar. \r\nMauris sagittis eros eget nunc ornare lacinia. Phasellus semper blandit \r\nerat. Nam venenatis metus nec efficitur vehicula.  \r\n                                </p>', 'w_1625570220.jpg', '2021-07-06 16:47:04', NULL, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `artist_id` int(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `artist_id`, `product_id`, `quantity`, `created`, `updated`) VALUES
(18, 28, 2, 10, 1, '2021-06-05 23:09:40', '2021-06-05 23:09:40'),
(19, 28, 2, 12, 1, '2021-06-05 23:09:42', '2021-06-05 23:09:42'),
(20, 28, 4, 6, 1, '2021-06-05 23:10:09', '2021-06-05 23:10:09'),
(63, 3, 10, 22, 1, '2021-06-16 20:58:26', '2021-06-16 20:58:26'),
(64, 3, 6, 19, 1, '2021-06-16 20:58:27', '2021-06-16 20:58:27'),
(65, 4, 10, 21, 1, '2021-06-20 02:11:36', '2021-07-17 19:06:01'),
(66, 4, 4, 17, 1, '2021-06-20 02:11:37', '2021-07-17 19:06:00'),
(67, 4, 6, 19, 1, '2021-06-20 02:11:38', '2021-06-20 02:11:38'),
(68, 4, 6, 14, 1, '2021-06-20 02:11:40', '2021-06-20 02:11:40'),
(91, 4, 33, 23, 1, '2021-06-29 20:52:34', '2021-06-29 20:52:34'),
(92, 4, 10, 22, 1, '2021-06-29 20:52:37', '2021-06-29 20:52:37'),
(97, 43, 4, 5, 1, '2021-07-02 04:39:50', '2021-07-02 04:39:50'),
(98, 43, 4, 7, 1, '2021-07-02 04:39:51', '2021-07-02 04:39:51'),
(99, 43, 6, 15, 1, '2021-07-02 04:39:54', '2021-07-02 04:39:54'),
(121, 5, 4, 4, 1, '2021-07-15 13:05:10', '2021-07-15 13:05:10'),
(125, 1, 46, 29, 2, '2021-07-20 12:19:09', '2021-07-20 12:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(255) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `type`, `status`) VALUES
(1, 'Painting\r\n', 1),
(2, 'Sculptors ', 1),
(3, 'Drawing', 1),
(4, 'Digital Print', 1),
(5, 'Photography', 1),
(6, 'Ceramics', 0),
(7, 'Collages', 1);

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `id` int(255) NOT NULL,
  `percentage` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `commission`
--

INSERT INTO `commission` (`id`, `percentage`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(3) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `status`) VALUES
(1, 'AF', 'Afghanistan', 1),
(2, 'AL', 'Albania', 1),
(3, 'DZ', 'Algeria', 1),
(4, 'DS', 'American Samoa', 1),
(5, 'AD', 'Andorra', 1),
(6, 'AO', 'Angola', 1),
(7, 'AI', 'Anguilla', 1),
(8, 'AQ', 'Antarctica', 1),
(9, 'AG', 'Antigua and Barbuda', 1),
(10, 'AR', 'Argentina', 1),
(11, 'AM', 'Armenia', 1),
(12, 'AW', 'Aruba', 1),
(13, 'AU', 'Australia', 1),
(14, 'AT', 'Austria', 1),
(15, 'AZ', 'Azerbaijan', 1),
(16, 'BS', 'Bahamas', 1),
(17, 'BH', 'Bahrain', 1),
(18, 'BD', 'Bangladesh', 1),
(19, 'BB', 'Barbados', 1),
(20, 'BY', 'Belarus', 1),
(21, 'BE', 'Belgium', 1),
(22, 'BZ', 'Belize', 1),
(23, 'BJ', 'Benin', 1),
(24, 'BM', 'Bermuda', 1),
(25, 'BT', 'Bhutan', 1),
(26, 'BO', 'Bolivia', 1),
(27, 'BA', 'Bosnia and Herzegovina', 1),
(28, 'BW', 'Botswana', 1),
(29, 'BV', 'Bouvet Island', 1),
(30, 'BR', 'Brazil', 1),
(31, 'IO', 'British Indian Ocean Territory', 1),
(32, 'BN', 'Brunei Darussalam', 1),
(33, 'BG', 'Bulgaria', 1),
(34, 'BF', 'Burkina Faso', 1),
(35, 'BI', 'Burundi', 1),
(36, 'KH', 'Cambodia', 1),
(37, 'CM', 'Cameroon', 1),
(38, 'CA', 'Canada', 1),
(39, 'CV', 'Cape Verde', 1),
(40, 'KY', 'Cayman Islands', 1),
(41, 'CF', 'Central African Republic', 1),
(42, 'TD', 'Chad', 1),
(43, 'CL', 'Chile', 1),
(44, 'CN', 'China', 1),
(45, 'CX', 'Christmas Island', 1),
(46, 'CC', 'Cocos (Keeling) Islands', 1),
(47, 'CO', 'Colombia', 1),
(48, 'KM', 'Comoros', 1),
(49, 'CG', 'Congo', 1),
(50, 'CK', 'Cook Islands', 1),
(51, 'CR', 'Costa Rica', 1),
(52, 'HR', 'Croatia (Hrvatska)', 1),
(53, 'CU', 'Cuba', 1),
(54, 'CY', 'Cyprus', 1),
(55, 'CZ', 'Czech Republic', 1),
(56, 'DK', 'Denmark', 1),
(57, 'DJ', 'Djibouti', 1),
(58, 'DM', 'Dominica', 1),
(59, 'DO', 'Dominican Republic', 1),
(60, 'TP', 'East Timor', 1),
(61, 'EC', 'Ecuador', 1),
(62, 'EG', 'Egypt', 1),
(63, 'SV', 'El Salvador', 1),
(64, 'GQ', 'Equatorial Guinea', 1),
(65, 'ER', 'Eritrea', 1),
(66, 'EE', 'Estonia', 1),
(67, 'ET', 'Ethiopia', 1),
(68, 'FK', 'Falkland Islands (Malvinas)', 1),
(69, 'FO', 'Faroe Islands', 1),
(70, 'FJ', 'Fiji', 1),
(71, 'FI', 'Finland', 1),
(72, 'FR', 'France', 1),
(73, 'FX', 'France, Metropolitan', 1),
(74, 'GF', 'French Guiana', 1),
(75, 'PF', 'French Polynesia', 1),
(76, 'TF', 'French Southern Territories', 1),
(77, 'GA', 'Gabon', 1),
(78, 'GM', 'Gambia', 1),
(79, 'GE', 'Georgia', 1),
(80, 'DE', 'Germany', 1),
(81, 'GH', 'Ghana', 1),
(82, 'GI', 'Gibraltar', 1),
(83, 'GK', 'Guernsey', 1),
(84, 'GR', 'Greece', 1),
(85, 'GL', 'Greenland', 1),
(86, 'GD', 'Grenada', 1),
(87, 'GP', 'Guadeloupe', 1),
(88, 'GU', 'Guam', 1),
(89, 'GT', 'Guatemala', 1),
(90, 'GN', 'Guinea', 1),
(91, 'GW', 'Guinea-Bissau', 1),
(92, 'GY', 'Guyana', 1),
(93, 'HT', 'Haiti', 1),
(94, 'HM', 'Heard and Mc Donald Islands', 1),
(95, 'HN', 'Honduras', 1),
(96, 'HK', 'Hong Kong', 1),
(97, 'HU', 'Hungary', 1),
(98, 'IS', 'Iceland', 1),
(99, 'IN', 'India', 1),
(100, 'IM', 'Isle of Man', 1),
(101, 'ID', 'Indonesia', 1),
(102, 'IR', 'Iran (Islamic Republic of)', 1),
(103, 'IQ', 'Iraq', 1),
(104, 'IE', 'Ireland', 1),
(105, 'IL', 'Israel', 1),
(106, 'IT', 'Italy', 1),
(107, 'CI', 'Ivory Coast', 1),
(108, 'JE', 'Jersey', 1),
(109, 'JM', 'Jamaica', 1),
(110, 'JP', 'Japan', 1),
(111, 'JO', 'Jordan', 1),
(112, 'KZ', 'Kazakhstan', 1),
(113, 'KE', 'Kenya', 1),
(114, 'KI', 'Kiribati', 1),
(115, 'KP', 'Korea, Democratic People\'s Republic of', 1),
(116, 'KR', 'Korea, Republic of', 1),
(117, 'XK', 'Kosovo', 1),
(118, 'KW', 'Kuwait', 1),
(119, 'KG', 'Kyrgyzstan', 1),
(120, 'LA', 'Lao People\'s Democratic Republic', 1),
(121, 'LV', 'Latvia', 1),
(122, 'LB', 'Lebanon', 1),
(123, 'LS', 'Lesotho', 1),
(124, 'LR', 'Liberia', 1),
(125, 'LY', 'Libyan Arab Jamahiriya', 1),
(126, 'LI', 'Liechtenstein', 1),
(127, 'LT', 'Lithuania', 1),
(128, 'LU', 'Luxembourg', 1),
(129, 'MO', 'Macau', 1),
(130, 'MK', 'Macedonia', 1),
(131, 'MG', 'Madagascar', 1),
(132, 'MW', 'Malawi', 1),
(133, 'MY', 'Malaysia', 1),
(134, 'MV', 'Maldives', 1),
(135, 'ML', 'Mali', 1),
(136, 'MT', 'Malta', 1),
(137, 'MH', 'Marshall Islands', 1),
(138, 'MQ', 'Martinique', 1),
(139, 'MR', 'Mauritania', 1),
(140, 'MU', 'Mauritius', 1),
(141, 'TY', 'Mayotte', 1),
(142, 'MX', 'Mexico', 1),
(143, 'FM', 'Micronesia, Federated States of', 1),
(144, 'MD', 'Moldova, Republic of', 1),
(145, 'MC', 'Monaco', 1),
(146, 'MN', 'Mongolia', 1),
(147, 'ME', 'Montenegro', 1),
(148, 'MS', 'Montserrat', 1),
(149, 'MA', 'Morocco', 1),
(150, 'MZ', 'Mozambique', 1),
(151, 'MM', 'Myanmar', 1),
(152, 'NA', 'Namibia', 1),
(153, 'NR', 'Nauru', 1),
(154, 'NP', 'Nepal', 1),
(155, 'NL', 'Netherlands', 1),
(156, 'AN', 'Netherlands Antilles', 1),
(157, 'NC', 'New Caledonia', 1),
(158, 'NZ', 'New Zealand', 1),
(159, 'NI', 'Nicaragua', 1),
(160, 'NE', 'Niger', 1),
(161, 'NG', 'Nigeria', 1),
(162, 'NU', 'Niue', 1),
(163, 'NF', 'Norfolk Island', 1),
(164, 'MP', 'Northern Mariana Islands', 1),
(165, 'NO', 'Norway', 1),
(166, 'OM', 'Oman', 1),
(167, 'PK', 'Pakistan', 1),
(168, 'PW', 'Palau', 1),
(169, 'PS', 'Palestine', 1),
(170, 'PA', 'Panama', 1),
(171, 'PG', 'Papua New Guinea', 1),
(172, 'PY', 'Paraguay', 1),
(173, 'PE', 'Peru', 1),
(174, 'PH', 'Philippines', 1),
(175, 'PN', 'Pitcairn', 1),
(176, 'PL', 'Poland', 1),
(177, 'PT', 'Portugal', 1),
(178, 'PR', 'Puerto Rico', 1),
(179, 'QA', 'Qatar', 1),
(180, 'RE', 'Reunion', 1),
(181, 'RO', 'Romania', 1),
(182, 'RU', 'Russian Federation', 1),
(183, 'RW', 'Rwanda', 1),
(184, 'KN', 'Saint Kitts and Nevis', 1),
(185, 'LC', 'Saint Lucia', 1),
(186, 'VC', 'Saint Vincent and the Grenadines', 1),
(187, 'WS', 'Samoa', 1),
(188, 'SM', 'San Marino', 1),
(189, 'ST', 'Sao Tome and Principe', 1),
(190, 'SA', 'Saudi Arabia', 1),
(191, 'SN', 'Senegal', 1),
(192, 'RS', 'Serbia', 1),
(193, 'SC', 'Seychelles', 1),
(194, 'SL', 'Sierra Leone', 1),
(195, 'SG', 'Singapore', 1),
(196, 'SK', 'Slovakia', 1),
(197, 'SI', 'Slovenia', 1),
(198, 'SB', 'Solomon Islands', 1),
(199, 'SO', 'Somalia', 1),
(200, 'ZA', 'South Africa', 1),
(201, 'GS', 'South Georgia South Sandwich Islands', 1),
(202, 'SS', 'South Sudan', 1),
(203, 'ES', 'Spain', 1),
(204, 'LK', 'Sri Lanka', 1),
(205, 'SH', 'St. Helena', 1),
(206, 'PM', 'St. Pierre and Miquelon', 1),
(207, 'SD', 'Sudan', 1),
(208, 'SR', 'Suriname', 1),
(209, 'SJ', 'Svalbard and Jan Mayen Islands', 1),
(210, 'SZ', 'Swaziland', 1),
(211, 'SE', 'Sweden', 1),
(212, 'CH', 'Switzerland', 1),
(213, 'SY', 'Syrian Arab Republic', 1),
(214, 'TW', 'Taiwan', 1),
(215, 'TJ', 'Tajikistan', 1),
(216, 'TZ', 'Tanzania, United Republic of', 1),
(217, 'TH', 'Thailand', 1),
(218, 'TG', 'Togo', 1),
(219, 'TK', 'Tokelau', 1),
(220, 'TO', 'Tonga', 1),
(221, 'TT', 'Trinidad and Tobago', 1),
(222, 'TN', 'Tunisia', 1),
(223, 'TR', 'Turkey', 1),
(224, 'TM', 'Turkmenistan', 1),
(225, 'TC', 'Turks and Caicos Islands', 1),
(226, 'TV', 'Tuvalu', 1),
(227, 'UG', 'Uganda', 1),
(228, 'UA', 'Ukraine', 1),
(229, 'AE', 'United Arab Emirates', 1),
(230, 'GB', 'United Kingdom', 1),
(231, 'US', 'United States', 1),
(232, 'UM', 'United States minor outlying islands', 1),
(233, 'UY', 'Uruguay', 1),
(234, 'UZ', 'Uzbekistan', 1),
(235, 'VU', 'Vanuatu', 1),
(236, 'VA', 'Vatican City State', 1),
(237, 'VE', 'Venezuela', 1),
(238, 'VN', 'Vietnam', 1),
(239, 'VG', 'Virgin Islands (British)', 1),
(240, 'VI', 'Virgin Islands (U.S.)', 1),
(241, 'WF', 'Wallis and Futuna Islands', 1),
(242, 'EH', 'Western Sahara', 1),
(243, 'YE', 'Yemen', 1),
(244, 'ZR', 'Zaire', 1),
(245, 'ZM', 'Zambia', 1),
(246, 'ZW', 'Zimbabwe', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dimensions`
--

CREATE TABLE `dimensions` (
  `id` int(255) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dimensions`
--

INSERT INTO `dimensions` (`id`, `type`, `status`) VALUES
(0, 'Custom', 1),
(1, 'A3 - 3508 x 4960 pixels', 1),
(2, 'A4 - 2480 x 3508 pixels', 1),
(4, 'A5 - 1748 x 2480 pixels', 1),
(5, '11\'\' x 14\'\' paper: 3300x4200 pixels', 1),
(6, '18\'\' x 24\'\' paper: 5400x7200 pixels ', 1),
(7, '24\" x 36\" poster: 7200x10800 pixels', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dimension_custom_label`
--

CREATE TABLE `dimension_custom_label` (
  `id` int(2) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dimension_custom_label`
--

INSERT INTO `dimension_custom_label` (`id`, `type`, `status`) VALUES
(1, 'mm', 1),
(2, 'cm', NULL),
(3, 'Inches', 1),
(4, 'Pixels', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(255) NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`id`, `first_name`, `last_name`, `title`, `description`, `email`, `phone`, `status`, `created`) VALUES
(1, 'Dilusha', 'Darshani', 'this is a title', 'this is a description this is a description', 'gsdilusha18@gmail.com', '07123456', 1, '2021-07-16 02:25:35'),
(2, 'Kasun', 'Perera', 'this is title 2', 'this is a description', 'gds@gamil.com', '077834663', 1, '2021-07-16 02:28:36'),
(3, 'Thanuja', 'Darshani', 'Title for inquiry', 'Descripiton for inquiry', 'Thanuja@gmail.com', '07123456', 1, '2021-07-16 02:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `mediums`
--

CREATE TABLE `mediums` (
  `id` int(255) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mediums`
--

INSERT INTO `mediums` (`id`, `type`, `status`) VALUES
(1, 'Oil Paint', 1),
(2, 'Acrylic', 1),
(3, 'Mixed Media', 1),
(4, 'Ink', 1),
(5, 'Pencil', 1),
(6, 'Metals', 1),
(7, 'Stone', 1),
(8, 'Mosaic', 0),
(9, 'Watercolor', 1),
(10, 'Others', 1),
(11, 'Light Painting', 1),
(12, 'Analog photography', 1),
(13, 'Digital Photography', 1),
(14, 'Charcoal', 1),
(15, 'Pastel', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `artist_id` int(255) DEFAULT NULL,
  `post_method` tinyint(1) DEFAULT NULL,
  `bid_id` int(255) DEFAULT NULL,
  `payment_method` tinyint(1) DEFAULT NULL,
  `commission` tinyint(2) DEFAULT NULL,
  `b_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_address_1` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_address_2` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(3) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `artist_id`, `post_method`, `bid_id`, `payment_method`, `commission`, `b_first_name`, `b_last_name`, `b_email`, `b_phone`, `b_address_1`, `b_address_2`, `town`, `state`, `postcode`, `country_id`, `status`, `note`, `created`) VALUES
(1, 3, 4, 1, NULL, 1, 10, 'Dilu', 'Seneviratne', 'gdsenev@gmail.com', '0712345678', 'Negombo', 'Negombo2', NULL, 'Western', NULL, 204, 6, NULL, '2020-12-04 20:00:31'),
(2, 5, 2, NULL, NULL, 1, 10, 'User', 'Name', 'user@gmail.com', '077123456', 'usertown', 'usertown2', NULL, 'Western', NULL, 204, 8, NULL, '2020-12-12 18:49:38'),
(3, 5, 4, NULL, NULL, 1, 10, 'User', 'Name', 'gdsenev@gmail.com', '077123456', 'usertown', 'usertown2', NULL, 'Western', NULL, 204, 12, 'Artist has been canceled te order product', '2020-12-12 18:49:38'),
(4, 5, 4, NULL, NULL, 1, 10, 'User', 'Name', 'user@gmail.com', '0771234567', 'usertown', 'usertown', NULL, 'Western', NULL, 204, 3, NULL, '2020-12-12 21:00:18'),
(5, 5, 4, NULL, NULL, 1, 10, 'Helen M ', 'Knight', 'user@gmail.com', '0771234567', 'No  887 ', 'Cameron Road', 'ARGYLE', 'Minnesota', ' 	56713', 231, 4, NULL, '2020-12-13 00:35:58'),
(6, 1, 4, NULL, NULL, 1, 10, 'Gayanthi', 'Dilusha', 'test@admin.com', '0712345678', 'Line 001', 'Line 002', NULL, 'Western', NULL, 204, 11, NULL, '2021-01-07 12:47:11'),
(7, 1, 2, NULL, NULL, 1, 10, 'Gayanthi', 'Dilusha', 'test@admin.com', '0712345678', 'Line 001', 'Line 002', NULL, 'Western', NULL, 204, 2, NULL, '2021-01-07 12:47:11'),
(8, 3, 4, NULL, NULL, 1, 10, 'Dilusha', 'Senevirathne', 'gdsenev@gmail.com', '071234567', 'address 1', 'address 2', 'Gampaha', 'Western', '129', 209, 6, NULL, '2021-01-08 19:16:17'),
(9, 3, 2, NULL, NULL, 1, 10, 'Dilusha', 'Senevirathne', 'gdsenev@gmail.com', '071234567', 'address 1', 'address 2', NULL, 'Western', NULL, 204, 1, NULL, '2021-01-08 19:16:17'),
(10, 3, 6, NULL, NULL, 1, 10, 'Dilusha', 'Senevirathne', 'gdsenev@gmail.com', '071234567', 'address 1', 'address 2', NULL, 'Western', NULL, 204, 6, NULL, '2021-01-08 19:16:17'),
(11, 2, 4, NULL, NULL, 1, 10, 'Kavindi', 'Perera', 'kavi@artist.com', '', '', '', NULL, 'Western', NULL, 204, 2, NULL, '2021-06-09 02:25:10'),
(12, 2, 2, NULL, NULL, 1, 10, 'Kavindi', 'Perera', 'kavi@artist.com', '', '', '', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-09 02:25:10'),
(13, 7, 4, NULL, NULL, 1, 10, 'Nimal', 'Perera', 'nimal@user.com', '071123123', 'Negombo Rd', 'Katunayake', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-10 19:07:47'),
(14, 7, 2, NULL, NULL, 1, 10, 'Nimal', 'Perera', 'nimal@user.com', '071123123', 'Negombo Rd', 'Katunayake', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-10 19:07:47'),
(15, 7, 10, NULL, NULL, 1, 10, 'Nimal', 'Perera', 'nimal@user.com', '071512312', 'Negombo rd', 'Greens', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-10 19:38:46'),
(16, 7, 4, NULL, NULL, 1, 10, 'Nimal', 'Perera', 'nimal@user.com', '071512312', 'Negombo rd', 'Greens', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-10 19:38:46'),
(17, 7, 2, NULL, NULL, 1, 10, 'Nimal', 'Perera', 'nimal@user.com', '071512312', 'Negombo rd', 'Greens', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-10 19:38:46'),
(18, 27, 4, NULL, NULL, 1, 10, 'Gayanthi', 'Senevirathne', 'gdsenev@gmail.com', '07123456', 'Negombo Rd', '', NULL, 'Western', NULL, 204, 1, NULL, '2021-06-11 20:52:12'),
(20, 1, 10, NULL, NULL, 1, 10, 'Gayanthi', 'Dilusha', 'e151041105@bit.uom.lk', '0712345678', 'Line 001', 'Line 002', 'Negombo', 'Western', '12345', 204, 12, '', '2021-06-12 22:03:36'),
(21, 1, 33, 1, NULL, 1, 10, 'Gayanthi updated', 'Dilusha ', 'e151041105@bit.uom.lk', '074564685', 'Line 001', 'Line 002', 'Negombo', 'Western', '12345', 204, 1, 'this is a note for checkouts', '2021-06-26 02:47:00'),
(22, 1, 4, 1, NULL, 0, 10, 'Gayanthi updated', 'Dilusha ', 'e151041105@bit.uom.lk', '074564685', 'Line 001', 'Line 002', 'Negombo', 'Western', '12345', 204, 8, 'this is a note for checkouts', '2021-06-26 02:47:00'),
(23, 1, 35, 1, NULL, 1, 10, 'Gayanthi ', 'Dilusha ', 'e151041105@bit.uom.lk', '074564685', 'No 55 Colombo Rd', 'Negombo', 'Negombo', 'Western', '125', 204, 5, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo', '2021-06-26 09:24:52'),
(24, 1, 10, 1, NULL, 1, 10, 'Gayanthi ', 'Dilusha ', 'e151041105@bit.uom.lk', '074564685', 'No 55 Colombo Rd', 'Negombo', 'Negombo', 'Western', '125', 204, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo', '2021-06-26 09:24:52'),
(25, 5, 6, 1, NULL, 0, 10, 'Test', 'User', 'gdsenev@gmail.com', '011111111', 'No 07', 'New Apartment Rd', 'Gampaha', 'Western', '77', 204, 2, 'This is order note', '2021-07-05 22:10:00'),
(26, 5, 4, 1, NULL, 0, 10, 'Test', 'User', 'gdsenev@gmail.com', '011111111', 'No 07', 'New Apartment Rd', 'Gampaha', 'Western', '77', 204, 11, 'This is order note', '2021-07-05 22:10:00'),
(27, 5, 4, 1, NULL, 0, 10, 'Test', 'User', 'gdsenev@gmail.com', '07777777', 'No 55 Colombo Rd', 'Negombo', 'Negombo ', 'western ', '125', 187, 13, 'this is a note', '2021-07-12 16:32:17'),
(28, 7, 6, 1, NULL, 0, 10, 'Nimal', 'Perera', 'gdsenev@gmail.com', '0711121245', 'no 15 B', 'Katana Rd', 'Katana', 'Western', '77', 201, 1, 'order note', '2021-07-13 01:15:01'),
(29, 7, 4, 1, NULL, 0, 10, 'Nimal', 'Perera', 'gdsenev@gmail.com', '0711121245', 'no 15 B', 'Katana Rd', 'Katana', 'Western', '77', 201, 5, 'order note', '2021-07-13 01:15:01'),
(30, 1, 4, 1, NULL, 1, 10, 'Gayanthi ', 'Dilusha ', 'e151041105@bit.uom.lk', '074564685', 'Line 001', 'Line 002', 'Negombo', 'Western', '12345', 204, 1, 'this is order note', '2021-07-19 22:24:27'),
(31, 47, 46, 1, NULL, 1, 10, 'Sethuli', 'Wijesinha', 'gdsenev@gmail.com', '074564685', 'No 07', 'New Apartment Rd', 'Gampaha', 'Western', '033', 204, 8, '', '2021-07-20 09:43:05'),
(32, 47, 46, 1, NULL, 1, 10, 'Sethuli', 'Wijesingha', 'gdsenev@gmail.com', '07123456', 'No 07', 'New Apartment Rd', 'Kandy', 'Western', '0555', 204, 2, '', '2021-07-20 09:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `order_inquiry`
--

CREATE TABLE `order_inquiry` (
  `id` int(255) NOT NULL,
  `type_id` tinyint(1) DEFAULT NULL,
  `order_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `subject` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_inquiry`
--

INSERT INTO `order_inquiry` (`id`, `type_id`, `order_id`, `user_id`, `subject`, `note`, `status`, `created`) VALUES
(1, 5, 2, 26, '5', 'Item has damaged', 0, '2021-07-10 02:29:14'),
(2, 2, 26, 5, 'Item as not it is on the product description', 'undefined', 1, '2021-07-10 02:32:16'),
(3, 2, 26, 5, 'Item as not it is on the product description', 'undefined', 1, '2021-07-10 02:36:09'),
(4, 2, 26, 5, 'Item as not it is on the product description', 'undefined', 1, '2021-07-10 02:37:18'),
(5, 2, 26, 5, 'Item not received', 'this is a note', 1, '2021-07-10 02:42:02'),
(6, 1, 26, 1, 'undefined', 'RE: Item not received', 1, '2021-07-10 19:46:09'),
(7, 1, 26, 1, 'RE: Item not received', 'This is a response message from admin', 1, '2021-07-10 19:46:48'),
(8, 2, 26, 5, 'Item not received', 'this is a response message this is a response message  this is a response message  this is a response message  this is a response message  this is a response message  this is a response message  this is a response message  this is a response message this is a response message this is a response message ', 1, '2021-07-10 19:47:29'),
(9, 2, 26, 5, 'Item has damaged', 'this is a response message this is a response message  this is a response message  this is a response message  this is a response message  this is a response message  this is a response message  this is a response message  this is a response message this is a response message this is a response message ', 1, '2021-07-10 20:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(255) NOT NULL,
  `order_id` int(255) DEFAULT NULL,
  `product_id` int(255) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status_user_id` int(255) DEFAULT NULL,
  `status_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `unit_price`, `quantity`, `status`, `note`, `created`, `status_user_id`, `status_time`) VALUES
(1, 1, 4, 2000, 5, 0, NULL, '2020-12-04 20:00:31', 4, '2020-12-12 21:00:58'),
(2, 1, 5, 5000, 1, 1, NULL, '2020-12-04 20:00:31', 4, '2020-12-12 21:00:58'),
(3, 1, 1, 1000, 1, 1, NULL, '2020-12-04 20:00:31', 4, '2020-12-12 21:00:58'),
(4, 1, 3, 10000, 1, 0, NULL, '2020-12-04 20:00:31', 4, '2020-12-12 21:00:58'),
(5, 2, 11, 7000, 1, 0, NULL, '2020-12-12 18:49:38', 2, '2020-12-13 00:32:22'),
(6, 2, 10, 5000, 1, 0, NULL, '2020-12-12 18:49:38', 2, '2020-12-13 00:32:22'),
(7, 3, 5, 5000, 2, 1, NULL, '2020-12-12 18:49:38', 4, '2020-12-13 00:04:09'),
(8, 4, 6, 7000, 1, 0, NULL, '2020-12-12 21:00:18', 4, '2020-12-12 21:00:58'),
(9, 4, 16, 80000, 1, 1, NULL, '2020-12-12 21:00:18', 4, '2020-12-12 21:00:58'),
(10, 5, 7, 15000, 1, 1, NULL, '2020-12-13 00:35:58', 4, '2021-07-05 22:15:54'),
(11, 5, 8, 3000, 1, 1, NULL, '2020-12-13 00:35:58', 4, '2021-07-05 22:15:54'),
(12, 6, 5, 5000, 2, 0, NULL, '2021-01-07 12:47:11', 4, NULL),
(13, 6, 3, 10000, 1, 1, NULL, '2021-01-07 12:47:11', NULL, NULL),
(14, 7, 12, 10000, 1, 1, NULL, '2021-01-07 12:47:11', 1, '2021-07-20 02:58:22'),
(15, 8, 16, 80000, 1, 1, NULL, '2021-01-08 19:16:17', 4, '2021-07-08 09:00:18'),
(16, 9, 12, 10000, 2, 1, NULL, '2021-01-08 19:16:17', NULL, NULL),
(17, 10, 15, 5000, 4, 1, NULL, '2021-01-08 19:16:17', 6, '2021-07-14 21:50:02'),
(18, 11, 9, 5000, 1, 1, NULL, '2021-06-09 02:25:10', 4, '2021-06-09 03:27:10'),
(19, 11, 5, 5000, 1, 1, NULL, '2021-06-09 02:25:10', 4, '2021-06-09 03:27:10'),
(20, 12, 10, 5000, 1, 1, NULL, '2021-06-09 02:25:10', NULL, NULL),
(21, 13, 3, 10000, 1, 1, NULL, '2021-06-10 19:07:47', NULL, NULL),
(22, 13, 6, 7000, 1, 1, NULL, '2021-06-10 19:07:47', NULL, NULL),
(23, 13, 5, 5000, 1, 1, NULL, '2021-06-10 19:07:47', NULL, NULL),
(24, 14, 10, 5000, 1, 1, NULL, '2021-06-10 19:07:47', NULL, NULL),
(25, 14, 12, 10000, 1, 1, NULL, '2021-06-10 19:07:47', NULL, NULL),
(26, 15, 22, 600, 2, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(27, 15, 21, 9000, 1, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(28, 15, 20, 5500, 1, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(29, 16, 16, 80000, 1, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(30, 16, 9, 5000, 2, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(31, 16, 7, 15000, 1, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(32, 17, 10, 5000, 2, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(33, 17, 12, 10000, 1, 1, NULL, '2021-06-10 19:38:46', NULL, NULL),
(34, 18, 9, 5000, 1, 1, NULL, '2021-06-11 20:52:12', 4, '2021-07-09 23:55:48'),
(35, 18, 16, 80000, 1, 1, NULL, '2021-06-11 20:52:12', NULL, NULL),
(36, 18, 17, 5424, 1, 1, NULL, '2021-06-11 20:52:12', NULL, NULL),
(42, 21, 23, 10000, 2, 1, NULL, '2021-06-26 02:47:00', NULL, NULL),
(43, 22, 16, 80000, 1, 0, NULL, '2021-06-26 02:47:00', 4, '2021-06-26 03:20:12'),
(44, 22, 6, 7000, 2, 0, NULL, '2021-06-26 02:47:00', 4, '2021-06-26 03:20:12'),
(45, 22, 5, 5000, 1, 0, NULL, '2021-06-26 02:47:00', 4, '2021-06-26 03:20:12'),
(46, 23, 24, 5000, 1, 1, NULL, '2021-06-26 09:24:52', 35, '2021-06-26 09:29:59'),
(47, 24, 22, 600, 2, 1, NULL, '2021-06-26 09:24:52', NULL, NULL),
(48, 25, 14, 5000, 2, 1, NULL, '2021-07-05 22:10:00', 6, '2021-07-14 21:50:13'),
(49, 26, 5, 5000, 1, 1, NULL, '2021-07-05 22:10:00', 4, '2021-07-05 22:16:52'),
(50, 26, 3, 10000, 1, 1, NULL, '2021-07-05 22:10:00', 4, '2021-07-05 22:16:52'),
(51, 26, 7, 15000, 1, 1, NULL, '2021-07-05 22:10:00', 4, '2021-07-05 22:16:52'),
(52, 27, 5, 5000, 2, 1, NULL, '2021-07-12 16:32:17', 4, '2021-07-12 16:36:02'),
(53, 27, 6, 7000, 1, 1, NULL, '2021-07-12 16:32:17', 4, '2021-07-12 16:36:02'),
(54, 27, 7, 15000, 1, 1, NULL, '2021-07-12 16:32:17', 4, '2021-07-12 16:36:02'),
(55, 28, 14, 5000, 1, 1, NULL, '2021-07-13 01:15:01', NULL, NULL),
(56, 28, 15, 5000, 1, 1, NULL, '2021-07-13 01:15:01', NULL, NULL),
(57, 29, 16, 80000, 2, 1, NULL, '2021-07-13 01:15:01', 4, '2021-07-13 01:23:51'),
(58, 30, 25, 500, 2, 1, NULL, '2021-07-19 22:24:27', NULL, NULL),
(59, 31, 28, 50000, 1, 0, NULL, '2021-07-20 09:43:05', 46, '2021-07-20 09:59:39'),
(60, 32, 29, 60000, 1, 1, NULL, '2021-07-20 09:53:36', 46, '2021-07-20 09:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `order_progress`
--

CREATE TABLE `order_progress` (
  `id` int(255) NOT NULL,
  `order_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_progress`
--

INSERT INTO `order_progress` (`id`, `order_id`, `user_id`, `status`, `created_time`, `note`) VALUES
(1, 1, 3, 1, '2020-12-04 20:00:31', 'Order Create'),
(2, 1, 4, 2, '2020-12-04 21:32:35', 'Artist approval'),
(3, 1, 3, 3, '2020-12-04 21:35:40', 'Payment submited'),
(4, 1, 1, 4, '2020-12-05 11:38:25', 'Payment approval'),
(5, 2, 5, 1, '2020-12-12 18:49:38', 'Order Create'),
(6, 3, 5, 1, '2020-12-12 18:49:38', 'Order Create'),
(7, 4, 5, 1, '2020-12-12 21:00:18', 'Order Create'),
(8, 4, 4, 2, '2020-12-12 21:01:51', 'Artist approval'),
(9, 2, 2, 8, '2020-12-13 00:32:22', 'Artist Reject'),
(10, 5, 5, 1, '2020-12-13 00:35:58', 'Order Create'),
(11, 6, 1, 1, '2021-01-07 12:47:11', 'Order Create'),
(12, 7, 1, 1, '2021-01-07 12:47:11', 'Order Create'),
(13, 8, 3, 1, '2021-01-08 19:16:17', 'Order Create'),
(14, 9, 3, 1, '2021-01-08 19:16:17', 'Order Create'),
(15, 10, 3, 1, '2021-01-08 19:16:17', 'Order Create'),
(16, 11, 2, 1, '2021-06-09 02:25:10', 'Order Create'),
(17, 12, 2, 1, '2021-06-09 02:25:10', 'Order Create'),
(18, 11, 4, 2, '2021-06-09 03:27:10', 'Artist approval'),
(19, 13, 7, 1, '2021-06-10 19:07:47', 'Order Create'),
(20, 14, 7, 1, '2021-06-10 19:07:47', 'Order Create'),
(21, 15, 7, 1, '2021-06-10 19:38:46', 'Order Create'),
(22, 16, 7, 1, '2021-06-10 19:38:46', 'Order Create'),
(23, 17, 7, 1, '2021-06-10 19:38:46', 'Order Create'),
(24, 18, 27, 1, '2021-06-11 20:52:12', 'Order Create'),
(27, 21, 1, 1, '2021-06-26 02:47:00', 'Order Create'),
(28, 22, 1, 1, '2021-06-26 02:47:00', 'Order Create'),
(29, 22, 4, 8, '2021-06-26 03:20:12', 'Artist Reject'),
(30, 23, 1, 1, '2021-06-26 09:24:52', 'Order Create'),
(31, 24, 1, 1, '2021-06-26 09:24:52', 'Order Create'),
(32, 23, 35, 2, '2021-06-26 09:30:07', 'Artist approval'),
(33, 25, 5, 1, '2021-07-05 22:10:00', 'Order Create'),
(34, 26, 5, 1, '2021-07-05 22:10:00', 'Order Create'),
(35, 5, 4, 2, '2021-07-05 22:15:54', 'Artist approval'),
(36, 26, 4, 2, '2021-07-05 22:16:52', 'Artist approval'),
(37, 8, 4, 2, '2021-07-08 09:00:18', 'Artist approval'),
(38, 8, 3, 3, '2021-07-08 09:05:08', 'Payment submited'),
(39, 8, 3, 3, '2021-07-08 09:05:15', 'Payment submited'),
(40, 8, 3, 3, '2021-07-08 09:07:07', 'Payment submited'),
(41, 8, 3, 3, '2021-07-08 09:07:28', 'Payment submited'),
(42, 8, 3, 3, '2021-07-08 09:13:46', 'Payment submited'),
(43, 8, 3, 3, '2021-07-08 11:30:45', 'Payment submited'),
(44, 8, 1, 9, '2021-07-09 02:30:23', 'Payment Reject '),
(45, 8, 1, 9, '2021-07-09 12:54:40', ' 	Payment Reject '),
(46, 8, 1, 9, '2021-07-09 17:02:41', 'Payment Reject '),
(47, 8, 1, 9, '2021-07-09 17:03:56', 'Payment Reject '),
(48, 8, 1, 9, '2021-07-09 17:04:11', 'Payment Reject '),
(49, 8, 1, 9, '2021-07-09 17:04:52', 'Payment Reject '),
(50, 8, 1, 4, '2021-07-09 17:05:38', 'Payment approval Payment confirmed'),
(51, 8, 4, 5, '2021-07-09 23:55:26', 'Order Dispatch'),
(52, 3, 5, 3, '2021-07-12 12:12:16', 'Payment submited'),
(53, 3, 1, 9, '2021-07-12 12:43:21', 'Payment Reject image is not clear'),
(54, 3, 5, 3, '2021-07-12 12:50:53', 'Payment submited'),
(55, 3, 5, 3, '2021-07-12 12:58:07', 'Payment submited'),
(56, 3, 5, 3, '2021-07-12 13:00:40', 'Payment submited'),
(57, 3, 1, 4, '2021-07-12 13:04:50', 'Payment approval '),
(58, 3, 1, 9, '2021-07-12 13:06:28', 'Payment Reject '),
(59, 3, 1, 4, '2021-07-12 13:07:06', 'Payment approval '),
(60, 3, 1, 4, '2021-07-12 13:10:33', 'Payment approval '),
(61, 3, 1, 4, '2021-07-12 13:17:57', 'Payment approval '),
(62, 3, 1, 4, '2021-07-12 13:23:44', 'Payment approval '),
(63, 1, 4, 5, '2021-07-12 14:30:27', 'Order Dispatch'),
(64, 1, 4, 5, '2021-07-12 14:35:39', 'Order Dispatch'),
(65, 8, 1, 4, '2021-07-12 14:52:29', 'Payment approval '),
(66, 8, 4, 5, '2021-07-12 14:53:44', 'Order Dispatch'),
(67, 27, 5, 1, '2021-07-12 16:32:17', 'Order Create'),
(68, 27, 4, 2, '2021-07-12 16:36:02', 'Artist approval'),
(69, 27, 5, 3, '2021-07-12 16:42:32', 'Payment submited'),
(70, 27, 1, 9, '2021-07-12 16:44:09', 'Payment Reject image is not clear'),
(71, 27, 5, 3, '2021-07-12 16:47:37', 'Payment submited'),
(72, 27, 1, 4, '2021-07-12 16:48:52', 'Payment approval '),
(73, 27, 1, 4, '2021-07-12 16:54:40', 'Payment approval approved'),
(74, 27, 4, 5, '2021-07-12 16:57:24', 'Order Dispatch'),
(75, 28, 7, 1, '2021-07-13 01:15:01', 'Order Create'),
(76, 29, 7, 1, '2021-07-13 01:15:01', 'Order Create'),
(77, 29, 4, 2, '2021-07-13 01:23:51', 'Artist approval'),
(78, 29, 7, 3, '2021-07-13 01:28:49', 'Payment submited'),
(79, 29, 1, 4, '2021-07-13 01:36:06', 'Payment approval due amount 150 000'),
(80, 29, 7, 3, '2021-07-13 01:53:59', 'Payment submited'),
(81, 29, 1, 4, '2021-07-13 01:56:53', 'Payment approval '),
(82, 29, 7, 3, '2021-07-13 01:58:12', 'Payment submited'),
(83, 29, 1, 4, '2021-07-13 02:03:07', 'Payment approval '),
(84, 29, 4, 5, '2021-07-13 02:29:41', 'Order Dispatch'),
(85, 1, 4, 5, '2021-07-13 23:02:17', 'Order Dispatch Order Dispatch'),
(86, 1, 4, 5, '2021-07-13 23:08:16', 'Order Dispatch Order Dispatch'),
(87, 1, 4, 5, '2021-07-13 23:12:55', 'Order Dispatch '),
(88, 1, 4, 5, '2021-07-13 23:13:19', 'Order Dispatch '),
(89, 1, 4, 5, '2021-07-13 23:15:47', 'Order Dispatch this order is dispatched on 13th of July'),
(90, 27, 5, 6, '2021-07-14 03:05:21', 'Order Collect'),
(91, 23, 1, 3, '2021-07-14 17:17:28', 'Payment submited'),
(92, 23, 1, 9, '2021-07-14 17:19:54', 'Payment Reject rejected '),
(93, 23, 1, 4, '2021-07-14 17:46:09', 'Payment approval:: approved : order id 23'),
(94, 27, 1, 13, '2021-07-14 19:52:16', 'Payment approval:: due amount - 16 000.00'),
(95, 27, 1, 7, '2021-07-14 19:59:50', 'Artist Payment:: completed'),
(96, 10, 6, 2, '2021-07-14 21:50:02', 'Artist approval'),
(97, 25, 6, 2, '2021-07-14 21:50:13', 'Artist approval'),
(98, 10, 3, 3, '2021-07-14 21:52:26', 'Payment submited'),
(99, 10, 1, 4, '2021-07-14 22:02:13', 'Payment approval:: Payment approved'),
(100, 10, 6, 5, '2021-07-14 22:31:48', 'Order Dispatch:: '),
(101, 10, 3, 6, '2021-07-14 22:32:14', 'Order Collect'),
(102, 26, 5, 3, '2021-07-15 00:07:34', 'Payment submited'),
(103, 26, 1, 9, '2021-07-15 00:09:39', 'Payment Reject '),
(104, 26, 1, 9, '2021-07-15 00:10:01', 'Payment Reject '),
(105, 26, 1, 11, '2021-07-15 00:28:55', 'Partial Payment approval:: Payment approval:: payment approved '),
(106, 26, 5, 3, '2021-07-15 00:38:51', 'Payment submited'),
(107, 26, 1, 11, '2021-07-15 00:40:06', 'Partial Payment approval:: Payment approval:: okay'),
(108, 26, 5, 3, '2021-07-15 00:42:27', 'Payment submited'),
(109, 26, 1, 11, '2021-07-15 00:46:34', 'Partial Payment approval:: Payment approval:: Thank you'),
(110, 26, 5, 3, '2021-07-15 00:47:58', 'Payment submited'),
(111, 26, 1, 11, '2021-07-15 00:48:44', 'Partial Payment approval:: Payment approval:: Thank you'),
(112, 30, 1, 1, '2021-07-19 22:24:27', 'Order Create'),
(113, 1, 1, 6, '2021-07-19 23:42:24', 'Order Collect'),
(114, 23, 1, 5, '2021-07-19 23:54:25', 'Order Dispatch:: updated by Admin'),
(115, 4, 1, 3, '2021-07-20 01:09:02', 'Payment submited'),
(116, 4, 1, 9, '2021-07-20 01:14:04', 'Payment Reject '),
(117, 4, 1, 9, '2021-07-20 01:16:18', 'Payment Reject '),
(118, 4, 1, 11, '2021-07-20 01:18:42', 'Partial Payment approval:: Payment approval:: '),
(119, 5, 1, 11, '2021-07-20 01:22:58', 'Partial Payment approval:: Payment approval:: '),
(120, 5, 5, 3, '2021-07-20 01:33:33', 'Payment submited'),
(121, 5, 1, 4, '2021-07-20 01:34:28', 'Payment approval:: approved'),
(122, 8, 1, 6, '2021-07-20 02:47:15', 'Order Collect'),
(123, 7, 1, 2, '2021-07-20 02:58:22', 'Artist approval'),
(124, 31, 47, 1, '2021-07-20 09:43:05', 'Order Create'),
(125, 32, 47, 1, '2021-07-20 09:53:36', 'Order Create'),
(126, 32, 46, 2, '2021-07-20 09:59:25', 'Artist approval'),
(127, 31, 46, 8, '2021-07-20 09:59:39', 'Artist Reject');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(255) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `type`, `label`) VALUES
(1, 'Awaiting Approval', 'warning'),
(2, 'Pending Payment', 'cyan'),
(3, 'Pending Verify Payment', 'secondary'),
(4, 'Pending Shipment', 'cyan'),
(5, 'Pending collect', 'cyan'),
(6, 'Pending Payment to artist', 'pink'),
(7, 'Completed', 'success'),
(8, 'Rejected by Artist', 'danger'),
(9, 'Payment Rejected', 'danger'),
(10, 'Shipment Canceled', 'danger'),
(11, 'Partially Paid', 'cyan'),
(12, 'Order Canceled', 'danger'),
(13, 'Hold and Pay for Artist', 'secondary');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(255) NOT NULL,
  `order_id` int(255) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_user_id` int(11) DEFAULT NULL,
  `status_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `amount`, `payment_date`, `description`, `created`, `image`, `status`, `status_user_id`, `status_time`) VALUES
(1, 6, 1, 5000, '2021-07-04 00:00:00', 'payment of order id 23', '2021-07-05 14:57:18', 'w_1625477171.jpg', 1, NULL, NULL),
(2, 4, 5, 50000, '2021-07-03 00:00:00', 'payment of order id 4', '2021-07-05 15:01:45', 'w_1625477451.jpg', 2, 1, '2021-07-20 01:14:04'),
(3, 23, 1, 5000, '2021-07-02 00:00:00', 'Test Note', '2021-07-05 15:38:46', 'w_1625479702.jpg', 2, 1, '2021-07-15 00:00:20'),
(4, 4, 5, 90000, '2021-07-01 00:00:00', 're submitted order id 4', '2021-07-05 15:40:50', 'w_1625479832.jpg', 2, 1, '2021-07-20 01:16:18'),
(5, 26, 5, 30, '2021-07-05 00:00:00', 'this is payment submission note', '2021-07-05 22:18:28', 'w_1625503646.jpg', 2, 1, '2021-07-15 00:09:39'),
(6, 26, 5, 60000, '2021-06-30 00:00:00', 'Please ensure that your name, Order ID and contact no is mentioned in the bank slip', '2021-07-05 23:33:17', 'w_1625508161.jpg', 2, 1, '2021-07-15 00:10:01'),
(7, 5, 3, 10000, '2021-06-30 00:00:00', 'this is payment note', '2021-07-06 00:42:45', 'w_1625512339.jpg', 1, 1, '2021-07-20 01:22:58'),
(8, 8, 3, 50, '2021-07-07 00:00:00', 'Payment for Order Id 8', '2021-07-08 09:05:08', 'w_1625715255.jpg', 2, 1, '2021-07-09 17:02:41'),
(9, 8, 3, 50, '2021-07-07 00:00:00', 'Payment for Order Id 8', '2021-07-08 09:05:15', 'w_1625715255.jpg', 2, 1, '2021-07-09 17:03:56'),
(10, 8, 3, 50, '2021-07-07 00:00:00', 'Payment for Order Id 8', '2021-07-08 09:07:07', 'w_1625715255.jpg', 2, 1, '2021-07-09 17:04:11'),
(11, 8, 3, 50, '2021-07-07 00:00:00', 'Payment for Order Id 8', '2021-07-08 09:07:28', 'w_1625715255.jpg', 2, 1, '2021-07-09 17:04:52'),
(12, 8, 3, 50000, '2021-07-07 00:00:00', 'Payment for order id 8', '2021-07-08 09:13:46', 'w_1625715805.jpg', 2, 1, '2021-07-09 12:54:40'),
(13, 8, 3, 80000, '2021-07-07 00:00:00', 'payment for order id 008', '2021-07-08 11:30:45', 'w_1625724002.jpg', 1, 1, '2021-07-12 14:52:29'),
(14, 3, 5, 70000, '2021-07-11 00:00:00', 'payment for order 03', '2021-07-12 12:12:16', 'w_1626072101.jpg', 2, 1, '2021-07-12 12:43:21'),
(15, 3, 5, 50000, '2021-07-10 00:00:00', 'payment for order 3', '2021-07-12 12:50:53', 'w_1626074432.jpg', 2, 1, '2021-07-12 13:06:28'),
(16, 3, 5, 60000, '2021-07-12 00:00:00', '2nd payment for order id 3', '2021-07-12 12:58:07', 'w_1626074860.jpg', 1, 1, '2021-07-12 13:17:57'),
(17, 3, 5, 60000, '2021-07-12 00:00:00', 'payment for order id 3', '2021-07-12 13:00:40', 'w_1626075019.jpg', 1, 1, '2021-07-12 13:23:44'),
(18, 27, 5, 32000, '2021-07-12 00:00:00', 'Payment for order id 27', '2021-07-12 16:42:32', 'w_1626088317.jpg', 2, 1, '2021-07-12 16:44:09'),
(19, 27, 5, 32000, '2021-07-12 00:00:00', 'payment for order id 27', '2021-07-12 16:47:37', 'w_1626088640.jpg', 1, 1, '2021-07-12 16:54:40'),
(20, 29, 7, 10000, '2021-07-13 00:00:00', 'half paid ', '2021-07-13 01:28:49', 'w_1626119867.jpg', 1, 1, '2021-07-13 01:36:06'),
(21, 29, 7, 150, '2021-07-13 00:00:00', 'due', '2021-07-13 01:53:59', 'w_1626121411.jpg', 1, 1, '2021-07-13 01:56:53'),
(22, 29, 7, 149850, '2021-07-13 00:00:00', '149 850', '2021-07-13 01:58:12', 'w_1626121665.jpg', 1, 1, '2021-07-13 02:03:07'),
(23, 23, 1, 5000, '2021-07-14 00:00:00', 'payment for order id 23', '2021-07-14 17:17:28', 'w_1626263208.jpg', 1, 1, '2021-07-14 17:46:09'),
(24, 10, 3, 20000, '2021-07-14 00:00:00', 'Payment for order id 10', '2021-07-14 21:52:26', 'w_1626279736.jpg', 1, 1, '2021-07-14 22:02:13'),
(25, 26, 5, 10000, '2021-07-15 00:00:00', 'payment for order id 26', '2021-07-15 00:07:34', 'w_1626287826.jpg', 1, 1, '2021-07-15 00:28:55'),
(26, 26, 5, 5000, '2021-07-15 00:00:00', 'payment for order id 26', '2021-07-15 00:38:51', 'w_1626289701.jpg', 1, 1, '2021-07-15 00:40:06'),
(27, 26, 5, 5000, '2021-07-15 00:00:00', 'Test', '2021-07-15 00:42:27', 'w_1626289919.jpg', 1, 1, '2021-07-15 00:46:34'),
(28, 26, 5, 5000, '2021-07-15 00:00:00', 'payment for 26 ', '2021-07-15 00:47:58', 'w_1626290259.jpg', 1, 1, '2021-07-15 00:48:44'),
(29, 4, 5, 80000, '2021-07-20 00:00:00', 'Added By Admin', '2021-07-20 01:09:02', 'w_1626723513.jpg', 1, 1, '2021-07-20 01:18:42'),
(30, 5, 5, 8000, '2021-07-20 00:00:00', 'due amount', '2021-07-20 01:33:33', 'w_1626724987.jpg', 1, 1, '2021-07-20 01:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `category_id` int(255) DEFAULT NULL,
  `medium_id` int(255) DEFAULT NULL,
  `post_method` tinyint(1) DEFAULT NULL,
  `bid_start_time` datetime DEFAULT NULL,
  `bid_end_time` datetime DEFAULT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `orientation` tinyint(1) DEFAULT NULL,
  `dimension_id` int(255) DEFAULT NULL,
  `dimension_x` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dimension_y` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dimension_label_id` int(2) DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `artwork_date` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `admin_status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `category_id`, `medium_id`, `post_method`, `bid_start_time`, `bid_end_time`, `title`, `description`, `price`, `quantity`, `orientation`, `dimension_id`, `dimension_x`, `dimension_y`, `dimension_label_id`, `image`, `artwork_date`, `status`, `admin_status`, `created`) VALUES
(1, 4, 1, 9, 2, '2011-08-24 00:00:00', '2011-08-25 00:00:00', 'test1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1000, 1, 1, 0, '150', '200', 3, 'w_1612536197.jpg', '2011-08-19 00:00:00', 1, 1, '2020-10-30 21:17:14'),
(2, 2, 7, 3, 2, '2020-11-04 00:00:00', '2020-12-03 00:00:00', 'test002', 'asdfjkl; sadkfajlkwfejrr;ewrkjpot bewtiewptiwe tpeowLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5000, 1, 1, 1, '', '', 1, 'w_1612536550.jpg', '2020-10-30 00:00:00', 1, 1, '2020-10-30 21:35:14'),
(3, 4, 2, 7, 1, '2020-11-05 00:00:00', '2020-12-05 00:00:00', 'test2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 10000, 10, 1, 0, '100', '200', 3, 'w_1625578806.jpg', '2020-11-05 00:00:00', 1, 1, '2020-11-05 21:16:48'),
(4, 4, 1, 1, 2, '2021-01-07 00:00:00', '2021-08-08 00:00:00', 'test 003', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2000, 5, 1, 2, '', '', 1, 'w_1625918372.jpg', '2020-11-06 00:00:00', 1, 1, '2020-11-06 22:05:02'),
(5, 4, 3, 1, 1, '2020-11-06 00:00:00', '2020-12-06 00:00:00', 'test 004', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5000, 14, 1, 1, '', '', 1, 'w_1612536095.jpg', '2020-11-06 00:00:00', 1, 1, '2020-11-06 23:48:03'),
(6, 4, 2, 1, 1, '2020-11-06 00:00:00', '2020-12-06 00:00:00', 'test 005', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 7000, 2, 1, 2, '', '', 1, 'w_1612536031.jpg', '2020-11-06 00:00:00', 1, 1, '2020-11-06 23:50:05'),
(7, 4, 3, 1, 1, '2020-11-06 00:00:00', '2020-12-06 00:00:00', 'sky upated', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 15000, 1, 1, 1, '', '', 1, 'w_1612536016.jpg', '2020-11-06 00:00:00', 1, 1, '2020-11-06 23:51:49'),
(8, 4, 3, 1, 2, '2021-08-09 00:00:00', '2021-12-09 00:00:00', 'Test 00078 update 22', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3000, 5, 1, 0, '502', '249', 3, 'w_1625918352.jpg', '2020-11-17 00:00:00', 1, 1, '2020-11-07 20:49:49'),
(9, 4, 1, 1, 1, '2020-11-15 00:00:00', '2020-12-15 00:00:00', 'NEW update', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5000, 1, 1, 1, '', '', 1, 'w_1625580804.jpg', '2020-11-15 00:00:00', 1, 1, '2020-11-15 09:49:53'),
(10, 2, 1, 1, 1, '2020-11-24 00:00:00', '2020-12-24 00:00:00', 'Picture 1', 'Untitled Abstract Expressionist Pen and Ink Drawing , ca. 1950\r\nPen and black ink and brush and black ink wash on paper. Hand signed. Framed with Separate Hand Signed Blindstamped Certificate of Authenticity signed by the artistLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5000, 1, 1, 1, '', '', 1, 'w_1612536515.jpg', '2020-11-24 00:00:00', 1, 1, '2020-11-24 20:32:50'),
(11, 2, 1, 1, 2, '2020-11-24 00:00:00', '2021-02-24 00:00:00', 'Picture 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 7000, 3, 1, 2, '', '', 1, 'w_1625580842.jpg', '2018-06-24 00:00:00', 1, 1, '2020-11-24 20:34:55'),
(12, 2, 2, 7, 1, '2020-11-24 00:00:00', '2020-12-24 00:00:00', 'Picture 3', 'Untitled Abstract Expressionist Pen and Ink Drawing , ca. 1950\r\nPen and black ink and brush and black ink wash on paper. Hand signed. Framed with Separate Hand Signed Blindstamped Certificate of Authenticity signed by the artistLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 10000, 10, 1, 1, '', '', 1, 'w_1612536456.jpg', '2010-12-24 00:00:00', 1, 1, '2020-11-24 20:36:24'),
(13, 6, 2, 1, 2, '2020-11-24 00:00:00', '2021-12-31 00:00:00', 'Picture 4', 'Untitled Abstract Expressionist Pen and Ink Drawing , ca. 1950\r\nPen and black ink and brush and black ink wash on paper. Hand signed. Framed with Separate Hand Signed Blindstamped Certificate of Authenticity signed by the artistLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2000, 1, 1, 0, '1000', '500', 4, 'w_1612536379.jpg', '2015-06-24 00:00:00', 1, 1, '2020-11-24 21:01:09'),
(14, 6, 9, 1, 1, '2020-11-24 00:00:00', '2020-12-24 00:00:00', 'Picture 5', 'Untitled Abstract Expressionist Pen and Ink Drawing , ca. 1950\r\nPhttp://localhost/warna2/1/artist/modal-product-image-upload.php?id=14en and black ink and brush and black ink wash on paper. Hand signed. Framed with Separate Hand Signed Blindstamped Certificate of Authenticity signed by the artistLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5000, 19, 1, 0, '', '', 4, 'w_1612536394.jpg', '2020-01-01 00:00:00', 1, 1, '2020-11-24 21:02:23'),
(15, 6, 1, 9, 1, '2020-11-24 00:00:00', '2020-12-24 00:00:00', 'Picture 6', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5000, 6, 1, 1, '', '', 1, 'w_1612536293.jpg', '2020-11-02 00:00:00', 1, 1, '2020-11-24 21:03:36'),
(16, 4, 1, 1, 1, '2020-12-11 00:00:00', '2021-01-11 00:00:00', 'dfdhrjdfj updated2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 80000, 3, 1, 1, '', '', 1, 'w_1612535949.jpg', '1970-01-01 00:00:00', 1, 1, '2020-12-11 20:38:46'),
(17, 4, 3, 1, 1, '2020-12-11 00:00:00', '2021-01-11 00:00:00', 'The sunset', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5424, 1, 1, 1, '', '', 1, 'w_1612535918.jpg', '1970-01-01 00:00:00', 1, 1, '2020-12-11 21:28:08'),
(19, 6, 6, 5, 1, '2021-06-10 00:00:00', '2021-07-10 00:00:00', 'Prime of Death Pencil Artwork ', '', 4000, 1, 1, 0, '500', '', 3, 'w_1623332977.jpg', '2020-06-10 00:00:00', 1, 1, '2021-06-10 19:19:42'),
(20, 10, 1, 1, 1, '2021-06-10 00:00:00', '2021-07-10 00:00:00', 'A Place To Rest', '', 5500, 1, 1, 0, '700', '500', 3, 'w_1623333278.jpg', '2007-02-09 00:00:00', 1, 1, '2021-06-10 19:24:41'),
(21, 10, 5, 1, 1, '2021-06-10 00:00:00', '2021-07-10 00:00:00', 'Brighter Than I Remember', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 9000, 1, 1, 1, '', '', 1, 'w_1625580532.jpg', '2000-10-01 00:00:00', 1, 1, '2021-06-10 19:26:28'),
(22, 10, 6, 5, 1, '2021-06-10 00:00:00', '2021-07-10 00:00:00', 'Deep Into A Memory', '', 600, 1, 1, 2, '', '', 1, 'w_1623333418.jpg', '2018-11-10 00:00:00', 1, 1, '2021-06-10 19:27:52'),
(23, 33, 1, 1, 1, '2021-06-26 00:00:00', '2021-07-26 00:00:00', 'this is the title ', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 10000, 1, 1, 0, '5000', '4000', 4, 'w_1625580651.jpg', '2018-07-03 00:00:00', 1, 1, '2021-06-26 01:37:19'),
(24, 35, 1, 5, 1, '2021-06-26 00:00:00', '2021-07-26 00:00:00', 'Title goes here', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo', 5000, 1, 1, 2, '2', '', 4, 'w_1625580775.jpg', '2018-07-03 00:00:00', 1, 1, '2021-06-26 09:21:42'),
(25, 4, 3, 1, 1, '2021-07-15 00:00:00', '2021-08-15 00:00:00', 'Buterfly ink painting', '', 500, -1, 1, 1, '', '', 1, 'w_1626333999.jpg', '2018-07-03 05:30:00', 1, 1, '2021-07-15 12:57:11'),
(26, 1, 1, 0, 1, '2021-07-17 00:00:00', '2021-08-17 00:00:00', 'nvbjyjhgjk', 'hgfjytiu', 50000, 1, 1, 1, '', '', 1, 'w_1626492850.jpg', '2021-07-06 00:00:00', 1, 1, '2021-07-17 09:04:14'),
(27, 1, 1, 0, 2, '2021-07-17 00:00:00', '2021-10-17 00:00:00', 'Sunrise', 'sunrise painting ', 20000, 1, 1, 5, '', '', 1, 'w_1626516448.jpg', '2021-07-10 00:00:00', 1, 1, '2021-07-17 15:37:33'),
(28, 46, 1, 15, 1, '2021-07-20 00:00:00', '2021-08-20 00:00:00', 'The Sun And The Moon', '“Every spark returns to darkness. Every sound returns to silence. Every flower returns to sleep with the earth. The journey of the sun and moon is predictable. But yours, is your ultimate\r\nart.”\r\n― Suzy Kassem, Rise Up and Salute the Sun: The Writings of Suzy Kassem', 50000, 0, 1, 4, '', '', 1, 'w_1626754033.jpg', '2021-07-20 00:00:00', 1, 1, '2021-07-20 09:37:16'),
(29, 46, 1, 4, 1, '2021-07-20 00:00:00', '2021-08-20 00:00:00', 'fortress of solitude', 'The Fortress of Solitude is a fictional fortress appearing in American comic books published by DC Comics, commonly in association with Superman. A place of solace and occasional headquarters for Superman, the fortress is typically depicted as being in frozen tundra, away from civilization.', 60000, 2, 1, 5, '', '', 1, 'w_1626754775.jpg', '2021-07-20 00:00:00', 1, 1, '2021-07-20 09:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(255) NOT NULL,
  `rate_artist_id` int(255) DEFAULT NULL,
  `rate` tinyint(1) DEFAULT NULL,
  `created_user_id` int(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `rate_artist_id`, `rate`, `created_user_id`, `created`, `updated`) VALUES
(1, 4, 5, 1, '2021-07-09 12:07:42', NULL),
(2, 4, 4, 5, '2021-07-09 12:07:42', NULL),
(3, 4, 5, 7, '2021-07-08 12:10:17', NULL),
(4, 4, 3, 9, '2021-07-09 12:10:17', NULL),
(5, 4, 3, 9, '2021-07-09 12:10:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(255) NOT NULL,
  `review_artist_id` int(255) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_user_id` int(255) DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_user_id` int(255) DEFAULT NULL,
  `status_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review_artist_id`, `comment`, `created_user_id`, `created_time`, `updated_time`, `status`, `status_user_id`, `status_time`) VALUES
(1, 4, 'ghfhgfhfLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 27, '2021-06-20 13:26:20', NULL, 1, NULL, NULL),
(2, 4, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2021-06-20 13:28:58', NULL, 1, NULL, NULL),
(3, 4, 'fyjgrfytercytriuytyLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, '2021-06-20 13:30:53', NULL, 1, NULL, NULL),
(4, 4, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 5, '2021-06-20 13:31:08', NULL, 1, NULL, NULL),
(5, 4, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 27, '2021-06-20 13:32:22', NULL, 1, NULL, NULL),
(6, 4, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 7, '2021-06-20 13:33:28', NULL, 1, NULL, NULL),
(7, 4, 'The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.nkkkkkkkkkkkkkkkkkkkkkkkk', 1, '2021-07-03 16:54:05', NULL, 1, NULL, NULL),
(8, 4, 'sadasgdaga gfhtrejer fhfh!', 1, '2021-06-29 23:57:13', NULL, 1, NULL, NULL),
(9, 4, 'cxcb bbb', 1, '2021-07-03 16:55:21', NULL, 1, NULL, NULL),
(10, 6, 'ghfhgfhfLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2021-06-30 00:03:41', NULL, 1, NULL, NULL),
(11, 6, 'The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.', 1, '2021-06-30 00:05:01', NULL, 1, NULL, NULL),
(12, 14, 'The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.', 1, '2021-06-30 00:06:30', NULL, 1, NULL, NULL),
(13, 14, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2021-06-30 00:07:40', NULL, 1, NULL, NULL),
(14, 11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2021-06-30 00:08:29', NULL, 1, NULL, NULL),
(15, 11, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2021-06-30 00:11:44', NULL, 1, NULL, NULL),
(16, 15, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. cxfsder', 1, '2021-07-04 11:38:32', NULL, 1, NULL, NULL),
(17, 15, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 13, '2021-07-04 11:17:52', NULL, 1, NULL, NULL),
(18, 15, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 11, '2021-07-04 11:18:52', NULL, 1, NULL, NULL),
(19, 15, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 9, '2021-07-04 11:19:36', NULL, 1, NULL, NULL),
(20, 15, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 8, '2021-07-04 11:19:59', NULL, 1, NULL, NULL),
(21, 15, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 6, '2021-07-04 11:20:26', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(255) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `type`, `status`) VALUES
(1, 'Painters', 1),
(2, 'Sculptors', 1),
(3, 'Printmakers', 1),
(4, 'Drawers', 1),
(5, 'Photographer', 1),
(6, 'Digital Artists', 1),
(7, 'Collage artists', 1),
(8, 'Textile Artists', 1),
(9, 'Others ', 1),
(10, 'new service', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `role_id` tinyint(1) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_1` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_2` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `town` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_id` int(3) DEFAULT NULL,
  `designation` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_number` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_code` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `nic` tinyint(1) DEFAULT NULL,
  `id_image` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `nic_verified_time` datetime DEFAULT NULL,
  `nic_note` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `new_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT NULL,
  `email_verified_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `email`, `first_name`, `last_name`, `phone`, `address_1`, `address_2`, `town`, `state`, `postcode`, `country_id`, `designation`, `image`, `facebook_url`, `linkedin_url`, `instagram_url`, `account_number`, `bank`, `branch_name`, `branch_code`, `status`, `nic`, `id_image`, `nic_verified_time`, `nic_note`, `created`, `new_email`, `email_verified`, `email_verified_link`, `email_verified_time`) VALUES
(1, 1, 'Admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'e151041105@bit.uom.lk', 'Gayanthi ', 'Dilusha ', '074564685', 'Line 001', 'Line 002', 'Negombo', 'Western', '12345', 204, '', 'w_1608353652.jpg', '', '', '', '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, NULL, NULL, NULL, '2020-10-29 12:34:18', NULL, 1, 'af4e77efe3c9ba8f23c24e77c8c4ec76bdb6aefa', '2021-07-02 04:34:18'),
(2, 2, 'kavi', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'kavi@artist.com', 'Kavindi', 'Perera', NULL, NULL, NULL, NULL, NULL, NULL, 204, 'Ceramic Artist', 'w_1621788440.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, '', NULL, NULL, '2020-10-29 15:19:13', 'gsdilusha198@gmail.com', 0, '07c1c1af1b89af561acce6a68c71de1a8dceb2c2', NULL),
(3, 2, 'dilu', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gdsenev777@gmail.com', 'Dilusha', 'Senevirathne', '07777777', 'no 566 Kaluthra', 'aDDress', 'Negombo test', 'western test', '1501', 151, '', 'temp', '', '', '', '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, 'w_1625512058.jpg', '2021-07-06 00:38:22', 'approved', '2020-10-29 19:51:24', 'gsdilusha197@gmail.com', 0, '3033b4f5995c2c97965839603e7ca4b1d8267f78', '2021-07-08 11:20:07'),
(4, 2, 'Artist', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gdsenev4@gmail.com', 'Ann', 'Perera', '0771234567', 'No. 27,  Elkaduwa Road', ' Karagahahinna', 'Matale', 'Central', '156', 204, 'Visual Artist', 'w_1624465459.jpg', 'https://www.facebook.com/', NULL, 'https://www.instagram.com/', '01234560656', 'Sampath bank', 'Haputhale', '012', 1, 1, 'w_1626779832.jpg', '2021-07-20 16:47:45', '', '2020-10-30 18:36:59', '', 1, 'c107a8c3a75cad291c996b176a49e3eef01cd73a', '2021-07-17 19:53:38'),
(5, 3, 'User', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gsdilusha198@gmail.com', 'Test', 'User', NULL, NULL, NULL, NULL, NULL, NULL, 198, NULL, 'w_1610359312.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 0, 0, 'test', NULL, NULL, '2020-10-30 18:37:21', NULL, 1, '960378bd62b48cfeea6f12366200a58304bb1412', '2021-07-05 22:00:43'),
(6, 2, 'gaya', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gaya@artist.com', 'Gaya', 'test', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610360824.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 2, 'w_1624679281.jpg', NULL, NULL, '2020-10-30 21:59:02', NULL, NULL, 'a76cdbe7c12c2e2b7911858951f9a2c465120099', NULL),
(7, 3, 'nimal', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'nimal@user.com', 'Nimal', 'Perera', NULL, NULL, NULL, NULL, NULL, NULL, 201, NULL, 'w_1610360000.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, 'test', NULL, NULL, '2020-12-09 21:10:52', NULL, 1, 'a262430f5a037e7a10d8e833d9b4558546bcdcd5', NULL),
(9, 3, 'jhon', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Jhon@user.com', 'Jhon', 'Fernando', NULL, NULL, NULL, NULL, NULL, NULL, 203, NULL, 'w_1610359423.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, 'test', NULL, NULL, '2020-12-11 20:01:20', NULL, NULL, 'e7437d4f738a8432280c9f25310c9215f2a53e1c', NULL),
(10, 2, 'ross', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ross@test.com', 'Ross', 'Green', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610359453.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, 'test', NULL, NULL, '2021-01-10 13:08:55', NULL, NULL, 'edfb8904d0ba9e01a4aa3c739ed69efc9d7807f3', NULL),
(11, 2, 'anne', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'anne@test.com', 'Anne', 'Sherly', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610359578.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, 'test', NULL, NULL, '2021-01-10 13:10:18', NULL, NULL, '3b5fa60a1e460a16c52f0b5e475757d4bc1946a8', NULL),
(13, 2, 'test2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test2@test.com', 'test2', 'Aritst2', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610359605.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, 'w_1624648550', '2021-07-05 19:01:12', NULL, '2021-01-10 13:13:03', NULL, NULL, '65a8e894b59a5c08ba296f3857a1fc1d586a8792', NULL),
(14, 2, 'test3', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test3@test.com', 'test3', 'Aritst3', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610360059.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, 'test', NULL, NULL, '2021-01-10 13:14:21', NULL, NULL, '7804bbbdb60addfbaae51c7f61d1ef340e2403aa', NULL),
(15, 2, 'test4', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gsdil@gmail.com', 'test4', 'Aritst4', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610359649.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 0, 1, 'test', '2021-07-20 09:16:37', '', '2021-01-10 13:15:47', NULL, NULL, '6fb3b8435f463c276ef2187dc9293ed44cca0e0f', NULL),
(16, 2, 'test5', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gsdilusha199@gmail.com', 'test5', 'Aritst5', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610359696.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, 'test', '2021-07-20 09:14:38', '', '2021-01-10 13:16:44', NULL, NULL, 'f560bc3ebece97d3291f8f79625fb7f8c49f80d7', NULL),
(17, 2, 'test6', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test6@test.com', 'test6', 'Aritst6', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1623311616.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-01-10 13:17:44', NULL, NULL, '0e6d3f25887b2adf25f19b31e9aeae893ba33864', NULL),
(18, 2, 'test7', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test7@test.com', 'test7', 'Aritst7', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1623311739.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, NULL, NULL, NULL, '2021-01-10 13:18:52', NULL, NULL, '308c29183bddee8a7e98ccc8b2209c4ed00bb432', NULL),
(19, 2, 'test8', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test8@test.com', 'test8', 'Aritst8', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1623311762.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, NULL, NULL, NULL, '2021-01-10 13:20:08', NULL, NULL, '0f41e6fdfdab173e6df67bc8cce00e88f4591d51', NULL),
(20, 2, 'test9', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'test9@test.com', 'test9', 'Aritst9', NULL, NULL, NULL, NULL, NULL, NULL, 204, NULL, 'w_1610359788.jpg', NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, NULL, NULL, NULL, '2021-01-10 13:21:13', NULL, NULL, '3a313bd316f02f2b43b8ada915c6bf4edab256e5', NULL),
(27, 3, '', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gyutguy', 'Gayanthi', 'Senevirathne', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, NULL, NULL, NULL, NULL, '2021-06-05 15:10:16', NULL, 1, '28dfe90d358e0ec0e8140685b0d3cca1374f7de2', '2021-06-20 01:31:03'),
(28, 3, 'cralwis@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d', 'cralwis@gmail.com', 'Randika', 'De Alwis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, NULL, NULL, NULL, NULL, '2021-06-05 23:08:27', NULL, 1, 'd31a90c2f2ac19e28660c457d97c8616ff0bc0f6', '2021-06-05 23:24:35'),
(33, 2, '', '499b0f3ac9e5e105fd5d545b122671ce82a81f24', 'gsdilujio@gmail.com', 'Sanduni', 'Silva', '0771234568', 'No 88, Colombo Rd', 'Negombo', 'Negombo', 'Western', '88', 204, 'Teacher', 'w_1624649454.jpg', 'https://www.facebook.com/', 'https://lk.linkedin.com/', '', '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, 'w_1624648550.jpg', '2021-06-26 01:13:41', NULL, '2021-06-25 23:35:39', NULL, 1, '297801a8f632d761783e13c5362afa9a59f3e482', '2021-06-26 02:40:00'),
(34, 2, '', '7c222fb2927d828af22f592134e8932480637c0d', 'test10@gmail.com', 'Kasun ', 'Samaranayake', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-26 07:50:56', NULL, 1, '57667dc77f011c22015f436c70ec3e270c9d5fd8', '2021-06-26 07:54:51'),
(35, 2, '', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', 'ghfdyh', 'Nimal', 'Perera', '07888888', 'No 01', 'Kadawath', 'kadawath', 'Western', '6569', 204, 'Teacher', 'w_1624680431.jpg', 'https://www.facebook.com/', 'https://www.facebook.com/', 'https://www.facebook.com/', '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, 'w_1624679281.jpg', '2021-06-26 09:18:45', NULL, '2021-06-26 09:14:09', NULL, 0, '2fbfcfeff3410f0ef48f4c672497f48b3583413c', '2021-06-26 09:15:23'),
(36, 2, '', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', 'gsdilusha194@gmail.com', 'Saman', 'Dissanayake', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, 'w_1624682338.jpg', '2021-07-20 09:11:20', '', '2021-06-26 09:57:38', NULL, 0, '75dfdb27e97c7361b7de119a260328f7bd3354ee', NULL),
(37, 3, '', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'vngjh@gmail.com', 'Nimal', 'Senarathne', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-26 10:05:08', NULL, 1, 'cbe4d3bcf0f72714b8f716d7bda9c78e2aa695de', '2021-06-26 10:05:22'),
(38, 3, 'gsdi', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', 'gsdil', 'Thanuja', 'Darshani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-28 12:53:31', NULL, 0, 'da3c0b771ec088f439d9bd56ca726fa0d8b62744', NULL),
(39, 2, '41105@b.com', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '41105@b.com', 'Thanuja', 'Darshani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-28 13:46:19', NULL, 0, '7286b399b9310b7dab43ccc48dd427baf530f18e', NULL),
(40, 3, 'gsdi', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'gsd', 'Thanuja', 'Darshani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-28 14:01:17', NULL, 0, 'dc59aaf5c8c79544821a9f28863e395e19056415', NULL),
(41, 3, 'gsdilush', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 'gsdilush', 'Nifra', 'Nayomi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-28 14:43:45', NULL, 0, '1806f1bbf473849e69cb35a4fd15757d142581b4', NULL),
(42, 2, 'gsdilusha19@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'gsdilusha@gmail.com', 'Thimira', 'Fernando', '', '', '', '', '', '', 1, '', 'w_1625818609.jpg', '', '', '', '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 0, NULL, NULL, NULL, '2021-06-28 15:18:57', NULL, 0, 'f2862069ffe0eb7c659606d5ff53079e7c0390d0', NULL),
(43, 3, 'gsdilusha19@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'gsdilush@gmail.com', 'Ridma', 'Perera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '12345678', 'Bank of Ceylon', 'Nittabuwa', '13', 1, 1, NULL, NULL, NULL, '2021-07-02 04:21:29', NULL, 1, '38f389222ded14e1273a68fefc4f91b3b19be596', '2021-07-02 04:29:30'),
(44, 3, 'gsdiusha19@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'gsdilusha195@gmail.com', 'Sithara', 'Ekanayake', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, '2021-07-20 06:23:49', NULL, 1, '04a773f96355bf394e0d27308283a615b47cc6d7', '2021-07-20 06:26:01'),
(45, 2, 'gdsenev@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '', 'Pansilu', 'Manchanayake', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, '2021-07-20 06:30:10', NULL, 1, '11bfd6bc3dde601ed6a90d201cd36df1a4980a4c', '2021-07-20 06:30:48'),
(46, 2, 'Thevin', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'gsdilusha19@gmail.com', 'Thevin', 'dissanayake', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'temp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'w_1626752104.jpg', '2021-07-20 09:05:28', '', '2021-07-20 06:37:48', NULL, 1, 'b9ef7912a5ad754e3db9da04b26fb23337c2a791', '2021-07-20 06:45:03'),
(47, 3, 'Sethuli', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'gdsenev@gmail.com', 'Sethuli', 'Wijesingha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, '2021-07-20 06:51:17', NULL, 1, '9ee29e79982204dda3e3816f9964aaed97634a77', '2021-07-20 06:51:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist_informations`
--
ALTER TABLE `artist_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_information_types`
--
ALTER TABLE `artist_information_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_payments`
--
ALTER TABLE `artist_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_services`
--
ALTER TABLE `artist_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dimensions`
--
ALTER TABLE `dimensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dimension_custom_label`
--
ALTER TABLE `dimension_custom_label`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediums`
--
ALTER TABLE `mediums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_inquiry`
--
ALTER TABLE `order_inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_progress`
--
ALTER TABLE `order_progress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist_informations`
--
ALTER TABLE `artist_informations`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `artist_information_types`
--
ALTER TABLE `artist_information_types`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `artist_payments`
--
ALTER TABLE `artist_payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `artist_services`
--
ALTER TABLE `artist_services`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `dimensions`
--
ALTER TABLE `dimensions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dimension_custom_label`
--
ALTER TABLE `dimension_custom_label`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mediums`
--
ALTER TABLE `mediums`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_inquiry`
--
ALTER TABLE `order_inquiry`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `order_progress`
--
ALTER TABLE `order_progress`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
