-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 15, 2023 at 10:30 PM
-- Server version: 8.0.34-0ubuntu0.20.04.1
-- PHP Version: 8.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aurora`
--

-- --------------------------------------------------------

--
-- Table structure for table `agronomy_areas`
--

CREATE TABLE `agronomy_areas` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_position` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_layout` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condition` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000000000000000',
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agronomy_livestock`
--

CREATE TABLE `agronomy_livestock` (
  `id` bigint NOT NULL,
  `code` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `species` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `breed` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` int NOT NULL,
  `dod` int NOT NULL,
  `rid` bigint NOT NULL,
  `aid` bigint NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint UNSIGNED NOT NULL,
  `iid` bigint UNSIGNED NOT NULL,
  `cid` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `contentType` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` mediumint UNSIGNED NOT NULL,
  `cost` decimal(10,2) UNSIGNED NOT NULL,
  `stockStatus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int NOT NULL,
  `si` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `rid` bigint UNSIGNED NOT NULL,
  `oid` bigint NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int UNSIGNED NOT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int NOT NULL,
  `f` decimal(10,2) NOT NULL,
  `t` decimal(10,2) NOT NULL,
  `code` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `quantity` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longblob NOT NULL,
  `tis` int NOT NULL,
  `tie` int NOT NULL,
  `ord` bigint NOT NULL,
  `status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rid` bigint UNSIGNED NOT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `cid` bigint UNSIGNED NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gravatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint UNSIGNED NOT NULL,
  `tie` int NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` tinyint UNSIGNED NOT NULL,
  `development` int NOT NULL,
  `maintenance` int NOT NULL,
  `comingsoon` int NOT NULL,
  `hoster` tinyint(1) NOT NULL,
  `hosterURL` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `forumOptions` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inventoryFallbackStatus` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `defaultPage` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoTitle` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoKeywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingvalentine` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingeaster` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingmothersday` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingfathersday` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingblackfriday` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadinghalloween` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingsmallbusinessday` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingchristmas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saleHeadingEOFY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metaRobots` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoRSSTitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoRSSNotes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoRSSLink` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoRSSAuthor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoRSSti` bigint NOT NULL,
  `business` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abn` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suburb` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` mediumint UNSIGNED NOT NULL,
  `phone` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vti` int UNSIGNED NOT NULL,
  `sti` int UNSIGNED NOT NULL,
  `dateFormat` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_check` int NOT NULL,
  `email_interval` int NOT NULL,
  `email_signature` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `storemessages` int NOT NULL,
  `message_check_interval` int NOT NULL,
  `chatAutoRemove` int NOT NULL,
  `messengerFBCode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `messengerFBColor` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `messengerFBGreeting` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderPayti` int UNSIGNED NOT NULL,
  `orderEmailSubject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderEmailLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderEmailNotes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orderEmailReadNotification` tinyint(1) NOT NULL,
  `austPostAPIKey` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gst` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberLimit` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberLimitSilver` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberLimitBronze` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberLimitGold` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `memberLimitPlatinum` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wholesaleLimit` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wholesaleLimitSilver` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wholesaleLimitBronze` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wholesaleLimitGold` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wholesaleLimitPlatinum` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `wholesaleTime` int NOT NULL,
  `wholesaleTimeSilver` int NOT NULL,
  `wholesaleTimeBronze` int NOT NULL,
  `wholesaleTimeGold` int NOT NULL,
  `wholesaleTimePlatinum` int NOT NULL,
  `fomo` tinyint(1) NOT NULL,
  `fomoStyle` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoOptions` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoIn` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoOut` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoState` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoArea` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoFullname` tinyint(1) NOT NULL,
  `fomoPostcodeFrom` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoPostcodeTo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwordResetLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwordResetSubject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountActivationSubject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountActivationLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingNoteTemplate` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingEmailSubject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingEmailLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingEmailReadNotification` tinyint(1) NOT NULL,
  `bookingAutoReplySubject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingAutoReplyLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingAttachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingAgreement` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookingBuffer` int NOT NULL,
  `contactAutoReplySubject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactAutoReplyLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `newslettersEmbedImages` int NOT NULL,
  `newslettersSendMax` int NOT NULL,
  `newslettersSendDelay` int NOT NULL,
  `newslettersOptOutLayout` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankAccountName` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankAccountNumber` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bankBSB` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payPalClientID` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payPalSecret` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_publishkey` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_secretkey` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `defaultOrder` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'old',
  `showItems` int NOT NULL,
  `searchItems` int NOT NULL,
  `idleTime` int NOT NULL,
  `ga_clientID` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ga_tracking` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ga_tagmanager` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ga_verification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gd_api` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reCaptchaClient` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reCaptchaServer` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_msvalidate` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_yandexverification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_alexaverification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_domainverify` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_pinterestverify` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mapapikey` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_region` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_placename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_position` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `geo_weatherAPI` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `php_options` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `php_APIkey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `php_honeypot` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `php_quicklink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `formMinTime` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `formMaxTime` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spamfilter` int NOT NULL,
  `notification_volume` int NOT NULL,
  `mediaOptions` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unsplash_appname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `unsplash_publickey` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `unsplash_secretkey` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediaMaxWidth` int NOT NULL,
  `mediaMaxHeight` int NOT NULL,
  `mediaMaxWidthThumb` int NOT NULL,
  `mediaMaxHeightThumb` int NOT NULL,
  `mediaQuality` int NOT NULL,
  `templateID` bigint NOT NULL,
  `templateQTY` int NOT NULL,
  `suggestions` int NOT NULL,
  `bti` int UNSIGNED NOT NULL,
  `backup_ti` int NOT NULL,
  `uti` int NOT NULL,
  `uti_freq` int NOT NULL,
  `update_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `navstat` int NOT NULL,
  `iconsColor` int NOT NULL,
  `a11yPosition` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `development`, `maintenance`, `comingsoon`, `hoster`, `hosterURL`, `options`, `forumOptions`, `inventoryFallbackStatus`, `defaultPage`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `saleHeadingvalentine`, `saleHeadingeaster`, `saleHeadingmothersday`, `saleHeadingfathersday`, `saleHeadingblackfriday`, `saleHeadinghalloween`, `saleHeadingsmallbusinessday`, `saleHeadingchristmas`, `saleHeadingEOFY`, `metaRobots`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `email_check`, `email_interval`, `email_signature`, `storemessages`, `message_check_interval`, `chatAutoRemove`, `messengerFBCode`, `messengerFBColor`, `messengerFBGreeting`, `language`, `timezone`, `orderPayti`, `orderEmailSubject`, `orderEmailLayout`, `orderEmailNotes`, `orderEmailReadNotification`, `austPostAPIKey`, `gst`, `memberLimit`, `memberLimitSilver`, `memberLimitBronze`, `memberLimitGold`, `memberLimitPlatinum`, `wholesaleLimit`, `wholesaleLimitSilver`, `wholesaleLimitBronze`, `wholesaleLimitGold`, `wholesaleLimitPlatinum`, `wholesaleTime`, `wholesaleTimeSilver`, `wholesaleTimeBronze`, `wholesaleTimeGold`, `wholesaleTimePlatinum`, `fomo`, `fomoStyle`, `fomoOptions`, `fomoIn`, `fomoOut`, `fomoState`, `fomoArea`, `fomoFullname`, `fomoPostcodeFrom`, `fomoPostcodeTo`, `passwordResetLayout`, `passwordResetSubject`, `accountActivationSubject`, `accountActivationLayout`, `bookingNoteTemplate`, `bookingEmailSubject`, `bookingEmailLayout`, `bookingEmailReadNotification`, `bookingAutoReplySubject`, `bookingAutoReplyLayout`, `bookingAttachment`, `bookingAgreement`, `bookingBuffer`, `contactAutoReplySubject`, `contactAutoReplyLayout`, `newslettersEmbedImages`, `newslettersSendMax`, `newslettersSendDelay`, `newslettersOptOutLayout`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `payPalClientID`, `payPalSecret`, `stripe_publishkey`, `stripe_secretkey`, `defaultOrder`, `showItems`, `searchItems`, `idleTime`, `ga_clientID`, `ga_tracking`, `ga_tagmanager`, `ga_verification`, `gd_api`, `reCaptchaClient`, `reCaptchaServer`, `seo_msvalidate`, `seo_yandexverification`, `seo_alexaverification`, `seo_domainverify`, `seo_pinterestverify`, `mapapikey`, `geo_region`, `geo_placename`, `geo_position`, `geo_weatherAPI`, `php_options`, `php_APIkey`, `php_honeypot`, `php_quicklink`, `formMinTime`, `formMaxTime`, `spamfilter`, `notification_volume`, `mediaOptions`, `unsplash_appname`, `unsplash_publickey`, `unsplash_secretkey`, `mediaMaxWidth`, `mediaMaxHeight`, `mediaMaxWidthThumb`, `mediaMaxHeightThumb`, `mediaQuality`, `templateID`, `templateQTY`, `suggestions`, `bti`, `backup_ti`, `uti`, `uti_freq`, `update_url`, `navstat`, `iconsColor`, `a11yPosition`, `ti`) VALUES
(1, 0, 0, 0, 0, '', '11101110011100000001101010100101', '0000000000000000000000000000000', 'back order', 'dashboard', 'ljsequipment', '', '', '', 'Clippy', '', '', '', '', '', '', '', '', '', 'index,follow', '', '', '', '', 0, '', '', '', '', '', '', '', 0, '', '', '', 0, 3600, 'M jS, Y g:i A', 1425893894, 3600, '<p>Sent using <a href=\"https://github.com/DiemenDesign/AuroraCMS\">AuroraCMS</a> the Australian Open Source Content Management System.</p>', 1, 300, 0, '', '#5484ed', '', 'en-AU', 'Australia/Hobart', 1209600, 'Order {order_number}', '<p>Hi {first}!</p>\r\n<p>Thank you for your payment, and choosing to support {business}.</p>\r\n{downloads}\r\n{courses}\r\n<p>You can view your invoice here: {order_link}</p>\r\n<p>Regards,<br>\r\n{business}</p>\r\n<hr>\r\n', '', 1, '', '0', '0', '0', '0', '0', '0', '5', '5', '5', '5', '5', 0, 0, 0, 0, 0, 1, 'comic', '111111010000000', 'slide-in-blurred-left', 'slide-out-blurred-left', 'ACT', 'all', 1, '', '', '%3Cp%3EHi%20%7Bname%7D%2C%3C/p%3E%3Cp%3EA%20Password%20Reset%20was%20requested%2C%20it%20is%20now%3A%20%7Bpassword%7D%3C/p%3E%3Cp%3EWe%20recommend%20changing%20the%20above%20password%20after%20logging%20in.%3C/p%3E', 'Password Reset {business}.', 'Account Activation for {username} from {site}.', '<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>The username you signed up with was: {username}</p><p>The AutoGenerated password is: {password}</p><p><br></p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>', '<p>This is a test template</p><p>Backup:</p><p><input type=\"checkbox\"> Music</p><p><input type=\"checkbox\"> Software</p><p><input type=\"checkbox\"> Emails</p><p><br></p>', '{business} Booking Confirmation on {date}', '<p>Hi {first},</p>\r\n\r\n<p>{details}</p>\r\n\r\n<p>Please check the details above, and get in touch if any need correcting.</p>\r\n\r\n<p>Kind Regards,<br>\r\n\r\n{business}</p>\r\n\r\n\r\n\r\n', 0, '{business} Booking Confirmation on {date}', '<p>Hi {first},</p>\r\n\r\n<p>Thank you for contacting {business}, someone will get back to you ASAP.<br>Please note, this email is not a confirmed booking - we will contact you to confirm the time and date of your booking.</p>\r\n\r\n<p>{externalLink}</p>\r\n\r\n<p>Kind Regards,<br>\r\n\r\n{business}</p>', '', '<p>By clicking this checkbox and or signing below, you agree that we are not responsible for any data loss.</p>', 3600, '{business} Contact Confirmation on {date}', '<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>', 0, 50, 5, '<br>\r\n<br>\r\n<p style=\"font-size: 10px;text-align: center;\">If you don\'t wish to continue to receive these Newsletters you can <a href=\"{optOutLink}\">Unsubscribe</a>.</p>', 'Westpac', 'D & A Suitters', '0000 0000 0000', '000000', 'test', '', 'pk_test_51JC3eiEqAm9jcrHKP7oecRmQoIYC0SioG94Nd8kCeXOFPddqfP2QVXc6d7idZU0uxuKkl4RAp3yyEGGDsUfc8GQz00o1PDZ848', 'sk_test_51JC3eiEqAm9jcrHK3o0hVEsXTJUKbfFZ7cPCgEkGLY3bUuz7yR6jXs2Fc64OzoHuOx3ZfSvDMkW2JCoJ9Xiw3cOv004v2JjyE6', 'new', 10, 0, 30, '', '', '', '', 'AIzaSyD88WkGT3JFrVYo-qL5bKOyIpvvx5yIf_o', '', '', '', '', '', '', '', '', '', '', '-41.1833414399023,146.1616936326027', '', '1011111000000000', '', '', '', '5', '60', 1, 0, '1110000000000000', 'AuroraCMS', 'zrrPVIalmeHf_VbARqGhS3C-K1BsVQ0lpahz7kyQ2rk', 'OuSKyWVzCyZnkQJ8OAccOuNzWDqeQs4yiRxDK8UCUhc', 1280, 1280, 250, 250, 88, 0, 0, 0, 0, 1602516248, 0, 0, '', 1, 0, 'right bottom', 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` bigint UNSIGNED NOT NULL,
  `mid` bigint DEFAULT NULL,
  `options` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000000000000000',
  `rank` int DEFAULT '0',
  `rid` bigint UNSIGNED DEFAULT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `login_user` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid` bigint UNSIGNED DEFAULT NULL,
  `ip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contentType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `schemaType` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoKeywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fccid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `urlSlug` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_1` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_2` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_3` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_4` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exturl` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suburb` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` mediumint UNSIGNED NOT NULL,
  `phone` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fileALT` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `videoURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agreementCheck` int NOT NULL,
  `attributionImageTitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifISO` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifAperture` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifFocalLength` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifShutterSpeed` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifCamera` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifLens` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifFilename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifti` bigint NOT NULL,
  `rrp` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) DEFAULT '0.00',
  `rCost` decimal(10,2) NOT NULL,
  `dCost` decimal(10,2) NOT NULL,
  `expense` decimal(10,2) NOT NULL,
  `sold` bigint NOT NULL,
  `weight` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `weightunit` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `width` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `widthunit` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mm',
  `height` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heightunit` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mm',
  `length` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lengthunit` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mm',
  `subject` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` longblob NOT NULL,
  `notes2` longblob NOT NULL,
  `attributionContentName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionContentURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` mediumint UNSIGNED NOT NULL,
  `cartonQuantity` mediumint NOT NULL,
  `itemCondition` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metaRobots` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stockStatus` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` bigint UNSIGNED NOT NULL,
  `internal` tinyint UNSIGNED NOT NULL,
  `featured` tinyint UNSIGNED NOT NULL,
  `bookable` tinyint(1) NOT NULL,
  `fti` bigint UNSIGNED NOT NULL,
  `assoc` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint UNSIGNED NOT NULL,
  `views` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `rating` int NOT NULL,
  `attempts` int NOT NULL,
  `suggestions` int NOT NULL,
  `checklist` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000000000000000',
  `active` tinyint UNSIGNED NOT NULL,
  `coming` tinyint NOT NULL DEFAULT '0',
  `geo_position` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin` tinyint(1) NOT NULL,
  `price` tinyint(1) NOT NULL,
  `highlight` tinyint(1) NOT NULL,
  `highlighttext` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `priceord` bigint NOT NULL,
  `tis` bigint UNSIGNED NOT NULL,
  `tie` bigint UNSIGNED NOT NULL,
  `lti` bigint UNSIGNED NOT NULL,
  `ti` bigint UNSIGNED NOT NULL,
  `eti` bigint NOT NULL,
  `pti` bigint NOT NULL,
  `templatelist` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contentStats`
