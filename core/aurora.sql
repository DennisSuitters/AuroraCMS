-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 17, 2023 at 11:22 PM
-- Server version: 8.0.34-0ubuntu0.20.04.1
-- PHP Version: 8.1.24

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
  `fomoOptions` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoStyle` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoIn` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoOut` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoActivitiesState` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoCoursesState` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoEventsState` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoInventoryState` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoServicesState` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoTestimonialsState` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fomoFullname` tinyint(1) NOT NULL,
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
  `seo_ahrefsverify` text COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `config` (`id`, `development`, `maintenance`, `comingsoon`, `hoster`, `hosterURL`, `options`, `forumOptions`, `inventoryFallbackStatus`, `defaultPage`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `saleHeadingvalentine`, `saleHeadingeaster`, `saleHeadingmothersday`, `saleHeadingfathersday`, `saleHeadingblackfriday`, `saleHeadinghalloween`, `saleHeadingsmallbusinessday`, `saleHeadingchristmas`, `saleHeadingEOFY`, `metaRobots`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `email_check`, `email_interval`, `email_signature`, `storemessages`, `message_check_interval`, `chatAutoRemove`, `messengerFBCode`, `messengerFBColor`, `messengerFBGreeting`, `language`, `timezone`, `orderPayti`, `orderEmailSubject`, `orderEmailLayout`, `orderEmailNotes`, `orderEmailReadNotification`, `austPostAPIKey`, `gst`, `memberLimit`, `memberLimitSilver`, `memberLimitBronze`, `memberLimitGold`, `memberLimitPlatinum`, `wholesaleLimit`, `wholesaleLimitSilver`, `wholesaleLimitBronze`, `wholesaleLimitGold`, `wholesaleLimitPlatinum`, `wholesaleTime`, `wholesaleTimeSilver`, `wholesaleTimeBronze`, `wholesaleTimeGold`, `wholesaleTimePlatinum`, `fomo`, `fomoOptions`, `fomoStyle`, `fomoIn`, `fomoOut`, `fomoActivitiesState`, `fomoCoursesState`, `fomoEventsState`, `fomoInventoryState`, `fomoServicesState`, `fomoTestimonialsState`, `fomoFullname`, `passwordResetLayout`, `passwordResetSubject`, `accountActivationSubject`, `accountActivationLayout`, `bookingNoteTemplate`, `bookingEmailSubject`, `bookingEmailLayout`, `bookingEmailReadNotification`, `bookingAutoReplySubject`, `bookingAutoReplyLayout`, `bookingAttachment`, `bookingAgreement`, `bookingBuffer`, `contactAutoReplySubject`, `contactAutoReplyLayout`, `newslettersEmbedImages`, `newslettersSendMax`, `newslettersSendDelay`, `newslettersOptOutLayout`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `payPalClientID`, `payPalSecret`, `stripe_publishkey`, `stripe_secretkey`, `defaultOrder`, `showItems`, `searchItems`, `idleTime`, `ga_clientID`, `ga_tracking`, `ga_tagmanager`, `ga_verification`, `gd_api`, `reCaptchaClient`, `reCaptchaServer`, `seo_msvalidate`, `seo_yandexverification`, `seo_alexaverification`, `seo_domainverify`, `seo_pinterestverify`, `seo_ahrefsverify`, `mapapikey`, `geo_region`, `geo_placename`, `geo_position`, `geo_weatherAPI`, `php_options`, `php_APIkey`, `php_honeypot`, `php_quicklink`, `formMinTime`, `formMaxTime`, `spamfilter`, `notification_volume`, `mediaOptions`, `unsplash_appname`, `unsplash_publickey`, `unsplash_secretkey`, `mediaMaxWidth`, `mediaMaxHeight`, `mediaMaxWidthThumb`, `mediaMaxHeightThumb`, `mediaQuality`, `templateID`, `templateQTY`, `suggestions`, `bti`, `backup_ti`, `uti`, `uti_freq`, `update_url`, `navstat`, `iconsColor`, `a11yPosition`, `ti`) VALUES