--

CREATE TABLE `contentStats` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `views` bigint NOT NULL,
  `sales` bigint NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courseTrack`
--

CREATE TABLE `courseTrack` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `complete` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `progress` int NOT NULL,
  `attempts` int NOT NULL,
  `score` int NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forumCategory`
--

CREATE TABLE `forumCategory` (
  `id` bigint NOT NULL,
  `rank` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_category` int NOT NULL,
  `ti` int NOT NULL,
  `pin` int NOT NULL,
  `help` int NOT NULL,
  `ord` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forumPosts`
--

CREATE TABLE `forumPosts` (
  `id` bigint NOT NULL,
  `rank` int NOT NULL,
  `cid` bigint NOT NULL,
  `tid` bigint NOT NULL,
  `pid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint NOT NULL,
  `vote` bigint NOT NULL,
  `pin` int NOT NULL,
  `help` int NOT NULL,
  `status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forumPostTrack`
--

CREATE TABLE `forumPostTrack` (
  `id` bigint NOT NULL,
  `cid` bigint NOT NULL,
  `tid` bigint NOT NULL,
  `pid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forumTopics`
--

CREATE TABLE `forumTopics` (
  `id` bigint NOT NULL,
  `rank` int NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `ti` int NOT NULL,
  `pin` int NOT NULL,
  `help` int NOT NULL,
  `ord` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forumVoteTrack`
--

CREATE TABLE `forumVoteTrack` (
  `id` bigint NOT NULL,
  `pid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iplist`
--

CREATE TABLE `iplist` (
  `id` bigint NOT NULL,
  `ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oti` int NOT NULL,
  `reason` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent` tinyint(1) NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livechat`
--

CREATE TABLE `livechat` (
  `id` bigint NOT NULL,
  `aid` bigint NOT NULL,
  `sid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `who` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phpChecked` int DEFAULT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint NOT NULL,
  `area` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` bigint UNSIGNED NOT NULL,
  `options` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00000000000000000000000000000000',
  `theme` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` tinyint(1) NOT NULL,
  `bio_options` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00000000000000000000000000000000',
  `username` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coverURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageTitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gravatar` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `www` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` int NOT NULL,
  `hash` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `emailPassword` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_check` int NOT NULL,
  `liveChatNotification` int NOT NULL,
  `email_signature` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suburb` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` mediumint UNSIGNED NOT NULL,
  `country` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abn` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoDescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume_notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint UNSIGNED NOT NULL,
  `helpResponder` tinyint(1) NOT NULL,
  `activate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `newsletter` int NOT NULL DEFAULT '0',
  `language` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int UNSIGNED NOT NULL,
  `discount` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spent` decimal(10,2) NOT NULL,
  `points` int NOT NULL,
  `purchaseLimit` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchaseTime` int NOT NULL,
  `infoHash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hostCost` decimal(8,2) NOT NULL,
  `siteCost` decimal(8,2) NOT NULL,
  `hostStatus` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siteStatus` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lti` int NOT NULL,
  `hti` int NOT NULL,
  `sti` int NOT NULL,
  `accountsContact` tinyint(1) NOT NULL,
  `userAgent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `userIP` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pti` int NOT NULL,
  `ord` bigint NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `username` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refTable` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `refColumn` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oldda` longblob,
  `newda` longblob NOT NULL,
  `action` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint NOT NULL,
  `rank` int DEFAULT '0',
  `pid` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `file` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumb` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileALT` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_1` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_2` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_3` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_4` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifISO` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifAperture` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifFocalLength` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifShutterSpeed` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifCamera` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifLens` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifFilename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exifti` int NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `views` bigint NOT NULL,
  `suggestions` int NOT NULL,
  `ord` bigint NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint UNSIGNED NOT NULL,
  `rank` int DEFAULT NULL,
  `mid` bigint NOT NULL DEFAULT '0',
  `uid` bigint NOT NULL,
  `options` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00000000',
  `login_user` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heading` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metaRobots` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileALT` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coverURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coverVideo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sliderOptions` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000000000000000',
  `sliderDirection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sliderEffect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sliderSpeed` int NOT NULL DEFAULT '300',
  `sliderAutoplayDelay` int NOT NULL DEFAULT '3000',
  `attributionImageTitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contentType` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `schemaType` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoKeywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint UNSIGNED NOT NULL,
  `checklist` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000000000000000',
  `active` tinyint UNSIGNED NOT NULL,
  `views` bigint NOT NULL,
  `suggestions` int NOT NULL,
  `tie` int NOT NULL,
  `eti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `rank`, `mid`, `uid`, `options`, `login_user`, `title`, `heading`, `seoTitle`, `metaRobots`, `url`, `file`, `fileALT`, `cover`, `coverURL`, `coverVideo`, `sliderOptions`, `sliderDirection`, `sliderEffect`, `sliderSpeed`, `sliderAutoplayDelay`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `checklist`, `active`, `views`, `suggestions`, `tie`, `eti`) VALUES
(1, 0, 0, 1, '00000000', 'Dennis Suitters', 'Home', '', '', '', '', 'index', '', 'http://localhost/AuroraCMS2/media/242113223-176711991250732-2533274213801360706-n.jpg', '', '', '0111110000000000', 'horizontal', 'fade', 300, 3000, '', '', '', 'index', '', 'wood,turning,woodturned,timber,open,source,photography,digital,artwork,websit,design,development', '', '', 'head', '', 0, '0000000000000000', 1, 0, 0, 0, 1694780941),
(2, 0, 0, 1, '00000000', 'Dennis Suitters', 'Blog', '', '', '', '', 'article', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'article', '', '', '', '', 'head', '', 6, '0000000000000000', 1, 0, 0, 0, 1694591276),
(3, 0, 0, 1, '00000000', 'Dennis Suitters', 'Portfolio', '', '', '', '', 'portfolio', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'portfolio', '', '', '', '', 'head', '', 11, '0000000000000000', 1, 0, 0, 0, 1692194659),
(4, 0, 0, 1, '00000000', 'Dennis Suitters', 'Bookings', '', '', '', '', 'bookings', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'bookings', '', '', '', '', 'head', '', 4, '0000000000000000', 1, 0, 0, 0, 1692197329),
(5, 0, 0, 1, '00000000', 'Dennis Suitters', 'Events', '', '', '', '', 'events', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'events', '', '', '', '', 'head', '', 12, '0000000000000000', 1, 0, 0, 0, 1692194660),
(6, 0, 0, 1, '00000000', 'Dennis Suitters', 'News', '', '', 'index,follow', '', 'news', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'news', '', '', '', '', 'head', '', 14, '0000000000000000', 1, 0, 0, 0, 1692194662),
(7, 0, 0, 1, '00000000', 'Dennis Suitters', 'Testimonials', '', '', '', '', 'testimonials', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'testimonials', '', '', '', '', 'head', '', 7, '0000000000000000', 1, 0, 0, 0, 1692197494),
(8, 0, 0, 1, '00000000', 'Dennis Suitters', 'Products', '', '', '', '', 'inventory', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'inventory', '', '', '', '', 'head', '', 10, '0000000000000000', 1, 0, 0, 0, 1694527828),
(9, 0, 0, 1, '11000000', 'Dennis Suitters', 'Services', '', '', '', '', 'services', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'service', '', '', '', '', 'head', '', 9, '0000000000000000', 1, 0, 0, 0, 1692194655),
(10, 0, 0, 1, '00000000', 'Dennis Suitters', 'Gallery', '', '', '', '', 'gallery', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'gallery', '', '', '', '', 'head', '', 13, '0000000000000000', 1, 0, 0, 0, 1692197717),
(11, 0, 0, 1, '00000000', 'Dennis Suitters', 'Contact', '', '', '', '', 'contactus', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'contactus', '', '', '', '', 'head', '', 8, '0000000000000000', 1, 0, 0, 0, 1694089555),
(12, 0, 0, 1, '00000000', 'Dennis Suitters', 'Cart', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'cart', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'cart', '', '', '', '', 'head', '', 15, '0000000000000000', 1, 0, 0, 0, 1692197779),
(13, 0, 0, 1, '00000000', 'Dennis Suitters', 'Terms of Service', 'Terms of Service', '', '', '', 'page', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'page', '', '', '', '', 'footer', '<p>Please read these Terms of Service (\"Terms\", \"Terms of Service\") carefully before using the {url} website (the \"Service\") operated by {business} (\"us\", \"we\", or \"our\").</p>\r\n<p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>\r\n<p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>\r\n<h2>Accounts</h2>\r\n<p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>\r\n<p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>\r\n<p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>\r\n<h2>Links To Other Web Sites</h2>\r\n<p>Our Service may contain links to third-party web sites or services that are not owned or controlled by {business}.</p>\r\n<p>{business} has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that {business} shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>\r\n<p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>\r\n<h2>Termination</h2>\r\n<p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<h2>Governing Law</h2>\r\n<p>These Terms shall be governed and construed in accordance with the laws of Tasmania, Australia, without regard to its conflict of law provisions.</p>\r\n<p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>\r\n<h2>Changes</h2>\r\n<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>\r\n<p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>\r\n', 22, '0000000000000000', 1, 0, 0, 0, 1692197972),
(14, 0, 0, 1, '00000000', 'Dennis Suitters', 'Search', '', '', '', '', 'search', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'search', '', '', '', '', 'other', '', 29, '0000000000000000', 1, 0, 0, 0, 1692198224),
(15, 0, 0, 1, '00000000', 'Dennis Suitters', 'About', '', '', '', '', 'aboutus', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'aboutus', '', '', '', '', 'head', '', 1, '0000000000000000', 1, 0, 0, 0, 1694187821),
(16, 300, 0, 1, '00000000', 'Dennis Suitters', 'Proofs', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'proofs', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'proofs', '', '', '', '', 'account', '', 26, '0000000000000000', 1, 0, 0, 0, 1692198130),
(17, 0, 0, 1, '00000000', 'Dennis Suitters', 'Newsletters', '', '', '', '', 'newsletters', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'newsletters', '', '', '', '', 'head', '', 18, '0000000000000000', 1, 0, 0, 0, 1692194668),
(19, 0, 0, 1, '00000000', 'Dennis Suitters', 'Distributors', '', '', '', '', 'distributors', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'distributors', '', '', '', '', 'footer', '', 19, '0000000000000000', 1, 0, 0, 0, 1692197879),
(20, 0, 0, 1, '00000000', 'Dennis Suitters', 'Privacy Policy', 'Privacy Policy', '', '', '', 'page', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'page', 'Article', '', '', '', 'footer', '<p>{business} (\"us\", \"we\", or \"our\") operates the {url} website (hereinafter referred to as the \"Service\").</p>\r\n<p>This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.</p>\r\n<p>We use your data to provide and improve the Service. By using the Service, you agree to the collection and use of information in accordance with this policy.</p>\r\n<h2>Definitions</h2>\r\n<ul>\r\n <li>\r\n  <p><strong>Service</strong></p>\r\n  <p>Service is the {url} website operated by {business}</p>\r\n </li>\r\n <li>\r\n  <p><strong>Personal Data</strong></p>\r\n  <p>Personal Data means data about a living individual who can be identified from those data (or from those and other information either in our possession or likely to come into our possession).</p>\r\n </li>\r\n <li>\r\n  <p><strong>Usage Data</strong></p>\r\n  <p>Usage Data is data collected automatically either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>\r\n </li>\r\n <li>\r\n  <p><strong>Cookies</strong></p>\r\n  <p>Cookies are small files stored on your device (computer or mobile device).</p>\r\n </li>\r\n</ul>\r\n<h2>Information Collection and Use</h2>\r\n<p>We collect several different types of information for various purposes to provide and improve our Service to you.</p>\r\n<h3>Types of Data Collected</h3>\r\n<h4>Personal Data</h4>\r\n<p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you (\"Personal Data\"). Personally identifiable information may include, but is not limited to:</p>\r\n<ul>\r\n <li>Email address</li>\r\n <li>First name and last name</li>\r\n <li>Phone number</li>\r\n <li>Address, State, Province, ZIP/Postal code, City</li>\r\n <li>Cookies and Usage Data</li>\r\n</ul>\r\n<h4>Usage Data</h4>\r\n<p>We may also collect information how the Service is accessed and used (\"Usage Data\"). This Usage Data may include information such as your computer\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>\r\n<h4>Tracking &amp; Cookies Data</h4>\r\n<p>We use cookies and similar tracking technologies to track the activity on our Service and we hold certain information.</p>\r\n<p>Cookies are files with a small amount of data which may include an anonymous unique identifier. Cookies are sent to your browser from a website and stored on your device. Other tracking technologies are also used such as beacons, tags and scripts to collect and track information and to improve and analyse our Service.</p>\r\n<p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.</p>\r\n<p>Examples of Cookies we use:</p>\r\n<ul>\r\n <li><strong>Session Cookies.</strong> We use Session Cookies to operate our Service.</li>\r\n <li><strong>Preference Cookies.</strong> We use Preference Cookies to remember your preferences and various settings.</li>\r\n <li><strong>Security Cookies.</strong> We use Security Cookies for security purposes.</li>\r\n</ul>\r\n<h2>Use of Data</h2>\r\n<p>Diemen Design uses the collected data for various purposes:</p>    \r\n<ul>\r\n <li>To provide and maintain the Service</li>\r\n <li>To notify you about changes to our Service</li>\r\n <li>To allow you to participate in interactive features of our Service when you choose to do so</li>\r\n <li>To provide customer care and support</li>\r\n <li>To provide analysis or valuable information so that we can improve the Service</li>\r\n <li>To monitor the usage of the Service</li>\r\n <li>To detect, prevent and address technical issues</li>\r\n</ul>\r\n<h2>Transfer Of Data</h2>\r\n<p>Your information, including Personal Data, may be transferred to, and maintained on computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>\r\n<p>If you are located outside Australia and choose to provide information to us, please note that we transfer the data, including Personal Data, to Australia and process it there.</p>\r\n<p>Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.</p>\r\n<p>{business} will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this Privacy Policy and no transfer of your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of your data and other personal information.</p>\r\n<h2>Disclosure Of Data</h2>\r\n<h3>Legal Requirements</h3>\r\n<p>Diemen Design may disclose your Personal Data in the good faith belief that such action is necessary to:</p>\r\n<ul>\r\n <li>To comply with a legal obligation</li>\r\n <li>To protect and defend the rights or property of Diemen Design</li>\r\n <li>To prevent or investigate possible wrongdoing in connection with the Service</li>\r\n <li>To protect the personal safety of users of the Service or the public</li>\r\n <li>To protect against legal liability</li>\r\n</ul>\r\n<p>As an European citizen, under GDPR, you have certain individual rights. You can learn more about these guides in the <a href=\"https://termsfeed.com/blog/gdpr/#Individual_Rights_Under_the_GDPR\">GDPR Guide</a>.</p>\r\n<h2>Security of Data</h2>\r\n<p>The security of your data is important to us but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.</p>\r\n<h2>Service Providers</h2>\r\n<p>We may employ third party companies and individuals to facilitate our Service (\"Service Providers\"), to provide the Service on our behalf, to perform Service-related services or to assist us in analyzing how our Service is used.</p>\r\n<p>These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.</p>\r\n<h2>Links to Other Sites</h2>\r\n<p>Our Service may contain links to other sites that are not operated by us. If you click a third party link, you will be directed to that third party\'s site. We strongly advise you to review the Privacy Policy of every site you visit.</p>\r\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>\r\n<h2>Children\'s Privacy</h2>\r\n<p>Our Service does not address anyone under the age of 18 (\"Children\").</p>\r\n<p>We do not knowingly collect personally identifiable information from anyone under the age of 18. If you are a parent or guardian and you are aware that your Child has provided us with Personal Data, please contact us. If we become aware that we have collected Personal Data from children without verification of parental consent, we take steps to remove that information from our servers.</p>\r\n<h2>Changes to This Privacy Policy</h2>\r\n<p>We may update our Privacy Policy from time to time.</p>\r\n<p>Changes will appear on this URL.</p>\r\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>\r\n', 21, '0000000000000000', 1, 0, 0, 0, 1692194673),
(21, 0, 0, 1, '00000000', 'Dennis Suitters', 'Login', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'login', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'login', '', '', '', '', 'other', '', 28, '0000000000000000', 1, 0, 0, 0, 1694089563),
(22, 0, 0, 1, '00000000', 'Dennis Suitters', 'Sitemap', '', '', '', '', 'sitemap', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'sitemap', '', '', '', '', 'footer', '', 20, '0000000000000000', 1, 0, 0, 0, 1692197921),
(23, 0, 0, 1, '00000000', 'Dennis Suitters', 'Coming Soon', 'Coming Soon title', '', '', '', 'comingsoon', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'comingsoon', '', '', '', '', 'none', '', 23, '0000000000000000', 1, 0, 0, 0, 1692198327),
(24, 0, 0, 1, '00000000', 'Dennis Suitters', 'Maintenance', 'Maintenance', '', '', '', 'maintenance', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'maintenance', '', '', '', '', 'none', '<p>We are currently doing Maintenance.</p>', 24, '0000000000000000', 1, 0, 0, 0, 1692198347),
(25, 0, 0, 1, '00000000', 'Dennis Suitters', 'FAQ', '', NULL, '', '', 'faq', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'faq', '', '', '', '', 'footer', '', 23, '0000000000000000', 1, 0, 0, 0, 1692198011),
(26, 0, 0, 1, '00000000', 'Dennis Suitters', 'Forum', '', NULL, '', '', 'forum', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'forum', 'Forum', '', '', '', 'head', '', 17, '0000000000000000', 1, 0, 0, 0, 1692194667),
(27, 300, 0, 1, '00000000', 'Dennis Suitters', 'Orders', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'orders', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'orders', '', '', '', '', 'account', '', 25, '0000000000000000', 1, 0, 0, 0, 1694527833),
(29, 300, 0, 1, '00000000', 'Dennis Suitters', 'Settings', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'settings', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'settings', '', '', '', '', 'account', '', 27, '0000000000000000', 1, 0, 0, 0, 1692198168),
(30, 0, 0, 1, '00000000', 'Dennis Suitters', 'Checkout', 'Payment Options', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'checkout', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'checkout', '', '', '', '', 'other', '<p>To ensure our user\'s privacy, we don\'t store Credit Card details,<br>only the chosen Payment Method, Name, Email and Date of Payment.</p>', 30, '0000000000000000', 1, 0, 0, 0, 1692198270),
(31, 0, 0, 1, '00000000', 'Dennis Suitters', 'Offline', '', 'Offline', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'offline', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'offline', '', '', '', '', 'none', '', 31, '0000000000000000', 1, 0, 0, 0, 1692198368),
(41, 0, 0, 1, '00000000', 'Dennis Suitters', 'Biography', '', '', '', '', 'biography', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'biography', '', '', '', '', 'head', '', 5, '0000000000000000', 1, 0, 0, 0, 1692197397),
(42, 0, 0, 1, '00000000', 'Dennis Suitters', 'Activation', '', NULL, 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'activate', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'activate', 'Page', '', '', '', 'none', '<p>Please login with the credentials emailed to you when signing up, and update your address details, thank you.</p>', 27, '0000000000000000', 1, 0, 0, 0, 1692194689),
(43, 0, 0, 1, '00000000', 'Dennis Suitters', 'Activities', '', '', '', '', 'activities', 'green and yellow tractor in garage', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'activities', '', '', '', '', 'head', '', 0, '0000000000000000', 1, 0, 0, 0, 1694176832),
(44, 0, 0, 1, '00000000', 'Dennis Suitters', 'Courses', '', NULL, '', '', 'content', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'course', 'Course', '', '', '', 'head', '', 16, '0000000000000000', 1, 0, 0, 0, 1692194666),
(45, 300, 0, 1, '00000000', 'Dennis Suitters', 'Courses', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'courses', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'courses', '', '', '', '', 'account', '', 24, '0000000000000000', 1, 0, 0, 0, 1692198064),
(50, 0, 0, 1, '00000000', 'Dennis Suitters', 'Pricing', '', '', '', '', 'pricing', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'pricing', '', '', '', '', 'head', '', 1, '0000000000000000', 1, 0, 0, 0, 1694186867);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mid` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rmid` bigint NOT NULL,
  `folder` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_business` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_phone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_mobile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_suburb` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_postcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `starred` int NOT NULL,
  `important` int NOT NULL,
  `notes_raw` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notes_raw_mime` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes_html` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes_html_mime` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachments` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_date` int NOT NULL,
  `size` bigint NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moduleQuestions`
--

CREATE TABLE `moduleQuestions` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_answer` int NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moduleQuestionsTrack`
--

CREATE TABLE `moduleQuestionsTrack` (
  `id` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `cid` bigint NOT NULL,
  `mid` bigint NOT NULL,
  `qid` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint NOT NULL,
  `tti` int NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` bigint NOT NULL,
  `oid` bigint UNSIGNED NOT NULL,
  `iid` bigint UNSIGNED NOT NULL,
  `cid` bigint NOT NULL,
  `contentType` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` mediumint UNSIGNED NOT NULL,
  `cost` decimal(10,2) UNSIGNED NOT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint NOT NULL,
  `cid` bigint UNSIGNED NOT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qid_ti` bigint UNSIGNED NOT NULL,
  `iid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `iid_ti` bigint UNSIGNED NOT NULL,
  `did` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `did_ti` bigint UNSIGNED NOT NULL,
  `aid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aid_ti` bigint UNSIGNED NOT NULL,
  `due_ti` bigint UNSIGNED NOT NULL,
  `rid` bigint NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postageCode` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postageOption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postageCost` decimal(6,2) NOT NULL,
  `payOption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payMethod` int NOT NULL,
  `payCost` decimal(6,2) NOT NULL,
  `trackOption` bigint NOT NULL,
  `trackNumber` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recurring` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `points` int NOT NULL,
  `paid_via` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `txn_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_amount` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_ti` int NOT NULL,
  `payment_status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` bigint UNSIGNED NOT NULL,
  `eti` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `width` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_width` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail_height` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `html` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `embed_url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint NOT NULL,
  `active` tinyint(1) NOT NULL,
  `dt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint NOT NULL,
  `code` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` int NOT NULL,
  `value` int NOT NULL,
  `quantity` int NOT NULL,
  `tis` int NOT NULL,
  `tie` int NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sidebar`
--

CREATE TABLE `sidebar` (
  `id` bigint NOT NULL,
  `rank` int NOT NULL,
  `mid` bigint NOT NULL,
  `contentType` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sidebar`
--

INSERT INTO `sidebar` (`id`, `rank`, `mid`, `contentType`, `view`, `icon`, `title`, `ord`, `active`) VALUES
(1, 400, 0, 'dashboard', 'dashboard', 'dashboard', 'Dashboard', 0, 1),
(2, 400, 0, 'livechat', 'livechat', 'chat', 'Livechat', 14, 1),
(3, 400, 0, 'dropdown', 'content', 'content', 'Content', 5, 1),
(4, 400, 3, 'media', 'media', 'picture', 'Media', 12, 1),
(5, 400, 0, 'pages', 'pages', 'content', 'Pages', 4, 1),
(6, 400, 3, 'faq', 'faq', 'faq', 'FAQ', 4, 1),
(7, 400, 3, 'scheduler', 'content', 'calendar-time', 'Scheduler', 11, 1),
(8, 400, 3, 'article', 'content', 'content', 'Articles', 0, 1),
(9, 400, 3, 'portfolio', 'content', 'portfolio', 'Portfolio', 7, 1),
(10, 400, 3, 'events', 'content', 'calendar', 'Events', 5, 1),
(11, 400, 3, 'news', 'content', 'email-read', 'News', 6, 1),
(12, 400, 3, 'testimonials', 'content', 'testimonial', 'Testimonials', 8, 1),
(13, 400, 3, 'inventory', 'content', 'shipping', 'Inventory', 1, 1),
(14, 400, 3, 'rewards', 'rewards', 'credit-card', 'Rewards', 10, 1),
(15, 400, 3, 'service', 'content', 'service', 'Services', 3, 1),
(16, 400, 3, 'proofs', 'content', 'proof', 'Proofs', 9, 1),
(17, 400, 0, 'messages', 'messages', 'inbox', 'Messages', 1, 1),
(18, 400, 0, 'forum', 'forum', 'forum', 'Forum', 9, 1),
(19, 400, 0, 'newsletters', 'newsletters', 'newspaper', 'Newsletters', 13, 1),
(20, 400, 0, 'bookings', 'bookings', 'calendar', 'Bookings', 10, 1),
(21, 400, 0, 'dropdown', 'orders', 'order', 'Orders', 6, 1),
(22, 400, 21, 'all', 'orders', 'order-quote', 'All', 0, 1),
(23, 400, 21, 'quotes', 'orders', 'order-quote', 'Quotes', 1, 1),
(24, 400, 21, 'invoices', 'orders', 'order-invoice', 'Invoices', 2, 1),
(25, 400, 21, 'pending', 'orders', 'order-pending', 'Pending', 3, 1),
(26, 400, 21, 'recurring', 'orders', 'order-recurring', 'Recurring', 4, 1),
(27, 400, 21, 'orderdue', 'orders', 'order-pending', 'Overdue', 5, 1),
(28, 400, 21, 'archived', 'orders', 'order-archived', 'Archived', 6, 1),
(29, 400, 0, 'accounts', 'accounts', 'users', 'Accounts', 3, 1),
(30, 400, 0, 'comments', 'comments', 'comments', 'Comments', 11, 1),
(31, 400, 0, 'reviews', 'reviews', 'review', 'Reviews', 12, 1),
(32, 400, 0, 'dropdown', 'settings', 'settings', 'Settings', 16, 1),
(33, 400, 32, 'livechat', 'settings', 'chat', 'Livechat', 8, 1),
(34, 400, 32, 'media', 'settings', 'picture', 'Media', 1, 1),
(35, 400, 32, 'pages', 'settings', 'content', 'Pages', 3, 1),
(36, 400, 32, 'content', 'settings', 'content', 'Content', 2, 1),
(37, 400, 32, 'forum', 'settings', 'forum', 'Forum', 5, 1),
(38, 400, 32, 'messages', 'settings', 'inbox', 'Messages', 7, 1),
(39, 400, 32, 'newsletters', 'settings', 'newspaper', 'Newsletters', 6, 1),
(40, 400, 32, 'bookings', 'settings', 'calendar', 'Bookings', 4, 1),
(41, 400, 32, 'orders', 'settings', 'order', 'Orders', 9, 1),
(42, 400, 32, 'accounts', 'settings', 'users', 'Accounts', 0, 1),
(43, 400, 0, 'dropdown', 'preferences', 'settings', 'Preferences', 15, 1),
(44, 400, 43, 'theme', 'preferences', 'theme', 'Theme', 2, 1),
(45, 400, 43, 'contact', 'preferences', 'address-card', 'Contact', 3, 1),
(46, 400, 43, 'social', 'preferences', 'user-group', 'Social', 4, 1),
(47, 400, 43, 'interface', 'preferences', 'sliders', 'Interface', 0, 1),
(48, 400, 43, 'seo', 'preferences', 'plugin-seo', 'SEO', 5, 1),
(49, 400, 43, 'activity', 'preferences', 'activity', 'Activity', 8, 1),
(50, 400, 43, 'tracker', 'preferences', 'tracker', 'Tracker', 10, 1),
(51, 400, 43, 'cart', 'preferences', 'shop-cart', 'Cart', 6, 1),
(52, 400, 43, 'database', 'preferences', 'database', 'Database', 11, 1),
(54, 400, 43, 'security', 'preferences', 'security', 'Security', 9, 1),
(55, 1000, 0, 'payments', 'payments', 'hosting', 'Payments', 18, 1),
(56, 400, 0, 'notification', 'notification', 'notification', 'Notifications', 17, 1),
(57, 400, 0, 'joblist', 'joblist', 'joblist', 'Job List', 19, 1),
(58, 900, 0, 'templates', 'templates', 'templates', 'Templates', 20, 1),
(59, 400, 43, 'a11y', 'preferences', 'a11y', 'Accessibility', 1, 1),
(60, 400, 3, 'activities', 'content', 'activities', 'Activities', 2, 1),
(61, 400, 0, 'course', 'course', 'education-cap', 'Courses', 8, 1),
(62, 400, 0, 'adverts', 'adverts', 'blocks', 'Adverts', 7, 1),
(63, 400, 0, 'agronomy', 'agronomy', 'agronomy', 'Agronomy', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `t` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `c` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `popup` int NOT NULL,
  `seen` int NOT NULL,
  `sti` int NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint NOT NULL,
  `contentType` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `html` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `contentType`, `section`, `title`, `html`, `notes`, `image`) VALUES
(1, 'all', 'card', 'Card', '<article class=\"card col-11 col-sm-5 col-lg-2-5\">\n<div class=\"card-footer pt-3\">\n<a class=\"btn\" href=\"<print content=linktitle>\">View</a><br>\n<quickview>\n<a class=\"btn\" data-fancybox data-type=\"ajax\" data-src=\"core/quickview.php?id=<print content=id>\" href=\"javascript:;\">Quick View</a>\n</quickview>\n</div>\n<div class=\"card-header\">\n<div class=\"h5 mt-3 d-block\"><a href=\"<print content=linktitle>\"><print content=\"title\"></a></div>\n</div>\n<figure class=\"card-image\">\n<a href=\"<print content=linktitle>\">\n<img <print content=srcset>src=\"<print content=thumb>\" loading=\"lazy\" alt=\"<print content=imageALT>\">\n</a>\n</figure>\n<div class=\"corner-ribbon small bottom-right\"><print content=\"contentType\"></div>\n<div class=\"corner-ribbon big bottom-right <print content=quantitycolor>\"><print content=\"quantity\"></div>\n<div class=\"corner-ribbon big bottom-left <print content=cssrank>\"><print content=\"rank\"></div>\n</article>', 'Single Item Card, width is determined by the CSS Styling set by the theme.', '<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 260 180\" fill=\"none\">\n<rect x=\"60\" y=\"15\" width=\"140\" height=\"150\" rx=\"4\" fill=\"var(--color-contrast-lower)\"></rect>\n<rect x=\"73\" y=\"48\" width=\"106\" height=\"6\" fill=\"var(--color-contrast-low)\"></rect>\n<rect x=\"73\" y=\"62\" width=\"48\" height=\"6\" fill=\"var(--color-primary)\"></rect>\n<rect x=\"73\" y=\"30\" width=\"82\" height=\"10\" fill=\"var(--color-contrast-high)\"></rect>\n<path d=\"M73 81H187V151H73V81Z\" fill=\"var(--color-bg)\"></path>\n<path d=\"M110.364 107.727C114.43 107.727 117.727 104.43 117.727 100.364C117.727 96.2968 114.43 93 110.364 93C106.297 93 103 96.2968 103 100.364C103 104.43 106.297 107.727 110.364 107.727Z\" fill=\"var(--color-contrast-medium)\"></path>\n<path d=\"M103 138.409L136.136 104.045L157 138.409H103Z\" fill=\"var(--color-contrast-medium)\"></path>\n</svg>'),
(3, 'all', 'card', 'Card v2', '<article class=\"card col-11 col-sm-5 col-lg-2-5 p-0\">\n<figure class=\"card-image fullheight m-0 p-0\">\n<a href=\"<print content=linktitle>\">\n<img <print content=srcset>src=\"<print content=image>\" loading=\"lazy\" alt=\"<print content=imageALT>\">\n</a>\n<figcaption class=\"card-figcaption p-3 m-0\">\n<div class=\"card-figtitle\"><print content=\"title\"></div>\n</figcaption>\n</figure>\n</article>', 'Single Item Card V2, width is determined by the CSS Styling set by the theme.', '<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 260 180\" fill=\"none\">\r\n<rect x=\"64\" y=\"15\" width=\"132\" height=\"150\" rx=\"4\" fill=\"var(--color-contrast-medium)\"></rect>\r\n<path d=\"M64 114H196V161C196 163.209 194.209 165 192 165H68C65.7909 165 64 163.209 64 161V114Z\" fill=\"black\" fill-opacity=\"0.47\"></path>\r\n<path d=\"M97 93L139 51L164 93H97Z\" fill=\"var(--color-contrast-high)\"></path>\r\n<path d=\"M105.144 59C109.562 59 113.144 55.4183 113.144 51C113.144 46.5817 109.562 43 105.144 43C100.725 43 97.1436 46.5817 97.1436 51C97.1436 55.4183 100.725 59 105.144 59Z\" fill=\"var(--color-contrast-high)\"></path>\r\n<rect opacity=\"0.596\" x=\"106\" y=\"147\" width=\"48\" height=\"6\" fill=\"white\"></rect>\r\n<rect x=\"89\" y=\"129\" width=\"82\" height=\"10\" fill=\"white\"></rect>\r\n</svg>'),
(4, 'all', 'card', 'Card Half Width', '<article class=\"card col-11 col-sm-5 mx-auto\">\r\n<figure class=\"card-image\">\r\n<a href=\"<print content=linktitle>\">\r\n<img <print content=srcset>src=\"<print content=thumb>\" loading=\"lazy\" alt=\"<print content=imageALT>\">\r\n</a>\r\n</figure>\r\n<div class=\"card-header h4\"><a href=\"<print content=linktitle>\" title=\"<print content=title>\"><print content=\"title\"></a></div>\r\n<div class=\"corner-ribbon small top-right\"><print content=\"cost\"></div>\r\n<div class=\"corner-ribbon big top-right <print content=quantitycolor>\"><print content=\"quantity\"></div>\r\n<div class=\"corner-ribbon big top-left <print content=cssrank>\"><print content=\"rank\"></div>\r\n<div class=\"card-body\">\r\n<print content=\"notes\">\r\n</div>\r\n<div class=\"card-footer\">\r\n<a class=\"btn\" href=\"<print content=linktitle>\">View</a>\r\n<quickview>\r\n<a class=\"btn\" data-fancybox data-type=\"ajax\" data-src=\"core/quickview.php?id=<print content=id>\" href=\"javascript:;\">Quick View</a>\r\n</quickview>\r\n</div>\r\n</article>', 'Card that takes up Half area width on laptop and desktop width screens and full width on mobile devices.', '<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 260 180\" fill=\"none\">\n<rect width=\"260\" height=\"180\" fill=\"var(--color-bg)\"></rect>\n<rect x=\"64\" y=\"15\" width=\"132\" height=\"150\" rx=\"4\" fill=\"var(--color-contrast-lower)\"></rect>\n<path d=\"M65 20C65 17.7909 66.7909 16 69 16H191C193.209 16 195 17.7909 195 20V96H65V20Z\" fill=\"var(--color-contrast-high)\"></path>\n<path d=\"M97 81L139 39L164 81H97Z\" fill=\"var(--color-contrast-medium)\"></path>\n<path d=\"M105.144 47C109.562 47 113.144 43.4183 113.144 39C113.144 34.5817 109.562 31 105.144 31C100.725 31 97.1436 34.5817 97.1436 39C97.1436 43.4183 100.725 47 105.144 47Z\" fill=\"var(--color-contrast-medium)\"></path>\n<rect x=\"77\" y=\"128\" width=\"106\" height=\"6\" fill=\"var(--color-contrast-low)\"></rect>\n<rect x=\"77\" y=\"144\" width=\"48\" height=\"6\" fill=\"var(--color-contrast-low)\"></rect>\n<rect x=\"77\" y=\"108\" width=\"82\" height=\"10\" fill=\"var(--color-contrast-high)\"></rect>\n</svg>'),
(5, 'all', 'card', 'Card Full Width', '<article class=\"card col-11 mx-auto\">\n<figure class=\"card-image\">\n<a href=\"<print content=linktitle>\">\n<img <print content=srcset>src=\"<print content=thumb>\" loading=\"lazy\" alt=\"<print content=imageALT>\">\n</a>\n</figure>\n<div class=\"card-header h4\"><a href=\"<print content=linktitle>\" title=\"<print content=title>\"><print content=\"title\"></a></div>\n<div class=\"corner-ribbon small top-right\"><print content=\"cost\"></div>\n<div class=\"corner-ribbon big top-right <print content=quantitycolor>\"><print content=\"quantity\"></div>\n<div class=\"corner-ribbon big top-left <print content=cssrank>\"><print content=\"rank\"></div>\n<div class=\"card-body\">\n<print content=\"notes\">\n</div>\n<div class=\"card-footer\">\n<a class=\"btn\" href=\"<print content=linktitle>\">View</a>\n<quickview>\n<a class=\"btn\" data-fancybox data-type=\"ajax\" data-src=\"core/quickview.php?id=<print content=id>\" href=\"javascript:;\">Quick View</a>\n</quickview>\n</div>\n</article>', 'Card that takes up Full area width on laptop and desktop width screens and full width on mobile devices.', '<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 260 180\" fill=\"none\">\r\n<rect width=\"260\" height=\"180\" fill=\"var(--color-bg)\"></rect>\r\n<rect x=\"64\" y=\"15\" width=\"132\" height=\"150\" rx=\"4\" fill=\"var(--color-contrast-lower)\"></rect>\r\n<path d=\"M65 20C65 17.7909 66.7909 16 69 16H191C193.209 16 195 17.7909 195 20V96H65V20Z\" fill=\"var(--color-contrast-high)\"></path>\r\n<path d=\"M97 81L139 39L164 81H97Z\" fill=\"var(--color-contrast-medium)\"></path>\r\n<path d=\"M105.144 47C109.562 47 113.144 43.4183 113.144 39C113.144 34.5817 109.562 31 105.144 31C100.725 31 97.1436 34.5817 97.1436 39C97.1436 43.4183 100.725 47 105.144 47Z\" fill=\"var(--color-contrast-medium)\"></path>\r\n<rect x=\"77\" y=\"128\" width=\"106\" height=\"6\" fill=\"var(--color-contrast-low)\"></rect>\r\n<rect x=\"77\" y=\"144\" width=\"48\" height=\"6\" fill=\"var(--color-contrast-low)\"></rect>\r\n<rect x=\"77\" y=\"108\" width=\"82\" height=\"10\" fill=\"var(--color-contrast-high)\"></rect>\r\n</svg>');

-- --------------------------------------------------------

--
-- Table structure for table `tracker`
--

CREATE TABLE `tracker` (
  `id` bigint NOT NULL,
  `pid` bigint NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlDest` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urlFrom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `userAgent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countryName` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countryCode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regionCode` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `device` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewportwidth` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sid` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whitelist`
--

CREATE TABLE `whitelist` (
  `id` bigint NOT NULL,
  `ip` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` bigint NOT NULL,
  `ref` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `width_sm` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `width_md` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width_lg` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width_xl` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width_xxl` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `ref`, `title`, `file`, `layout`, `width_sm`, `width_md`, `width_lg`, `width_xl`, `width_xxl`, `ord`, `active`) VALUES
(3, 'dashboard', 'Visitor Stats', 'visitorstats.php', '', '6', '12', '6', '6', '4', 1, 1),
(4, 'dashboard', 'Top Ten Highest Viewed Pages', 'viewedpages.php', '', '6', '', '', '6', '4', 11, 1),
(8, 'dashboard', 'Top Ten Search Keywords This Month', 'topkeywords.php', '', '6', '', '', '6', '3', 9, 1),
(9, 'dashboard', 'Recent Admin Activity', 'recentadminactivity.php', '', '6', '6', '', '6', '4', 10, 1),
(10, 'dashboard', 'Latest AuroraCMS Updates', 'auroracmsupdates.php', '', '6', '', '', '6', '4', 15, 0),
(13, 'dashboard', 'Devices', 'devices.php', '', '3', '5', '', '3', '2', 7, 1),
(14, 'dashboard', 'Browsers', 'browsers.php', '', '6', '5', '', '3', '2', 6, 1),
(15, 'dashboard', 'Referrers', 'referrers.php', '', '3', '6', '', '3', '2', 5, 1),
(16, 'dashboard', 'Countries', 'countries.php', '', '3', '6', '', '3', '2', 8, 1),
(17, 'dashboard', 'Weather', 'weather.php', '', '6', '', '', '', '', 2, 0),
(18, 'dashboard', 'Sale Content Suggestions', 'salecontent.php', '', '12', '', '', '12', '', 0, 1),
(21, 'dashboard', 'Sales Stats', 'dashboardsalesstats.php', '', '12', '6', '5', '6', '4', 4, 1),
(22, 'dashboard', 'Latest Orders', 'dashboardlatestorders.php', '', '6', '6', '', '6', '4', 3, 1),
(23, 'dashboard', 'Latest Theme Updates', 'themeupdates.php', '', '6', '', '', '6', '4', 14, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agronomy_areas`
--
ALTER TABLE `agronomy_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agronomy_livestock`
--
ALTER TABLE `agronomy_livestock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contentStats`
--
ALTER TABLE `contentStats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courseTrack`
--
ALTER TABLE `courseTrack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumCategory`
--
ALTER TABLE `forumCategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumPosts`
--
ALTER TABLE `forumPosts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumPostTrack`
--
ALTER TABLE `forumPostTrack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumTopics`
--
ALTER TABLE `forumTopics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forumVoteTrack`
--
ALTER TABLE `forumVoteTrack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iplist`
--
ALTER TABLE `iplist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `livechat`
--
ALTER TABLE `livechat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moduleQuestions`
--
ALTER TABLE `moduleQuestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moduleQuestionsTrack`
--
ALTER TABLE `moduleQuestionsTrack`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sidebar`
--
ALTER TABLE `sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracker`
--
ALTER TABLE `tracker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whitelist`
--
ALTER TABLE `whitelist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agronomy_areas`
--
ALTER TABLE `agronomy_areas`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agronomy_livestock`
--
ALTER TABLE `agronomy_livestock`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contentStats`
--
ALTER TABLE `contentStats`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courseTrack`
--
ALTER TABLE `courseTrack`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumCategory`
--
ALTER TABLE `forumCategory`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumPosts`
--
ALTER TABLE `forumPosts`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumPostTrack`
--
ALTER TABLE `forumPostTrack`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumTopics`
--
ALTER TABLE `forumTopics`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forumVoteTrack`
--
ALTER TABLE `forumVoteTrack`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `iplist`
--
ALTER TABLE `iplist`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livechat`
--
ALTER TABLE `livechat`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moduleQuestions`
--
ALTER TABLE `moduleQuestions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `moduleQuestionsTrack`
--
ALTER TABLE `moduleQuestionsTrack`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sidebar`
--
ALTER TABLE `sidebar`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tracker`
--
ALTER TABLE `tracker`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