(1, 0, 0, 0, 0, '', '10111110011110000001101010100101', '0000000000000000000000000000000', 'back order', 'dashboard', 'default', '', '', '', 'Clippy', '', '', '', '', '', '', '', '', '', 'index,follow', '', '', '', '', 0, '', '', '', '', '', '', '', 0, '', '', '', 0, 3600, 'M jS, Y g:i A', 1425893894, 3600, '<p>Sent using <a href=\"https://github.com/DiemenDesign/AuroraCMS\">AuroraCMS</a> the Australian Open Source Content Management System.</p>', 1, 300, 0, '', '#5484ed', '', 'en-AU', 'Australia/Hobart', 1209600, 'Order {order_number}', '<p>Hi {first}!</p>\r\n<p>Thank you for your payment, and choosing to support {business}.</p>\r\n{downloads}\r\n{courses}\r\n<p>You can view your invoice here: {order_link}</p>\r\n<p>Regards,<br>\r\n{business}</p>\r\n<hr>\r\n', '', 1, '', '0', '0', '0', '0', '0', '0', '5', '5', '5', '5', '5', 0, 0, 0, 0, 0, 0, '1111111011111111', 'comic', 'slide-in-blurred-left', 'slide-out-blurred-left', '', '', '', 'All', '', '', 1, '%3Cp%3EHi%20%7Bname%7D%2C%3C/p%3E%3Cp%3EA%20Password%20Reset%20was%20requested%2C%20it%20is%20now%3A%20%7Bpassword%7D%3C/p%3E%3Cp%3EWe%20recommend%20changing%20the%20above%20password%20after%20logging%20in.%3C/p%3E', 'Password Reset {business}.', 'Account Activation for {username} from {site}.', '<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>The username you signed up with was: {username}</p><p>The AutoGenerated password is: {password}</p><p><br></p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>', '<p>This is a test template</p><p>Backup:</p><p><input type=\"checkbox\"> Music</p><p><input type=\"checkbox\"> Software</p><p><input type=\"checkbox\"> Emails</p><p><br></p>', '{business} Booking Confirmation on {date}', '<p>Hi {first},</p>\r\n\r\n<p>{details}</p>\r\n\r\n<p>Please check the details above, and get in touch if any need correcting.</p>\r\n\r\n<p>Kind Regards,<br>\r\n\r\n{business}</p>\r\n\r\n\r\n\r\n', 0, '{business} Booking Confirmation on {date}', '<p>Hi {first},</p>\r\n\r\n<p>Thank you for contacting {business}, someone will get back to you ASAP.<br>Please note, this email is not a confirmed booking - we will contact you to confirm the time and date of your booking.</p>\r\n\r\n<p>{externalLink}</p>\r\n\r\n<p>Kind Regards,<br>\r\n\r\n{business}</p>', '', '<p>By clicking this checkbox and or signing below, you agree that we are not responsible for any data loss.</p>', 3600, '{business} Contact Confirmation on {date}', '<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>', 0, 50, 5, '<br>\r\n<br>\r\n<p style=\"font-size: 10px;text-align: center;\">If you don\'t wish to continue to receive these Newsletters you can <a href=\"{optOutLink}\">Unsubscribe</a>.</p>', 'Westpac', 'D & A Suitters', '0000 0000 0000', '000000', 'test', '', '', '', 'new', 4, 10, 30, '', '', '', '', 'AIzaSyD88WkGT3JFrVYo-qL5bKOyIpvvx5yIf_o', '', '', '', '', '', '', '', '', '', '', '', '-41.1833414399023,146.1616936326027', '', '1011111000000000', '', '', '', '5', '60', 1, 0, '1110000000000000', 'AuroraCMS', 'zrrPVIalmeHf_VbARqGhS3C-K1BsVQ0lpahz7kyQ2rk', 'OuSKyWVzCyZnkQJ8OAccOuNzWDqeQs4yiRxDK8UCUhc', 1280, 1280, 250, 250, 88, 0, 0, 0, 0, 1602516248, 0, 0, '', 1, 0, 'right bottom', 0);

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

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `area`, `state`, `postcode`, `active`) VALUES
(3, 'Darwin', 'NT', '0800', 1),
(36, 'Barkly', 'NT', '0852', 1),
(62, 'East Arnhem', 'NT', '0822', 1),
(135, 'Katherine', 'NT', '0822', 1),
(173, 'Palmerson', 'NT', '0830', 1),
(300, 'Alice Springs', 'NT', '0870', 1),
(716, 'Sydney', 'NSW', '2000', 1),
(718, 'Waterloo', 'NSW', '2000', 1),
(748, 'Alexandria', 'NSW', '2015', 1),
(790, 'Clovelly', 'NSW', '2031', 1),
(800, 'Maroubra', 'NSW', '2035', 1),
(828, 'Lidcombe', 'NSW', '2141', 1),
(840, 'Petersham', 'NSW', '2049', 1),
(851, 'St Leonards', 'NSW', '2060', 1),
(882, 'Willoughby', 'NSW', '2068', 1),
(889, 'Lindfield', 'NSW', '2070', 1),
(892, 'Pymble', 'NSW', '2071', 1),
(904, 'Thornleigh', 'NSW', '2076', 1),
(920, 'Hornsby', 'NSW', '2083', 1),
(928, 'Frenchs Forest', 'NSW', '2084', 1),
(929, 'Belrose', 'NSW', '2085', 1),
(937, 'Spit Junction', 'NSW', '2088', 1),
(939, 'Neutral Bay', 'NSW', '2089', 1),
(952, 'Manly', 'NSW', '2095', 1),
(958, 'Collaroy Plateau', 'NSW', '2097', 1),
(963, 'Wheeler Heights', 'NSW', '2097', 1),
(1012, 'North Ryde', 'NSW', '2109', 1),
(1026, 'Ryde', 'NSW', '2112', 1),
(1036, 'Rydalmere', 'NSW', '2116', 1),
(1038, 'Parramatta', 'NSW', '2150', 1),
(1042, 'Carlingford', 'NSW', '2118', 1),
(1058, 'Cherrybrook', 'NSW', '2126', 1),
(1065, 'Croydon Park', 'NSW', '2133', 1),
(1070, 'Burwood', 'NSW', '2134', 1),
(1094, 'Leightonfield', 'NSW', '2163', 1),
(1107, 'Seven Hills', 'NSW', '2147', 1),
(1116, 'Toongabbie', 'NSW', '2146', 1),
(1123, 'Blacktown', 'NSW', '2148', 1),
(1172, 'Smithfield', 'NSW', '2164', 1),
(1186, 'Prestons', 'NSW', '2170', 1),
(1199, 'Liverpool', 'NSW', '2170', 1),
(1208, 'Narellan', 'NSW', '2171', 1),
(1235, 'St Marys', 'NSW', '2178', 1),
(1254, 'Yagoona', 'NSW', '2199', 1),
(1256, 'Bankstown', 'NSW', '2200', 1),
(1263, 'Mount Lewis', 'NSW', '2190', 1),
(1265, 'Marrickville', 'NSW', '2204', 1),
(1268, 'Rockdale', 'NSW', '2216', 1),
(1271, 'Kingsgrove', 'NSW', '2208', 1),
(1276, 'Bexley', 'NSW', '2207', 1),
(1284, 'Peakhurst', 'NSW', '2210', 1),
(1291, 'Revesby', 'NSW', '2212', 1),
(1315, 'Hurstville', 'NSW', '2220', 1),
(1330, 'Kirrawee', 'NSW', '2232', 1),
(1701, 'Nelson Bay', 'NSW', '2315', 1),
(3966, 'Minto', 'NSW', '2558', 1),
(3976, 'Campbelltown', 'NSW', '2560', 1),
(3994, 'Ingleburn', 'NSW', '2565', 1),
(4291, 'Harman', 'ACT', '2600', 1),
(4309, 'Mitchell', 'ACT', '2911', 1),
(4324, 'Phillip', 'ACT', '2606', 1),
(4343, 'Fyshwick', 'ACT', '2609', 1),
(4379, 'Macquarie', 'ACT', '2614', 1),
(4382, 'Page', 'ACT', '2614', 1),
(5207, 'Werrington Downs', 'NSW', '2747', 1),
(5297, 'Glendenning', 'NSW', '2761', 1),
(5307, 'Riverstone', 'NSW', '2765', 1),
(5336, 'Mount Druitt', 'NSW', '2770', 1),
(5344, 'Blaxland', 'NSW', '2774', 1),
(6148, 'Greenway', 'ACT', '2900', 1),
(6184, 'Amaroo', 'ACT', '2914', 1),
(6198, 'Footscray', 'VIC', '3011', 1),
(6209, 'Newport', 'VIC', '3015', 1),
(6219, 'Sunshine', 'VIC', '3020', 1),
(6224, 'St Albans', 'VIC', '3021', 1),
(6237, 'Melbourne', 'VIC', '3000', 1),
(6269, 'Niddrie', 'VIC', '3042', 1),
(6298, 'Preston', 'VIC', '3072', 1),
(6304, 'Somerton', 'VIC', '3062', 1),
(6348, 'Fitzroy', 'VIC', '3065', 1),
(6370, 'Epping', 'VIC', '3076', 1),
(6385, 'Bundoora', 'VIC', '3083', 1),
(6420, 'Deepdene', 'VIC', '3101', 1),
(6430, 'Templestowe', 'VIC', '3106', 1),
(6441, 'Mooroolbark', 'VIC', '3138', 1),
(6445, 'Richmond', 'VIC', '3121', 1),
(6455, 'Hawthorn', 'VIC', '3122', 1),
(6471, 'Box Hill', 'VIC', '3128', 1),
(6482, 'Nunawading', 'VIC', '3131', 1),
(6531, 'Mount Waverley', 'VIC', '3149', 1),
(6552, 'Ferntree Gully', 'VIC', '3156', 1),
(6556, 'Bayswater', 'VIC', '3153', 1),
(6565, 'Belgrave', 'VIC', '3160', 1),
(6597, 'Braeside', 'VIC', '3195', 1),
(6603, 'Dandenong', 'VIC', '3175', 1),
(6618, 'St Kilda', 'VIC', '3182', 1),
(6628, 'Brighton', 'VIC', '3186', 1),
(6634, 'Moorabbin', 'VIC', '3189', 1),
(6664, 'Seaford', 'VIC', '3198', 1),
(6706, 'Grovedale', 'VIC', '3216', 1),
(6711, 'Geelong', 'VIC', '3220', 1),
(9474, 'Bittern', 'VIC', '3918', 1),
(9711, 'Brisbane', 'QLD', '4000', 1),
(9722, 'Albion', 'QLD', '4010', 1),
(9752, 'Wavell Heights', 'QLD', '4012', 1),
(9764, 'Sandgate', 'QLD', '4017', 1),
(9775, 'Clontarf', 'QLD', '4019', 1),
(9798, 'Stafford', 'QLD', '4053', 1),
(9816, 'Brendale', 'QLD', '4500', 1),
(9820, 'Kelvin Grove', 'QLD', '4051', 1),
(9839, 'Ferny Hills', 'QLD', '4055', 1),
(9870, 'Toowong', 'QLD', '4066', 1),
(9885, 'Kenmore', 'QLD', '4069', 1),
(9901, 'Richlands', 'QLD', '4077', 1),
(9911, 'Rocklea', 'QLD', '4106', 1),
(9931, 'Coorparoo', 'QLD', '4151', 1),
(9964, 'Acacia Ridge', 'QLD', '4110', 1),
(9978, 'Archerfield', 'QLD', '4108', 1),
(9983, 'Logan Central', 'QLD', '4114', 1),
(10042, 'Loganholme', 'QLD', '4129', 1),
(10069, 'Tingalpa', 'QLD', '4153', 1),
(10071, 'Capalaba', 'QLD', '4157', 1),
(10085, 'Cleveland', 'QLD', '4163', 1),
(10139, 'Yatala', 'QLD', '4207', 1),
(10177, 'Nerang', 'QLD', '4211', 1),
(10202, 'Arundel', 'QLD', '4214', 1),
(10208, 'Burleigh Heads', 'QLD', '4220', 1),
(10240, 'Bundall', 'QLD', '4217', 1),
(10253, 'Robina', 'QLD', '4226', 1),
(10275, 'Currumbin', 'QLD', '4221', 1),
(10374, 'Goodna', 'QLD', '4300', 1),
(10392, 'Booval', 'QLD', '4303', 1),
(10422, 'Ipswich', 'QLD', '4305', 1),
(11402, 'Burpengary', 'QLD', '4505', 1),
(11420, 'Caboolture', 'QLD', '4510', 1),
(13666, 'Adelaide', 'SA', '5000', 1),
(13678, 'Regency Park', 'SA', '5010', 1),
(13708, 'Port Adelaide', 'SA', '5013', 1),
(13755, 'Marleston', 'SA', '5031', 1),
(13854, 'Mitcham', 'SA', '5062', 1),
(13859, 'Kent Town', 'SA', '5063', 1),
(13875, 'Glynde', 'SA', '5066', 1),
(14047, 'Gawler', 'SA', '5118', 1),
(14143, 'Lonsdale', 'SA', '5160', 1),
(18532, 'Lutwyche', 'QLD', '4030', 1),
(18533, 'Helensvale', 'QLD', '4212', 1),
(18576, 'Ridgley', 'TAS', '7321', 1),
(18577, 'Howrah', 'TAS', '7018', 1),
(18608, 'Kingston', 'TAS', '7050', 1),
(18624, 'Moonah', 'TAS', '7009', 1),
(18627, 'Lutana', 'TAS', '7009', 1),
(18628, 'Derwent Park', 'TAS', '7009', 1),
(18629, 'Glenorchy', 'TAS', '7010', 1),
(18630, 'Montrose', 'TAS', '7010', 1),
(18631, 'Rosetta', 'TAS', '7010', 1),
(18632, 'Chigwell', 'TAS', '7011', 1),
(18638, 'Hobart', 'TAS', '7000', 1),
(18639, 'Glebe', 'TAS', '7000', 1),
(18640, 'Mount Stuart', 'TAS', '7000', 1),
(18641, 'North Hobart', 'TAS', '7000', 1),
(18643, 'West Hobart', 'TAS', '7000', 1),
(18645, 'Battery Point', 'TAS', '7004', 1),
(18646, 'South Hobart', 'TAS', '7004', 1),
(18647, 'Dynnyrne', 'TAS', '7005', 1),
(18649, 'Sandy Bay', 'TAS', '7005', 1),
(18650, 'Mount Nelson', 'TAS', '7007', 1),
(18651, 'Tolmans Hill', 'TAS', '7007', 1),
(18653, 'West Moonah', 'TAS', '7009', 1),
(18656, 'Goodwood', 'TAS', '7010', 1),
(18657, 'Austins Ferry', 'TAS', '7011', 1),
(18658, 'Berriedale', 'TAS', '7011', 1),
(18659, 'Claremont', 'TAS', '7011', 1),
(18662, 'Geilston Bay', 'TAS', '7015', 1),
(18663, 'Lindisfarne', 'TAS', '7015', 1),
(18664, 'Rose Bay', 'TAS', '7015', 1),
(18665, 'Risdon Vale', 'TAS', '7016', 1),
(18667, 'Honeywood', 'TAS', '7017', 1),
(18668, 'Old Beach', 'TAS', '7017', 1),
(18669, 'Otago', 'TAS', '7017', 1),
(18670, 'Risdon', 'TAS', '7017', 1),
(18672, 'Bellerive', 'TAS', '7018', 1),
(18673, 'Montagu Bay', 'TAS', '7018', 1),
(18674, 'Mornington', 'TAS', '7018', 1),
(18676, 'Rosny Park', 'TAS', '7018', 1),
(18677, 'Tranmere', 'TAS', '7018', 1),
(18678, 'Warrane', 'TAS', '7018', 1),
(18680, 'Oakdowns', 'TAS', '7019', 1),
(18681, 'Rokeby', 'TAS', '7019', 1),
(18684, 'Lauderdale', 'TAS', '7021', 1),
(18705, 'Gagebrook', 'TAS', '7030', 1),
(18729, 'Taroona', 'TAS', '7053', 1),
(18737, 'Ridgeway', 'TAS', '7054', 1),
(19337, 'Weetangera', 'ACT', '2614', 1),
(19338, 'Cook', 'ACT', '2614', 1),
(19339, 'Aranda', 'ACT', '2614', 1),
(19340, 'O\'Connor', 'ACT', '2602', 1),
(19341, 'Turner', 'ACT', '2612', 1),
(19342, 'Acton', 'ACT', '2601', 1),
(19343, 'Yarralumla', 'ACT', '2600', 1),
(19344, 'Deakin', 'ACT', '2600', 1),
(19345, 'Garran', 'ACT', '2605', 1),
(19346, 'Hughes', 'ACT', '2605', 1),
(19347, 'Lyons', 'ACT', '2606', 1),
(19348, 'Weston', 'ACT', '2611', 1),
(19349, 'Holder', 'ACT', '2611', 1),
(19350, 'Duffy', 'ACT', '2611', 1),
(19351, 'Rivett', 'ACT', '2611', 1),
(19352, 'Stirling', 'ACT', '2611', 1),
(19353, 'Waramanga', 'ACT', '2611', 1),
(19354, 'Fisher', 'ACT', '2611', 1),
(19355, 'Chifley', 'ACT', '2606', 1),
(19356, 'Pearce', 'ACT', '2607', 1),
(19357, 'Torrens', 'ACT', '2607', 1),
(19358, 'Mawson', 'ACT', '2607', 1),
(19359, 'Farrer', 'ACT', '2607', 1),
(19360, 'O\'Malley', 'ACT', '2606', 1),
(19361, 'Isaacs', 'ACT', '2607', 1),
(19362, 'Kambah', 'ACT', '2902', 1),
(19363, 'Wanniassa', 'ACT', '2903', 1),
(19364, 'Oxley', 'ACT', '2903', 1),
(19365, 'Monash', 'ACT', '2904', 1),
(19366, 'Gowrie', 'ACT', '2904', 1),
(19367, 'Chisholm', 'ACT', '2905', 1),
(19368, 'Richardson', 'ACT', '2905', 1),
(19369, 'Calwell', 'ACT', '2905', 1),
(19370, 'Isabella Plains', 'ACT', '2905', 1),
(19371, 'Bonython', 'ACT', '2905', 1),
(19372, 'Gordon', 'ACT', '2906', 1),
(19373, 'Banks', 'ACT', '2906', 1),
(19374, 'Conder', 'ACT', '2906', 1),
(19375, 'Theodore', 'ACT', '2905', 1),
(19376, 'Karabar', 'ACT', '2620', 1),
(19377, 'Jerrabomberra', 'ACT', '2619', 1),
(19378, 'Greenleigh', 'ACT', '2620', 1),
(19379, 'Crestwood', 'ACT', '2620', 1),
(19380, 'Queanbeyan', 'ACT', '2620', 1),
(19382, 'Oaks Estate', 'ACT', '2620', 1),
(19383, 'Queanbeyan East', 'ACT', '2620', 1),
(19384, 'Narrabundah', 'ACT', '2604', 1),
(19385, 'Red Hill', 'ACT', '2603', 1),
(19386, 'Griffith', 'ACT', '2603', 1),
(19387, 'Kingston', 'ACT', '2604', 1),
(19388, 'Russell', 'ACT', '2600', 1),
(19389, 'Duntroon', 'ACT', '2612', 1),
(19390, 'Pialligo', 'ACT', '2609', 1),
(19391, 'Campbell', 'ACT', '2612', 1),
(19392, 'Reid', 'ACT', '2612', 1),
(19393, 'Canberra', 'ACT', '2600', 1),
(19394, 'Braddon', 'ACT', '2612', 1),
(19395, 'Hackett', 'ACT', '2602', 1),
(19396, 'Watson', 'ACT', '2602', 1),
(19397, 'Downer', 'ACT', '2602', 1),
(19398, 'Lyneham', 'ACT', '2602', 1),
(19399, 'Bruce', 'ACT', '2617', 1),
(19400, 'Scullin', 'ACT', '2614', 1),
(19401, 'Higgins', 'ACT', '2615', 1),
(19402, 'Holt', 'ACT', '2615', 1),
(19403, 'Latham', 'ACT', '2615', 1),
(19404, 'Melba', 'ACT', '2615', 1),
(19405, 'Evatt', 'ACT', '2617', 1),
(19406, 'McKellar', 'ACT', '2617', 1),
(19407, 'Lawson', 'ACT', '2617', 1),
(19408, 'Kaleen', 'ACT', '2617', 1),
(19409, 'Giralang', 'ACT', '2617', 1),
(19410, 'Spence', 'ACT', '2615', 1),
(19411, 'Fraser', 'ACT', '2615', 1),
(19412, 'Hall', 'ACT', '2618', 1),
(19413, 'Kinlyside', 'ACT', '2618', 1),
(19414, 'Nicholls', 'ACT', '2913', 1),
(19415, 'Crace', 'ACT', '2911', 1),
(19416, 'Palmerston', 'ACT', '2913', 1),
(19417, 'Kenny', 'ACT', '2912', 1),
(19418, 'Harrison', 'ACT', '2914', 1),
(19419, 'Throsby', 'ACT', '2914', 1),
(19420, 'Forde', 'ACT', '2914', 1),
(19421, 'Gungahlin', 'ACT', '2912', 1),
(19422, 'Moncrieff', 'ACT', '2914', 1),
(19423, 'Casey', 'ACT', '2913', 1),
(19424, 'Taylor', 'ACT', '2913', 1),
(19425, 'Franklin', 'ACT', '2913', 1),
(19426, 'Charnwood', 'ACT', '2615', 1),
(19427, 'Flynn', 'ACT', '2615', 1),
(19428, 'Wright', 'ACT', '2611', 1),
(19429, 'Tharwa', 'ACT', '2620', 1),
(19430, 'Tuggeranong', 'ACT', '2900', 1),
(19431, 'Paddys River', 'ACT', '2620', 1),
(19432, 'Gilmore', 'ACT', '2905', 1),
(19433, 'MacArthur', 'ACT', '2904', 1),
(19434, 'Fadden', 'ACT', '2904', 1),
(19435, 'Chapman', 'ACT', '2611', 1),
(19436, 'Curtin', 'ACT', '2605', 1),
(19437, 'Coombs', 'ACT', '2611', 1),
(19438, 'Denman Prospect', 'ACT', '2611', 1),
(19439, 'Barton', 'ACT', '2600', 1),
(19440, 'Queanbeyan West', 'ACT', '2620', 1),
(19441, 'Googong', 'ACT', '2620', 1),
(19442, 'Symonston', 'ACT', '2609', 1),
(19443, 'Hawker', 'ACT', '2614', 1),
(19444, 'Strathnairn', 'ACT', '2615', 1),
(19445, 'Belconnen', 'ACT', '2617', 1),
(19446, 'Ngunnawal', 'ACT', '2913', 1),
(19447, 'Jacka', 'ACT', '2914', 1),
(19448, 'Bonner', 'ACT', '2914', 1),
(19449, 'Heathcote', 'NSW', '2233', 1),
(19450, 'Engadine', 'NSW', '2233', 1),
(19451, 'Yarrawarrah', 'NSW', '2233', 1),
(19452, 'Loftus', 'NSW', '2232', 1),
(19453, 'Woronora Heights', 'NSW', '2233', 1),
(19454, 'Lucas Heights', 'NSW', '2234', 1),
(19455, 'Barden Ridge', 'NSW', '2234', 1),
(19456, 'Grays Point', 'NSW', '2232', 1),
(19457, 'Gymea Bay', 'NSW', '2227', 1),
(19458, 'Yowie Bay', 'NSW', '2228', 1),
(19459, 'Lilli Pilli', 'NSW', '2229', 1),
(19460, 'Port Hacking', 'NSW', '2229', 1),
(19461, 'Dolans Bay', 'NSW', '2229', 1),
(19462, 'Burraneer', 'NSW', '2230', 1),
(19463, 'Maianbar', 'NSW', '2230', 1),
(19464, 'Bundeena', 'NSW', '2230', 1),
(19465, 'Woolooware', 'NSW', '2230', 1),
(19466, 'Cronulla', 'NSW', '2230', 1),
(19467, 'Kurnell', 'NSW', '2231', 1),
(19468, 'Sylvania Waters', 'NSW', '2224', 1),
(19469, 'Miranda', 'NSW', '2228', 1),
(19470, 'Taren Point', 'NSW', '2229', 1),
(19471, 'Caringbah South', 'NSW', '2229', 1),
(19472, 'Gymea', 'NSW', '2227', 1),
(19473, 'Oyster Bay', 'NSW', '2225', 1),
(19474, 'Kangaroo Point', 'NSW', '2224', 1),
(19475, 'Sylvania', 'NSW', '2224', 1),
(19476, 'Kareela', 'NSW', '2232', 1),
(19477, 'Woronora', 'NSW', '2232', 1),
(19478, 'Bonnet Bay', 'NSW', '2226', 1),
(19479, 'Bangor', 'NSW', '2234', 1),
(19480, 'Illawong', 'NSW', '2234', 1),
(19481, 'Alfords Point', 'NSW', '2234', 1),
(19482, 'Sandy Point', 'NSW', '2172', 1),
(19483, 'Pleasure Point', 'NSW', '2172', 1),
(19484, 'Wattle Grove', 'NSW', '2173', 1),
(19485, 'Glenfield', 'NSW', '2167', 1),
(19486, 'Macquarie Fields', 'NSW', '2164', 1),
(19487, 'Long Point', 'NSW', '2564', 1),
(19488, 'Minto Heights', 'NSW', '2566', 1),
(19489, 'Kentlyn', 'NSW', '2560', 1),
(19490, 'Rosemeadow', 'NSW', '2560', 1),
(19491, 'St Helens Park', 'NSW', '2560', 1),
(19492, 'Bradbury', 'NSW', '2560', 1),
(19493, 'Ambarvale', 'NSW', '2560', 1),
(19494, 'Glen Alpine', 'NSW', '2560', 1),
(19495, 'Englorie Park', 'NSW', '2560', 1),
(19496, 'Airds', 'NSW', '2560', 1),
(19497, 'Ruse', 'NSW', '2560', 1),
(19498, 'Mount Annan', 'NSW', '2567', 1),
(19499, 'Spring Farm', 'NSW', '2570', 1),
(19500, 'Elderslie', 'NSW', '2570', 1),
(19501, 'Camden', 'NSW', '2570', 1),
(19502, 'Camden South', 'NSW', '2570', 1),
(19503, 'Camden Park', 'NSW', '2570', 1),
(19504, 'Menangle', 'NSW', '2568', 1),
(19505, 'Menangle Park', 'NSW', '2563', 1),
(19506, 'Grasmere', 'NSW', '2570', 1),
(19507, 'Ellis Lane', 'NSW', '2570', 1),
(19508, 'Oran Park', 'NSW', '2570', 1),
(19509, 'Catherine Field', 'NSW', '2557', 1),
(19511, 'Currans Hill', 'NSW', '2567', 1),
(19512, 'Smeaton Grange', 'NSW', '2567', 1),
(19513, 'Harrington Park', 'NSW', '2567', 1),
(19514, 'Kirkham', 'NSW', '2570', 1),
(19515, 'Gledswood Hills', 'NSW', '2567', 1),
(19516, 'Blairmount', 'NSW', '2559', 1),
(19517, 'Blair Athol', 'NSW', '2560', 1),
(19518, 'Kearns', 'NSW', '2558', 1),
(19519, 'Eschol Park', 'NSW', '2558', 1),
(19520, 'Claymore', 'NSW', '2559', 1),
(19521, 'Raby', 'NSW', '2566', 1),
(19522, 'Leppington', 'NSW', '2179', 1),
(19523, 'Denham Court', 'NSW', '2565', 1),
(19524, 'Bardia', 'NSW', '2565', 1),
(19525, 'Edmondson Park', 'NSW', '2174', 1),
(19526, 'West Hoxton', 'NSW', '2171', 1),
(19527, 'Austral', 'NSW', '2179', 1),
(19528, 'Kemps Creek', 'NSW', '2178', 1),
(19529, 'Badgerys Creek', 'NSW', '2555', 1),
(19530, 'Bringelly', 'NSW', '2556', 1),
(19531, 'Cecil Park', 'NSW', '2178', 1),
(19532, 'Mount Vernon', 'NSW', '2178', 1),
(19533, 'Horsley Park', 'NSW', '2175', 1),
(19534, 'Prairiewood', 'NSW', '2176', 1),
(19535, 'Bossley Park', 'NSW', '2176', 1),
(19536, 'Greenfield Park', 'NSW', '2176', 1),
(19537, 'Edensor Park', 'NSW', '2176', 1),
(19538, 'Abbotsbury', 'NSW', '2176', 1),
(19539, 'Cecil Hills', 'NSW', '2171', 1),
(19540, 'Elizabeth Hills', 'NSW', '2171', 1),
(19541, 'Hinchinbrook', 'NSW', '2168', 1),
(19542, 'Green Valley', 'NSW', '2168', 1),
(19543, 'Bonnyrigg Heights', 'NSW', '2177', 1),
(19544, 'Miller', 'NSW', '2168', 1),
(19545, 'Lurnea', 'NSW', '2170', 1),
(19546, 'Glenfield', 'NSW', '2157', 1),
(19547, 'Ashcroft', 'NSW', '2168', 1),
(19548, 'Sadleir', 'NSW', '2168', 1),
(19549, 'Busby', 'NSW', '2168', 1),
(19550, 'Bonnyrigg', 'NSW', '2177', 1),
(19551, 'Wakeley', 'NSW', '2176', 1),
(19552, 'Fairfield West', 'NSW', '2165', 1),
(19553, 'Cabramatta', 'NSW', '2166', 1),
(19554, 'Warwick Farm', 'NSW', '2170', 1),
(19555, 'Moorebank', 'NSW', '2170', 1),
(19556, 'Holsworthy', 'NSW', '2173', 1),
(19557, 'Milperra', 'NSW', '2214', 1),
(19558, 'Panania', 'NSW', '2213', 1),
(19559, 'Voyager Point', 'NSW', '2172', 1),
(19560, 'Hammondville', 'NSW', '2170', 1),
(19561, 'Padstow', 'NSW', '2211', 1),
(19562, 'Georges Hall', 'NSW', '2198', 1),
(19563, 'Carramar', 'NSW', '2163', 1),
(19564, 'Potts Hill', 'NSW', '2143', 1),
(19565, 'Chester Hill', 'NSW', '2162', 1),
(19566, 'Guildford West', 'NSW', '2161', 1),
(19567, 'Woodpark', 'NSW', '2164', 1),
(19568, 'Old Guildford', 'NSW', '2161', 1),
(19569, 'Merrylands', 'NSW', '2160', 1),
(19570, 'Guildford', 'NSW', '2161', 1),
(19571, 'Auburn', 'NSW', '2144', 1),
(19572, 'Chullora', 'NSW', '2190', 1),
(19573, 'Punchbowl', 'NSW', '2196', 1),
(19574, 'Riverwood', 'NSW', '2210', 1),
(19575, 'Padstow Heights', 'NSW', '2211', 1),
(19576, 'Lugarno', 'NSW', '2210', 1),
(19577, 'Oatley', 'NSW', '2223', 1),
(19578, 'Kyle Bay', 'NSW', '2221', 1),
(19579, 'Connells Point', 'NSW', '2221', 1),
(19580, 'Carss Park', 'NSW', '2221', 1),
(19581, 'Hurstville Grove', 'NSW', '2220', 1),
(19582, 'Mortdale', 'NSW', '2223', 1),
(19583, 'South Hurstville', 'NSW', '2221', 1),
(19584, 'Allawah', 'NSW', '2218', 1),
(19585, 'Ramsgate', 'NSW', '2217', 1),
(19586, 'Sans Souci', 'NSW', '2219', 1),
(19587, 'Dolls Point', 'NSW', '2219', 1),
(19588, 'Sandringham', 'NSW', '2219', 1),
(19589, 'Kogarah', 'NSW', '2217', 1),
(19590, 'Brighton-Le-Sands', 'NSW', '2216', 1),
(19591, 'Kyeemagh', 'NSW', '2216', 1),
(19592, 'Banksia', 'NSW', '2216', 1),
(19593, 'Turrella', 'NSW', '2205', 1),
(19594, 'Wolli Creek', 'NSW', '2205', 1),
(19595, 'Bardwell Valley', 'NSW', '2207', 1),
(19596, 'Bardwell Park', 'NSW', '2207', 1),
(19597, 'Bexley North', 'NSW', '2207', 1),
(19598, 'Roselands', 'NSW', '2196', 1),
(19599, 'Belmore', 'NSW', '2192', 1),
(19600, 'Earlwood', 'NSW', '2206', 1),
(19601, 'Canterbury', 'NSW', '2193', 1),
(19602, 'Campsie', 'NSW', '2194', 1),
(19603, 'Lakemba', 'NSW', '2195', 1),
(19604, 'Villawood', 'NSW', '2163', 1),
(19605, 'Canley Vale', 'NSW', '2166', 1),
(19606, 'Canley Heights', 'NSW', '2166', 1),
(19607, 'St Johns Park', 'NSW', '2176', 1),
(19608, 'Silverdale', 'NSW', '2752', 1),
(19609, 'Werombi', 'NSW', '2570', 1),
(19610, 'Orangeville', 'NSW', '2570', 1),
(19611, 'Belimbla Park', 'NSW', '2570', 1),
(19612, 'Oakdale', 'NSW', '2570', 1),
(19613, 'The Oaks', 'NSW', '2570', 1),
(19614, 'Mount Hunter', 'NSW', '2570', 1),
(19615, 'Bickley Vale', 'NSW', '2570', 1),
(19616, 'Cawdor', 'NSW', '2570', 1),
(19617, 'Razorback', 'NSW', '2571', 1),
(19618, 'Picton', 'NSW', '2571', 1),
(19619, 'Thirlmere', 'NSW', '2572', 1),
(19620, 'Lakesland', 'NSW', '2572', 1),
(19621, 'Mowbray Park', 'NSW', '2571', 1),
(19622, 'Couridjah', 'NSW', '2571', 1),
(19623, 'Buxton', 'NSW', '2571', 1),
(19624, 'Bargo', 'NSW', '2574', 1),
(19625, 'Wilton', 'NSW', '2571', 1),
(19626, 'Appin', 'NSW', '2560', 1),
(19628, 'Douglas Park', 'NSW', '2569', 1),
(19630, 'Wetherill Park', 'NSW', '2164', 1),
(19631, 'Erskine Park', 'NSW', '2759', 1),
(19632, 'St Clair', 'NSW', '2759', 1),
(19633, 'Orchard Hills', 'NSW', '2748', 1),
(19634, 'Glenmore Park', 'NSW', '2745', 1),
(19635, 'Lapstone', 'NSW', '2773', 1),
(19636, 'Glenbrook', 'NSW', '2773', 1),
(19637, 'Emu Plains', 'NSW', '2750', 1),
(19638, 'Emu Heights', 'NSW', '2750', 1),
(19639, 'Mount Riverview', 'NSW', '2774', 1),
(19640, 'Jamisontown', 'NSW', '2750', 1),
(19641, 'South Penrith', 'NSW', '2750', 1),
(19642, 'Penrith', 'NSW', '2750', 1),
(19643, 'Cranebrook', 'NSW', '2749', 1),
(19644, 'Castlereagh', 'NSW', '2749', 1),
(19645, 'Yarramundi', 'NSW', '2753', 1),
(19646, 'Londonderry', 'NSW', '2753', 1),
(19647, 'Berkshire Park', 'NSW', '2765', 1),
(19648, 'Llandilo', 'NSW', '2747', 1),
(19649, 'Jordan Springs', 'NSW', '2747', 1),
(19650, 'Cambridge Gardens', 'NSW', '2747', 1),
(19651, 'Cambridge Park', 'NSW', '2747', 1),
(19652, 'Werrington', 'NSW', '2747', 1),
(19653, 'St Marys', 'NSW', '2760', 1),
(19654, 'Claremont Meadows', 'NSW', '2747', 1),
(19655, 'Caddens', 'NSW', '2747', 1),
(19656, 'Colyton', 'NSW', '2760', 1),
(19657, 'Oxley Park', 'NSW', '2760', 1),
(19658, 'North St Marys', 'NSW', '2760', 1),
(19659, 'Whalan', 'NSW', '2770', 1),
(19660, 'Hebersham', 'NSW', '2770', 1),
(19661, 'Dharruk', 'NSW', '2770', 1),
(19662, 'Emerton', 'NSW', '2770', 1),
(19663, 'Tregear', 'NSW', '2770', 1),
(19664, 'Lethbridge Park', 'NSW', '2770', 1),
(19665, 'Ropes Crossing', 'NSW', '2760', 1),
(19666, 'Shanes Park', 'NSW', '2747', 1),
(19667, 'Marsden Park', 'NSW', '2765', 1),
(19668, 'Quakers Hill', 'NSW', '2763', 1),
(19669, 'Plumpton', 'NSW', '2761', 1),
(19670, 'Oakhurst', 'NSW', '2761', 1),
(19671, 'Hassall Grove', 'NSW', '2761', 1),
(19672, 'Bidwill', 'NSW', '2770', 1),
(19673, 'Shalvey', 'NSW', '2770', 1),
(19674, 'Willmot', 'NSW', '2770', 1),
(19675, 'Schofields', 'NSW', '2762', 1),
(19676, 'Windsor Downs', 'NSW', '2756', 1),
(19677, 'Doonside', 'NSW', '2767', 1),
(19678, 'Lalor Park', 'NSW', '2147', 1),
(19679, 'Kings Langley', 'NSW', '2147', 1),
(19680, 'Kings Park', 'NSW', '2148', 1),
(19681, 'Woodcroft', 'NSW', '2767', 1),
(19682, 'Marayong', 'NSW', '2148', 1),
(19683, 'Dean Park', 'NSW', '2761', 1),
(19684, 'Dulwich Hill', 'NSW', '2203', 1),
(19685, 'La Perouse', 'NSW', '2036', 1),
(19686, 'Little Bay', 'NSW', '2036', 1),
(19687, 'Phillip Bay', 'NSW', '2036', 1),
(19688, 'Chifley', 'NSW', '2036', 1),
(19689, 'Malabar', 'NSW', '2036', 1),
(19690, 'Matraville', 'NSW', '2036', 1),
(19691, 'Pagewood', 'NSW', '2035', 1),
(19692, 'Daceyville', 'NSW', '2032', 1),
(19693, 'Kingsford', 'NSW', '2032', 1),
(19694, 'South Coogee', 'NSW', '2034', 1),
(19695, 'Rosebery', 'NSW', '2018', 1),
(19696, 'Surry Hills', 'NSW', '2010', 1),
(19697, 'Kensington', 'NSW', '2033', 1),
(19698, 'Randwick', 'NSW', '2031', 1),
(19699, 'Bondi Junction', 'NSW', '2022', 1),
(19700, 'Bondi', 'NSW', '2026', 1),
(19701, 'Bondi Beach', 'NSW', '2026', 1),
(19702, 'North Bondi', 'NSW', '2026', 1),
(19703, 'Dover Heights', 'NSW', '2030', 1),
(19704, 'Vaucluse', 'NSW', '2030', 1),
(19705, 'Watsons Bay', 'NSW', '2030', 1),
(19706, 'Rose Bay', 'NSW', '2029', 1),
(19707, 'Bellevue Hill', 'NSW', '2023', 1),
(19708, 'Point Piper', 'NSW', '2027', 1),
(19709, 'Double Bay', 'NSW', '2028', 1),
(19710, 'Darlinghurst', 'NSW', '2010', 1),
(19711, 'Elizabeth Bay', 'NSW', '2011', 1),
(19712, 'Woolloomooloo', 'NSW', '2011', 1),
(19713, 'Haymarket', 'NSW', '2000', 1),
(19714, 'Redfern', 'NSW', '2016', 1),
(19715, 'Waterloo', 'NSW', '2017', 1),
(19716, 'Zetland', 'NSW', '2017', 1),
(19717, 'Eastlakes', 'NSW', '2018', 1),
(19718, 'Hillsdale', 'NSW', '2036', 1),
(19719, 'Botany', 'NSW', '2019', 1),
(19720, 'Mascot', 'NSW', '2020', 1),
(19721, 'Leichhardt', 'NSW', '2040', 1),
(19722, 'Summer Hill', 'NSW', '2130', 1),
(19723, 'Ashbury', 'NSW', '2193', 1),
(19724, 'Belfield', 'NSW', '2191', 1),
(19725, 'Concord', 'NSW', '2137', 1),
(19726, 'Canada Bay', 'NSW', '2046', 1),
(19727, 'Abbotsford', 'NSW', '2046', 1),
(19728, 'Chiswick', 'NSW', '2046', 1),
(19729, 'Russell Lea', 'NSW', '2046', 1),
(19730, 'Rodd Point', 'NSW', '2046', 1),
(19731, 'Drummoyne', 'NSW', '2047', 1),
(19732, 'North Ryde', 'NSW', '2113', 1),
(19733, 'East Ryde', 'NSW', '2113', 1),
(19734, 'Gladesville', 'NSW', '2111', 1),
(19735, 'Hunters Hill', 'NSW', '2110', 1),
(19736, 'Huntleys Cove', 'NSW', '211`', 1),
(19737, 'Henley', 'NSW', '211`', 1),
(19738, 'Huntleys Point', 'NSW', '211`', 1),
(19739, 'Woolwich', 'NSW', '2110', 1),
(19740, 'Greenwich', 'NSW', '2065', 1),
(19741, 'North Sydney', 'NSW', '2060', 1),
(19742, 'Kirribilli', 'NSW', '2061', 1),
(19743, 'McMahons Point', 'NSW', '2060', 1),
(19744, 'Waverton', 'NSW', '2060', 1),
(19745, 'Cremorne Point', 'NSW', '2090', 1),
(19746, 'Kurraba Point', 'NSW', '2089', 1),
(19747, 'Clifton Gardens', 'NSW', '2088', 1),
(19748, 'Mosman', 'NSW', '2088', 1),
(19749, 'Northbridge', 'NSW', '2063', 1),
(19750, 'Cammeray', 'NSW', '2062', 1),
(19751, 'Artarmon', 'NSW', '2064', 1),
(19752, 'Castlecrag', 'NSW', '2068', 1),
(19753, 'Willoughby East', 'NSW', '2068', 1),
(19754, 'North Willoughby', 'NSW', '2068', 1),
(19755, 'Middle Cove', 'NSW', '2068', 1),
(19756, 'Castle Cove', 'NSW', '2069', 1),
(19757, 'Roseville Chase', 'NSW', '2069', 1),
(19758, 'Roseville', 'NSW', '2069', 1),
(19759, 'Chatswood', 'NSW', '2067', 1),
(19760, 'Chatswood West', 'NSW', '2067', 1),
(19761, 'West Lindfield', 'NSW', '2070', 1),
(19762, 'Eastwood', 'NSW', '2122', 1),
(19763, 'Denistone', 'NSW', '2114', 1),
(19764, 'Denistone West', 'NSW', '2114', 1),
(19765, 'Melrose Park', 'NSW', '2114', 1),
(19766, 'Putney', 'NSW', '2112', 1),
(19767, 'Rhodes', 'NSW', '2138', 1),
(19768, 'Cabarita', 'NSW', '2137', 1),
(19769, 'North Strathfield', 'NSW', '2137', 1),
(19770, 'Newington', 'NSW', '2127', 1),
(19771, 'Silverwater', 'NSW', '2128', 1),
(19772, 'Dundas', 'NSW', '2117', 1),
(19773, 'Telopea', 'NSW', '2117', 1),
(19774, 'Dundas Valley', 'NSW', '2117', 1),
(19775, 'Oatlands', 'NSW', '2117', 1),
(19776, 'North Parramatta', 'NSW', '2151', 1),
(19777, 'Harris Park', 'NSW', '2150', 1),
(19778, 'Camellia', 'NSW', '2142', 1),
(19779, 'Mays Hill', 'NSW', '2145', 1),
(19780, 'Westmead', 'NSW', '2145', 1),
(19781, 'Wentworthville', 'NSW', '2145', 1),
(19782, 'Girraween', 'NSW', '2145', 1),
(19783, 'Constitution Hill', 'NSW', '2145', 1),
(19784, 'Old Toongabbie', 'NSW', '2146', 1),
(19785, 'Glenwood', 'NSW', '2768', 1),
(19786, 'Parklea', 'NSW', '2768', 1),
(19787, 'Acacia Gardens', 'NSW', '2763', 1),
(19788, 'Kellyville Ridge', 'NSW', '2155', 1),
(19789, 'Rouse Hill', 'NSW', '2155', 1),
(19790, 'Tallawong', 'NSW', '2762', 1),
(19791, 'McGraths Hill', 'NSW', '2756', 1),
(19792, 'Oakville', 'NSW', '2765', 1),
(19793, 'Pitt Town', 'NSW', '2756', 1),
(19794, 'Gables', 'NSW', '2765', 1),
(19795, 'Box Hill', 'NSW', '2765', 1),
(19796, 'Nelson', 'NSW', '2765', 1),
(19797, 'Annangrove', 'NSW', '2156', 1),
(19798, 'North Kellyville', 'NSW', '2155', 1),
(19799, 'Beaumont Hills', 'NSW', '2155', 1),
(19800, 'Kellyville', 'NSW', '2155', 1),
(19801, 'Glenhaven', 'NSW', '2156', 1),
(19802, 'Castle Hill', 'NSW', '2154', 1),
(19803, 'Baulkham Hills', 'NSW', '2153', 1),
(19804, 'Northmead', 'NSW', '2152', 1),
(19805, 'Dural', 'NSW', '2158', 1),
(19806, 'Hornsby', 'NSW', '2077', 1),
(19807, 'Westleigh', 'NSW', '2120', 1),
(19808, 'Beecroft', 'NSW', '2119', 1),
(19809, 'Cheltenham', 'NSW', '2119', 1),
(19810, 'Epping', 'NSW', '2121', 1),
(19811, 'North Epping', 'NSW', '2121', 1),
(19812, 'South Turramurra', 'NSW', '2074', 1),
(19813, 'West Pymble', 'NSW', '2073', 1),
(19814, 'Pymble', 'NSW', '2073', 1),
(19815, 'Turramurra', 'NSW', '2074', 1),
(19816, 'Warrawee', 'NSW', '2074', 1),
(19817, 'Wahroonga', 'NSW', '2076', 1),
(19818, 'St Ives', 'NSW', '2075', 1),
(19819, 'Davidson', 'NSW', '2085', 1),
(19820, 'East Killara', 'NSW', '2071', 1),
(19822, 'East Lindfield', 'NSW', '2070', 1),
(19823, 'Killarney Heights', 'NSW', '2087', 1),
(19824, 'Frenchs Forest', 'NSW', '2086', 1),
(19825, 'Forestville', 'NSW', '2087', 1),
(19826, 'Allambie Heights', 'NSW', '2100', 1),
(19827, 'Seaforth', 'NSW', '2092', 1),
(19828, 'Balgowlah', 'NSW', '2093', 1),
(19829, 'Balgowlah Heights', 'NSW', '2093', 1),
(19830, 'Clontarf', 'NSW', '2093', 1),
(19831, 'Manly Vale', 'NSW', '2093', 1),
(19832, 'North Manly', 'NSW', '2100', 1),
(19833, 'Freshwater', 'NSW', '2096', 1),
(19834, 'Wingala', 'NSW', '2099', 1),
(19835, 'Brookvale', 'NSW', '2100', 1),
(19836, 'Dee Why', 'NSW', '2099', 1),
(19837, 'Narraweena', 'NSW', '2099', 1),
(19838, 'Beacon Hill', 'NSW', '2100', 1),
(19839, 'St Ives Chase', 'NSW', '2075', 1),
(19840, 'North Turramurra', 'NSW', '2074', 1),
(19841, 'Mount Colah', 'NSW', '2079', 1),
(19842, 'Hornsby Heights', 'NSW', '2077', 1),
(19843, 'Waitara', 'NSW', '2077', 1),
(19844, 'North Wahroonga', 'NSW', '2076', 1),
(19845, 'Duffys Forest', 'NSW', '2084', 1),
(19846, 'Terrey Hills', 'NSW', '2084', 1),
(19847, 'Cromer', 'NSW', '2099', 1),
(19848, 'North Narrabeen', 'NSW', '2101', 1),
(19849, 'Elanora Heights', 'NSW', '2101', 1),
(19850, 'Warriewood', 'NSW', '2102', 1),
(19851, 'Ingleside', 'NSW', '2101', 1),
(19852, 'Mona Vale', 'NSW', '2103', 1),
(19853, 'Newport', 'NSW', '2106', 1),
(19854, 'Bayview', 'NSW', '2104', 1),
(19855, 'Church Point', 'NSW', '2105', 1),
(19856, 'Bilgola Plateau', 'NSW', '2107', 1),
(19857, 'Bilgola Beach', 'NSW', '2107', 1),
(19858, 'Avalon Beach', 'NSW', '2107', 1),
(19859, 'Palm Beach', 'NSW', '2108', 1),
(19860, 'Greystanes', 'NSW', '2145', 1),
(19861, 'Stuart Park', 'NT', '0820', 1),
(19862, 'Larrakeyah', 'NT', '0820', 1),
(19863, 'The Gardens', 'NT', '0820', 1),
(19864, 'Bayview', 'NT', '0820', 1),
(19865, 'Woolner', 'NT', '0820', 1),
(19866, 'Fannie Bay', 'NT', '0820', 1),
(19867, 'The Narrows', 'NT', '0820', 1),
(19868, 'Winnellie', 'NT', '0820', 1),
(19869, 'Ludmilla', 'NT', '0820', 1),
(19870, 'Coconut Grove', 'NT', '0810', 1),
(19871, 'Nightcliff', 'NT', '0810', 1),
(19872, 'Rapid Creek', 'NT', '0810', 1),
(19873, 'Millner', 'NT', '0810', 1),
(19874, 'Brinkin', 'NT', '0810', 1),
(19875, 'Alawa', 'NT', '0810', 1),
(19876, 'Jingili', 'NT', '0810', 1),
(19877, 'Marrara', 'NT', '0812', 1),
(19878, 'Moil', 'NT', '0810', 1),
(19879, 'Wagaman', 'NT', '0810', 1),
(19880, 'Casuarina', 'NT', '0810', 1),
(19881, 'Tiwi', 'NT', '0810', 1),
(19882, 'Muirhead', 'NT', '0810', 1),
(19883, 'Lyons', 'NT', '0810', 1),
(19884, 'Leanyer', 'NT', '0812', 1),
(19885, 'Wulagi', 'NT', '0812', 1),
(19886, 'Malak', 'NT', '0812', 1),
(19887, 'Karama', 'NT', '0812', 1),
(19888, 'Berrimah', 'NT', '0828', 1),
(19889, 'Knuckey Lagoon', 'NT', '0828', 1),
(19890, 'Holtze', 'NT', '0829', 1),
(19891, 'Pinelands', 'NT', '0829', 1),
(19892, 'Durack', 'NT', '0830', 1),
(19893, 'Palmerston City', 'NT', '0830', 1),
(19894, 'Yarrawonga', 'NT', '0830', 1),
(19895, 'Driver', 'NT', '0830', 1),
(19896, 'Gray', 'NT', '0830', 1),
(19897, 'Bakewell', 'NT', '0832', 1),
(19898, 'Gunn', 'NT', '0832', 1),
(19899, 'Farrar', 'NT', '0830', 1),
(19900, 'Johnston', 'NT', '0832', 1),
(19901, 'Marlow Lagoon', 'NT', '0830', 1),
(19902, 'Moulden', 'NT', '0830', 1),
(19903, 'Woodroffe', 'NT', '0830', 1),
(19904, 'Rosebery', 'NT', '0832', 1),
(19905, 'Bellamack', 'NT', '0832', 1),
(19906, 'Zuccoli', 'NT', '0832', 1),
(19907, 'Howard Springs', 'NT', '0835', 1),
(19908, 'Girraween', 'NT', '0836', 1),
(19909, 'Mcminns Lagoon', 'NT', '0822', 1),
(19910, 'Virginia', 'NT', '0834', 1),
(19911, 'Coolangatta', 'QLD', '4225', 1),
(19912, 'Bilinga', 'QLD', '4224', 1),
(19913, 'Tugun', 'QLD', '4224', 1),
(19914, 'Currumbin Waters', 'QLD', '4223', 1),
(19915, 'Tallebudgera', 'QLD', '4228', 1),
(19916, 'Elanora', 'QLD', '4221', 1),
(19917, 'Currumbin', 'QLD', '4223', 1),
(19918, 'Palm Beach', 'QLD', '4221', 1),
(19919, 'Reedy Creek', 'QLD', '4227', 1),
(19920, 'Mudgeeraba', 'QLD', '4213', 1),
(19921, 'Varsity Lakes', 'QLD', '4227', 1),
(19922, 'Burleigh Waters', 'QLD', '4220', 1),
(19923, 'Miami', 'QLD', '4220', 1),
(19924, 'Mermaid Waters', 'QLD', '4218', 1),
(19925, 'Mermaid Beach', 'QLD', '4218', 1),
(19926, 'Merrimac', 'QLD', '4226', 1),
(19927, 'Tallai', 'QLD', '4213', 1),
(19928, 'Worongary', 'QLD', '4213', 1),
(19929, 'Gilston', 'QLD', '4211', 1),
(19930, 'Carrara', 'QLD', '4211', 1),
(19931, 'Broadbeach', 'QLD', '4218', 1),
(19932, 'Broadbeach Waters', 'QLD', '4218', 1),
(19933, 'Isle of Capri', 'QLD', '4217', 1),
(19934, 'Surfers Paradise', 'QLD', '4217', 1),
(19935, 'Ashmore', 'QLD', '4214', 1),
(19936, 'Main Beach', 'QLD', '4217', 1),
(19937, 'Southport', 'QLD', '4215', 1),
(19938, 'Molendinar', 'QLD', '4214', 1),
(19939, 'Labrador', 'QLD', '4215', 1),
(19940, 'Parkwood', 'QLD', '4214', 1),
(19941, 'Gaven', 'QLD', '4211', 1),
(19942, 'Pacific Pines', 'QLD', '4211', 1),
(19943, 'Coombabah', 'QLD', '4216', 1),
(19944, 'Runaway Bay', 'QLD', '4216', 1),
(19945, 'Paradise Point', 'QLD', '4216', 1),
(19946, 'Hope Island', 'QLD', '4212', 1),
(19947, 'Oxenford', 'QLD', '4210', 1),
(19948, 'Upper Coomera', 'QLD', '4209', 1),
(19949, 'Coomera', 'QLD', '4209', 1),
(19950, 'Pimpama', 'QLD', '4209', 1),
(19951, 'Jacobs Well', 'QLD', '4208', 1),
(19952, 'Ormeau', 'QLD', '4208', 1),
(19953, 'Beenleigh', 'QLD', '4207', 1),
(19954, 'Eagleby', 'QLD', '4207', 1),
(19955, 'Russell Island', 'QLD', '4184', 1),
(19956, 'Redland Bay', 'QLD', '4165', 1),
(19957, 'Thornlands', 'QLD', '4164', 1),
(19958, 'Victoria Point', 'QLD', '4165', 1),
(19960, 'Alexandra Hills', 'QLD', '4161', 1),
(19961, 'Birkdale', 'QLD', '4159', 1),
(19962, 'Wellington Point', 'QLD', '4160', 1),
(19963, 'Crestmead', 'QLD', '4132', 1),
(19964, 'Regents Park', 'QLD', '4118', 1),
(19965, 'Heritage Park', 'QLD', '4118', 1),
(19966, 'Boronia Heights', 'QLD', '4124', 1),
(19967, 'Greenbank', 'QLD', '4124', 1),
(19968, 'Springfield', 'QLD', '4300', 1),
(19969, 'Brookwater', 'QLD', '4300', 1),
(19970, 'Augustine Heights', 'QLD', '4300', 1),
(19971, 'Redbank Plains', 'QLD', '4301', 1),
(19972, 'Ripley', 'QLD', '4306', 1),
(19973, 'Flinders View', 'QLD', '4305', 1),
(19974, 'Yamanto', 'QLD', '4305', 1),
(19975, 'Leichhardt', 'QLD', '4305', 1),
(19976, 'One Mile', 'QLD', '4305', 1),
(19977, 'Raceview', 'QLD', '4305', 1),
(19978, 'Churchill', 'QLD', '4305', 1),
(19979, 'West Ipswich', 'QLD', '4305', 1),
(19980, 'Wulkuraka', 'QLD', '4305', 1),
(19981, 'Sadliers Crossing', 'QLD', '4305', 1),
(19982, 'Coalfalls', 'QLD', '4305', 1),
(19983, 'Woodend', 'QLD', '4305', 1),
(19984, 'Brassall', 'QLD', '4305', 1),
(19985, 'Karrabin', 'QLD', '4306', 1),
(19986, 'Walloon', 'QLD', '4306', 1),
(19987, 'Booval', 'QLD', '4304', 1),
(19988, 'Newtown', 'QLD', '4305', 1),
(19989, 'North Ipswich', 'QLD', '4305', 1),
(19990, 'Bundamba', 'QLD', '4304', 1),
(19991, 'North Booval', 'QLD', '4304', 1),
(19992, 'East Ipswich', 'QLD', '4305', 1),
(19993, 'Tivoli', 'QLD', '4305', 1),
(19994, 'Blackstone', 'QLD', '4304', 1),
(19995, 'Silkstone', 'QLD', '4304', 1),
(19996, 'Dinmore', 'QLD', '4303', 1),
(19997, 'Karalee', 'QLD', '4306', 1),
(19998, 'Chuwar', 'QLD', '4306', 1),
(19999, 'Barellan Point', 'QLD', '4306', 1),
(20000, 'Redbank', 'QLD', '4301', 1),
(20001, 'Moggill', 'QLD', '4070', 1),
(20002, 'Bellbowrie', 'QLD', '4070', 1),
(20003, 'Anstead', 'QLD', '4070', 1),
(20004, 'Pullenvale', 'QLD', '4069', 1),
(20005, 'Pinjarra Hills', 'QLD', '4069', 1),
(20006, 'Middle Park', 'QLD', '4074', 1),
(20007, 'Riverhills', 'QLD', '4074', 1),
(20008, 'Westlake', 'QLD', '4074', 1),
(20009, 'Jamboree Heights', 'QLD', '4074', 1),
(20010, 'Sumner', 'QLD', '4074', 1),
(20011, 'Wacol', 'QLD', '4076', 1),
(20012, 'Carole Park', 'QLD', '4300', 1),
(20013, 'Camira', 'QLD', '4300', 1),
(20014, 'Forest Lake', 'QLD', '4078', 1),
(20015, 'Heathwood', 'QLD', '4110', 1),
(20016, 'Pallara', 'QLD', '4110', 1),
(20017, 'Doolandella', 'QLD', '4077', 1),
(20018, 'Inala', 'QLD', '4077', 1),
(20019, 'Parkinson', 'QLD', '4115', 1),
(20020, 'Hillcrest', 'QLD', '4118', 1),
(20021, 'Forestdale', 'QLD', '4118', 1),
(20022, 'Waterford West', 'QLD', '4133', 1),
(20023, 'Waterford', 'QLD', '4133', 1),
(20024, 'Holmview', 'QLD', '4207', 1),
(20025, 'Bethania', 'QLD', '4205', 1),
(20026, 'Loganlea', 'QLD', '4131', 1),
(20027, 'Marsden', 'QLD', '4132', 1),
(20028, 'Berrinba', 'QLD', '4117', 1),
(20029, 'Drewvale', 'QLD', '4116', 1),
(20030, 'Browns Plains', 'QLD', '4118', 1),
(20031, 'Kingston', 'QLD', '4114', 1),
(20032, 'Woodridge', 'QLD', '4114', 1),
(20033, 'Slacks Creek', 'QLD', '4127', 1),
(20034, 'Springwood', 'QLD', '4127', 1),
(20035, 'Daisy Hill', 'QLD', '4127', 1),
(20036, 'Shailer Park', 'QLD', '4128', 1),
(20037, 'Cornubia', 'QLD', '4130', 1),
(20038, 'Rochedale South', 'QLD', '4123', 1),
(20039, 'Underwood', 'QLD', '4119', 1),
(20040, 'Kuraby', 'QLD', '4112', 1),
(20041, 'Runcorn', 'QLD', '4113', 1),
(20042, 'Sunnybank Hills', 'QLD', '4109', 1),
(20043, 'Oxley', 'QLD', '4075', 1),
(20044, 'Seventeen Mile Rocks', 'QLD', '4073', 1),
(20045, 'Mount Ommaney', 'QLD', '4074', 1),
(20046, 'Darra', 'QLD', '4076', 1),
(20047, 'Jindalee', 'QLD', '4074', 1),
(20048, 'Chapel Hill', 'QLD', '4069', 1),
(20049, 'Fig Tree Pocket', 'QLD', '4069', 1),
(20050, 'Sherwood', 'QLD', '4075', 1),
(20051, 'Corinda', 'QLD', '4075', 1),
(20052, 'Sunnybank', 'QLD', '4109', 1),
(20053, 'Robertson', 'QLD', '4109', 1),
(20054, 'Coopers Plains', 'QLD', '4108', 1),
(20055, 'Salisbury', 'QLD', '4107', 1),
(20056, 'Moorooka', 'QLD', '4105', 1),
(20057, 'Yeerongpilly', 'QLD', '4105', 1),
(20058, 'St Lucia', 'QLD', '4067', 1),
(20059, 'Indooroopilly', 'QLD', '4068', 1),
(20060, 'Chelmer', 'QLD', '4068', 1),
(20061, 'Graceville', 'QLD', '4075', 1),
(20062, 'Paddington', 'QLD', '4064', 1),
(20063, 'The Gap', 'QLD', '4061', 1),
(20064, 'Bardon', 'QLD', '4065', 1),
(20065, 'Upper Kedron', 'QLD', '4055', 1),
(20066, 'Ferny Grove', 'QLD', '4055', 1),
(20067, 'Arana Hills', 'QLD', '4054', 1),
(20068, 'Bunya', 'QLD', '4055', 1),
(20069, 'McDowall', 'QLD', '4053', 1),
(20070, 'Chermside', 'QLD', '4032', 1),
(20071, 'Everton Park', 'QLD', '4053', 1),
(20072, 'Stafford Heights', 'QLD', '4053', 1),
(20073, 'Chermside West', 'QLD', '4032', 1),
(20074, 'Aspley', 'QLD', '4034', 1),
(20075, 'Kedron', 'QLD', '4031', 1),
(20076, 'Kalinga', 'QLD', '4030', 1),
(20077, 'Windsor', 'QLD', '4030', 1),
(20078, 'Grange', 'QLD', '4051', 1),
(20079, 'Gordon Park', 'QLD', '4031', 1),
(20080, 'Teneriffe', 'QLD', '4005', 1),
(20081, 'Fortitude Valley', 'QLD', '4006', 1),
(20082, 'Newstead', 'QLD', '4006', 1),
(20083, 'Herston', 'QLD', '4006', 1),
(20084, 'Red Hill', 'QLD', '4059', 1),
(20085, 'South Brisbane', 'QLD', '4101', 1),
(20086, 'West End', 'QLD', '4101', 1),
(20087, 'Highgate Hill', 'QLD', '4101', 1),
(20088, 'Dutton Park', 'QLD', '4102', 1),
(20089, 'Fairfield', 'QLD', '4103', 1),
(20090, 'Yeronga', 'QLD', '4104', 1),
(20091, 'Tarragindi', 'QLD', '4121', 1),
(20092, 'Holland Park West', 'QLD', '4121', 1),
(20093, 'Greenslopes', 'QLD', '4120', 1),
(20094, 'Camp Hill', 'QLD', '4152', 1),
(20095, 'Norman Park', 'QLD', '4170', 1),
(20096, 'East Brisbane', 'QLD', '4169', 1),
(20097, 'Kangaroo Point', 'QLD', '4169', 1),
(20098, 'Morningside', 'QLD', '4170', 1),
(20099, 'Hawthorne', 'QLD', '4171', 1),
(20100, 'Seven Hills', 'QLD', '4170', 1),
(20101, 'Mount Gravatt', 'QLD', '4122', 1),
(20102, 'Upper Mount Gravatt', 'QLD', '4122', 1),
(20103, 'Rochedale', 'QLD', '4123', 1),
(20104, 'Burbank', 'QLD', '4156', 1),
(20105, 'Carindale', 'QLD', '4152', 1),
(20106, 'Belmont', 'QLD', '4153', 1),
(20107, 'Gumdale', 'QLD', '4154', 1),
(20108, 'Chandler', 'QLD', '4155', 1),
(20109, 'Thorneside', 'QLD', '4158', 1),
(20110, 'Ransome', 'QLD', '4154', 1),
(20111, 'Wakerley', 'QLD', '4154', 1),
(20112, 'Carina', 'QLD', '4152', 1),
(20113, 'Cannon Hill', 'QLD', '4170', 1),
(20114, 'Bulimba', 'QLD', '4171', 1),
(20115, 'Murarrie', 'QLD', '4172', 1),
(20116, 'Hemmant', 'QLD', '4174', 1),
(20117, 'Manly West', 'QLD', '4179', 1),
(20118, 'Lota', 'QLD', '4179', 1),
(20119, 'Manly', 'QLD', '4179', 1),
(20120, 'Wynnum', 'QLD', '4178', 1),
(20121, 'Lytton', 'QLD', '4178', 1),
(20122, 'Kelvin Grove', 'QLD', '4059', 1),
(20123, 'Hamilton', 'QLD', '4007', 1),
(20124, 'Eagle Farm', 'QLD', '4009', 1),
(20125, 'Pinkenba', 'QLD', '4008', 1),
(20126, 'Nundah', 'QLD', '4012', 1),
(20127, 'Northgate', 'QLD', '4013', 1),
(20128, 'Banyo', 'QLD', '4014', 1),
(20129, 'Nudgee', 'QLD', '4014', 1),
(20130, 'Hendra', 'QLD', '4011', 1),
(20131, 'Geebung', 'QLD', '4034', 1),
(20132, 'Boondall', 'QLD', '4034', 1),
(20133, 'Taigum', 'QLD', '4018', 1),
(20134, 'Fitzgibbon', 'QLD', '4018', 1),
(20135, 'Deagon', 'QLD', '4017', 1),
(20136, 'Shorncliffe', 'QLD', '4017', 1),
(20137, 'Bracken Ridge', 'QLD', '4017', 1),
(20138, 'Bald Hills', 'QLD', '4036', 1),
(20139, 'Brighton', 'QLD', '4017', 1),
(20140, 'Strathpine', 'QLD', '4500', 1),
(20141, 'Bray Park', 'QLD', '4500', 1),
(20142, 'Warner', 'QLD', '4500', 1),
(20143, 'Cashmere', 'QLD', '4500', 1),
(20144, 'Lawnton', 'QLD', '4501', 1),
(20145, 'Joyner', 'QLD', '4500', 1),
(20146, 'Whiteside', 'QLD', '4503', 1),
(20147, 'Petrie', 'QLD', '4502', 1),
(20148, 'Murrumba Downs', 'QLD', '4503', 1),
(20149, 'Griffin', 'QLD', '4503', 1),
(20150, 'Kallangur', 'QLD', '4503', 1),
(20151, 'Mango Hill', 'QLD', '4509', 1),
(20152, 'Clontarf', 'QLD', '4019', 1),
(20153, 'Woody Point', 'QLD', '4019', 1),
(20154, 'Margate', 'QLD', '4019', 1),
(20155, 'Redcliffe', 'QLD', '4020', 1),
(20156, 'Scarborough', 'QLD', '4020', 1),
(20157, 'Newport', 'QLD', '4020', 1),
(20158, 'Rothwell', 'QLD', '4022', 1),
(20159, 'Kippa-Ring', 'QLD', '4021', 1),
(20160, 'North Lakes', 'QLD', '4509', 1),
(20161, 'Dakabin', 'QLD', '4503', 1),
(20162, 'Deception Bay', 'QLD', '4508', 1),
(20163, 'Narangba', 'QLD', '4504', 1),
(20164, 'Burpengary East', 'QLD', '4505', 1),
(20165, 'Beachmere', 'QLD', '4510', 1),
(20166, 'Morayfield', 'QLD', '4506', 1),
(20167, 'McLaren Vale', 'SA', '5171', 1),
(20168, 'Aldinga Beach', 'SA', '5173', 1),
(20169, 'Port Willunga', 'SA', '5173', 1),
(20170, 'Maslin Beach', 'SA', '5170', 1),
(20171, 'Moana', 'SA', '5169', 1),
(20172, 'Seaford Rise', 'SA', '5169', 1),
(20173, 'Seaford', 'SA', '5169', 1),
(20174, 'Old Noarlunga', 'SA', '5168', 1),
(20175, 'Port Noarlunga South', 'SA', '5167', 1),
(20176, 'Port Noarlunga South', 'SA', '5169', 1),
(20177, 'Port Noarlunga', 'SA', '5167', 1),
(20178, 'Noarlunga Downs', 'SA', '5168', 1),
(20179, 'Huntfield Heights', 'SA', '5163', 1),
(20180, 'Hackham', 'SA', '5163', 1),
(20181, 'Morphett Vale', 'SA', '5162', 1),
(20182, 'Christie Downs', 'SA', '5164', 1),
(20183, 'Christies Beach', 'SA', '5165', 1),
(20184, 'O\'Sullivan Beach', 'SA', '5166', 1),
(20185, 'Reynella', 'SA', '5161', 1),
(20186, 'Woodcroft', 'SA', '5162', 1),
(20187, 'Old Reynella', 'SA', '5161', 1),
(20188, 'Hallett Cove', 'SA', '5158', 1),
(20189, 'Sheidow Park', 'SA', '5158', 1),
(20190, 'Trott Park', 'SA', '5158', 1),
(20191, 'Happy Valley', 'SA', '5159', 1),
(20192, 'Chandlers Hill', 'SA', '5159', 1),
(20193, 'Aberfoyle Park', 'SA', '5159', 1),
(20194, 'O\'Halloran Hill', 'SA', '5158', 1),
(20195, 'Seacliff', 'SA', '5049', 1),
(20196, 'Seacliff Park', 'SA', '5049', 1),
(20197, 'Seaview Downs', 'SA', '5049', 1),
(20198, 'Seacombe Heights', 'SA', '5047', 1),
(20199, 'Darlington', 'SA', '5047', 1),
(20200, 'Bedford Park', 'SA', '5042', 1),
(20201, 'Bellevue Heights', 'SA', '5050', 1),
(20202, 'Eden Hills', 'SA', '5050', 1),
(20203, 'Blackwood', 'SA', '5051', 1),
(20204, 'Hawthorndene', 'SA', '5051', 1),
(20205, 'Craigburn Farm', 'SA', '5051', 1),
(20206, 'Coromandel Valley', 'SA', '5051', 1),
(20207, 'Flagstaff Hill', 'SA', '5159', 1),
(20208, 'Tonsley', 'SA', '5042', 1),
(20209, 'Mitchell Park', 'SA', '5043', 1),
(20210, 'Marion', 'SA', '5043', 1),
(20211, 'Oaklands Park', 'SA', '5046', 1),
(20212, 'North Brighton', 'SA', '5048', 1),
(20213, 'Hove', 'SA', '5048', 1),
(20214, 'Brighton', 'SA', '5048', 1),
(20215, 'South Brighton', 'SA', '5048', 1),
(20216, 'Clovelly Park', 'SA', '5042', 1),
(20217, 'Saint Marys', 'SA', '5042', 1),
(20218, 'Panorama', 'SA', '5041', 1),
(20219, 'Pasadena', 'SA', '5042', 1),
(20220, 'Belair', 'SA', '5052', 1),
(20221, 'Springfield', 'SA', '5062', 1),
(20222, 'Lower Mitcham', 'SA', '5062', 1),
(20223, 'Colonel Light Gardens', 'SA', '5041', 1),
(20224, 'Daw Park', 'SA', '5041', 1),
(20225, 'Melrose Park', 'SA', '5039', 1),
(20226, 'Edwardstown', 'SA', '5039', 1),
(20227, 'South Plympton', 'SA', '5038', 1),
(20228, 'Plympton Park', 'SA', '5038', 1),
(20229, 'Camden Park', 'SA', '5038', 1),
(20230, 'Novar Gardens', 'SA', '5040', 1),
(20231, 'Glenelg North', 'SA', '5045', 1),
(20232, 'Glenelg', 'SA', '5045', 1),
(20233, 'North Plympton', 'SA', '5037', 1),
(20234, 'Plympton', 'SA', '5038', 1),
(20235, 'Glandore', 'SA', '5037', 1),
(20236, 'Black Forest', 'SA', '5035', 1),
(20237, 'Millswood', 'SA', '5034', 1),
(20238, 'Kings Park', 'SA', '5034', 1),
(20239, 'Clarence Gardens', 'SA', '5039', 1),
(20240, 'Cumberland Park', 'SA', '5041', 1),
(20241, 'Westbourne Park', 'SA', '5041', 1),
(20242, 'Hawthorn', 'SA', '5062', 1),
(20243, 'Kingswood', 'SA', '5062', 1),
(20244, 'Highgate', 'SA', '5063', 1),
(20245, 'Myrtle Bank', 'SA', '5064', 1),
(20246, 'Urrbrae', 'SA', '5064', 1),
(20247, 'Mount Osmond', 'SA', '5064', 1),
(20248, 'Glen Osmond', 'SA', '5064', 1),
(20249, 'Beaumont', 'SA', '5066', 1),
(20250, 'St Georges', 'SA', '5064', 1),
(20251, 'Glenunga', 'SA', '5064', 1),
(20252, 'Fullarton', 'SA', '5063', 1),
(20253, 'Frewville', 'SA', '5063', 1),
(20254, 'Glenside', 'SA', '5065', 1),
(20255, 'Eastwood', 'SA', '5063', 1),
(20256, 'Parkside', 'SA', '5063', 1),
(20257, 'Unley', 'SA', '5061', 1),
(20258, 'Malvern', 'SA', '5061', 1),
(20259, 'Wayville', 'SA', '5034', 1),
(20260, 'Forestville', 'SA', '5035', 1),
(20261, 'Everard Park', 'SA', '5035', 1),
(20262, 'Kurralta Park', 'SA', '5037', 1),
(20263, 'Netley', 'SA', '5037', 1),
(20264, 'Marleston', 'SA', '5033', 1),
(20265, 'West Beach', 'SA', '5024', 1),
(20266, 'West Richmond', 'SA', '5033', 1),
(20267, 'Richmond', 'SA', '5033', 1),
(20268, 'Mile End South', 'SA', '5031', 1),
(20269, 'Brooklyn Park', 'SA', '5032', 1),
(20270, 'Henley Beach South', 'SA', '5022', 1),
(20271, 'Lockleys', 'SA', '5032', 1),
(20272, 'Cowandilla', 'SA', '5033', 1),
(20273, 'Mile End', 'SA', '5031', 1),
(20274, 'Dulwich', 'SA', '5065', 1),
(20275, 'Toorak Gardens', 'SA', '5065', 1),
(20276, 'Rose Park', 'SA', '5067', 1),
(20277, 'Leabrook', 'SA', '5068', 1),
(20278, 'Marryatville', 'SA', '5068', 1),
(20279, 'Heathpool', 'SA', '5068', 1),
(20280, 'Erindale', 'SA', '5066', 1),
(20281, 'Burnside', 'SA', '5066', 1),
(20282, 'Stonyfell', 'SA', '5066', 1),
(20283, 'Wattle Park', 'SA', '5066', 1),
(20284, 'Skye', 'SA', '5072', 1),
(20285, 'Auldana', 'SA', '5072', 1),
(20286, 'Rosslyn Park', 'SA', '5072', 1),
(20287, 'Kensington Park', 'SA', '5068', 1),
(20288, 'Kensington Gardens', 'SA', '5068', 1),
(20289, 'Beulah Park', 'SA', '5067', 1),
(20290, 'Kensington', 'SA', '5068', 1),
(20291, 'Henley Beach', 'SA', '5022', 1),
(20292, 'Fulham Gardens', 'SA', '5024', 1),
(20293, 'Kidman Park', 'SA', '5025', 1),
(20294, 'Flinders Park', 'SA', '5025', 1),
(20295, 'Torrensville', 'SA', '5031', 1),
(20296, 'Thebarton', 'SA', '5031', 1),
(20297, 'North Adelaide', 'SA', '5006', 1),
(20298, 'College Park', 'SA', '5069', 1),
(20299, 'Norwood', 'SA', '5067', 1),
(20300, 'Kent Town', 'SA', '5067', 1),
(20301, 'Trinity Gardens', 'SA', '5068', 1),
(20302, 'Maylands', 'SA', '5069', 1),
(20303, 'Stepney', 'SA', '5069', 1),
(20304, 'Evandale', 'SA', '5069', 1),
(20305, 'Joslin', 'SA', '5070', 1),
(20306, 'Royston Park', 'SA', '5070', 1),
(20307, 'Marden', 'SA', '5070', 1),
(20308, 'Vale Park', 'SA', '5081', 1),
(20309, 'Walkerville', 'SA', '5081', 1),
(20310, 'Medindie', 'SA', '5081', 1),
(20311, 'Gilberton', 'SA', '5081', 1),
(20312, 'Thorngate', 'SA', '5082', 1),
(20313, 'Fitzroy', 'SA', '5082', 1),
(20314, 'Ovingham', 'SA', '5082', 1),
(20315, 'Brompton', 'SA', '5007', 1),
(20316, 'Welland', 'SA', '5007', 1),
(20317, 'Croydon', 'SA', '5008', 1),
(20318, 'West Croydon', 'SA', '5008', 1),
(20319, 'Beverley', 'SA', '5009', 1),
(20320, 'Findon', 'SA', '5023', 1),
(20321, 'Dernancourt', 'SA', '5075', 1),
(20322, 'Sefton Park', 'SA', '5083', 1),
(20323, 'Blair Athol', 'SA', '5084', 1),
(20324, 'Kilburn', 'SA', '5084', 1),
(20325, 'Clearview', 'SA', '5085', 1),
(20326, 'Enfield', 'SA', '5085', 1),
(20327, 'Northfield', 'SA', '5085', 1),
(20328, 'Northgate', 'SA', '5085', 1),
(20329, 'Giles Plains', 'SA', '5086', 1),
(20330, 'Greenacres', 'SA', '5086', 1),
(20331, 'Hampstead Gardens', 'SA', '5086', 1),
(20332, 'Hillcrest', 'SA', '5086', 1),
(20333, 'Manningham', 'SA', '5086', 1),
(20334, 'Oakden', 'SA', '5086', 1),
(20335, 'Klemzig', 'SA', '5087', 1),
(20336, 'Windsor Gardens', 'SA', '5087', 1),
(20337, 'Holden Hill', 'SA', '5088', 1),
(20338, 'Highbury', 'SA', '5089', 1),
(20339, 'Hope Valley', 'SA', '5090', 1),
(20340, 'Banksia Park', 'SA', '5091', 1),
(20341, 'Tea Tree Gully', 'SA', '5091', 1),
(20342, 'Vista', 'SA', '5091', 1),
(20343, 'Modbury', 'SA', '5092', 1),
(20344, 'Modbury Heights', 'SA', '5092', 1),
(20345, 'Modbury North', 'SA', '5092', 1),
(20346, 'Para Vista', 'SA', '5093', 1),
(20347, 'Valley View', 'SA', '5093', 1),
(20348, 'Dry Creek', 'SA', '5094', 1),
(20349, 'Gepps Cross', 'SA', '5094', 1),
(20350, 'Mawson Lakes', 'SA', '5095', 1),
(20351, 'Pooraka', 'SA', '5095', 1),
(20352, 'Gulfview Heights', 'SA', '5096', 1),
(20353, 'Para Hills', 'SA', '5096', 1),
(20354, 'Para Hills West', 'SA', '5096', 1),
(20355, 'Redwood Park', 'SA', '5097', 1),
(20356, 'Ridgehaven', 'SA', '5097', 1),
(20357, 'St Agnes', 'SA', '5097', 1),
(20358, 'Ingle Farm', 'SA', '5098', 1),
(20359, 'Walkley Heights', 'SA', '5098', 1),
(20360, 'Parafield', 'SA', '5106', 1),
(20361, 'Salisbury South', 'SA', '5106', 1),
(20362, 'Green Fields', 'SA', '5107', 1),
(20363, 'Parafield Gardens', 'SA', '5107', 1),
(20364, 'Paralowie', 'SA', '5108', 1),
(20365, 'Salisbury', 'SA', '5108', 1),
(20366, 'Salisbury Downs', 'SA', '5108', 1),
(20367, 'Salisbury North', 'SA', '5108', 1),
(20368, 'Brahma Lodge', 'SA', '5109', 1),
(20369, 'Salisbury East', 'SA', '5109', 1),
(20370, 'Salisbury Heights', 'SA', '5109', 1),
(20371, 'Salisbury Park', 'SA', '5109', 1),
(20372, 'Salisbury Plain', 'SA', '5109', 1),
(20373, 'Bolivar', 'SA', '5110', 1),
(20374, 'Buckland Park', 'SA', '5110', 1),
(20376, 'Burton', 'SA', '5110', 1),
(20377, 'Globe Derby Park', 'SA', '5110', 1),
(20378, 'St Kilda', 'SA', '5110', 1),
(20379, 'Waterloo Corner', 'SA', '5110', 1),
(20380, 'Edinburgh', 'SA', '5111', 1),
(20381, 'Elizabeth', 'SA', '5112', 1),
(20382, 'Elizabeth East', 'SA', '5112', 1),
(20383, 'Elizabeth Grove', 'SA', '5112', 1),
(20384, 'Elizabeth South', 'SA', '5112', 1),
(20385, 'Elizabeth Vale', 'SA', '5112', 1),
(20386, 'Hillbank', 'SA', '5112', 1),
(20387, 'Davoren Park', 'SA', '5113', 1),
(20388, 'Elizabeth Downs', 'SA', '5113', 1),
(20389, 'Elizabeth North', 'SA', '5113', 1),
(20390, 'Elizabeth Park', 'SA', '5113', 1),
(20391, 'Elizabeth West', 'SA', '5113', 1),
(20392, 'Andrews Farm', 'SA', '5114', 1),
(20395, 'Blakeview', 'SA', '5114', 1),
(20396, 'Craigmore', 'SA', '5114', 1),
(20397, 'Gould Creek', 'SA', '5114', 1),
(20398, 'Humbug Scrub', 'SA', '5114', 1),
(20399, 'One Tree Hill', 'SA', '5114', 1),
(20400, 'Smithfield', 'SA', '5114', 1),
(20401, 'Smithfield Plains', 'SA', '5114', 1),
(20402, 'Uleybury', 'SA', '5114', 1),
(20403, 'Yattalunga', 'SA', '5114', 1),
(20404, 'Munno Para', 'SA', '5115', 1),
(20405, 'Munno Para Downs', 'SA', '5115', 1),
(20406, 'Munno Para West', 'SA', '5115', 1),
(20407, 'Hillier', 'SA', '5116', 1),
(20408, 'Angle Vale', 'SA', '5117', 1),
(20409, 'Bibaringa', 'SA', '5118', 1),
(20410, 'Virginia', 'SA', '5120', 1),
(20411, 'Macdonald Park', 'SA', '5121', 1),
(20412, 'Penfield', 'SA', '5121', 1),
(20413, 'Penfield Gardens', 'SA', '5121', 1),
(20414, 'Golden Grove', 'SA', '5125', 1),
(20415, 'Greenwith', 'SA', '5125', 1),
(20416, 'Fairview Park', 'SA', '5126', 1),
(20417, 'Surrey Downs', 'SA', '5126', 1),
(20418, 'Yatala Vale', 'SA', '5126', 1),
(20419, 'Wynn Vale', 'SA', '5127', 1),
(20420, 'Houghton', 'SA', '5131', 1),
(20421, 'Adelaide', 'SA', '5005', 1),
(20422, 'Bowden', 'SA', '5007', 1),
(20423, 'Hindmarsh', 'SA', '5007', 1),
(20424, 'West Hindmarsh', 'SA', '5007', 1),
(20425, 'Croydon Park', 'SA', '5008', 1),
(20426, 'Devon Park', 'SA', '5008', 1),
(20427, 'Dudley Park', 'SA', '5008', 1),
(20428, 'Renown Park', 'SA', '5008', 1),
(20429, 'Ridleyton', 'SA', '5008', 1),
(20430, 'Allenby Gardens', 'SA', '5009', 1),
(20431, 'Kilkenny', 'SA', '5009', 1),
(20432, 'Angle Park', 'SA', '5010', 1),
(20433, 'Ferryden Park', 'SA', '5010', 1),
(20434, 'Woodville', 'SA', '5011', 1),
(20435, 'Woodville Park', 'SA', '5011', 1),
(20436, 'Woodville South', 'SA', '5011', 1),
(20437, 'Woodville West', 'SA', '5011', 1),
(20438, 'Athol Park', 'SA', '5012', 1),
(20439, 'Mansfield Park', 'SA', '5012', 1),
(20440, 'Woodville Gardens', 'SA', '5012', 1),
(20441, 'Woodville North', 'SA', '5012', 1),
(20442, 'Ottoway', 'SA', '5013', 1),
(20443, 'Pennington', 'SA', '5013', 1),
(20444, 'Rosewater', 'SA', '5013', 1),
(20445, 'Wingfield', 'SA', '5013', 1),
(20446, 'Albert Park', 'SA', '5014', 1),
(20447, 'Alberton', 'SA', '5014', 1),
(20448, 'Cheltenham', 'SA', '5014', 1),
(20449, 'Hendon', 'SA', '5014', 1),
(20450, 'Queenstown', 'SA', '5014', 1),
(20451, 'Royal Park', 'SA', '5014', 1),
(20452, 'Birkenhead', 'SA', '5015', 1),
(20453, 'Ethelton', 'SA', '5015', 1),
(20454, 'Glanville', 'SA', '5015', 1);
INSERT INTO `locations` (`id`, `area`, `state`, `postcode`, `active`) VALUES
(20455, 'New Port', 'SA', '5015', 1),
(20456, 'Port Adelaide', 'SA', '5015', 1),
(20457, 'Largs Bay', 'SA', '5016', 1),
(20458, 'Largs North', 'SA', '5016', 1),
(20459, 'Peterhead', 'SA', '5016', 1),
(20460, 'Osborne', 'SA', '5017', 1),
(20461, 'Taperoo', 'SA', '5017', 1),
(20462, 'North Haven', 'SA', '5018', 1),
(20463, 'Outer Harbor', 'SA', '5018', 1),
(20464, 'Exeter', 'SA', '5019', 1),
(20465, 'Semaphore', 'SA', '5019', 1),
(20466, 'Semaphore Park', 'SA', '5019', 1),
(20467, 'Semaphore South', 'SA', '5019', 1),
(20468, 'West Lakes Shore', 'SA', '5020', 1),
(20469, 'West Lakes', 'SA', '5021', 1),
(20470, 'Grange', 'SA', '5022', 1),
(20471, 'Tennyson', 'SA', '5022', 1),
(20472, 'Grange', 'SA', '5023', 1),
(20473, 'Seaton', 'SA', '5023', 1),
(20474, 'Fulham', 'SA', '5024', 1),
(20475, 'Underdale', 'SA', '5032', 1),
(20476, 'Hilton', 'SA', '5033', 1),
(20477, 'Clarence Park', 'SA', '5034', 1),
(20478, 'Goodwood', 'SA', '5034', 1),
(20479, 'Ashford', 'SA', '5035', 1),
(20480, 'Keswick', 'SA', '5035', 1),
(20481, 'Hyde Park', 'SA', '5061', 1),
(20482, 'Unley Park', 'SA', '5061', 1),
(20483, 'Linden Park', 'SA', '5065', 1),
(20484, 'Tusmore', 'SA', '5065', 1),
(20485, 'Hazelwood Park', 'SA', '5066', 1),
(20486, 'St Morris', 'SA', '5068', 1),
(20487, 'Hackney', 'SA', '5069', 1),
(20488, 'St Peters', 'SA', '5069', 1),
(20489, 'Felixstow', 'SA', '5070', 1),
(20490, 'Firle', 'SA', '5070', 1),
(20491, 'Glynde', 'SA', '5070', 1),
(20492, 'Payneham', 'SA', '5070', 1),
(20493, 'Payneham South', 'SA', '5070', 1),
(20495, 'Magill', 'SA', '5072', 1),
(20496, 'Hectorville', 'SA', '5073', 1),
(20497, 'Rostrevor', 'SA', '5073', 1),
(20498, 'Tranmere', 'SA', '5073', 1),
(20499, 'Campbelltown', 'SA', '5074', 1),
(20500, 'Newton', 'SA', '5074', 1),
(20501, 'Paradise', 'SA', '5075', 1),
(20502, 'Athelstone', 'SA', '5076', 1),
(20503, 'Collinswoof', 'SA', '5081', 1),
(20504, 'Medindie Gardens', 'SA', '5081', 1),
(20505, 'Prospect', 'SA', '5082', 1),
(20506, 'Broadview', 'SA', '5083', 1),
(20507, 'Nailsworth', 'SA', '5083', 1),
(20508, 'Leawood Gardens', 'SA', '5150', 1),
(20509, 'Garden Island', 'SA', '5960', 1),
(20510, 'Sturt', 'SA', '5047', 1),
(20511, 'Dover Gardens', 'SA', '5048', 1),
(20512, 'Kingston Park', 'SA', '5049', 1),
(20513, 'Marino', 'SA', '5049', 1),
(20514, 'Seacliff Downs', 'SA', '5049', 1),
(20515, 'Glenalta', 'SA', '5052', 1),
(20517, 'Brown Hill Creek', 'SA', '5062', 1),
(20518, 'Clapham', 'SA', '5062', 1),
(20519, 'Netherby', 'SA', '5062', 1),
(20520, 'Torrens Park', 'SA', '5062', 1),
(20521, 'Lynton', 'SA', '5062', 1),
(20522, 'Brown Hill Creek', 'SA', '5064', 1),
(20523, 'Ironbank', 'SA', '5153', 1),
(20524, 'Upper Sturt', 'SA', '5156', 1),
(20525, 'Cherry Gardens', 'SA', '5157', 1),
(20526, 'Clarendon', 'SA', '5157', 1),
(20527, 'Coromandel East', 'SA', '5157', 1),
(20528, 'Kangarilla', 'SA', '5157', 1),
(20529, 'Hallet Cove', 'SA', '5158', 1),
(20530, 'Reynella East', 'SA', '5161', 1),
(20531, 'Onkaparinga Hills', 'SA', '5162', 1),
(20532, 'Hackham West', 'SA', '5163', 1),
(20533, 'Noarlunga Centre', 'SA', '5168', 1),
(20534, 'Seaford Meadows', 'SA', '5169', 1),
(20535, 'Blewitt Springs', 'SA', '5171', 1),
(20536, 'McLaren Flat', 'SA', '5171', 1),
(20537, 'Tatachilla', 'SA', '5171', 1),
(20538, 'Whites Valley', 'SA', '5172', 1),
(20539, 'Willunga', 'SA', '5172', 1),
(20540, 'Willunga South', 'SA', '5172', 1),
(20541, 'Aldinga', 'SA', '5173', 1),
(20542, 'Sellicks Beach', 'SA', '5174', 1),
(20543, 'Sellicks Hill', 'SA', '5174', 1),
(20548, 'New Town', 'TAS', '7008', 1),
(20550, 'Collinsvale', 'TAS', '7012', 1),
(20557, 'Rosny', 'TAS', '7018', 1),
(20558, 'Clarendon Vale', 'TAS', '7019', 1),
(20560, 'Sandford', 'TAS', '7020', 1),
(20561, 'South Arm', 'TAS', '7022', 1),
(20563, 'Cremorne', 'TAS', '7024', 1),
(20565, 'Richmond', 'TAS', '7025', 1),
(20570, 'Bagdad', 'TAS', '7030', 1),
(20572, 'Bothwell', 'TAS', '7030', 1),
(20573, 'Bridgewater', 'TAS', '7030', 1),
(20574, 'Brighton', 'TAS', '7030', 1),
(20581, 'Granton', 'TAS', '7030', 1),
(20585, 'Kempton', 'TAS', '7030', 1),
(20590, 'Mangalore', 'TAS', '7030', 1),
(20596, 'Pontville', 'TAS', '7030', 1),
(20603, 'Kingston Beach', 'TAS', '7050', 1),
(20604, 'Blackmans Bay', 'TAS', '7052', 1),
(20605, 'Bonnet Hill', 'TAS', '7053', 1),
(20607, 'Coningham', 'TAS', '7054', 1),
(20608, 'Electrona', 'TAS', '7054', 1),
(20610, 'Howden', 'TAS', '7054', 1),
(20611, 'Leslie Vale', 'TAS', '7054', 1),
(20612, 'Lower Snug', 'TAS', '7054', 1),
(20613, 'Margate', 'TAS', '7054', 1),
(20615, 'Nierinna', 'TAS', '7054', 1),
(20617, 'Snug', 'TAS', '7054', 1),
(20618, 'Tinderbox', 'TAS', '7054', 1),
(20620, 'Huntingfield', 'TAS', '7055', 1),
(20625, 'Glen Huon', 'TAS', '7109', 1),
(20627, 'Grove', 'TAS', '7109', 1),
(20629, 'Huonville', 'TAS', '7109', 1),
(20635, 'Lucaston', 'TAS', '7109', 1),
(20641, 'Ranelagh', 'TAS', '7109', 1),
(20649, 'Abels Bay', 'TAS', '7112', 1),
(20650, 'Charlotte Cove', 'TAS', '7112', 1),
(20651, 'Cygnet', 'TAS', '7112', 1),
(20653, 'Eggs And Bacon Bay', 'TAS', '7112', 1),
(20658, 'Verona Sands', 'TAS', '7112', 1),
(20659, 'Franklin', 'TAS', '7113', 1),
(20663, 'Geeveston', 'TAS', '7116', 1),
(20665, 'Port Huon', 'TAS', '7116', 1),
(20668, 'Dover', 'TAS', '7117', 1),
(20677, 'Oatlands', 'TAS', '7120', 1),
(20678, 'Parattah', 'TAS', '7120', 1),
(20710, 'Lachlan', 'TAS', '7140', 1),
(20712, 'Lawitta', 'TAS', '7140', 1),
(20716, 'Magra', 'TAS', '7140', 1),
(20725, 'New Norfolk', 'TAS', '7140', 1),
(20727, 'Ouse', 'TAS', '7140', 1),
(20738, 'Westerway', 'TAS', '7140', 1),
(20764, 'Woodbridge', 'TAS', '7162', 1),
(20767, 'Acton Park', 'TAS', '7170', 1),
(20768, 'Cambridge', 'TAS', '7170', 1),
(20771, 'Midway Point', 'TAS', '7171', 1),
(20776, 'Sorell', 'TAS', '7172', 1),
(20778, 'Carlton', 'TAS', '7173', 1),
(20780, 'Connellys Marsh', 'TAS', '7173', 1),
(20781, 'Dodges Ferry', 'TAS', '7173', 1),
(20783, 'Lewisham', 'TAS', '7173', 1),
(20784, 'Primrose Sands', 'TAS', '7173', 1),
(20790, 'Dunalley', 'TAS', '7177', 1),
(20816, 'Swansea', 'TAS', '7190', 1),
(20817, 'Triabunna', 'TAS', '7190', 1),
(20818, 'Ross', 'TAS', '7209', 1),
(20829, 'Evendale', 'TAS', '7212', 1),
(20830, 'Nile', 'TAS', '7212', 1),
(20836, 'Fingal', 'TAS', '7214', 1),
(20841, 'Bicheno', 'TAS', '7215', 1),
(20844, 'Cornwall', 'TAS', '7215', 1),
(20851, 'Scamander', 'TAS', '7215', 1),
(20853, 'St Marys', 'TAS', '7215', 1),
(20862, 'St Helens', 'TAS', '7216', 1),
(20865, 'Alanvale', 'TAS', '7248', 1),
(20867, 'Invermay', 'TAS', '7248', 1),
(20868, 'Mayfield', 'TAS', '7248', 1),
(20869, 'Mowbray', 'TAS', '7248', 1),
(20871, 'Newnham', 'TAS', '7248', 1),
(20872, 'Rocherlea', 'TAS', '7248', 1),
(20874, 'Kings Meadows', 'TAS', '7249', 1),
(20875, 'Punchbowl', 'TAS', '7249', 1),
(20876, 'Sandhill', 'TAS', '7249', 1),
(20877, 'South Launceston', 'TAS', '7249', 1),
(20878, 'Youngtown', 'TAS', '7249', 1),
(20879, 'Blackstone Heights', 'TAS', '7250', 1),
(20880, 'East Launceston', 'TAS', '7250', 1),
(20881, 'Elphin', 'TAS', '7250', 1),
(20882, 'Launceston', 'TAS', '7250', 1),
(20883, 'Newstead', 'TAS', '7250', 1),
(20884, 'Norwood', 'TAS', '7250', 1),
(20885, 'Prospect', 'TAS', '7250', 1),
(20886, 'Ravenswood', 'TAS', '7250', 1),
(20887, 'Riverside', 'TAS', '7250', 1),
(20888, 'St Leonards', 'TAS', '7250', 1),
(20889, 'Summerhill', 'TAS', '7250', 1),
(20891, 'Trevallyn', 'TAS', '7250', 1),
(20893, 'West Launceston', 'TAS', '7250', 1),
(20895, 'Dilston', 'TAS', '7252', 1),
(20898, 'Lulworth', 'TAS', '7252', 1),
(20903, 'Weymouth', 'TAS', '7252', 1),
(20906, 'George Town', 'TAS', '7253', 1),
(20909, 'Bellingham', 'TAS', '7254', 1),
(20933, 'Grassy', 'TAS', '7256', 1),
(20964, 'Scottsdale', 'TAS', '7260', 1),
(20970, 'Branxholm', 'TAS', '7261', 1),
(20972, 'Bridport', 'TAS', '7262', 1),
(20976, 'Legerwood', 'TAS', '7263', 1),
(20995, 'Winnaleah', 'TAS', '7265', 1),
(21001, 'Lilydale', 'TAS', '7268', 1),
(21006, 'Beauty Point', 'TAS', '7270', 1),
(21009, 'Greens Beach', 'TAS', '7270', 1),
(21010, 'Ilfraville', 'TAS', '7270', 1),
(21016, 'Blackwall', 'TAS', '7275', 1),
(21018, 'Exeter', 'TAS', '7275', 1),
(21022, 'Lanena', 'TAS', '7275', 1),
(21028, 'Gravelly Beach', 'TAS', '7276', 1),
(21031, 'Legana', 'TAS', '7277', 1),
(21032, 'Rosevears', 'TAS', '7277', 1),
(21033, 'Hadpsen', 'TAS', '7290', 1),
(21034, 'Carrick', 'TAS', '7291', 1),
(21040, 'Devon Hills', 'TAS', '7300', 1),
(21041, 'Perth', 'TAS', '7300', 1),
(21046, 'Longford', 'TAS', '7301', 1),
(21049, 'Cressy', 'TAS', '7302', 1),
(21056, 'Westbury', 'TAS', '7303', 1),
(21064, 'Deloraine', 'TAS', '7304', 1),
(21088, 'Railton', 'TAS', '7305', 1),
(21096, 'Gowrie Park', 'TAS', '7306', 1),
(21106, 'Sheffield', 'TAS', '7306', 1),
(21112, 'Hawley Beach', 'TAS', '7307', 1),
(21113, 'Latrobe', 'TAS', '7307', 1),
(21116, 'Port Sorell', 'TAS', '7307', 1),
(21117, 'Sassafras', 'TAS', '7307', 1),
(21118, 'Shearwater', 'TAS', '7307', 1),
(21121, 'Wesley Vale', 'TAS', '7307', 1),
(21123, 'Ambleside', 'TAS', '7310', 1),
(21124, 'Devonport', 'TAS', '7310', 1),
(21125, 'Don', 'TAS', '7310', 1),
(21126, 'East Devonport', 'TAS', '7310', 1),
(21128, 'Eugenana', 'TAS', '7310', 1),
(21129, 'Forth', 'TAS', '7310', 1),
(21134, 'Melrose', 'TAS', '7310', 1),
(21135, 'Miandetta', 'TAS', '7310', 1),
(21138, 'Quoiba', 'TAS', '7310', 1),
(21139, 'South Spreyton', 'TAS', '7310', 1),
(21140, 'Spreyton', 'TAS', '7310', 1),
(21141, 'Stony Rise', 'TAS', '7310', 1),
(21142, 'Tarleton', 'TAS', '7310', 1),
(21143, 'Tugrah', 'TAS', '7310', 1),
(21144, 'Wilmot', 'TAS', '7310', 1),
(21145, 'Abbotsham', 'TAS', '7315', 1),
(21147, 'Gawler', 'TAS', '7315', 1),
(21149, 'Leith', 'TAS', '7315', 1),
(21157, 'Sprent', 'TAS', '7315', 1),
(21158, 'Turners Beach', 'TAS', '7315', 1),
(21159, 'Ulverstone', 'TAS', '7315', 1),
(21161, 'West Ulverstone', 'TAS', '7315', 1),
(21164, 'Heybridge', 'TAS', '7316', 1),
(21167, 'Penguin', 'TAS', '7316', 1),
(21168, 'Preservation Bay', 'TAS', '7316', 1),
(21171, 'Sulphur Creek', 'TAS', '7316', 1),
(21173, 'Acton', 'TAS', '7320', 1),
(21174, 'Brooklyn', 'TAS', '7320', 1),
(21175, 'Burnie', 'TAS', '7320', 1),
(21176, 'Camdale', 'TAS', '7320', 1),
(21177, 'Cooee', 'TAS', '7320', 1),
(21178, 'Downlands', 'TAS', '7320', 1),
(21179, 'Emu Heights', 'TAS', '7320', 1),
(21180, 'Havenview', 'TAS', '7320', 1),
(21181, 'Hillcrest', 'TAS', '7320', 1),
(21182, 'Montello', 'TAS', '7320', 1),
(21183, 'Ocean Vista', 'TAS', '7320', 1),
(21184, 'Park Grove', 'TAS', '7320', 1),
(21185, 'Parklands', 'TAS', '7320', 1),
(21186, 'Romaine', 'TAS', '7320', 1),
(21188, 'Shorewell Park', 'TAS', '7320', 1),
(21189, 'South Burnie', 'TAS', '7320', 1),
(21190, 'Upper Burnie', 'TAS', '7320', 1),
(21191, 'Wivenhoe', 'TAS', '7320', 1),
(21205, 'Hellyer', 'TAS', '7321', 1),
(21211, 'Natone', 'TAS', '7321', 1),
(21216, 'Sisters Beach', 'TAS', '7321', 1),
(21217, 'Stowport', 'TAS', '7321', 1),
(21219, 'Tullah', 'TAS', '7321', 1),
(21222, 'Waratah', 'TAS', '7321', 1),
(21227, 'Somerset', 'TAS', '7322', 1),
(21247, 'Wynyard', 'TAS', '7325', 1),
(21248, 'Yolla', 'TAS', '7325', 1),
(21256, 'Forest', 'TAS', '7330', 1),
(21271, 'Smithton', 'TAS', '7330', 1),
(21279, 'Stanley', 'TAS', '7331', 1),
(21280, 'Gormanston', 'TAS', '7466', 1),
(21282, 'Queenstown', 'TAS', '7467', 1),
(21284, 'Strahan', 'TAS', '7468', 1),
(21288, 'Zeehan', 'TAS', '7469', 1),
(21289, 'Rosebery', 'TAS', '7470', 1),
(21290, 'Lenah Valley', 'TAS', '7008', 1),
(21293, 'Southbank', 'VIC', '3006', 1),
(21295, 'Seddon', 'VIC', '3011', 1),
(21297, 'Brooklyn', 'VIC', '3012', 1),
(21298, 'Kingsville', 'VIC', '3012', 1),
(21299, 'Maidstone', 'VIC', '3012', 1),
(21300, 'Tottenham', 'VIC', '3012', 1),
(21302, 'Yarraville', 'VIC', '3013', 1),
(21305, 'Spotswood', 'VIC', '3015', 1),
(21306, 'Williamstown', 'VIC', '3016', 1),
(21307, 'Altona', 'VIC', '3018', 1),
(21308, 'Seaholme', 'VIC', '3018', 1),
(21309, 'Braybrook', 'VIC', '3019', 1),
(21310, 'Robinson', 'VIC', '3019', 1),
(21311, 'Albion', 'VIC', '3020', 1),
(21312, 'Albanvale', 'VIC', '3021', 1),
(21313, 'Kealba', 'VIC', '3021', 1),
(21314, 'Kings Park', 'VIC', '3021', 1),
(21315, 'Ardeer', 'VIC', '3022', 1),
(21317, 'Burnside', 'VIC', '3023', 1),
(21318, 'Cairnlea', 'VIC', '3023', 1),
(21319, 'Caroline Springs', 'VIC', '3023', 1),
(21320, 'Deer Park', 'VIC', '3023', 1),
(21321, 'Mount Cottrell', 'VIC', '3024', 1),
(21322, 'Wyndham Vale', 'VIC', '3024', 1),
(21325, 'Seabrook', 'VIC', '3028', 1),
(21326, 'Hoppers Crossing', 'VIC', '3029', 1),
(21327, 'Tarneit', 'VIC', '3029', 1),
(21328, 'Derrimut', 'VIC', '3030', 1),
(21329, 'Point Cook', 'VIC', '3030', 1),
(21330, 'Werribee', 'VIC', '3030', 1),
(21331, 'Flemington', 'VIC', '3031', 1),
(21332, 'Kensington', 'VIC', '3031', 1),
(21333, 'Ascot Vale', 'VIC', '3032', 1),
(21334, 'Highpoint City', 'VIC', '3032', 1),
(21335, 'Maribymong', 'VIC', '3032', 1),
(21336, 'Travancore', 'VIC', '3032', 1),
(21338, 'Avondale Heights', 'VIC', '3034', 1),
(21339, 'Keilor', 'VIC', '3036', 1),
(21341, 'Delahey', 'VIC', '3037', 1),
(21342, 'Hillside', 'VIC', '3037', 1),
(21343, 'Sydenham', 'VIC', '3037', 1),
(21345, 'Taylors Lakes', 'VIC', '3038', 1),
(21346, 'Moonee Ponds', 'VIC', '3039', 1),
(21347, 'Aberfeldie', 'VIC', '3040', 1),
(21348, 'Essendon', 'VIC', '3040', 1),
(21354, 'Gladstone Park', 'VIC', '3043', 1),
(21355, 'Gowanbrae', 'VIC', '3043', 1),
(21356, 'Tullamarine', 'VIC', '3043', 1),
(21357, 'Pascoe Vale', 'VIC', '3044', 1),
(21359, 'Glenroy', 'VIC', '3046', 1),
(21360, 'Hadfield', 'VIC', '3046', 1),
(21361, 'Oak Park', 'VIC', '3046', 1),
(21362, 'Broadmeadows', 'VIC', '3047', 1),
(21363, 'Dallas', 'VIC', '3047', 1),
(21364, 'Jacana', 'VIC', '3047', 1),
(21365, 'Coolaroo', 'VIC', '3048', 1),
(21367, 'Attwood', 'VIC', '3049', 1),
(21368, 'Westmeadows', 'VIC', '3049', 1),
(21370, 'Hotham Hill', 'VIC', '3051', 1),
(21371, 'Parkville', 'VIC', '3052', 1),
(21376, 'Brunswick', 'VIC', '3056', 1),
(21378, 'Coburg', 'VIC', '3058', 1),
(21380, 'Merlynston', 'VIC', '3058', 1),
(21381, 'Moreland', 'VIC', '3058', 1),
(21382, 'Greenvale', 'VIC', '3059', 1),
(21383, 'Fawkner', 'VIC', '3060', 1),
(21384, 'Campbellfield', 'VIC', '3061', 1),
(21385, 'Oaklands Junction', 'VIC', '3063', 1),
(21386, 'Yuroke', 'VIC', '3063', 1),
(21387, 'Craigieburn', 'VIC', '3064', 1),
(21388, 'Donnybrook', 'VIC', '3064', 1),
(21389, 'Kalkallo', 'VIC', '3064', 1),
(21390, 'Mickleham', 'VIC', '3064', 1),
(21391, 'Roxburgh Park', 'VIC', '3064', 1),
(21392, 'Collingwood', 'VIC', '3066', 1),
(21393, 'Abbotsford', 'VIC', '3067', 1),
(21394, 'Clifton Hill', 'VIC', '3068', 1),
(21396, 'Northcote', 'VIC', '3070', 1),
(21397, 'Thornbury', 'VIC', '3071', 1),
(21398, 'Northland Centre', 'VIC', '3072', 1),
(21401, 'Keon Park', 'VIC', '3073', 1),
(21402, 'Reservoir', 'VIC', '3073', 1),
(21403, 'Thomastown', 'VIC', '3074', 1),
(21404, 'Lalor', 'VIC', '3075', 1),
(21405, 'Alphington', 'VIC', '3078', 1),
(21406, 'Fairfield', 'VIC', '3078', 1),
(21407, 'Ivanhoe', 'VIC', '3079', 1),
(21411, 'Mill Park', 'VIC', '3082', 1),
(21412, 'Kingsbury', 'VIC', '3083', 1),
(21413, 'Banyule', 'VIC', '3084', 1),
(21414, 'Eaglemount', 'VIC', '3084', 1),
(21415, 'Heidelberg', 'VIC', '3084', 1),
(21416, 'Rosanna', 'VIC', '3084', 1),
(21417, 'Viewbank', 'VIC', '3084', 1),
(21418, 'Macleod', 'VIC', '3085', 1),
(21419, 'Yallambie', 'VIC', '3085', 1),
(21420, 'Watsonia', 'VIC', '3087', 1),
(21421, 'Briar Hill', 'VIC', '3088', 1),
(21422, 'Greensborough', 'VIC', '3088', 1),
(21423, 'Saint Helena', 'VIC', '3088', 1),
(21425, 'Plenty', 'VIC', '3090', 1),
(21426, 'Yarrambat', 'VIC', '3091', 1),
(21427, 'Lower Plenty', 'VIC', '3093', 1),
(21428, 'Montmorency', 'VIC', '3094', 1),
(21429, 'Eltham', 'VIC', '3095', 1),
(21431, 'Research', 'VIC', '3096', 1),
(21432, 'Wattle Glen', 'VIC', '3096', 1),
(21434, 'Kangaroo Ground', 'VIC', '3097', 1),
(21435, 'Watsons Creek', 'VIC', '3097', 1),
(21438, 'Hurstbridge', 'VIC', '3099', 1),
(21439, 'Nutfield', 'VIC', '3099', 1),
(21440, 'Strathewen', 'VIC', '3099', 1),
(21441, 'Kew', 'VIC', '3101', 1),
(21443, 'Balwyn', 'VIC', '3103', 1),
(21445, 'Bulleen', 'VIC', '3105', 1),
(21447, 'Doncaster', 'VIC', '3108', 1),
(21450, 'Donvale', 'VIC', '3111', 1),
(21452, 'Warrandyte', 'VIC', '3113', 1),
(21453, 'Park Orchards', 'VIC', '3114', 1),
(21454, 'Wonga Park', 'VIC', '3115', 1),
(21455, 'Chirnside Park', 'VIC', '3116', 1),
(21456, 'Burnley', 'VIC', '3121', 1),
(21457, 'Cremorne', 'VIC', '3121', 1),
(21459, 'Camberwell', 'VIC', '3124', 1),
(21463, 'Middle Camberwell', 'VIC', '3124', 1),
(21464, 'Burwood', 'VIC', '3125', 1),
(21466, 'Canterbury', 'VIC', '3126', 1),
(21467, 'Mont Albert', 'VIC', '3127', 1),
(21468, 'Surrey Hills', 'VIC', '3127', 1),
(21470, 'Houston', 'VIC', '3128', 1),
(21471, 'Wattle Park', 'VIC', '3128', 1),
(21473, 'Kerrimuir', 'VIC', '3129', 1),
(21475, 'Blackburn', 'VIC', '3130', 1),
(21478, 'Laburnum', 'VIC', '3130', 1),
(21480, 'Forest Hill', 'VIC', '3131', 1),
(21481, 'Mitcham', 'VIC', '3132', 1),
(21482, 'Rangeview', 'VIC', '3132', 1),
(21483, 'Vermont', 'VIC', '3133', 1),
(21485, 'Ringwood', 'VIC', '3134', 1),
(21488, 'Warranwood', 'VIC', '3134', 1),
(21490, 'Heathmont', 'VIC', '3135', 1),
(21492, 'Croydon', 'VIC', '3136', 1),
(21496, 'Kilsyth', 'VIC', '3137', 1),
(21498, 'Hoddles Creek', 'VIC', '3139', 1),
(21499, 'Launching Place', 'VIC', '3139', 1),
(21500, 'Seville', 'VIC', '3139', 1),
(21502, 'Woori Yallock', 'VIC', '3139', 1),
(21503, 'Yellingbo', 'VIC', '3139', 1),
(21504, 'Lilydale', 'VIC', '3140', 1),
(21506, 'Hawksburn', 'VIC', '3142', 1),
(21507, 'Toorak', 'VIC', '3142', 1),
(21508, 'Armadale', 'VIC', '3143', 1),
(21510, 'Kooyong', 'VIC', '3144', 1),
(21511, 'Malvern', 'VIC', '3144', 1),
(21513, 'Central Park', 'VIC', '3145', 1),
(21516, 'Glen Iris', 'VIC', '3146', 1),
(21517, 'Ashburton', 'VIC', '3147', 1),
(21518, 'Ashwood', 'VIC', '3147', 1),
(21519, 'Chadstone', 'VIC', '3148', 1),
(21520, 'Holmesglen', 'VIC', '3148', 1),
(21521, 'Syndal', 'VIC', '3149', 1),
(21522, 'Glen Waverley', 'VIC', '3150', 1),
(21523, 'Wheelers Hill', 'VIC', '3150', 1),
(21526, 'Knox City Centre', 'VIC', '3152', 1),
(21527, 'Studfield', 'VIC', '3152', 1),
(21528, 'Wantirna', 'VIC', '3152', 1),
(21531, 'The Basin', 'VIC', '3154', 1),
(21532, 'Boronia', 'VIC', '3155', 1),
(21533, 'Lysterfield', 'VIC', '3156', 1),
(21534, 'Mountain Gate', 'VIC', '3156', 1),
(21535, 'Upper Ferntree Gully', 'VIC', '3156', 1),
(21536, 'Upwey', 'VIC', '3158', 1),
(21537, 'Menzies Creek', 'VIC', '3159', 1),
(21538, 'Selby', 'VIC', '3159', 1),
(21539, 'Tecoma', 'VIC', '3160', 1),
(21542, 'Caulfield', 'VIC', '3162', 1),
(21545, 'Carnegie', 'VIC', '3163', 1),
(21546, 'Glen Huntly', 'VIC', '3163', 1),
(21547, 'Murrumbeena', 'VIC', '3163', 1),
(21551, 'Hughesdale', 'VIC', '3166', 1),
(21552, 'Oakleigh', 'VIC', '3166', 1),
(21555, 'Clayton', 'VIC', '3168', 1),
(21556, 'Notting Hill', 'VIC', '3168', 1),
(21557, 'Clarinda', 'VIC', '3169', 1),
(21559, 'Mulgrave', 'VIC', '3170', 1),
(21560, 'Sandown Village', 'VIC', '3171', 1),
(21561, 'Springvale', 'VIC', '3171', 1),
(21562, 'Dingley Village', 'VIC', '3172', 1),
(21564, 'Keysborough', 'VIC', '3173', 1),
(21565, 'Noble Park', 'VIC', '3174', 1),
(21569, 'Doveton', 'VIC', '3177', 1),
(21570, 'Rowville', 'VIC', '3178', 1),
(21571, 'Scoresby', 'VIC', '3179', 1),
(21572, 'Knoxfield', 'VIC', '3180', 1),
(21573, 'Prahran', 'VIC', '3181', 1),
(21574, 'Windsor', 'VIC', '3181', 1),
(21577, 'Balaclava', 'VIC', '3183', 1),
(21580, 'Elwood', 'VIC', '3184', 1),
(21581, 'Elsternwick', 'VIC', '3185', 1),
(21582, 'Gardenvale', 'VIC', '3185', 1),
(21583, 'Ripponlea', 'VIC', '3185', 1),
(21587, 'Hampton', 'VIC', '3188', 1),
(21591, 'Wishart', 'VIC', '3189', 1),
(21592, 'Highett', 'VIC', '3190', 1),
(21593, 'Sandringham', 'VIC', '3191', 1),
(21594, 'Cheltenham', 'VIC', '3192', 1),
(21596, 'Southland Centre', 'VIC', '3192', 1),
(21597, 'Beaumaris', 'VIC', '3193', 1),
(21598, 'Black Rock', 'VIC', '3193', 1),
(21600, 'Mentone', 'VIC', '3194', 1),
(21601, 'Aspendale', 'VIC', '3195', 1),
(21602, 'Aspendale Gardens', 'VIC', '3195', 1),
(21603, 'Mordialloc', 'VIC', '3195', 1),
(21604, 'Parkdale', 'VIC', '3195', 1),
(21605, 'Waterways', 'VIC', '3195', 1),
(21606, 'Bonbeach', 'VIC', '3196', 1),
(21607, 'Chelsea', 'VIC', '3196', 1),
(21609, 'Edithvale', 'VIC', '3196', 1),
(21610, 'Carrum', 'VIC', '3197', 1),
(21611, 'Patterson Lakes', 'VIC', '3197', 1),
(21613, 'Frankston', 'VIC', '3199', 1),
(21614, 'Karingal', 'VIC', '3199', 1),
(21619, 'Bentleigh', 'VIC', '3204', 1),
(21620, 'Mckinnon', 'VIC', '3204', 1),
(21622, 'Albert Park', 'VIC', '3206', 1),
(21628, 'Corio', 'VIC', '3214', 1),
(21631, 'Bell Park', 'VIC', '3215', 1),
(21632, 'Bell Post Hill', 'VIC', '3215', 1),
(21633, 'Hamlyn Heights', 'VIC', '3215', 1),
(21635, 'Belmont', 'VIC', '3216', 1),
(21645, 'Breakwater', 'VIC', '3219', 1),
(21648, 'St Albans Park', 'VIC', '3219', 1),
(21653, 'Batesford', 'VIC', '3221', 1),
(21680, 'Barwon Heads', 'VIC', '3227', 1),
(21682, 'Connewarre', 'VIC', '3227', 1),
(21685, 'Anglesea', 'VIC', '3230', 1),
(21688, 'Fairhaven', 'VIC', '3231', 1),
(21801, 'Yambuk', 'VIC', '3285', 1),
(21815, 'Tarrington', 'VIC', '3301', 1),
(21920, 'Streatham', 'VIC', '3351', 1),
(21989, 'Talbot', 'VIC', '3371', 1),
(22307, 'Dawesville', 'WA', '6211', 1),
(22308, 'Wannanup', 'WA', '6210', 1),
(22309, 'Falcon', 'WA', '6210', 1),
(22310, 'Erskine', 'WA', '6210', 1),
(22311, 'Halls Head', 'WA', '6210', 1),
(22312, 'Dudley Park', 'WA', '6210', 1),
(22313, 'Coodanup', 'WA', '6210', 1),
(22314, 'Furnissdale', 'WA', '6209', 1),
(22315, 'North Yunderup', 'WA', '6208', 1),
(22316, 'South Yunderup', 'WA', '6208', 1),
(22317, 'Pinjarra', 'WA', '6208', 1),
(22318, 'Ravenswood', 'WA', '6208', 1),
(22319, 'Barragup', 'WA', '6209', 1),
(22320, 'Greenfields', 'WA', '6210', 1),
(22321, 'Mandurah', 'WA', '6210', 1),
(22322, 'Nambeelup', 'WA', '6207', 1),
(22323, 'Silver Sands', 'WA', '6210', 1),
(22324, 'Meadow Springs', 'WA', '6210', 1),
(22326, 'Parklands', 'WA', '6180', 1),
(22327, 'San Remo', 'WA', '6210', 1),
(22328, 'Stake Hill', 'WA', '6181', 1),
(22329, 'Lakelands', 'WA', '6180', 1),
(22330, 'Madora Bay', 'WA', '6210', 1),
(22331, 'Singleton', 'WA', '6175', 1),
(22332, 'Golden Bay', 'WA', '6174', 1),
(22333, 'Karnup', 'WA', '6176', 1),
(22334, 'Secret Harbour', 'WA', '6173', 1),
(22335, 'Port Kennedy', 'WA', '6172', 1),
(22336, 'Warnbro', 'WA', '6169', 1),
(22337, 'Baldivis', 'WA', '6171', 1),
(22338, 'Waikiki', 'WA', '6169', 1),
(22339, 'Safety Bay', 'WA', '6169', 1),
(22340, 'Shoalwater', 'WA', '6169', 1),
(22341, 'Rockingham', 'WA', '6168', 1),
(22342, 'Cooloongup', 'WA', '6168', 1),
(22343, 'Wellard', 'WA', '6170', 1),
(22344, 'Serpentine', 'WA', '6125', 1),
(22345, 'Mundijong', 'WA', '6123', 1),
(22346, 'Whitby', 'WA', '6123', 1),
(22347, 'Cardup', 'WA', '6122', 1),
(22348, 'Leda', 'WA', '6170', 1),
(22349, 'Hillman', 'WA', '6168', 1),
(22350, 'Medina', 'WA', '6167', 1),
(22351, 'Calista', 'WA', '6167', 1),
(22352, 'Parmelia', 'WA', '6167', 1),
(22353, 'Orelia', 'WA', '6167', 1),
(22354, 'Bertram', 'WA', '6167', 1),
(22355, 'Casuarina', 'WA', '6167', 1),
(22356, 'Byford', 'WA', '6122', 1),
(22357, 'Anketell', 'WA', '6167', 1),
(22358, 'Oakford', 'WA', '6121', 1),
(22359, 'Wungong', 'WA', '6112', 1),
(22360, 'Darling Downs', 'WA', '6122', 1),
(22361, 'Wandi', 'WA', '6167', 1),
(22362, 'Wattleup', 'WA', '6166', 1),
(22363, 'Henderson', 'WA', '6166', 1),
(22364, 'Munster', 'WA', '6166', 1),
(22365, 'Hammond Park', 'WA', '6164', 1),
(22366, 'Aubin Grove', 'WA', '6164', 1),
(22367, 'Banjup', 'WA', '6164', 1),
(22368, 'Forrestdale', 'WA', '6112', 1),
(22369, 'Haynes', 'WA', '6112', 1),
(22370, 'Hilbert', 'WA', '6112', 1),
(22371, 'Brookdale', 'WA', '6112', 1),
(22372, 'Mount Richon', 'WA', '6112', 1),
(22373, 'Bedfordale', 'WA', '6112', 1),
(22374, 'Armadale', 'WA', '6112', 1),
(22375, 'Mount Nasura', 'WA', '6112', 1),
(22376, 'Kelmscott', 'WA', '6111', 1),
(22377, 'Roleystone', 'WA', '6111', 1),
(22378, 'Karragullen', 'WA', '6111', 1),
(22379, 'Camillo', 'WA', '6111', 1),
(22380, 'Seville Grove', 'WA', '6112', 1),
(22381, 'Piara Waters', 'WA', '6112', 1),
(22382, 'Harrisdale', 'WA', '6112', 1),
(22383, 'Southern River', 'WA', '6110', 1),
(22384, 'Canning Vale', 'WA', '6155', 1),
(22385, 'Huntingdale', 'WA', '6110', 1),
(22386, 'Gosnells', 'WA', '6110', 1),
(22387, 'Martin', 'WA', '6110', 1),
(22388, 'Thornlie', 'WA', '6108', 1),
(22389, 'Parkwood', 'WA', '6147', 1),
(22390, 'Willetton', 'WA', '6156', 1),
(22391, 'Bull Creek', 'WA', '6149', 1),
(22392, 'Bateman', 'WA', '6150', 1),
(22393, 'Winthrop', 'WA', '6150', 1),
(22394, 'Kardinya', 'WA', '6163', 1),
(22395, 'Samson', 'WA', '6163', 1),
(22396, 'Hilton', 'WA', '6163', 1),
(22397, 'Beaconsfield', 'WA', '6162', 1),
(22398, 'Hamilton Hill', 'WA', '6163', 1),
(22399, 'South Fremantle', 'WA', '6162', 1),
(22400, 'Fremantle', 'WA', '6160', 1),
(22401, 'White Gum Valley', 'WA', '6162', 1),
(22402, 'Willagee', 'WA', '6156', 1),
(22403, 'O\'Connor', 'WA', '6163', 1),
(22404, 'Palmyra', 'WA', '6157', 1),
(22405, 'Bicton', 'WA', '6157', 1),
(22406, 'Melville', 'WA', '6156', 1),
(22407, 'Attadale', 'WA', '6156', 1),
(22408, 'Myaree', 'WA', '6154', 1),
(22409, 'Alfred Cove', 'WA', '6154', 1),
(22410, 'Booragoon', 'WA', '6154', 1),
(22411, 'Applecross', 'WA', '6153', 1),
(22412, 'Mount Pleasant', 'WA', '6153', 1),
(22413, 'Ardross', 'WA', '6153', 1),
(22414, 'Leeming', 'WA', '6149', 1),
(22415, 'North Lake', 'WA', '6163', 1),
(22416, 'Murdoch', 'WA', '6150', 1),
(22417, 'Jandakot', 'WA', '6164', 1),
(22418, 'South Lake', 'WA', '6164', 1),
(22419, 'Bibra Lake', 'WA', '6163', 1),
(22420, 'Yangebup', 'WA', '6164', 1),
(22421, 'Lake Coogee', 'WA', '6166', 1),
(22422, 'Spearwood', 'WA', '6163', 1),
(22423, 'North Coogee', 'WA', '6163', 1),
(22424, 'Coolbellup', 'WA', '6163', 1),
(22425, 'Willagee', 'WA', '6166', 1),
(22426, 'Rossmoyne', 'WA', '6148', 1),
(22427, 'Riverton', 'WA', '6148', 1),
(22428, 'Shelley', 'WA', '6148', 1),
(22429, 'Willetton', 'WA', '6155', 1),
(22430, 'Lynwood', 'WA', '6147', 1),
(22431, 'Ferndale', 'WA', '6148', 1),
(22432, 'Langford', 'WA', '6147', 1),
(22433, 'Kenwick', 'WA', '6107', 1),
(22434, 'Maddington', 'WA', '6109', 1),
(22435, 'Orange Grove', 'WA', '6109', 1),
(22436, 'Beckenham', 'WA', '6107', 1),
(22437, 'Cannington', 'WA', '6107', 1),
(22438, 'East Cannington', 'WA', '6107', 1),
(22439, 'Queens Park', 'WA', '6107', 1),
(22440, 'Wilson', 'WA', '6107', 1),
(22441, 'Bentley', 'WA', '6102', 1),
(22442, 'East Victoria Park', 'WA', '6101', 1),
(22443, 'Manning', 'WA', '6152', 1),
(22444, 'Salter Point', 'WA', '6152', 1),
(22445, 'Como', 'WA', '6152', 1),
(22446, 'Waterford', 'WA', '6152', 1),
(22447, 'Karawara', 'WA', '6152', 1),
(22448, 'Kensington', 'WA', '6151', 1),
(22449, 'Victoria Park', 'WA', '6100', 1),
(22450, 'Welshpool', 'WA', '6106', 1),
(22451, 'Carlisle', 'WA', '6101', 1),
(22452, 'Lathlain', 'WA', '6100', 1),
(22453, 'Burswood', 'WA', '6100', 1),
(22454, 'South Perth', 'WA', '6151', 1),
(22455, 'Kewdale', 'WA', '6105', 1),
(22456, 'Rivervale', 'WA', '6103', 1),
(22457, 'Belmont', 'WA', '6104', 1),
(22458, 'Cloverdale', 'WA', '6105', 1),
(22459, 'Forrestfield', 'WA', '6058', 1),
(22460, 'Wattle Grove', 'WA', '6107', 1),
(22461, 'Lesmurdie', 'WA', '6067', 1),
(22462, 'Carmel', 'WA', '6076', 1),
(22463, 'Walliston', 'WA', '6076', 1),
(22464, 'Bickley', 'WA', '6076', 1),
(22465, 'Piesse Brook', 'WA', '6076', 1),
(22466, 'Kalamunda', 'WA', '6076', 1),
(22467, 'Gooseberry Hill', 'WA', '6076', 1),
(22468, 'Maida Vale', 'WA', '6057', 1),
(22469, 'High Wycombe', 'WA', '6057', 1),
(22470, 'Bushmead', 'WA', '6055', 1),
(22471, 'Helena Valley', 'WA', '6056', 1),
(22472, 'Darlington', 'WA', '6070', 1),
(22473, 'Glen Forrest', 'WA', '6071', 1),
(22474, 'Mahogany Creek', 'WA', '6072', 1),
(22475, 'Koongamia', 'WA', '6056', 1),
(22476, 'Bellevue', 'WA', '6056', 1),
(22477, 'Hazelmere', 'WA', '6055', 1),
(22478, 'Guildford', 'WA', '6055', 1),
(22479, 'South Guildford', 'WA', '6055', 1),
(22480, 'Woodbridge', 'WA', '6056', 1),
(22481, 'Midland', 'WA', '6056', 1),
(22482, 'Viveash', 'WA', '6056', 1),
(22483, 'Middle Swan', 'WA', '6056', 1),
(22484, 'Midvale', 'WA', '6056', 1),
(22485, 'Greenmount', 'WA', '6056', 1),
(22486, 'Swan View', 'WA', '6056', 1),
(22487, 'Stratton', 'WA', '6056', 1),
(22488, 'Jane Brook', 'WA', '6056', 1),
(22489, 'Red Hill', 'WA', '6056', 1),
(22490, 'Caversham', 'WA', '6055', 1),
(22491, 'Ashfield', 'WA', '6054', 1),
(22492, 'Bassendean', 'WA', '6054', 1),
(22493, 'Bayswater', 'WA', '6053', 1),
(22494, 'Maylands', 'WA', '6051', 1),
(22495, 'East Perth', 'WA', '6004', 1),
(22496, 'Perth', 'WA', '6000', 1),
(22497, 'Northbridge', 'WA', '6003', 1),
(22498, 'North Fremantle', 'WA', '6159', 1),
(22499, 'Mosman Park', 'WA', '6012', 1),
(22500, 'Peppermint Grove', 'WA', '6011', 1),
(22501, 'Claremont', 'WA', '6010', 1),
(22502, 'Swanbourne', 'WA', '6010', 1),
(22503, 'Cottesloe', 'WA', '6011', 1),
(22504, 'Mount Claremont', 'WA', '6010', 1),
(22505, 'Karrakatta', 'WA', '6010', 1),
(22506, 'Dalkeith', 'WA', '6009', 1),
(22507, 'Nedlands', 'WA', '6009', 1),
(22508, 'Shenton Park', 'WA', '6008', 1),
(22509, 'Daglish', 'WA', '6008', 1),
(22510, 'Jolimont', 'WA', '6014', 1),
(22511, 'Subiaco', 'WA', '6008', 1),
(22512, 'Wembley', 'WA', '6014', 1),
(22513, 'Floreat', 'WA', '6014', 1),
(22514, 'City Beach', 'WA', '6015', 1),
(22515, 'Wembley Downs', 'WA', '6019', 1),
(22516, 'Churchlands', 'WA', '6018', 1),
(22517, 'Glendalough', 'WA', '6016', 1),
(22518, 'West Leederville', 'WA', '6007', 1),
(22519, 'Mount Hawthorn', 'WA', '6016', 1),
(22520, 'North Perth', 'WA', '6006', 1),
(22521, 'Leederville', 'WA', '6007', 1),
(22522, 'Mount Lawley', 'WA', '6050', 1),
(22523, 'Inglewood', 'WA', '6052', 1),
(22524, 'Menora', 'WA', '6050', 1),
(22525, 'Coolbinia', 'WA', '6050', 1),
(22526, 'Bedford', 'WA', '6052', 1),
(22527, 'Morley', 'WA', '6052', 1),
(22528, 'Eden Hill', 'WA', '6054', 1),
(22529, 'Lockridge', 'WA', '6054', 1),
(22530, 'Kiara', 'WA', '6054', 1),
(22531, 'Beechboro', 'WA', '6063', 1),
(22532, 'Noranda', 'WA', '6062', 1),
(22533, 'Morley', 'WA', '6062', 1),
(22534, 'Dianella', 'WA', '6059', 1),
(22535, 'Nollamara', 'WA', '6061', 1),
(22536, 'Westminster', 'WA', '6061', 1),
(22537, 'Balcatta', 'WA', '6021', 1),
(22538, 'Stirling', 'WA', '6021', 1),
(22539, 'Tuart Hill', 'WA', '6060', 1),
(22540, 'Yokine', 'WA', '6060', 1),
(22541, 'Gwelup', 'WA', '6018', 1),
(22542, 'Innaloo', 'WA', '6018', 1),
(22543, 'Woodlands', 'WA', '6018', 1),
(22544, 'Karrinyup', 'WA', '6018', 1),
(22545, 'Trigg', 'WA', '6029', 1),
(22546, 'Doubleview', 'WA', '6018', 1),
(22547, 'Osborne Park', 'WA', '6017', 1),
(22548, 'Scarborough', 'WA', '6019', 1),
(22549, 'Watermans Bay', 'WA', '6020', 1),
(22550, 'North Beach', 'WA', '6020', 1),
(22551, 'Carine', 'WA', '6020', 1),
(22552, 'Hamersley', 'WA', '6022', 1),
(22553, 'Balga', 'WA', '6061', 1),
(22554, 'Mirrabooka', 'WA', '6061', 1),
(22555, 'Malaga', 'WA', '6090', 1),
(22556, 'Bennett Springs', 'WA', '6063', 1),
(22557, 'Dayton', 'WA', '6055', 1),
(22558, 'West Swan', 'WA', '6055', 1),
(22559, 'Brabham', 'WA', '6055', 1),
(22560, 'Ballajura', 'WA', '6066', 1),
(22561, 'Koondoola', 'WA', '6064', 1),
(22562, 'Alexander Heights', 'WA', '6064', 1),
(22563, 'Marangaroo', 'WA', '6064', 1),
(22564, 'Girrawheen', 'WA', '6064', 1),
(22565, 'Warwick', 'WA', '6024', 1),
(22566, 'Duncraig', 'WA', '6023', 1),
(22567, 'Marmion', 'WA', '6020', 1),
(22568, 'Sorrento', 'WA', '6020', 1),
(22569, 'Greenwood', 'WA', '6024', 1),
(22570, 'Hillarys', 'WA', '6025', 1),
(22571, 'Padbury', 'WA', '6025', 1),
(22572, 'Kingsley', 'WA', '6026', 1),
(22573, 'Madeley', 'WA', '6065', 1),
(22574, 'Darch', 'WA', '6065', 1),
(22575, 'Landsdale', 'WA', '6065', 1),
(22576, 'Henley Brook', 'WA', '6055', 1),
(22577, 'Herne Hill', 'WA', '6056', 1),
(22578, 'Millendon', 'WA', '6056', 1),
(22579, 'Baskerville', 'WA', '6056', 1),
(22580, 'Upper Swan', 'WA', '6069', 1),
(22581, 'Belhus', 'WA', '6069', 1),
(22582, 'Aveley', 'WA', '6069', 1),
(22583, 'Ellenbrook', 'WA', '6069', 1),
(22584, 'Jandabup', 'WA', '6077', 1),
(22585, 'Gnangara', 'WA', '6077', 1),
(22586, 'Melaleuca', 'WA', '6079', 1),
(22587, 'Wanneroo', 'WA', '6065', 1),
(22588, 'Pearsall', 'WA', '6065', 1),
(22589, 'Hocking', 'WA', '6065', 1),
(22590, 'Wangara', 'WA', '6065', 1),
(22591, 'Woodvale', 'WA', '6026', 1),
(22592, 'Craigie', 'WA', '6025', 1),
(22593, 'Kallaroo', 'WA', '6025', 1),
(22594, 'Mullaloo', 'WA', '6027', 1),
(22595, 'Beldon', 'WA', '6027', 1),
(22596, 'Edgewater', 'WA', '6027', 1),
(22597, 'Heathridge', 'WA', '6027', 1),
(22598, 'Ocean Reef', 'WA', '6027', 1),
(22599, 'Connolly', 'WA', '6027', 1),
(22600, 'Joondalup', 'WA', '6027', 1),
(22601, 'Iluka', 'WA', '6028', 1),
(22602, 'Currambine', 'WA', '6028', 1),
(22603, 'Ashby', 'WA', '6065', 1),
(22604, 'Tapping', 'WA', '6065', 1),
(22605, 'Mariginiup', 'WA', '6078', 1),
(22606, 'Banksia Grove', 'WA', '6031', 1),
(22607, 'Carramar', 'WA', '6031', 1),
(22608, 'Kinross', 'WA', '6028', 1),
(22609, 'Burns Beach', 'WA', '6028', 1),
(22610, 'Clarkson', 'WA', '6030', 1),
(22611, 'Merriwa', 'WA', '6030', 1),
(22612, 'Ridgewood', 'WA', '6030', 1),
(22613, 'Quinns Rocks', 'WA', '6030', 1),
(22614, 'Jindalee', 'WA', '6036', 1),
(22615, 'Butler', 'WA', '6036', 1),
(22616, 'Alkimos', 'WA', '6038', 1),
(22617, 'Eglinton', 'WA', '6034', 1),
(22618, 'Yanchep', 'WA', '6035', 1);

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
(1, 0, 0, 1, '00000000', 'Dennis Suitters', 'Home', 'Here is a heading for the Home Page.', 'Here\'s a Meta Title for the Home Page.Here\'s a Meta Title for', '', '', 'index', 'Test ALT Text', 'http://localhost/AuroraCMS2/media/242113223-176711991250732-2533274213801360706-n.jpg', '', '', '0111110000000000', 'horizontal', 'fade', 300, 3000, '', '', '', 'index', '', 'wood,turning,woodturned,timber,open,source,photography,digital,artwork,websit,design,development', 'Here\'s a Meta Title for the Home Page.Here\'s a Meta Title for', '', 'head', '<p>Ripper cane toad taking the piss lets throw a bull bar unit manchester moolah&period; Trackies pint oi veg out fly wire what&apos;s crackin&apos; pot dole bludger&period; Flanny thingo runners freckle&period; Grundies thingo not my cup of tea woop woop bitzer counter meal sook metho battler two pot screamer stuffed&period; Oi figjam wouldn&apos;t piss on them if they&apos;re on fire where joey ken oath brekkie bludger bikie pot schooner&period; Mate strewth nah&comma; yeah brickie grundies two up bloody spit the dummy wrap your laughing gear &apos;round that a few stubbies short of a six-pack&period; Fisho woop woop stoked chock a block cockie piss off barbie dog&apos;s balls&period; Mates shoey sickie she&apos;ll be right clucky avo&period; Battler donga as stands out like hit the turps brumby&period; Freo avo kelpie pinga cockie wrap your laughing gear &apos;round that bizzo&period;</p><p>Cab sav when ropeable waggin&apos; school brolly pint ripper&period; Tell your story walkin&apos; veg out she&apos;ll be right dole bludger galah&period; Ankle biter hard yakka struth rollie and sheila&period; Feral garbo fairy floss blow in the bag milk bar bog standard chewie thunderbox bottlo icy pole&period; Bog standard amber fluid hoon carrying on like a pork chop bikie goon toads&period; Better than a kick up the backside taking the piss oldies avo&period; Offsider tinny yabber stands out like a iffy a few stubbies short of a six-pack&period;</p><p>Boozer goon bush bash knackered op shop dag bazza boil-over mickey mouse mate cut lunch commando not my bowl of rice&period; Mad as a op shop big smoke aussie salute no worries jug gobsmacked like a madwoman&apos;s shit freckle postie&period; Lets get some lollies ya ford brass razoo give it a burl&period; Good oil sanger he&apos;s dreaming truckie gutful of cab sav fly wire as cross as a&period; Strides lets get some a cold one cranky bradman lollies roadie&period; Tosser runners stuffed laughing gear strewth mokkies gutta bushie do the harry boardies pinga sandgropper&period; Fremantle doctor scratchy truckie divvy van&period; Bizzo scratchy catcus paddock cook bingle come a shazza offsider mokkies&period; Heaps flanny pissed off dill&period; Two up loose cannon brizzie nah&comma; yeah lets get some&period; Schooner rack off bazza laughing gear shonky one for the road bastards&period; Tosser pinga blimey decent nik rort bog standard maccas snag like a madwoman&apos;s shit boil-over&period; Flamin&apos; doovalacky as cunning as a prezzy mullet dog&apos;s eye&period;</p><p>Coathanger cactus mate aussie salute swag tickets on yourself metho boil-over&period; He&apos;s dreaming bonza few roos loose in the top paddock crook rip snorter billy ya troppo defo dropkick&period; Ugg boots fruit loop banana bender it&apos;ll be gobful&period; Knock sheila turps deadset stubby holder&period; Uluru up the duff nuddy daks sheila cream dipstick bluey&period; How ace brickie gone walkabout cream mate&apos;s rates&period; Grundies u-ie trackies piece of piss crack the shits stubby&period; Blind smokes skeg galah knackered have a go&comma; you mug yabber slaps fair crack of the whip&period; Blind chook maccas plonk true blue&period; Fruit loop spag bol bail out gobsmacked stubby hoon&period; Spewin&apos; drongo gyno no worries&comma; mate&comma; she&apos;ll be right flick head like a dropped pie mokkies&period; Arvo skull chewie dipstick&period; Lappy bonza booze bus billabong digger booze bus damper&period; Knickers wobbly mongrel back of bourke larrikin how&period; Waratah troppo good oil he&apos;s dreaming few roos loose in the top paddock brumby whinge cleanskin&period; You little ripper garbo blue bottle-o root rat&period;</p><p>Toads pretty spiffy tell your story walkin&apos; lollies dag counter meal he hasn&apos;t got a&period; Stubby holder tell your story walkin&apos; she&apos;ll be apples get a dog up ya&period; Durry holden spit the dummy kelpie boozer where trackies bonzer&period; Feral bathers bush bash flanny chunder and hooroo pretty spiffy dinky-di his blood&apos;s worth bottling&period; Like a madwoman&apos;s shit ute corker stuffed bruce moolah longneck rock up mokkies&period; Offsider facey brolly banana bender rack off pissed off chewie coppers&period; Cark it cab sav he&apos;s got a massive ugg where blimey ya crow eaters chokkie&period; Have a captain cook full boar ciggy ace brass razoo&period; Nuddy cockie aussie salute chuck a yewy daks his blood&apos;s worth bottling pull the wool over your eyes unit middy&period; Not my bowl of rice taking the piss two pot screamer bushman&apos;s handkerchief give it a burl aussie rules footy off chops mickey mouse mate&period; Durry brizzie cleanskin ace yous shonky amber fluid my fisho&period; Holy dooley as dry as a porky mates spewin&apos; oi&period; What&apos;s crackin&apos; what&apos;s the john dory&quest; joey whinge bodgy furthy she&apos;ll be right&period;</p>', 0, '0000000000000000', 1, 5, 0, 0, 1697542995),
(2, 0, 0, 1, '00000000', 'Dennis Suitters', 'Blog', '', '', '', '', 'article', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'article', '', '', '', '', 'head', '', 7, '0000000000000000', 1, 1, 0, 0, 1697462295),
(3, 0, 0, 1, '00000000', 'Dennis Suitters', 'Portfolio', '', '', '', '', 'portfolio', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'portfolio', '', '', '', '', 'head', '', 12, '0000000000000000', 1, 2, 0, 0, 1696989660),
(4, 0, 0, 1, '00000000', 'Dennis Suitters', 'Bookings', '', '', '', '', 'bookings', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'bookings', '', '', '', '', 'head', '', 5, '0000000000000000', 1, 0, 0, 0, 1697542999),
(5, 0, 0, 1, '00000000', 'Dennis Suitters', 'Events', '', '', '', '', 'events', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'events', '', '', '', '', 'head', '', 13, '0000000000000000', 1, 1, 0, 0, 1696989661),
(6, 0, 0, 1, '00000000', 'Dennis Suitters', 'News', '', '', 'index,follow', '', 'news', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'news', '', '', '', '', 'head', '', 15, '0000000000000000', 1, 2, 0, 0, 1696989665),
(7, 0, 0, 1, '00000000', 'Dennis Suitters', 'Testimonials', '', '', '', '', 'testimonials', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'testimonials', '', '', '', '', 'head', '', 8, '0000000000000000', 1, 1, 0, 0, 1696989654),
(8, 0, 0, 1, '00000000', 'Dennis Suitters', 'Products', '', '', '', '', 'inventory', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'inventory', '', '', '', '', 'head', '', 11, '0000000000000000', 1, 9, 0, 0, 1696989659),
(9, 0, 0, 1, '11000000', 'Dennis Suitters', 'Services', '', '', '', '', 'services', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'service', '', '', '', '', 'head', '', 10, '0000000000000000', 1, 1, 0, 0, 1696989658),
(10, 0, 0, 1, '00000000', 'Dennis Suitters', 'Gallery', '', '', '', '', 'gallery', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'gallery', '', '', '', '', 'head', '', 14, '0000000000000000', 1, 2, 0, 0, 1696989662),
(11, 0, 0, 1, '00000000', 'Dennis Suitters', 'Contact', '', '', '', '', 'contactus', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'contactus', '', '', '', '', 'head', '', 9, '0000000000000000', 1, 1, 0, 0, 1696989656),
(12, 0, 0, 1, '00000000', 'Dennis Suitters', 'Cart', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'cart', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'cart', '', '', '', '', 'head', '', 16, '0000000000000000', 1, 1, 0, 0, 1696989666),
(13, 0, 0, 1, '00000000', 'Dennis Suitters', 'Terms of Service', 'Terms of Service', '', '', '', 'page', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'page', '', '', '', '', 'footer', '<p>Please read these Terms of Service (\"Terms\", \"Terms of Service\") carefully before using the {url} website (the \"Service\") operated by {business} (\"us\", \"we\", or \"our\").</p>\r\n<p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>\r\n<p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>\r\n<h2>Accounts</h2>\r\n<p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>\r\n<p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>\r\n<p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>\r\n<h2>Links To Other Web Sites</h2>\r\n<p>Our Service may contain links to third-party web sites or services that are not owned or controlled by {business}.</p>\r\n<p>{business} has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that {business} shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>\r\n<p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>\r\n<h2>Termination</h2>\r\n<p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<h2>Governing Law</h2>\r\n<p>These Terms shall be governed and construed in accordance with the laws of Tasmania, Australia, without regard to its conflict of law provisions.</p>\r\n<p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>\r\n<h2>Changes</h2>\r\n<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>\r\n<p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>\r\n', 22, '0000000000000000', 1, 0, 0, 0, 1692197972),
(14, 0, 0, 1, '00000000', 'Dennis Suitters', 'Search', '', '', '', '', 'search', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'search', '', '', '', '', 'other', '', 29, '0000000000000000', 1, 0, 0, 0, 1696989681),
(15, 0, 0, 1, '00000000', 'Dennis Suitters', 'About', '', '', '', '', 'aboutus', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'aboutus', '', '', '', '', 'head', '', 4, '0000000000000000', 1, 0, 0, 0, 1697542998),
(16, 300, 0, 1, '00000000', 'Dennis Suitters', 'Proofs', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'proofs', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'proofs', '', '', '', '', 'account', '', 26, '0000000000000000', 1, 0, 0, 0, 1696989675),
(17, 0, 0, 1, '00000000', 'Dennis Suitters', 'Newsletters', '', '', '', '', 'newsletters', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'newsletters', '', '', '', '', 'head', '', 18, '0000000000000000', 1, 0, 0, 0, 1696989668),
(19, 0, 0, 1, '00000000', 'Dennis Suitters', 'Distributors', '', '', '', '', 'distributors', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'distributors', '', '', '', '', 'footer', '', 19, '0000000000000000', 1, 0, 0, 0, 1692197879),
(20, 0, 0, 1, '00000000', 'Dennis Suitters', 'Privacy Policy', 'Privacy Policy', '', '', '', 'page', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'page', 'Article', '', '', '', 'footer', '<p>{business} (\"us\", \"we\", or \"our\") operates the {url} website (hereinafter referred to as the \"Service\").</p>\r\n<p>This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.</p>\r\n<p>We use your data to provide and improve the Service. By using the Service, you agree to the collection and use of information in accordance with this policy.</p>\r\n<h2>Definitions</h2>\r\n<ul>\r\n <li>\r\n  <p><strong>Service</strong></p>\r\n  <p>Service is the {url} website operated by {business}</p>\r\n </li>\r\n <li>\r\n  <p><strong>Personal Data</strong></p>\r\n  <p>Personal Data means data about a living individual who can be identified from those data (or from those and other information either in our possession or likely to come into our possession).</p>\r\n </li>\r\n <li>\r\n  <p><strong>Usage Data</strong></p>\r\n  <p>Usage Data is data collected automatically either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>\r\n </li>\r\n <li>\r\n  <p><strong>Cookies</strong></p>\r\n  <p>Cookies are small files stored on your device (computer or mobile device).</p>\r\n </li>\r\n</ul>\r\n<h2>Information Collection and Use</h2>\r\n<p>We collect several different types of information for various purposes to provide and improve our Service to you.</p>\r\n<h3>Types of Data Collected</h3>\r\n<h4>Personal Data</h4>\r\n<p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you (\"Personal Data\"). Personally identifiable information may include, but is not limited to:</p>\r\n<ul>\r\n <li>Email address</li>\r\n <li>First name and last name</li>\r\n <li>Phone number</li>\r\n <li>Address, State, Province, ZIP/Postal code, City</li>\r\n <li>Cookies and Usage Data</li>\r\n</ul>\r\n<h4>Usage Data</h4>\r\n<p>We may also collect information how the Service is accessed and used (\"Usage Data\"). This Usage Data may include information such as your computer\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>\r\n<h4>Tracking &amp; Cookies Data</h4>\r\n<p>We use cookies and similar tracking technologies to track the activity on our Service and we hold certain information.</p>\r\n<p>Cookies are files with a small amount of data which may include an anonymous unique identifier. Cookies are sent to your browser from a website and stored on your device. Other tracking technologies are also used such as beacons, tags and scripts to collect and track information and to improve and analyse our Service.</p>\r\n<p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.</p>\r\n<p>Examples of Cookies we use:</p>\r\n<ul>\r\n <li><strong>Session Cookies.</strong> We use Session Cookies to operate our Service.</li>\r\n <li><strong>Preference Cookies.</strong> We use Preference Cookies to remember your preferences and various settings.</li>\r\n <li><strong>Security Cookies.</strong> We use Security Cookies for security purposes.</li>\r\n</ul>\r\n<h2>Use of Data</h2>\r\n<p>Diemen Design uses the collected data for various purposes:</p>    \r\n<ul>\r\n <li>To provide and maintain the Service</li>\r\n <li>To notify you about changes to our Service</li>\r\n <li>To allow you to participate in interactive features of our Service when you choose to do so</li>\r\n <li>To provide customer care and support</li>\r\n <li>To provide analysis or valuable information so that we can improve the Service</li>\r\n <li>To monitor the usage of the Service</li>\r\n <li>To detect, prevent and address technical issues</li>\r\n</ul>\r\n<h2>Transfer Of Data</h2>\r\n<p>Your information, including Personal Data, may be transferred to, and maintained on computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>\r\n<p>If you are located outside Australia and choose to provide information to us, please note that we transfer the data, including Personal Data, to Australia and process it there.</p>\r\n<p>Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.</p>\r\n<p>{business} will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this Privacy Policy and no transfer of your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of your data and other personal information.</p>\r\n<h2>Disclosure Of Data</h2>\r\n<h3>Legal Requirements</h3>\r\n<p>Diemen Design may disclose your Personal Data in the good faith belief that such action is necessary to:</p>\r\n<ul>\r\n <li>To comply with a legal obligation</li>\r\n <li>To protect and defend the rights or property of Diemen Design</li>\r\n <li>To prevent or investigate possible wrongdoing in connection with the Service</li>\r\n <li>To protect the personal safety of users of the Service or the public</li>\r\n <li>To protect against legal liability</li>\r\n</ul>\r\n<p>As an European citizen, under GDPR, you have certain individual rights. You can learn more about these guides in the <a href=\"https://termsfeed.com/blog/gdpr/#Individual_Rights_Under_the_GDPR\">GDPR Guide</a>.</p>\r\n<h2>Security of Data</h2>\r\n<p>The security of your data is important to us but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.</p>\r\n<h2>Service Providers</h2>\r\n<p>We may employ third party companies and individuals to facilitate our Service (\"Service Providers\"), to provide the Service on our behalf, to perform Service-related services or to assist us in analyzing how our Service is used.</p>\r\n<p>These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.</p>\r\n<h2>Links to Other Sites</h2>\r\n<p>Our Service may contain links to other sites that are not operated by us. If you click a third party link, you will be directed to that third party\'s site. We strongly advise you to review the Privacy Policy of every site you visit.</p>\r\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>\r\n<h2>Children\'s Privacy</h2>\r\n<p>Our Service does not address anyone under the age of 18 (\"Children\").</p>\r\n<p>We do not knowingly collect personally identifiable information from anyone under the age of 18. If you are a parent or guardian and you are aware that your Child has provided us with Personal Data, please contact us. If we become aware that we have collected Personal Data from children without verification of parental consent, we take steps to remove that information from our servers.</p>\r\n<h2>Changes to This Privacy Policy</h2>\r\n<p>We may update our Privacy Policy from time to time.</p>\r\n<p>Changes will appear on this URL.</p>\r\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>\r\n', 21, '0000000000000000', 1, 0, 0, 0, 1692194673),
(21, 0, 0, 1, '00000000', 'Dennis Suitters', 'Login', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'login', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'login', '', '', '', '', 'other', '', 28, '0000000000000000', 1, 0, 0, 0, 1696989677),
(22, 0, 0, 1, '00000000', 'Dennis Suitters', 'Sitemap', '', '', '', '', 'sitemap', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'sitemap', '', '', '', '', 'footer', '', 20, '0000000000000000', 1, 0, 0, 0, 1692197921),
(23, 0, 0, 1, '00000000', 'Dennis Suitters', 'Coming Soon', 'Coming Soon title', '', '', '', 'comingsoon', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'comingsoon', '', '', '', '', 'none', '', 23, '0000000000000000', 1, 0, 0, 1698672060, 1697203302),
(24, 0, 0, 1, '00000000', 'Dennis Suitters', 'Maintenance', 'Maintenance', '', '', '', 'maintenance', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'maintenance', '', '', '', '', 'none', '<p>We are currently doing Maintenance.</p>', 24, '0000000000000000', 1, 0, 0, 0, 1692198347),
(25, 0, 0, 1, '00000000', 'Dennis Suitters', 'FAQ', '', NULL, '', '', 'faq', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'faq', '', '', '', '', 'footer', '', 23, '0000000000000000', 1, 0, 0, 0, 1692198011),
(26, 0, 0, 1, '00000000', 'Dennis Suitters', 'Forum', '', NULL, '', '', 'forum', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'forum', 'Forum', '', '', '', 'head', '', 1, '0000000000000000', 1, 2, 0, 0, 1697542996),
(27, 300, 0, 1, '00000000', 'Dennis Suitters', 'Orders', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'orders', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'orders', '', '', '', '', 'account', '', 25, '0000000000000000', 1, 0, 0, 0, 1696989673),
(29, 300, 0, 1, '00000000', 'Dennis Suitters', 'Settings', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'settings', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'settings', '', '', '', '', 'account', '', 27, '0000000000000000', 1, 0, 0, 0, 1696989676),
(30, 0, 0, 1, '00000000', 'Dennis Suitters', 'Checkout', 'Payment Options', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'checkout', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'checkout', '', '', '', '', 'other', '<p>To ensure our user\'s privacy, we don\'t store Credit Card details,<br>only the chosen Payment Method, Name, Email and Date of Payment.</p>', 30, '0000000000000000', 1, 0, 0, 0, 1692198270),
(31, 0, 0, 1, '00000000', 'Dennis Suitters', 'Offline', '', 'Offline', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'offline', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'offline', '', '', '', '', 'none', '', 31, '0000000000000000', 1, 0, 0, 0, 1692198368),
(41, 0, 0, 1, '00000000', 'Dennis Suitters', 'Biography', '', '', '', '', 'biography', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'biography', '', '', '', '', 'head', '', 6, '0000000000000000', 1, 1, 0, 0, 1696989652),
(42, 0, 0, 1, '00000000', 'Dennis Suitters', 'Activation', '', NULL, 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'activate', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'activate', 'Page', '', '', '', 'none', '<p>Please login with the credentials emailed to you when signing up, and update your address details, thank you.</p>', 27, '0000000000000000', 1, 0, 0, 0, 1692194689),
(43, 0, 0, 1, '00000000', 'Dennis Suitters', 'Activities', '', '', '', '', 'activities', 'green and yellow tractor in garage', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'activities', '', '', '', '', 'head', '', 2, '0000000000000000', 1, 3, 0, 0, 1697543297),
(44, 0, 0, 1, '00000000', 'Dennis Suitters', 'Courses', '', NULL, '', '', 'content', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'course', 'Course', '', '', '', 'head', '', 17, '0000000000000000', 1, 6, 0, 0, 1696989667),
(45, 300, 0, 1, '00000000', 'Dennis Suitters', 'Courses', '', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'courses', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'courses', '', '', '', '', 'account', '', 24, '0000000000000000', 1, 1, 0, 0, 1696989672),
(50, 0, 0, 1, '00000000', 'Dennis Suitters', 'Pricing', '', '', '', '', 'pricing', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'pricing', '', '', '', '', 'head', '', 3, '0000000000000000', 1, 1, 0, 0, 1697542997),
(54, NULL, 0, 0, '00000000', '', 'Notification 1697376183', '', '', '', '', 'notification', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'notification', 'Article', '', '', '', 'notification', '', 1697376183, '0000000000000000', 0, 0, 0, 0, 1697376183);

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
(2, 400, 0, 'livechat', 'livechat', 'chat', 'Livechat', 26, 1),
(3, 400, 0, 'dropdown', 'content', 'content', 'Content', 1, 1),
(4, 400, 3, 'media', 'media', 'picture', 'Media', 1, 1),
(5, 400, 3, 'pages', 'pages', 'content', 'Pages', 2, 1),
(6, 400, 3, 'faq', 'faq', 'faq', 'FAQ', 10, 1),
(7, 400, 3, 'scheduler', 'content', 'calendar-time', 'Scheduler', 0, 1),
(8, 400, 3, 'article', 'content', 'content', 'Articles', 3, 1),
(9, 400, 3, 'portfolio', 'content', 'portfolio', 'Portfolio', 13, 1),
(10, 400, 3, 'events', 'content', 'calendar', 'Events', 9, 1),
(11, 400, 3, 'news', 'content', 'email-read', 'News', 12, 1),
(12, 400, 3, 'testimonials', 'content', 'testimonial', 'Testimonials', 6, 1),
(13, 400, 3, 'inventory', 'content', 'shipping', 'Inventory', 4, 1),
(14, 400, 3, 'rewards', 'rewards', 'credit-card', 'Rewards', 15, 1),
(15, 400, 3, 'service', 'content', 'service', 'Services', 5, 1),
(16, 400, 3, 'proofs', 'content', 'proof', 'Proofs', 14, 1),
(17, 400, 0, 'messages', 'messages', 'inbox', 'Messages', 27, 1),
(18, 400, 3, 'forum', 'forum', 'forum', 'Forum', 17, 1),
(19, 400, 3, 'newsletters', 'newsletters', 'newspaper', 'Newsletters', 18, 1),
(20, 400, 0, 'bookings', 'bookings', 'calendar', 'Bookings', 24, 1),
(21, 400, 0, 'dropdown', 'orders', 'order', 'Orders', 29, 1),
(22, 400, 21, 'all', 'orders', 'order-quote', 'All', 30, 1),
(23, 400, 21, 'quotes', 'orders', 'order-quote', 'Quotes', 31, 1),
(24, 400, 21, 'invoices', 'orders', 'order-invoice', 'Invoices', 32, 1),
(25, 400, 21, 'pending', 'orders', 'order-pending', 'Pending', 33, 1),
(26, 400, 21, 'recurring', 'orders', 'order-recurring', 'Recurring', 34, 1),
(27, 400, 21, 'orderdue', 'orders', 'order-pending', 'Overdue', 35, 1),
(28, 400, 21, 'archived', 'orders', 'order-archived', 'Archived', 36, 1),
(29, 400, 0, 'accounts', 'accounts', 'users', 'Accounts', 22, 1),
(30, 400, 3, 'comments', 'comments', 'comments', 'Comments', 11, 1),
(31, 400, 3, 'reviews', 'reviews', 'review', 'Reviews', 19, 1),
(32, 400, 0, 'dropdown', 'settings', 'settings', 'Settings', 51, 1),
(33, 400, 32, 'livechat', 'settings', 'chat', 'Livechat', 56, 1),
(34, 400, 32, 'media', 'settings', 'picture', 'Media', 57, 1),
(35, 400, 32, 'pages', 'settings', 'content', 'Pages', 61, 1),
(36, 400, 32, 'content', 'settings', 'content', 'Content', 54, 1),
(37, 400, 32, 'forum', 'settings', 'forum', 'Forum', 55, 1),
(38, 400, 32, 'messages', 'settings', 'inbox', 'Messages', 58, 1),
(39, 400, 32, 'newsletters', 'settings', 'newspaper', 'Newsletters', 59, 1),
(40, 400, 32, 'bookings', 'settings', 'calendar', 'Bookings', 53, 1),
(41, 400, 32, 'orders', 'settings', 'order', 'Orders', 60, 1),
(42, 400, 32, 'accounts', 'settings', 'users', 'Accounts', 52, 1),
(43, 400, 0, 'dropdown', 'preferences', 'settings', 'Preferences', 39, 1),
(44, 400, 43, 'theme', 'preferences', 'theme', 'Theme', 4, 1),
(45, 400, 43, 'contact', 'preferences', 'address-card', 'Contact', 1, 1),
(46, 400, 43, 'social', 'preferences', 'user-group', 'Social', 2, 1),
(47, 400, 43, 'interface', 'preferences', 'sliders', 'Interface', 0, 1),
(48, 400, 43, 'seo', 'preferences', 'plugin-seo', 'SEO', 3, 1),
(49, 400, 43, 'activity', 'preferences', 'activity', 'Activity', 9, 1),
(50, 400, 43, 'tracker', 'preferences', 'tracker', 'Tracker', 10, 1),
(51, 400, 43, 'cart', 'preferences', 'shop-cart', 'Cart', 6, 1),
(52, 400, 43, 'database', 'preferences', 'database', 'Database', 7, 1),
(54, 400, 43, 'security', 'preferences', 'security', 'Security', 8, 1),
(55, 1000, 0, 'payments', 'payments', 'hosting', 'Payments', 37, 1),
(56, 400, 3, 'notification', 'notification', 'notification', 'Notifications', 20, 1),
(57, 400, 0, 'joblist', 'joblist', 'joblist', 'Job List', 25, 1),
(58, 900, 32, 'templates', 'templates', 'templates', 'Templates', 38, 1),
(59, 400, 43, 'a11y', 'preferences', 'a11y', 'Accessibility', 5, 1),
(60, 400, 3, 'activities', 'content', 'activities', 'Activities', 7, 1),
(61, 400, 3, 'course', 'course', 'education-cap', 'Courses', 16, 1),
(62, 400, 3, 'adverts', 'adverts', 'blocks', 'Adverts', 8, 1),
(63, 400, 0, 'agronomy', 'agronomy', 'agronomy', 'Agronomy', 23, 1);

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
(10, 'dashboard', 'Latest AuroraCMS Updates', 'auroracmsupdates.php', '', '6', '', '', '6', '4', 15, 1),
(13, 'dashboard', 'Devices', 'devices.php', '', '3', '5', '', '3', '2', 7, 1),
(14, 'dashboard', 'Browsers', 'browsers.php', '', '6', '5', '', '3', '2', 6, 1),
(15, 'dashboard', 'Referrers', 'referrers.php', '', '3', '6', '', '3', '2', 5, 1),
(16, 'dashboard', 'Countries', 'countries.php', '', '3', '6', '', '3', '2', 8, 1),
(17, 'dashboard', 'Weather', 'weather.php', '', '6', '', '', '', '', 2, 1),
(18, 'dashboard', 'Sale Content Suggestions', 'salecontent.php', '', '12', '', '', '12', '', 0, 1),
(21, 'dashboard', 'Sales Stats', 'dashboardsalesstats.php', '', '12', '6', '5', '6', '4', 4, 1),
(22, 'dashboard', 'Latest Orders', 'dashboardlatestorders.php', '', '6', '6', '', '6', '4', 3, 1),
(23, 'dashboard', 'Latest Theme Updates', 'themeupdates.php', '', '6', '', '', '6', '4', 14, 1);

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22619;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
