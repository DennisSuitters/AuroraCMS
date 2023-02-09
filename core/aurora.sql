-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 10, 2023 at 02:13 AM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 8.1.15

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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint UNSIGNED NOT NULL,
  `iid` bigint UNSIGNED NOT NULL,
  `cid` bigint NOT NULL,
  `rid` bigint NOT NULL,
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
  `contentType` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int UNSIGNED NOT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int NOT NULL,
  `f` decimal(10,2) NOT NULL,
  `t` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `tis` int NOT NULL,
  `tie` int NOT NULL,
  `ord` bigint NOT NULL,
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

INSERT INTO `config` (`id`, `development`, `maintenance`, `comingsoon`, `hoster`, `hosterURL`, `options`, `forumOptions`, `inventoryFallbackStatus`, `defaultPage`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `saleHeadingvalentine`, `saleHeadingeaster`, `saleHeadingmothersday`, `saleHeadingfathersday`, `saleHeadingblackfriday`, `saleHeadinghalloween`, `saleHeadingsmallbusinessday`, `saleHeadingchristmas`, `metaRobots`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `email_check`, `email_interval`, `email_signature`, `storemessages`, `message_check_interval`, `chatAutoRemove`, `messengerFBCode`, `messengerFBColor`, `messengerFBGreeting`, `language`, `timezone`, `orderPayti`, `orderEmailSubject`, `orderEmailLayout`, `orderEmailNotes`, `orderEmailReadNotification`, `austPostAPIKey`, `gst`, `memberLimit`, `memberLimitSilver`, `memberLimitBronze`, `memberLimitGold`, `memberLimitPlatinum`, `wholesaleLimit`, `wholesaleLimitSilver`, `wholesaleLimitBronze`, `wholesaleLimitGold`, `wholesaleLimitPlatinum`, `wholesaleTime`, `wholesaleTimeSilver`, `wholesaleTimeBronze`, `wholesaleTimeGold`, `wholesaleTimePlatinum`, `passwordResetLayout`, `passwordResetSubject`, `accountActivationSubject`, `accountActivationLayout`, `bookingNoteTemplate`, `bookingEmailSubject`, `bookingEmailLayout`, `bookingEmailReadNotification`, `bookingAutoReplySubject`, `bookingAutoReplyLayout`, `bookingAttachment`, `bookingAgreement`, `bookingBuffer`, `contactAutoReplySubject`, `contactAutoReplyLayout`, `newslettersEmbedImages`, `newslettersSendMax`, `newslettersSendDelay`, `newslettersOptOutLayout`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `payPalClientID`, `payPalSecret`, `stripe_publishkey`, `stripe_secretkey`, `defaultOrder`, `showItems`, `searchItems`, `idleTime`, `ga_clientID`, `ga_tracking`, `ga_tagmanager`, `ga_verification`, `gd_api`, `reCaptchaClient`, `reCaptchaServer`, `seo_msvalidate`, `seo_yandexverification`, `seo_alexaverification`, `seo_domainverify`, `seo_pinterestverify`, `mapapikey`, `geo_region`, `geo_placename`, `geo_position`, `geo_weatherAPI`, `php_options`, `php_APIkey`, `php_honeypot`, `php_quicklink`, `formMinTime`, `formMaxTime`, `spamfilter`, `notification_volume`, `mediaMaxWidth`, `mediaMaxHeight`, `mediaMaxWidthThumb`, `mediaMaxHeightThumb`, `mediaQuality`, `templateID`, `templateQTY`, `suggestions`, `bti`, `backup_ti`, `uti`, `uti_freq`, `update_url`, `navstat`, `iconsColor`, `a11yPosition`, `ti`) VALUES
(1, 0, 0, 0, 1, '', '11101010011101000001101110101101', '0000000000000000000000000000000', 'back order', 'dashboard', 'raycraftcomputerconsultants', '', '', '', 'Clippy', '', '', '', '', '', '', '', '', 'index,follow', '', '', '', '', 0, 'Example Name', '000 000 000', '92 Cradle Mountain Rd', 'Wilmot', 'Wilmot', 'TAS', 'Australia', 7310, '+61367111092', '', 'diemendesign@gmail.com', 0, 3600, 'M jS, Y g:i A', 1425893894, 3600, '<p>Sent using <a href=\"https://github.com/DiemenDesign/AuroraCMS\">AuroraCMS</a> the Australian Open Source Content Management System.</p>', 0, 300, 0, '', '#5484ed', '', 'en-AU', 'Australia/Hobart', 1209600, 'Order {order_number}', '<p>Hi {first}!</p>\r\n<p>Thank you for your payment, and choosing to support {business}.</p>\r\n{downloads}\r\n{courses}\r\n<p>You can view your invoice here: {order_link}</p>\r\n<p>Regards,<br>\r\n{business}</p>\r\n<hr>\r\n', '', 1, '', '0', '0', '0', '0', '0', '0', '5', '5', '5', '5', '5', 0, 0, 0, 0, 0, '%3Cp%3EHi%20%7Bname%7D%2C%3C/p%3E%3Cp%3EA%20Password%20Reset%20was%20requested%2C%20it%20is%20now%3A%20%7Bpassword%7D%3C/p%3E%3Cp%3EWe%20recommend%20changing%20the%20above%20password%20after%20logging%20in.%3C/p%3E', 'Password Reset {business}.', 'Account Activation for {username} from {site}.', '<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>The username you signed up with was: {username}</p><p>The AutoGenerated password is: {password}</p><p><br></p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>', '<p>This is a test template</p><p>Backup:</p><p><input type=\"checkbox\"> Music</p><p><input type=\"checkbox\"> Software</p><p><input type=\"checkbox\"> Emails</p><p><br></p>', '{business} Booking Confirmation on {date}', '<p>Hi {first},</p>\r\n\r\n<p>{details}</p>\r\n\r\n<p>Please check the details above, and get in touch if any need correcting.</p>\r\n\r\n<p>Kind Regards,<br>\r\n\r\n{business}</p>\r\n\r\n\r\n\r\n', 0, '{business} Booking Confirmation on {date}', '<p>Hi {first},</p>\r\n\r\n<p>Thank you for contacting {business}, someone will get back to you ASAP.<br>Please note, this email is not a confirmed booking - we will contact you to confirm the time and date of your booking.</p>\r\n\r\n<p>{externalLink}</p>\r\n\r\n<p>Kind Regards,<br>\r\n\r\n{business}</p>', '', '<p>By clicking this checkbox and or signing below, you agree that we are not responsible for any data loss.</p>', 3600, '{business} Contact Confirmation on {date}', '<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>', 0, 50, 5, '<br>\r\n<br>\r\n<p style=\"font-size: 10px;text-align: center;\">If you don\'t wish to continue to receive these Newsletters you can <a href=\"{optOutLink}\">Unsubscribe</a>.</p>', 'Westpac', 'D & A Suitters', '0000 0000 0000', '000000', 'test', '', 'pk_test_51JC3eiEqAm9jcrHKP7oecRmQoIYC0SioG94Nd8kCeXOFPddqfP2QVXc6d7idZU0uxuKkl4RAp3yyEGGDsUfc8GQz00o1PDZ848', 'sk_test_51JC3eiEqAm9jcrHK3o0hVEsXTJUKbfFZ7cPCgEkGLY3bUuz7yR6jXs2Fc64OzoHuOx3ZfSvDMkW2JCoJ9Xiw3cOv004v2JjyE6', 'new', 10, 0, 30, '', '', '', '', 'AIzaSyD88WkGT3JFrVYo-qL5bKOyIpvvx5yIf_o', '', '', '', '', '', '', '', 'pk.eyJ1IjoiZGllbWVuZGVzaWduIiwiYSI6ImNraXZ2NnR4eDBlMGUyeHF0czRmNTd1cHQifQ.35xKSiAHcPT2L7CsNfSmlw', '', '', '-41.18382187627851,146.16142272949222', '282ab8bfbbcd4fda80958b6d3184ba1d', '1011111000000000', '', '', '', '5', '60', 1, 0, 1280, 1280, 250, 250, 88, 0, 0, 0, 0, 1602516248, 0, 0, '', 2, 0, 'right bottom', 0);

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
(1, 0, 0, 1, '00000000', 'Dennis Suitters', 'Home', 'We are Diemen Design, Creators of Beautiful and Iconic Tasmanian Handcrafted and Timber Items from Tasmania.', '', '', '', 'index', 'Live Lightly Centre Reception', 'http://localhost/AuroraCMS2/media/img-6116.jpg', '', '', '0111110000000000', 'horizontal', 'fade', 300, 3000, '', '', '', 'index', '', 'wood,turning,woodturned,timber,open,source,photography,digital,artwork,websit,design,development', '', '', 'head', '<p>🪘Diemen Design &dollar;100&period;00 is a &num; Tasmanian &lpar;Lutruwita&rpar; based Maker Studio of Handcrafted Wood and Timber Products&comma; producing Office&comma; Kitchen and Home-ware Utensil&apos;s and everyday items&period; We endeavour to produce products that are aesthetically pleasing&comma; easy to use and useful for everyone from all walks of life&period;</p>&NewLine;<p>Our Handcrafted Products&comma; 🇨🇴mainly consist of Wood Turned Products&comma; using mainly Tasmanian locally sourced timbers&comma; in an ecological and sustainable process&period; We prefer to use Tree Timber material that has long been felled&comma; taken down for safety reasons&comma; or has fallen without intervention&period;</p>&NewLine;<p>Diemen Design is situated within <a href=\"https://happyvalleygoat.farm/\">Happy Valley Goat Farm</a>&comma; where we look after Sheep&comma; Goats and Chickens&comma; in an eco-friendly and animal friendly manner&comma; with the help of our Dog &quot;Bella&quot;&comma; our cheeky Maremma&period; We look after our animals better than ourselves&period;</p><p>Have a <a href=\"https://www.tasmanian.com.au/tools-and-resources/podcasts\">Listen</a> to what it&apos;s like to be a Tasmanian Owned and run Business&comma; presented by <a href=\"https://www.tasmanian.com.au/\">Brand Tasmania</a> or follow them on <a href=\"https://twitter.com/brandtasmania\">Twitter</a>&period;</p>', 0, '0000000000000000', 1, 3002, 0, 0, 1675869756),
(2, 0, 0, 1, '00000000', 'Dennis Suitters', 'Blog', 'Blog Heading', '', '', '', 'article', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'article', '', '', '', '', 'head', '<p>Paddock bottlo ugg boots fair go, mate fossicker. Mickey mouse mate esky ciggy roadie boardies cream stonkered. Icy pole bikie slacker as busy as a give it a burl. Pissed bitzer rort blind outback defo galah fairy floss bradman. Bruce how stickybeak ya cut lunch booze bus how. Chock a block hottie daks sleepout pash pretty spiffy built like a holden skite coppers. Carrying on like a pork chop dero gyno bloody oath ciggies dead horse jumbuck bail up dill. Cockie ridgy-didge cane toad strewth ripper better than a ham sandwich fair crack of the whip bonzer. Ankle biter longneck slab whinge not my bowl of rice booze true blue mad as a gobful up the duff accadacca ironman. Dero what\'s the john dory? lollies struth strides buggered up the duff chokkie. Heaps vinnie\'s joey outback paddock crikey blow in the bag. Shazza skite ropeable lippy freo six of one, half a dozen of the other flick beauty. When amber fluid tucker full blown fly wire head like a dropped pie barrack avo slaps catcus spewin\'. Knickers dead horse put a sock in it buck\'s night shoot through bushie rollie fisho bogan donga.</p><p>Roo bundy whinge gobful and holy dooley bodgy root rat. Budgie smugglers lets get some brekkie compo brolly cut lunch commando flanno. Crikey bikie u-ie lizard drinking rello freo. Offsider throw-down jillaroo ciggy bastards skite. Leg it crow eaters rotten to skite ciggies drongo. No worries trackie dacks hottie clacker ocker truckie. Rotten bunyip toads dob fair suck of the sauce bottle stonkered accadacca. Whinge cane toad a few sandwiches short of a picnic christmas as cunning as a gutful of bradman.</p><p>He hasn\'t got a rollie bushranger oi she\'ll be right. Bazza turps boardies truckie bonzer. Smokes better than a kick up the backside ambo aerial pingpong. Tell him he\'s dreaming fairy floss dole bludger wouldn\'t piss on them if they\'re on fire. Longneck blowie leg it off chops bingle lets get some tosser avo bloody. Squizz blimey buckley\'s chance thunderbox deadset he\'s dreaming. Dry as as dead dingo\'s donga struth fairy floss stubby oi as stands out like dry as as dead dingo\'s donga fair go, mate. G\'day bushranger donger apples pozzy strides crack the shits built like a squizz good oil better than a kick up the backside reckon. Flake thongs sandgroppers u-ie chuck a spaz ace cockie. Donga bush bash furthy donga brolly beauty barbie tucker-bag as cunning as a.</p>', 5, '0000000000000000', 1, 59, 0, 0, 1631882095),
(3, 0, 0, 1, '00000000', 'Dennis Suitters', 'Portfolio', '', '', '', '', 'portfolio', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'portfolio', '', '', '', '', 'head', '', 10, '0000000000000000', 0, 0, 0, 0, 1624603960),
(4, 0, 15, 1, '00000000', 'Dennis Suitters', 'Bookings', 'Bookings Page', '', '', '', 'bookings', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'bookings', '', '', '', '', 'head', '<p>Loose cannon struth ratbag hit the frog and toad no wuckin&apos; furries dunny deadset carry on like a pork chop&period; &dollar;100&period;00 Bottle-o you little ripper she&apos;ll be right cobber&period; Rage on better than a kick up the backside garbo boogie board flick and&period; Better than a ham sandwich no wuckin&apos; furries bail up prezzy boogie board mates&period; Dry as as dead dingo&apos;s donga brass razoo shark biscuit brolly bingle freckle&period; Ratbag two up avos knackered defo&period; Skull trackies chook butcher loose cannon blue pash not my cup of tea sheila what&apos;s crackin&apos; rage on footy&period; Ankle biter cut snake sunnies chin wag coppers fair dinkum&period; Maccas bloody hard yakka fossicker&period; Dardy bottlo amber fluid porky lippy&period;</p><p>Blow in the bag outback slappa home grown where cracker dill suss it out&period; Up the duff g&apos;day dinky-di grab us a catcus lappy&period; Mullet onya bike tucker-bag a few sandwiches short of a picnic roo bar freo vb&period; Deadset tucker plonk fairy floss&period; Tucker-bag bloke servo bloke grouse&period; Battler flanny a few sandwiches short of a picnic also pozzy jumbuck defo pav&period;</p><p>Compo sandgropper grouse crow eaters&period; Digger pull the wool over their eyes cark it goon bag&period; Chock a block parma doovalacky bonza oi heaps stickybeak&period; Dag ugg boots corker mate&apos;s rates shoey&period; Ten clicks away furthy rapt pav fair suck of the sauce bottle chuck a spaz how&period; Bloody ripper rack off fisho boil-over skull aussie salute milk bar mates eureka as dry as a lippy dardy&period; Ken oath middy bities spit the dummy shag on a rock bloody oath&period;</p><p>Dero shazza got us some metho brizzie tucker-bag mickey mouse mate rock up offsider carry on like a pork chop&period; Cobber iffy swag bingle bushman&apos;s handkerchief bastard chock a block decent nik pull the wool over their eyes&period; Tradie better than a kick up the backside throw-down laughing gear middy fremantle doctor kindie&period; Shazza sickie footy slaps as dry as a gutta&period; Brass razoo ciggies arvo thunderbox gutta dog&apos;s breakfast furthy&period; Sick drongo fruit loop accadacca buckley&apos;s chance offsider nuddy chewie stubby pissed suss it out bradman&period; Slacker bushranger goon bag barbie chuck a yewy carrying on like a pork chop dead horse bushman&apos;s handkerchief smokes&period; Shazza built like a bazza ugg piss up dog&apos;s eye come a tosser road train taking the piss&period; Butcher schooner goon whit shazza got us some middy prezzy lollies&period;</p><p>Pozzy leg it chunder mozzie&period; Throw-down longneck parma going off&period; Avo brizzie to he&apos;s got a massive he&apos;s dreaming&period; Cark it trackie dacks footy moolah bogged skeg piker shoey&period; Bush he&apos;s got a massive thunderbox piss off&period; Brisvegas like a madwoman&apos;s shit down under billy&period; Flamin&apos; good oil as dry as a sook hottie&period;</p>', 1, '0000000000000000', 1, 0, 0, 0, 1675607735),
(5, 0, 0, 1, '00000000', 'Dennis Suitters', 'Events', '', '', '', '', 'events', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'events', '', '', '', '', 'head', '', 11, '0000000000000000', 0, 14, 0, 0, 1649512297),
(6, 0, 0, 1, '00000000', 'Anonymous', 'News', '', '', 'index,follow', '', 'news', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'news', '', '', '', '', 'head', '', 13, '0000000000000000', 0, 0, 0, 0, 1585466222),
(7, 0, 0, 1, '00000000', 'Dennis Suitters', 'Testimonials', 'Testimonials Heading', '', '', '', 'testimonials', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'testimonials', '', '', '', '', 'head', '<p>Boardies she\'ll be apples blow in the bag schooner postie dole bludger dunny rat knackered rort. Frog in a sock crow eaters ankle biter freckle dry as as dead dingo\'s donga she\'ll be apples have a captain cook bush oyster. Trackies blowie brizzie shoey stubby vinnie\'s beauty apples chuck a sickie. Beauty snag chokkie better than a kick up the backside squizz piss off. Bloke skeg bluey bloody stickybeak manchester mickey mouse mate no wuckin\' furries shazza laughing gear suss. Bull bar like a madwoman\'s shit muster pelican grouse pozzy and chin wag. Road train gyno thunderbox cark it fossicker. Dog\'s breakfast fruit loop too right a few stubbies short of a six-pack as cross as a. Dipstick beauty straight to the pool room devo ford longneck. Gnarly avo bathers bail up bounce. Kelpie show pony donga bottlo galah.</p>', 6, '0000000000000000', 1, 44, 0, 0, 1648201613),
(8, 0, 0, 1, '00000000', 'Dennis Suitters', 'Products', 'Products Heading', '', '', '', 'inventory', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'inventory', '', '', '', '', 'head', '<p>Trackie dacks on the cans divvy van piss off esky as stands out like. His blood\'s worth bottling cobber ironman joey furthy devo toads mate no dramas bounce. Whinge offsider bog standard jackaroo sleepout pelican. Bail  offsider bluey middy flick. Sunnies bloody oath thingo postie flanny cleanskin bingle grouse. Cut lunch commando jackaroo grab us a skull back of bourke chokkie lurk dog\'s breakfast bingle. Cranky full boar yobbo stubby holder servo gobsmacked ute. Booze bus billy dunny brisvegas good onya. Furthy servo plonk op shop bitzer aussie salute brisvegas pissed off barrack up the duff. Fruit loop no dramas two pot screamer and bloody ripper galah full blown. She\'ll be apples root rat dero flick ugg.</p><p>Amber fluid strewth iffy flat out like a. Brickie dog\'s breakfast my bodgy bail jumbuck. Dipstick heaps knock throw a shrimp on the barbie waratah feral. Crack the shits bonzer battler come a fisho cab sav bushie show pony mate. Your shout oldies rip snorter fair go, mate bloody ripper. Chin wag burk compo trackie dacks.</p>', 9, '0000000000000000', 1, 543, 0, 0, 1631882174),
(9, 0, 0, 1, '11000000', 'Dennis Suitters', 'Services', '', '', '', '', 'services', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'service', '', '', '', '', 'head', '', 8, '0000000000000000', 0, 0, 0, 0, 1629879786),
(10, 0, 0, 1, '00000000', 'Dennis Suitters', 'Gallery', 'Gallery Heading', '', '', '', 'gallery', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'gallery', '', '', '', '', 'head', '<p>Gyno off chops no worries buggered bushranger back of bourke. Shark biscuit flick flamin\' feral bush telly good oil sunnies hooroo. Rego chewie moolah dardy sunnies one for the road ten clicks away flat out. Sickie mates she\'ll be apples gobsmacked piker dunny shark biscuit outback too right strewth cockie. Gobsmacked top end dinky-di flick squizz stands out like a tickets on yourself to. Fairy floss donga also and fair suck of the sauce bottle ambo. Chin wag his blood\'s worth bottling road train dardy galah smoko budgie smugglers woop woop bush telly sickie eureka. As stands out like dropkick rack off loose cannon stonkered grog loose cannon. Dill op shop trackies kindie brisvegas.</p><p>Burk snag chokkie to chokkie bruce. Battler bundy mates ridgy-didge slab tosser fair go, mate. Beauty when yobbo bushman\'s handkerchief goon bag pissed off. Tucker-bag carrying on like a pork chop piece of piss avos it\'ll be dob sick cook shonky. Rapt truckie cane toad feral mad as a fair go, mate eureka piece of piss it\'ll be.</p>', 12, '0000000000000000', 0, 26, 0, 0, 1631882769),
(11, 0, 0, 1, '00000000', 'Dennis Suitters', 'Contact', 'Contact Heading', '', '', '', 'contactus', '', '', '', '', '0000000000000000', '', '', 300, 3000, 'Contact Page Attribution', 'Anonymous', 'https://diemen.design/', 'contactus', '', '', '', '', 'head', '<p>Bastard bruce dunny rat fisho taking the piss accadacca chuck a yewy. Kindie off chops suss what\'s crackin\' gnarly. Fair crack of the whip skeg fair go one for the road snag prezzy maccas. Tinny waggin\' school bush bash plonk. Apples skull lets throw a sunnies as busy as a. Loose cannon two pot screamer as stands out like pint ciggies.</p>', 7, '0000000000000000', 1, 79, 0, 0, 1648201587),
(12, 0, 0, 1, '00000000', 'Dennis Suitters', 'Cart', 'Cart Heading', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'cart', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'cart', '', '', '', '', 'head', '<p>Leg it pissed flick ford throw-down. Thunderbox garbo fair dinkum two pot screamer. Two up stoked flanny full blown two pot screamer burk boogie board better than a kick up the backside. Rock up hit the turps cut lunch commando nipper yakka. Home grown galah chook bonza ratbag. Ken oath knackered devo waggin\' school and servo. Chunder better than a ham sandwich troppo heaps gutful of. Divvy van strewth troppo garbo fair crack of the whip road train up the duff arvo. Chokkie blue bushranger aerial pingpong shonky sickie. Drongo burk goon two up flanny. Burk frothy smoko gone walkabout billabong defo. Bush bash butcher bodgy paddock two pot screamer.</p>', 14, '0000000000000000', 1, 448, 0, 0, 1648430722),
(13, 0, 0, 1, '00000000', 'dev', 'Terms of Service', 'Terms of Service', '', 'index,follow', '', 'page', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'page', '', '', '', '', 'footer', '<p>Please read these Terms of Service (\"Terms\", \"Terms of Service\") carefully before using the {url} website (the \"Service\") operated by {business} (\"us\", \"we\", or \"our\").</p>\r\n<p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>\r\n<p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.</p>\r\n<h2>Accounts</h2>\r\n<p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>\r\n<p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>\r\n<p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>\r\n<h2>Links To Other Web Sites</h2>\r\n<p>Our Service may contain links to third-party web sites or services that are not owned or controlled by {business}.</p>\r\n<p>{business} has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that {business} shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>\r\n<p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>\r\n<h2>Termination</h2>\r\n<p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<h2>Governing Law</h2>\r\n<p>These Terms shall be governed and construed in accordance with the laws of Tasmania, Australia, without regard to its conflict of law provisions.</p>\r\n<p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>\r\n<h2>Changes</h2>\r\n<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>\r\n<p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>\r\n', 21, '0000000000000000', 1, 13, 0, 0, 1641913095),
(14, 0, 0, 1, '00000000', 'Dennis Suitters', 'Search', '', 'Search Meta title', '', '', 'search', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'search', '', '', '', '', 'other', '', 28, '0000000000000000', 1, 19, 0, 0, 1604631971),
(15, 0, 0, 1, '00000000', 'Dennis Suitters', 'About', '', '', '', '', 'aboutus', '', '', '', '', '0000000000000000', '', '', 300, 3000, 'Contact Cover Attribution', 'Anonymous', 'https://diemen.design/', 'aboutus', '', '', '', '', 'head', '<p>Kindie struth sleepout bonza donga banana bender&period; Mate yakka shazza got us some crack the shits mate sandgroppers rubbish&period; Trackie dacks gyno mullet give it a burl bathers to fossicker chuck a spaz&period; Fly wire amber fluid watch out for the pozzy ironman up yours roo&period; Battler pissed lizard drinking slappa&period; Vee dub cubby house yabber boardies apples&period; No wucka&apos;s bizzo she&apos;ll be apples vee dub pozzy bloody muster&period;</p><p>Reckon ken oath frog in a sock bities galah bazza unit ripper frog in a sock he&apos;s got a massive rapt&period; Cream yabber yakka smokes ford road train&period; Bikie tucker crook going off burk flanno&period; Trackie dacks bush bash bruce accadacca catcus&period; Outback lollies mates cut snake mickey mouse mate avo aussie salute feral defo&period; Ken oath sick shazza got us some bloody ute fair crack of the whip&period; Boardies mate&apos;s rates yabber what&apos;s crackin&apos; roo&period; Butcher knackered wrap your laughing gear &apos;round that better than a kick up the backside suss ankle biter bazza better than a kick up the backside&period; Footy freo grog mickey mouse mate dinky-di budgie smugglers bizzo two pot screamer&period; Bush gone walkabout bitzer throw a shrimp on the barbie rollie chuck a spaz ken oath&period; Roadie brizzie stubby holder she&apos;ll be right&period; Footy holy dooley trackies lets throw a&period;</p><p>Fair go&comma; mate sunnies bodgy aerial pingpong built like a lollies vinnie&apos;s a cold one shoot through&period; Tell your story walkin&apos; full boar crow eaters no worries&comma; mate&comma; she&apos;ll be right&period; Brizzie grab us a sunnies waggin&apos; school ratbag vb gutful of few roos loose in the top paddock roo&period; Suss a few stubbies short of a six-pack christmas put a sock in it lippy&period; Blow in the bag damper dog&apos;s eye to dog&apos;s eye&period; Brekkie six of one&comma; half a dozen of the other furthy mickey mouse mate no worries&period; Jillaroo top bloke digger roo bar accadacca fair dinkum burk scratchy also op shop&period;</p>', 1, '0000000000000000', 1, 68, 0, 0, 1667736312),
(16, 300, 0, 1, '00000000', 'Dennis Suitters', 'Proofs', '', 'Proofs', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'proofs', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'proofs', '', '', '', '', 'account', '', 25, '0000000000000000', 1, 9, 0, 0, 1624604287),
(17, 0, 0, 1, '00000000', 'Dennis Suitters', 'Newsletters', '', '', '', '', 'newsletters', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'newsletters', '', '', '', '', 'head', '', 17, '0000000000000000', 1, 1, 0, 0, 1675055019),
(19, 0, 0, 1, '00000000', 'Dennis Suitters', 'Distributors', 'Distributors Heading', 'Distributors', '', '', 'distributors', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'distributors', '', '', '', '', 'footer', '', 18, '0000000000000000', 1, 6, 0, 0, 1631883780),
(20, 0, 0, 1, '00000000', 'dev', 'Privacy Policy', 'Privacy Policy', '', '', '', 'page', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'page', 'Article', '', '', '', 'footer', '<p>{business} (\"us\", \"we\", or \"our\") operates the {url} website (hereinafter referred to as the \"Service\").</p>\r\n<p>This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.</p>\r\n<p>We use your data to provide and improve the Service. By using the Service, you agree to the collection and use of information in accordance with this policy.</p>\r\n<h2>Definitions</h2>\r\n<ul>\r\n <li>\r\n  <p><strong>Service</strong></p>\r\n  <p>Service is the {url} website operated by {business}</p>\r\n </li>\r\n <li>\r\n  <p><strong>Personal Data</strong></p>\r\n  <p>Personal Data means data about a living individual who can be identified from those data (or from those and other information either in our possession or likely to come into our possession).</p>\r\n </li>\r\n <li>\r\n  <p><strong>Usage Data</strong></p>\r\n  <p>Usage Data is data collected automatically either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>\r\n </li>\r\n <li>\r\n  <p><strong>Cookies</strong></p>\r\n  <p>Cookies are small files stored on your device (computer or mobile device).</p>\r\n </li>\r\n</ul>\r\n<h2>Information Collection and Use</h2>\r\n<p>We collect several different types of information for various purposes to provide and improve our Service to you.</p>\r\n<h3>Types of Data Collected</h3>\r\n<h4>Personal Data</h4>\r\n<p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you (\"Personal Data\"). Personally identifiable information may include, but is not limited to:</p>\r\n<ul>\r\n <li>Email address</li>\r\n <li>First name and last name</li>\r\n <li>Phone number</li>\r\n <li>Address, State, Province, ZIP/Postal code, City</li>\r\n <li>Cookies and Usage Data</li>\r\n</ul>\r\n<h4>Usage Data</h4>\r\n<p>We may also collect information how the Service is accessed and used (\"Usage Data\"). This Usage Data may include information such as your computer\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>\r\n<h4>Tracking &amp; Cookies Data</h4>\r\n<p>We use cookies and similar tracking technologies to track the activity on our Service and we hold certain information.</p>\r\n<p>Cookies are files with a small amount of data which may include an anonymous unique identifier. Cookies are sent to your browser from a website and stored on your device. Other tracking technologies are also used such as beacons, tags and scripts to collect and track information and to improve and analyse our Service.</p>\r\n<p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.</p>\r\n<p>Examples of Cookies we use:</p>\r\n<ul>\r\n <li><strong>Session Cookies.</strong> We use Session Cookies to operate our Service.</li>\r\n <li><strong>Preference Cookies.</strong> We use Preference Cookies to remember your preferences and various settings.</li>\r\n <li><strong>Security Cookies.</strong> We use Security Cookies for security purposes.</li>\r\n</ul>\r\n<h2>Use of Data</h2>\r\n<p>Diemen Design uses the collected data for various purposes:</p>    \r\n<ul>\r\n <li>To provide and maintain the Service</li>\r\n <li>To notify you about changes to our Service</li>\r\n <li>To allow you to participate in interactive features of our Service when you choose to do so</li>\r\n <li>To provide customer care and support</li>\r\n <li>To provide analysis or valuable information so that we can improve the Service</li>\r\n <li>To monitor the usage of the Service</li>\r\n <li>To detect, prevent and address technical issues</li>\r\n</ul>\r\n<h2>Transfer Of Data</h2>\r\n<p>Your information, including Personal Data, may be transferred to, and maintained on computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>\r\n<p>If you are located outside Australia and choose to provide information to us, please note that we transfer the data, including Personal Data, to Australia and process it there.</p>\r\n<p>Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.</p>\r\n<p>{business} will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this Privacy Policy and no transfer of your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of your data and other personal information.</p>\r\n<h2>Disclosure Of Data</h2>\r\n<h3>Legal Requirements</h3>\r\n<p>Diemen Design may disclose your Personal Data in the good faith belief that such action is necessary to:</p>\r\n<ul>\r\n <li>To comply with a legal obligation</li>\r\n <li>To protect and defend the rights or property of Diemen Design</li>\r\n <li>To prevent or investigate possible wrongdoing in connection with the Service</li>\r\n <li>To protect the personal safety of users of the Service or the public</li>\r\n <li>To protect against legal liability</li>\r\n</ul>\r\n<p>As an European citizen, under GDPR, you have certain individual rights. You can learn more about these guides in the <a href=\"https://termsfeed.com/blog/gdpr/#Individual_Rights_Under_the_GDPR\">GDPR Guide</a>.</p>\r\n<h2>Security of Data</h2>\r\n<p>The security of your data is important to us but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.</p>\r\n<h2>Service Providers</h2>\r\n<p>We may employ third party companies and individuals to facilitate our Service (\"Service Providers\"), to provide the Service on our behalf, to perform Service-related services or to assist us in analyzing how our Service is used.</p>\r\n<p>These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.</p>\r\n<h2>Links to Other Sites</h2>\r\n<p>Our Service may contain links to other sites that are not operated by us. If you click a third party link, you will be directed to that third party\'s site. We strongly advise you to review the Privacy Policy of every site you visit.</p>\r\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>\r\n<h2>Children\'s Privacy</h2>\r\n<p>Our Service does not address anyone under the age of 18 (\"Children\").</p>\r\n<p>We do not knowingly collect personally identifiable information from anyone under the age of 18. If you are a parent or guardian and you are aware that your Child has provided us with Personal Data, please contact us. If we become aware that we have collected Personal Data from children without verification of parental consent, we take steps to remove that information from our servers.</p>\r\n<h2>Changes to This Privacy Policy</h2>\r\n<p>We may update our Privacy Policy from time to time.</p>\r\n<p>Changes will appear on this URL.</p>\r\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>\r\n', 20, '0000000000000000', 1, 26, 0, 0, 1641914276),
(21, 0, 0, 1, '00000000', 'Dennis Suitters', 'Login', '', 'Login Meta Title', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'login', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'login', '', '', '', '', 'other', '', 27, '0000000000000000', 1, 107, 0, 0, 1648434730),
(22, 0, 0, 1, '00000000', 'Dennis Suitters', 'Sitemap', 'Sitemap Heading', 'Sitemap Meta Title', '', '', 'sitemap', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'sitemap', '', '', '', '', 'footer', '<p>Budgie smugglers ute off chops joey rack off. Whinge waggin\' school put a sock in it loose cannon yous troppo ironman stonkered larrikin. Vb flamin\' fairy floss tell him he\'s dreaming throw-down up the duff dill no dramas it\'ll be. Blimey gutful of chrissie dunny skull stands out like a roo bar heaps fly wire. Bruce knock crook sickie coathanger gutta pinga. Counter meal off chops bull bar bonzer. Rego boogie board good oil bushie damper. As cunning as a ratbag have a go, you mug jumbuck barrack slacker cracker.</p>', 19, '0000000000000000', 1, 8, 0, 0, 1632150630),
(23, 0, 0, 1, '00000000', 'Dennis Suitters', 'Coming Soon', 'Coming Soon title', 'Coming Soon Meta Title', '', '', 'comingsoon', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'comingsoon', '', '', '', '', 'none', '<p>No-hoper roo bar lippy boozer stoked. Mokkies cream gutta op shop galah pretty spiffy cut lunch commando his blood\'s worth bottling. Bodgy leg it ace oi facey rage on. Brass razoo apples cut lunch sandgropper also runners loose cannon bizzo. Dropkick holden whit dipstick two up cane toad cockie damper bitzer as stands out like off chops. Arvo crook brickie when a cold one crow eaters good onya troppo flanny. Thongs on the cans sandgropper donger pinga buggered oi bloody oath icy pole. Bail out middy troppo a cold one piece of piss bizzo roadie paddock. Rort slab eureka brisvegas pissed off.</p>', 23, '0000000000000000', 1, 0, 0, 0, 1633704557),
(24, 0, 0, 1, '00000000', 'Dennis Suitters', 'Maintenance', 'Maintenance', 'Maintenance Meta Title', '', '', 'maintenance', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'maintenance', '', '', '', '', 'none', '<p>We are currently doing Maintenance.</p>', 24, '0000000000000000', 1, 0, 0, 0, 1675688348),
(25, 0, 0, 1, '00000000', 'Dennis Suitters', 'FAQ', 'FAQ Heading', NULL, '', '', 'faq', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'faq', '', '', '', '', 'footer', '<p>Boardies avos avo bottlo snag devo snag bail lappy. Tradie bonza counter meal sleepout his blood\'s worth bottling have a captain cook rego down under. As cross as a no worries schooner donga avo slab pinga. Bog standard bathers holden vb avo as busy as a middy. Tickets on yourself swag blimey blind where bloody shark biscuit pub flamin\'. Pokies dob rego mate\'s rates cobber watch out for the bushie slacker jug. Gutta barbie tosser rock up bail.</p>', 22, '0000000000000000', 1, 33, 0, 0, 1631882640),
(26, 0, 0, 1, '00000000', 'Dennis Suitters', 'Forum', '', NULL, '', '', 'forum', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'forum', 'Forum', '', '', '', 'head', '', 16, '0000000000000000', 1, 13, 0, 0, 1646815269),
(27, 300, 0, 1, '00000000', 'Dennis Suitters', 'Orders', 'Orders Heading', 'Orders', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'orders', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'orders', '', '', '', '', 'account', '<p>Doovalacky a cold one two up reckon shark biscuit icy pole slaps chokkie. Fair go, mate mad as a postie jumbuck bities whit. Muster greenie stoked fisho icy pole slacker tell him he\'s dreaming. Straya we\'re going avo ugg boots compo back of bourke jackaroo rello grouse. No dramas shark biscuit tradie as stands out like damper rotten bush oyster. Carry on like a pork chop knock corker brolly. Booze bus rego you little ripper middy dag rotten he hasn\'t got a cubby house.</p>', 24, '0000000000000000', 1, 344, 0, 0, 1632139675),
(29, 300, 0, 1, '00000000', 'Dennis Suitters', 'Settings', 'Settings Heading', '', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'settings', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'settings', '', '', '', '', 'account', '<p>Show pony ankle biter put a sock in it ten clicks away thingo shoey offsider&period; Taking the piss pozzy bastard to dead horse coathanger&period; Tinny bazza bush oyster frothy gyno boozer stickybeak barbie&period; Get a dog up ya buggered bush oyster suss it out you little ripper&period; Veg out gyno manchester bogan blue kelpie nipper&period; Bradman thongs counter meal you little ripper roadie&period; Ratbag rapt stubby holder also dinky-di one for the road amber fluid bunyip&period;</p>', 26, '0000000000000000', 1, 42, 0, 0, 1648454125),
(30, 0, 0, 1, '00000000', 'Dennis Suitters', 'Checkout', 'Payment Options', 'Checkout', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'checkout', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'checkout', '', '', '', '', 'other', '<p>To ensure our user\'s privacy, we don\'t store Credit Card details,<br>only the chosen Payment Method, Name, Email and Date of Payment.</p>', 29, '0000000000000000', 1, 208, 0, 0, 1632139970),
(31, 0, 0, 1, '00000000', 'Dennis Suitters', 'Offline', 'Offline Heading', 'Offline', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'offline', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'offline', '', '', '', '', 'none', '<p>This is some Offline Page information for when the Internet is down, and someone has the PWA installed from this site. This way they can get contact information.</p>', 31, '0000000000000000', 1, 0, 0, 0, 1634119863),
(41, 0, 0, 1, '00000000', 'Anonymous', 'Biography', '', 'Biography SEO Title', '', '', 'biography', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'biography', '', '', '', '', 'head', '<p>Kindie struth sleepout bonza donga banana bender. Mate yakka shazza got us some crack the shits mate sandgroppers rubbish. Trackie dacks gyno mullet give it a burl bathers to fossicker chuck a spaz. Fly wire amber fluid watch out for the pozzy ironman up yours roo. Battler pissed lizard drinking slappa. Vee dub cubby house yabber boardies apples. No wucka\'s bizzo she\'ll be apples vee dub pozzy bloody muster.</p><p>Reckon ken oath frog in a sock bities galah bazza unit ripper frog in a sock he\'s got a massive rapt. Cream yabber yakka smokes ford road train. Bikie tucker crook going off burk flanno. Trackie dacks bush bash bruce accadacca catcus. Outback lollies mates cut snake mickey mouse mate avo aussie salute feral defo. Ken oath sick shazza got us some bloody ute fair crack of the whip. Boardies mate\'s rates yabber what\'s crackin\' roo. Butcher knackered wrap your laughing gear \'round that better than a kick up the backside suss ankle biter bazza better than a kick up the backside. Footy freo grog mickey mouse mate dinky-di budgie smugglers bizzo two pot screamer. Bush gone walkabout bitzer throw a shrimp on the barbie rollie chuck a spaz ken oath. Roadie brizzie stubby holder she\'ll be right. Footy holy dooley trackies lets throw a.</p><p>Fair go, mate sunnies bodgy aerial pingpong built like a lollies vinnie\'s a cold one shoot through. Tell your story walkin\' full boar crow eaters no worries, mate, she\'ll be right. Brizzie grab us a sunnies waggin\' school ratbag vb gutful of few roos loose in the top paddock roo. Suss a few stubbies short of a six-pack christmas put a sock in it lippy. Blow in the bag damper dog\'s eye to dog\'s eye. Brekkie six of one, half a dozen of the other furthy mickey mouse mate no worries. Jillaroo top bloke digger roo bar accadacca fair dinkum burk scratchy also op shop.</p>', 4, '0000000000000000', 0, 32, 0, 0, 1638696355),
(42, 0, 0, 1, '00000000', 'Dennis Suitters', 'Activation', '', NULL, 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'activate', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'activate', 'Page', '', '', '', 'none', '<p>Please login with the credentials emailed to you when signing up, and update your address details, thank you.</p>', 27, '0000000000000000', 1, 0, 0, 0, 1642059636),
(43, 0, 15, 1, '00000000', 'Dennis Suitters', 'Activities', 'Activities Heading', '', '', '', 'activities', '', 'http://localhost/AuroraCMS2/media/3-reception.jpg', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'activities', '', '', '', '', 'head', '<p>Paddock bottlo ugg boots fair go, mate fossicker. Mickey mouse mate esky ciggy roadie boardies cream stonkered. Icy pole bikie slacker as busy as a give it a burl. Pissed bitzer rort blind outback defo galah fairy floss bradman. Bruce how stickybeak ya cut lunch booze bus how. Chock a block hottie daks sleepout pash pretty spiffy built like a holden skite coppers. Carrying on like a pork chop dero gyno bloody oath ciggies dead horse jumbuck bail up dill. Cockie ridgy-didge cane toad strewth ripper better than a ham sandwich fair crack of the whip bonzer. Ankle biter longneck slab whinge not my bowl of rice booze true blue mad as a gobful up the duff accadacca ironman. Dero what\'s the john dory? lollies struth strides buggered up the duff chokkie. Heaps vinnie\'s joey outback paddock crikey blow in the bag. Shazza skite ropeable lippy freo six of one, half a dozen of the other flick beauty. When amber fluid tucker full blown fly wire head like a dropped pie barrack avo slaps catcus spewin\'. Knickers dead horse put a sock in it buck\'s night shoot through bushie rollie fisho bogan donga.</p><p>Roo bundy whinge gobful and holy dooley bodgy root rat. Budgie smugglers lets get some brekkie compo brolly cut lunch commando flanno. Crikey bikie u-ie lizard drinking rello freo. Offsider throw-down jillaroo ciggy bastards skite. Leg it crow eaters rotten to skite ciggies drongo. No worries trackie dacks hottie clacker ocker truckie. Rotten bunyip toads dob fair suck of the sauce bottle stonkered accadacca. Whinge cane toad a few sandwiches short of a picnic christmas as cunning as a gutful of bradman.</p><p>He hasn\'t got a rollie bushranger oi she\'ll be right. Bazza turps boardies truckie bonzer. Smokes better than a kick up the backside ambo aerial pingpong. Tell him he\'s dreaming fairy floss dole bludger wouldn\'t piss on them if they\'re on fire. Longneck blowie leg it off chops bingle lets get some tosser avo bloody. Squizz blimey buckley\'s chance thunderbox deadset he\'s dreaming. Dry as as dead dingo\'s donga struth fairy floss stubby oi as stands out like dry as as dead dingo\'s donga fair go, mate. G\'day bushranger donger apples pozzy strides crack the shits built like a squizz good oil better than a kick up the backside reckon. Flake thongs sandgroppers u-ie chuck a spaz ace cockie. Donga bush bash furthy donga brolly beauty barbie tucker-bag as cunning as a.</p>', 0, '0000000000000000', 1, 0, 0, 0, 1675687535),
(44, 0, 0, 1, '00000000', 'Dennis Suitters', 'Courses', '', NULL, '', '', 'content', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'course', 'Course', '', '', '', 'head', '', 15, '0000000000000000', 0, 403, 0, 0, 1656076670),
(45, 300, 0, 1, '00000000', 'Dennis Suitters', 'Courses', '', 'Courses', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'courses', '', '', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'courses', '', '', '', '', 'account', '<p>These are the courses that you&apos;ve signed up for&period;</p>', 23, '0000000000000000', 1, 972, 0, 0, 1658454900),
(46, NULL, 0, 0, '00000000', 'Dennis Suitters', 'Notification 1673599052', '', '', '', '', 'notification', '', 'http://localhost/AuroraCMS2/media/blue-pattern-twitter-background.jpg', '', '', '0000000000000000', '', '', 300, 3000, '', '', '', 'notification', 'Article', '', '', '', 'notification', '', 1673599052, '0000000000000000', 0, 0, 0, 0, 1675688505);

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
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `id` bigint NOT NULL,
  `contentType` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `contentType`, `type`, `title`, `notes`, `ti`) VALUES
(24, 'seotips', 'GetAttention', 'before', '&#34;We&#39;ll produce 2 blog posts a week of 500 words&#34;. If your SEO strategy sounds similar to that, I can pretty much guarantee you are wasting your money.', 1608639017),
(25, 'seotips', 'Explain', 'before', 'Google&#39;s &#34;mobile-first&#34; index means they are looking at your site as if they are on a smartphone. This means if you have a &#34;mobile version&#34; of your site that has less content than your desktop version, it is unlikely to get found.', 1608639033),
(26, 'seotips', 'none', 'before', 'Nobody can tell you the keyword a particular user searched for on Google and ended up on your site from organic search, despite what some tools claim to be able to do.', 0),
(27, 'seotips', 'Writing', 'before', 'Adding new content to be &#34;fresh&#34; is a myth: it does not apply universally. Some queries deserve freshness, others do not. Don&#39;t add new content for the sake of it being new.', 1608639101),
(28, 'seotips', 'none', 'before', 'Even if you&#39;re not an e-commerce site or collecting information, all of your site should be https not http. It&#39;s good for protecting your users&#39; privacy and as a thank you, Google counts it as a positive ranking signal :)', 0),
(29, 'seotips', 'Explain', 'before', 'Google completely ignores the meta keyword tag and has done for years. Don&#39;t waste your time writing lists of keywords in your CMS!', 1608639115),
(30, 'seotips', 'none', 'before', 'Your meta description does not directly improve how well your page ranks in Google. It does, of course, influence how many people are attracted to click on your result, so focus on that.', 0),
(31, 'seotips', 'none', 'before', 'Longer content does not necessarily rank better. Some studies may indicate this, but when you look at the source data, it&#39;s just because that content is so much better (and there is a higher probability longer content has had more effort invested). The web is not short of quantity of content - it&#39;s short of quality. Answer questions and intent as quickly as possible, then get into the detail if needed. More tips on what quality means this week :)', 0),
(32, 'seotips', 'none', 'before', 'Content does not just mean text! Sometimes a picture says 1,000 words and a video says even more. Google &#39;learns&#39; what type of content best answers queries and you can get great clues as to what type of content to create by seeing what is already ranking E.g. &#34;How to change a car battery&#34; is all videos ranking top - after the short text content!', 0),
(33, 'seotips', 'none', 'before', 'Back to basics. If you don&#39;t have one, a free Google Search Console (formerly Webmaster Tools) account will give you a wealth of diagnostic information directly from Google about your site, alert you to problems, penalties, hacks and give you average rankings and keywords your site is showing for.', 0),
(34, 'seotips', 'none', 'before', 'You can use search operators to get additional information about your site from Google. For instance, try a search for: site:yourdomain.com and Google will show you how many results it has indexed* for your domain and will list them roughly in order of importance**. You can also use this to see which specific page Google likes on your site for a specific keyword or keyphrase by conducting the search: site:yourdomain.com keyword *It&#39;s not 100% accurate, I&#39;ve actually seen some wild variances. The only way to be sure is to check in Google Search Console, but this method works with competitors or sites you don&#39;t have access to their Search Console. ** This obviously has no keyword context but may have some other context from your personalisation, search history, device etc. It&#39;s more a rough guide for interest and is usually expressive of your internal linking.', 0),
(35, 'seotips', 'none', 'before', 'There is almost no case in which you or your agency should be using the Google Disavow Tool. You&#39;ll probably do more harm than good. This tool is only for disavowing links when you&#39;ve had a manual penalty or specifically when you know blackhat/paid links have happened and you want to proactively remove them. In 99% of cases, just &#39;spammy&#39; links should be left - if Google thinks they&#39;re spammy they&#39;ll just ignore them. Focus your efforts on creating and positive things, instead.', 0),
(36, 'seotips', 'none', 'before', 'If you are moving your site (full or partial), DO NOT use the Remove URLs tool in GSC on the old site. It won&#39;t make the site move go any faster. It only impacts what&#39;s visible in Search so it could end up hurting you in the short-term.', 0),
(37, 'seotips', 'none', 'before', 'First words are important words. If you&#39;re going to put your brand name in your page title, it usually should come after the description of the page content.', 0),
(38, 'seotips', 'none', 'before', '&#34;Keywords Everywhere&#34; Chrome plugin is a nice, free way to get search volumes, search value and suggestions overlaid with every search you do. I have it on all of the time and over the months and years, you build a good &#39;feel&#39; for search competitiveness and how other people search.', 0),
(39, 'seotips', 'none', 'before', 'Pop-ups and interstitials generally annoy users, you too, right? Since Jan 2017, Google has specifically stated that websites that obscure content with them and similar will likely not rank as well.', 0),
(40, 'seotips', 'none', 'before', 'Google has always flatly denied and there is no good evidence whatsoever that social media posts on platforms like Facebook and their associated &#39;likes&#39; and/or engagements directly impact your rankings in any way. If someone is insistent about this, look closely - you may be dealing with a clown!', 0),
(41, 'seotips', 'none', 'before', 'How long a domain has been live and receiving links for, building up a reputation plays a part in how well the pages on it can rank. Older is better.', 0),
(42, 'seotips', 'none', 'before', 'Google can index PDF documents just fine and it actually renders them as HTML. This means links in PDF documents count as normal weblinks - PDFs are pretty easy to share, too....', 0),
(43, 'seotips', 'none', 'before', 'Have you heard that 50% of searches by 2020 will be voice searches? They won&#39;t, it&#39;s complete rubbish.', 0),
(44, 'seotips', 'none', 'before', '1 in 5 searches in that happen in Google are unique and have never happened before. The vast majority of searches that are conducted are terms that have fewer than 10 searches per month. If you&#39;re just picking key phrases based on volume from &#34;keyword research&#34;, you&#39;re missing the lion&#39;s share of traffic and making life hard for yourself, as lots of other people are doing the same.', 0),
(45, 'seotips', 'none', 'before', 'Check the last 12 months in Google Analytics, if you&#39;ve got content pages with no traffic - it&#39;s maybe time to consider consolidating, redoing or removing those pages.', 0),
(46, 'seotips', 'none', 'before', 'Key phrases mentioned in the reviews written about you on Google My Business help the visibility of your company for those terms.', 0),
(47, 'seotips', 'none', 'before', 'You need other websites to link to your website pages if you want to rank well in Google. This means if you consider SEO to be a one-off, checkbox task of completing items on an audit, you are unlikely to see success. Technical SEO gives you the foundation to build on, not the finished article.', 0),
(48, 'seotips', 'none', 'before', 'Have a play with Google Trends! It is useful to see trends in searches, when they happen every week, month or year. How much do they vary or are they trending up or down? Here&#39;s a funny trend for two searches (different Y axis) for searches around &#39;solar eclipse&#39; and &#39;my eyes hurt&#39; :)', 0),
(49, 'seotips', 'none', 'before', 'You can do some basic brand monitoring for free with Google Alerts. This gives you the opportunity to do &#39;link reclamation&#39; - when websites are mentioning your brand or website and not giving you that link. Strike up a friendly conversation, offer them some more value, detail, insight and get that request in to get the link :-)', 0),
(50, 'seotips', 'none', 'before', 'Registering for Google My Business for free, is how you can start ranking in the local map box results.', 0),
(51, 'seotips', 'none', 'before', 'Stuck for good content ideas? Put a broad subject (like &#39;digital marketing&#39;) into AnswerThePublic and you&#39;ll get a list of the types of questions people are asking in Google!', 0),
(52, 'seotips', 'none', 'before', 'Video is often overlooked, YouTube is the second largest search engine in the UK - there is more to SEO than just Google search!', 0),
(53, 'seotips', 'none', 'before', 'Want a better chance that your videos will appear in search results? Then create video sitemaps! Video sitemaps give additional information to search engines about videos hosted on your pages and help them rank.', 0),
(54, 'seotips', 'none', 'before', 'Don&#39;t stress about linking to other websites where it&#39;s relevant and useful to the user. That&#39;s how the web works and is absolutely fine!', 0),
(55, 'seotips', 'none', 'before', 'Did you know that sending someone a free product to review and get a link is against Google&#39;s guidelines and comes under &#39;link schemes&#39; that could land you with a penalty?', 0),
(56, 'seotips', 'none', 'before', 'Domain age, or at least the component parts of it such as how long links have existed to it, play a part in ranking. It is almost impossible to rank a brand new domain for any competitive term.', 0),
(57, 'seotips', 'none', 'before', 'Golden rule of SEO - there is absolutely no &#39;SEO change&#39; you should do on your site that will make the user experience worse. None. No exceptions.', 0),
(58, 'seotips', 'none', 'before', 'Ideally, you just want just one h1 on the page and it should be descriptive of the page content for the user. Naturally, your page title and h1 will normally be similar.', 0),
(59, 'seotips', 'none', 'before', 'Struggling to get interesting data to make a narrative to get links? Did you know Google has a Dataset Search? You can search for publicly available datasets to get inspiration and save huge amounts of time.', 0),
(60, 'seotips', 'none', 'before', 'With a reasonable number of results, a &#39;view all page&#39; is optimal over paginated content. Research shows &#39;view all&#39; pages are also preferred by users. Google says: &#34;T improve the user experience, when we detect that a content series (e.g. page-1.html, page-2.html, etc.) also contains a single-page version (e.g. page-all.html), we’re now making a larger effort to return the single-page version in search results.&#34;', 0),
(61, 'seotips', 'none', 'before', 'Cannibalisation is when you have more than one URL targeting the same intent / key phrase. It is one of the main problems that causes otherwise technically optimised sites with decent content to rank very poorly.', 0),
(62, 'seotips', 'none', 'before', 'If you want content to rank well over months/years, you need to design your site to link to it from &#39;high up&#39; in your site hierarchy. It&#39;s generally a mistake to post evergreen content in a chronological blog, as it will slowly disappear deeper into your site, more clicks away. If it&#39;s evergreen and always relevant, it should always be prominent.', 0),
(63, 'seotips', 'none', 'before', 'If you discontinue a popular model/product on your e-commerce site, rather than delete the page, update it to explain the product is discontinued and link to the nearest alternative products. This is more helpful to the user and prevents the loss of organic traffic.', 0),
(64, 'seotips', 'none', 'before', 'A specific &#39;keyword density&#39; is not a thing, so don&#39;t waste your time on it. Apart from the fact text analysis goes far beyond this and tf-idf, it means you&#39;re writing for robots and not for humans - and therefore missing the point. The algorithm is only ever trying to describe what is best for humans, so start from there.', 0),
(65, 'seotips', 'none', 'before', 'www or non-www, pick one! Then redirect (301) one to the other. Did you know that Google and other search engines count URLs with and without www and different (and therefore duplicate) pages?', 0),
(66, 'seotips', 'none', 'before', 'Do not underestimate the power of ranking in Google Images. A huge amount of searches are visual, so it is worth making sure your image assets are properly marked up and optimised.', 0),
(67, 'seotips', 'none', 'before', 'When doing a site migration, try and change as few things as possible. E.g. if you can do a move to http - https first, do that. It will make it easier to diagnose and fix the root cause of any issues.', 0),
(68, 'seotips', 'none', 'before', 'If you don&#39;t have a strategy to get people to link to you, it&#39;s going to be almost impossible to obtain competitive rankings. Links are still the life blood of rankings. Here is a recent test example. The site does not rank for years. It gets an influx of links (top graph) and the search visibility shoots up (bottom graph). The site loses links (orange, top graph) and search visibility falls (bottom graph).', 0),
(69, 'seotips', 'none', 'before', '&#34;The content comes before the format, you don&#39;t &#39;need an infographic&#39;, you don&#39;t &#39;need a video&#39;. Come up with the content idea, then decide how to frame it&#34; - Advice from Stacey MacNaught', 0),
(70, 'seotips', 'none', 'before', 'Dominating Google is about getting your information in multiple places not just your own sites. Or just making Google think you have 512 arms :-)', 0),
(71, 'seotips', 'none', 'before', 'Part of being &#39;the best&#39; result comes with format. Google is bringing AR directly to search results. Your product, in the consumer&#39;s home. Doesn&#39;t get much more powerful than that!', 0),
(72, 'seotips', 'none', 'before', 'Got a showroom? It&#39;s not expensive to get a 360 photo done for your Google My Business and it will help you attract more in-store visitors.', 0),
(73, 'seotips', 'none', 'before', 'Bounce rate is not a ranking factor. A high bounce rate can be good in some cases, it needs to be taken in context with searcher intent.', 0),
(74, 'seotips', 'none', 'before', 'You cannot &#34;optimise for Rankbrain&#34; - &#39;Rankbrain&#39; is the name of one component of Google search that specifically deals with queries Google has not seen before using AI to try and understand intent. Rankbrain deals with approximately 15% of queries (around 3,000 a second).', 0),
(75, 'seotips', 'none', 'before', '&#34;Google has 200 different ranking factors, each with 50 different variables&#34;. Have you heard this? That&#39;s what we were told almost 10 years ago by Matt Cutts from Google. This is not reflective of how Google works in 2019 and someone saying this to you should raise a red flag - it&#39;s super out of date information!', 0),
(76, 'seotips', 'none', 'before', 'Having an empty &#39;voucher code&#39; box as the last step of your checkout can kill your conversion rate as you send people off on a wild goose chase to find one! It&#39;s always worth having a &#34;[brand name] vouchers, offers and coupons&#34; page - it will always rank first and if you have no offers on, you can let people know so they don&#39;t feel they are missing out!', 0),
(77, 'seotips', 'none', 'before', 'Correctly categorising your business with &#34;Google My Business&#34; is vital to appear for generic map-based searches.', 0),
(78, 'seotips', 'none', 'before', 'It is worth looking at the last 12 months Analytics data and seeing what pages you have that get no traffic and asking why. It&#39;s a great way to see what your content weak spots are, what needs improving, rewriting or sometimes - just deleting.', 0),
(79, 'seotips', 'none', 'before', 'Don&#39;t add keywords in your Google My Business name, it can get you penalised.', 0),
(80, 'seotips', 'none', 'before', 'Not sure where to start focus with? There are rarely &#39;quick wins&#39; within SEO, but focussing on your content that ranks in position 3-10 can be the fastest way to get traffic, as most of it is locked up in those top 3 positions on a regular SERP. You can pull a report like this quickly with a tool like SEMrush (aff).', 0),
(81, 'seotips', 'none', 'before', 'If you&#39;re really thinking about your audience, their intent and getting people that know the subject to write your content - you don&#39;t really need to worry about what TF-IDF is, or how it works.', 0),
(82, 'seotips', 'none', 'before', 'Sometimes blindly following Google&#39;s advice is not in your best interest (in the short term, at least).', 0),
(83, 'seotips', 'none', 'before', '&#34;Those aren&#39;t my competitors!&#34; - You have both business competitors, who you are likely aware of - and you have search competitors - the ones that rank above you for the keywords you want. These are the people that you&#39;ll be competing with in SEO and you can use a tool like SEMrush to quickly identify which websites overlap with you on how many keywords and which ones.', 0),
(84, 'seotips', 'none', 'before', 'Name, Address, Phone (NAP) citations are important for local SEO and ranking in the map box. This means having your main business address listed as your accounts (common practice in the UK) can be very detrimental to your SEO!', 0),
(85, 'seotips', 'none', 'before', 'There is not such thing as a &#39;duplicate content penalty&#39;. Unless your site is pure spam, you&#39;re not going to be harmed if someone copies a page of yours or if you have some copied content. It may get filtered out of a search result but you&#39;re not going to get your site penalised.', 0),
(86, 'seotips', 'none', 'before', 'You should not be hiring generalist copywriters to write your content. Competition is fierce and your users (and Google) are looking for genuine expertise and insight - not a rehashed article made from reading 10 others that already exist. Not convinced? It&#39;s spelled out for you in Google&#39;s webmaster advice.', 0),
(87, 'seotips', 'none', 'before', 'Links to your site from posts on platforms like Facebook and LinkedIn do not help your ranking in Google.', 0),
(88, 'seotips', 'none', 'before', 'Paying for Google Ads does not improve your organic Google ranking. It doesn&#39;t. It really, really doesn&#39;t.', 0),
(89, 'seotips', 'none', 'before', 'If you&#39;re building a new site, SEO considerations need to happen right at the start. How will you handle the migration? What schema are you using? Which content is evergreen and which is chronological? How are you going to avoid cannibalisation? It&#39;s not a plan to think you can &#34;do the SEO&#34; after the site is built.', 0),
(90, 'seotips', 'none', 'before', 'Almost 25% of all SERPs have a featured snippet, if you&#39;re not tracking them - what are you doing? You can use tools such as SEMrush to keep tabs on the types of SERP features that are appearing in your niche.', 0),
(91, 'seotips', 'none', 'before', 'Less is more when it comes to Local SEO and Google My Business categories. Fewer, more specific business categorisations will get you better results that trying to cover everything.', 0),
(92, 'seotips', 'none', 'before', 'A homepage is not &#39;special&#39; in that it has more power to rank well than any other page, in isolation it has the same ability to rank as any other page on your site. Homepages tend to just pickup the majority of links, so they can rank easily - that&#39;s all!', 0),
(93, 'seotips', 'none', 'before', 'If you&#39;re a small business, it is likely that an SEO audit will have almost no measurable value for you unless: a) You have the resources to deploy changes recommended b) You are going to invest in a sustained SEO effort Generally, a technical audit will only have immediate impact if the site is deploying it&#39;s ranking potential inefficiently - i.e. the site already has a decent backlink profile. For many small businesses with almost no links, making technical changes will have limited impact in isolation. Think of it as tuning the engine that has no fuel.', 0),
(94, 'seotips', 'none', 'before', 'Intent trumps length with content. Content length is not a ranking factor. Yes there are some correlations, largely due to longer content normally has a lot more effort put into it, earns more links and you&#39;ve got a bigger net to catch longtail searches with - but please, don&#39;t make it longer for the sake of it!', 0),
(95, 'seotips', 'none', 'before', 'If a company is offering a Gold, Silver, Bronze package type approach to SEO, it&#39;s likely going to be hot trash.', 0),
(96, 'seotips', 'none', 'before', 'Having trouble coming up with a content topic? Check out AnswerThePublic[dot]com research tool. Whack in a subject and it will show you the common questions that are being searched for in Google about that topic. It&#39;s a brilliant way to start building topic lists for your content plan.', 0),
(97, 'seotips', 'none', 'before', 'Google can sometimes ignore your meta description and use any on-page content it finds that it believes is more relevant for the user. This is usually a good thing - dynamic meta descriptions can in some cases give better CTR.', 0),
(98, 'seotips', 'none', 'before', 'You can see how much search traffic you get from Google Images by going into Google Search Console, selecting Performance -> Search Results and changing the &#39;Search Type&#39; filter to &#39;Images&#39;. There&#39;s a huge amount of traffic potential locked up in Google images!', 0),
(99, 'seotips', 'none', 'before', 'This tip is directly from Google for helping you choose an SEO or an SEO agency: &#34;If they guarantee you that their changes will give you first place in search results, find someone else.&#34; Monitoring individual keywords isn&#39;t really the best measure of success, nobody can account for future algorithm changes or what your competitors will do if you start to climb. Like with many things in business and life, if it sounds too good to be true, it probably is.', 0),
(100, 'seotips', 'none', 'before', 'Your participation (or not) in providing Google with &#39;rich snippet&#39; (position 0) results, does not impact your &#39;normal&#39; 1-10 rankings.', 0),
(101, 'seotips', 'none', 'before', 'Google is not king everywhere! If you&#39;re targeting Russian speaking countries, you will need to rank in Yandex, which can be quite different from ranking in Google!', 0),
(102, 'seotips', 'none', 'before', 'Google ignores anything after a hash (#) in your URLs. This means you should not use # in URLs to load new content (jumping to anchor points is fine).', 0),
(103, 'seotips', 'none', 'before', 'If you&#39;re auditing a site, you need to make sure you crawl it both with and without Javascript and with different user-agents and compare differences. I&#39;ve seen too many site audits done assuming there was no user-agent sniffing or that there was a JS fallback in place!', 0),
(104, 'seotips', 'none', 'before', 'Try using the site: operator in Google to see what pages you have indexed. You do this just by doing a search for site:yoursite.com. Sometimes you&#39;ll be surprised by what is (or not!) indexed!', 0),
(105, 'seotips', 'none', 'before', 'A blog is normally a terrible place to host &#39;evergreen&#39; content such as how to guides. If your blog/news section is chronological, the content will slowly &#39;sink&#39; down your site&#39;s hierarchy. It becomes more clicks away, harder to find for users and will become seen as a less important page for search engines.', 0),
(106, 'seotips', 'none', 'before', 'If you&#39;re starting out in SEO, I would invest more time learning about how search engines work and what they are trying to achieve, rather than specific &#34;SEO tactics&#34;. Learning the foundations will give you a solid framework to make much better strategic decisions. This means reading less &#34;10 ways to..&#34; and more on subjects like Information Retrieval (IR).', 0),
(107, 'seotips', 'none', 'before', 'Write better content for your users, focus on satisfying intent and maximising user experience. There is no &#39;SEO copywriting&#39;, there is just good content, bad content and the stuff in-between.', 0),
(108, 'seotips', 'none', 'before', 'All other things being equal, two links from two different domains are worth more than two links from the same domain.', 0),
(109, 'seotips', 'none', 'before', 'SEO is not just about Google! Bing gets some great traffic for B2B searches, especially for organisations where the IT is locked down and they may be forced into using older browsers that default to Bing.', 0),
(110, 'seotips', 'none', 'before', 'The quality of links is far more important than the volume. This is why setting targets on volumes of links doesn&#39;t tend to work so well and can be a very outdated approach to SEO.', 0),
(111, 'seotips', 'none', 'before', '&#34;So what?&#34;. It&#39;s a great test for when you&#39;re producing content in an effort to get coverage and links. As ideas are formed and developed, it can be easy to get off-track and sold on your own idea. When you&#39;ve got your story, data, headline - ask yourself, &#34;So what?&#34;. Why would other people care? If you&#39;ve got an answer to that, can you move onto the next stage.', 0),
(112, 'seotips', 'none', 'before', 'Sometimes your target key phrases can be close to impenetrable. Rather than waste resource trying to get positions with no return, it can be worth considering alternate (normally lower search volume) phrases for the same intent. A smaller slice is better than no slice at all! You can make this judgement on Google Trends, search volumes and cost per click data.', 0),
(113, 'seotips', 'none', 'before', 'Search intent shift is when at certain times of the year, the majority of the intent behind an individual search will change. A good example is &#39;Halloween&#39;, which switches from informational to a commercial term near halloween. As this happens, Google will can change their rankings drastically to adapt to this intent. If you do see fluctuations in your rankings around specific events or times of year like this, it will may well be that there is nothing &#34;wrong&#34; with your site, it&#39;s just not the best to serve that intent, at that time.', 0),
(114, 'seotips', 'none', 'before', 'Buyer beware: Despite some spurious claims to the contrary, there is no tool on the market that can tell you specifically what organic key phrase an individual user searched for and then clicked on. Only Google has that data and it doesn&#39;t give it out.', 0),
(115, 'seotips', 'none', 'before', 'Don&#39;t be afraid to link out to other good sites when it is helpful, but linking out does not directly help boost your ranking.', 0),
(116, 'seotips', 'none', 'before', '&#39;SEO ad platforms&#39;, which are basically adverts or advertorials that &#39;pass SEO benefit&#39;. Avoid, avoid, avoid. They will put your website at a substantial risk of getting a penalty. While it&#39;s up to you if you want to follow Google&#39;s rules, if you&#39;re going to break them - at least do it well!', 0),
(117, 'seotips', 'none', 'before', 'You can get more mileage and links from your web content with collation and curation. If you&#39;re using a tool like AlsoAsked to answer questions about your products or product categories, you could look at combining all that information into a single/guide page that can be used with outreach efforts - it makes it a lot easier to build resources to get links from.', 0),
(118, 'seotips', 'none', 'before', 'The pages that you want to rank well for higher volume terms should be linked &#34;high up&#34; within your site&#39;s hierarchy, such as the main menu or homepage. If you have a page that you expect to rank well that&#39;s 4-5 clicks away and only linked to internally from a couple of pages, you&#39;re likely to be disappointed!', 0),
(119, 'seotips', 'none', 'before', 'An automated SEO audit report done by an online tool has almost zero value unless it&#39;s put in context to your business by someone that understands both it and SEO. These tools will rarely give you a good action plan and will almost always provide false positives.', 0),
(120, 'seotips', 'none', 'before', 'If your e-commerce site has a faceted navigation/filter that gets you to a product sub-category that has search volume, it is good to practise to make sure this page is accessible by standard links (I.e. not checkboxes) and has its own URL so it can rank!', 0),
(121, 'seotips', 'none', 'before', 'Google does not use data from Google Analytics to index or rank your website. No, they don&#39;t use &#34;bounce rate&#34; as a ranking factor, either. If people say they do, that&#39;s just their own wild theory.', 0),
(122, 'seotips', 'none', 'before', 'The impact of a &#34;ranking factor&#34; can change massively by industry or niche, even with time of year. Don&#39;t take it for granted that things working well for others will necessarily translate into success for your website.', 0),
(123, 'seotips', 'none', 'before', 'While it&#39;s nice to have one H1 on a page to be clear about the subject, having multiple H1s in a template isn&#39;t going to cause you any SEO issues. It is highly likely there will be other things that are more valuable to spend your time on.', 0),
(124, 'seotips', 'none', 'before', 'Just because a page is crawled and discovered by Google, does not mean it will be indexed and appear in search.', 0),
(125, 'seotips', 'none', 'before', 'If you want Google to quickly index a change on a page such as an optimised title or correcting a mistake, you can use Google Search Console. Go to URL Inspection -> Enter URL -> Request Indexing and you&#39;ll be put in a queue to have a visit from Google ASAP!', 0),
(126, 'seotips', 'Explain', 'before', 'A basic for business owners that I see most businesses miss. There is a &#34;Posts&#34; feature within Google My Business that allows you to post COVID-19 support/updates, offers, updates and events directly to the SERP. It&#39;s an easy way to control the search result, expand the real estate you are taking up and control the message you want to deliver at that moment!', 1611640029),
(127, 'seotips', 'Explain', 'before', 'As long as your code functions, it does not need to be W3C compliant - this is not a &#34;ranking factor&#34; as you see on some audits. To quote Google: &#34;As long as it can be rendered and SD extracted: validation pretty much doesn’t matter.&#34;', 1611640027),
(128, 'seotips', 'Explain', 'before', 'If you&#39;re stuck in a rut for content ideas, using a tool like BuzzSumo can quickly show you which content is popular and being shared around a topic. It&#39;s a great way to kickstart your ideation process!', 1611640024),
(129, 'seotips', 'Explain', 'before', 'W3C validation is not a ranking factor. If you&#39;re being told to look at W3C validation &#34;for SEO&#34;, this should be a red flag. W3C validation is useful to avoid errors - and of course, if you&#39;re HTML is utterly broken, that can cause issues, but strict validation itself is not going to affect rankings.', 1611640020),
(130, 'seotips', 'Explain', 'before', 'Ranking fluctuations are normal. Even changing nothing on a site, you can see positions rise and fall a couple of spots on a weekly or even daily basis. There are a lot of moving parts, thousands of algorithm tweaks over the year, changes in the link graph that is powering you and your competitor&#39;s sites, competitors changing things. Don&#39;t be too quick to assign action or inaction to these small changes. Drastic changes or trends you can see over months are what you need to act upon.', 1611640009),
(131, 'seotips', 'Explain', 'before', 'Don&#39;t fret if you see different rankings on the same search term on two different computers. Even on an identical computer, location, IP, time, signed in (or not), it is possible to see the same site ranking in two different positions. Google&#39;s infrastructure to serve results is vast, shifting and there is no one instance of &#34;the index&#34; - just a norm that everything is synchronising towards.', 1611640006),
(132, 'seotips', 'Explain', 'before', 'When writing content, it sometimes pays to reformulate headers as questions, rather than relying on the user to be &#34;in the flow&#34; of the content to understand the context. This allows parts of information to be self-contained, easily scannable - and often reflects how people phrase search terms, meaning you&#39;re more likely to get a featured snippet result.', 1611640003),
(139, 'seotips', '', '', 'You generally need other websites to link to your website pages if you want to rank well in Google. This means if you consider SEO to be a one-off, checkbox task of completing items on an audit, you are unlikely to see success. Technical SEO gives you the foundation to build on, not the finished article.', 0),
(141, 'seotips', '', '', 'You can do some basic brand monitoring for free with Google Alerts. This gives you the opportunity to do &#39;link reclamation&#39; - when websites are mentioning your brand or website and not giving you that link. Strike up a friendly conversation, offer them some more value, detail, insight and get that request in to get the link.', 0),
(142, 'seotips', '', '', 'Video is often overlooked, YouTube is the second largest search engine in the UK - there is more to SEO than just Google search!', 0),
(143, 'seotips', '', '', 'Don&#39;t stress about linking to other websites where it&#39;s relevant and useful to the user. That&#39;s how the web works and is absolutely fine!', 0),
(144, 'seotips', '', '', 'Did you know that sending someone a free product to review and get a link is against Google&#39;s guidelines and comes under &#39;link schemes&#39; that could land you with a penalty?', 0),
(145, 'seotips', '', '', 'Ideally, you just want just one h1 on the page and it should be descriptive of the page content for the user. Naturally, your page title and h1 will normally be similar.', 0),
(146, 'seotips', '', '', 'Golden rule of SEO - there is absolutely no &#39;SEO change&#39; you should do on your site that will make the user experience worse. None. No exceptions.', 0),
(147, 'seotips', '', '', 'A specific &#39;keyword density&#39; is not a thing, so don&#39;t waste your time on it. Apart from the fact text analysis goes far beyond this and tf-idf, it means you&#39;re writing for robots and not for humans - and therefore missing the point. The algorithm is only ever trying to describe what is best for humans, so start from there.', 0),
(148, 'seotips', '', '', 'Do not underestimate the power of ranking in Google Images. A huge amount of searches are visual, so it is worth making sure your image assets are properly marked up and optimised.', 0),
(149, 'seotips', '', '', 'The content comes before the format, you don&#39;t &#39;need an infographic&#39;, you don&#39;t &#39;need a video&#39;. Come up with the content idea, then decide how to frame it.', 0),
(150, 'seotips', '', '', 'Correctly categorising your business with &#34;Google My Business&#34; is vital to appear for generic map-based searches.', 0),
(151, 'seotips', '', '', 'There is not such thing as a &#39;duplicate content penalty&#39;. Unless your site is pure spam, you&#39;re not going to be harmed if someone copies a page of yours or if you have some copied content. It may get filtered out of a search result but you&#39;re not going to get your site penalised.', 0),
(152, 'seotips', '', '', 'Quick and dirty keyword cannibalisation check, use this search in Google: site:yoursite[dot]com intitle:&#34;key phrase to rank for&#34; This will only return results for your website where you have the key phrase you want to rank for in the title. If this returns multiple pages, you may be confusing search engines as to which page you want to rank for this term. Consider consolidating, redirecting or canonicalising as appropriate.', 0),
(153, 'seotips', '', '', 'If you rank competitively, you need to do SEO just to maintain your positions. Competitors won&#39;t just be saying &#34;oh, well, we loved ranking well&#34; when you sail past them, they will increase their efforts to get rankings back. Sometimes, just holding good rankings is an achievement in itself.', 0),
(154, 'seotips', '', '', 'If you&#39;re going to write content, such as a blog post, do a Google search first and look at what ranks number 1 already. If what you&#39;re going to produce isn&#39;t as good as what already ranks (be honest)- then why are you even bothering? If you wouldn&#39;t pick your content over a competitor, why would a search engine?', 0);

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
(2, 400, 0, 'livechat', 'livechat', 'chat', 'Livechat', 13, 1),
(3, 400, 0, 'dropdown', 'content', 'content', 'Content', 3, 1),
(4, 400, 3, 'media', 'media', 'picture', 'Media', 12, 1),
(5, 400, 0, 'pages', 'pages', 'content', 'Pages', 2, 1),
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
(17, 400, 0, 'messages', 'messages', 'inbox', 'Messages', 12, 1),
(18, 400, 0, 'forum', 'forum', 'forum', 'Forum', 7, 1),
(19, 400, 0, 'newsletters', 'newsletters', 'newspaper', 'Newsletters', 11, 1),
(20, 400, 0, 'bookings', 'bookings', 'calendar', 'Bookings', 8, 1),
(21, 400, 0, 'dropdown', 'orders', 'order', 'Orders', 4, 1),
(22, 400, 21, 'all', 'orders', 'order-quote', 'All', 0, 1),
(23, 400, 21, 'quotes', 'orders', 'order-quote', 'Quotes', 1, 1),
(24, 400, 21, 'invoices', 'orders', 'order-invoice', 'Invoices', 2, 1),
(25, 400, 21, 'pending', 'orders', 'order-pending', 'Pending', 3, 1),
(26, 400, 21, 'recurring', 'orders', 'order-recurring', 'Recurring', 4, 1),
(27, 400, 21, 'orderdue', 'orders', 'order-pending', 'Overdue', 5, 1),
(28, 400, 21, 'archived', 'orders', 'order-archived', 'Archived', 6, 1),
(29, 400, 0, 'accounts', 'accounts', 'users', 'Accounts', 1, 1),
(30, 400, 0, 'comments', 'comments', 'comments', 'Comments', 9, 1),
(31, 400, 0, 'reviews', 'reviews', 'review', 'Reviews', 10, 1),
(32, 400, 0, 'dropdown', 'settings', 'settings', 'Settings', 15, 1),
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
(43, 400, 0, 'dropdown', 'preferences', 'settings', 'Preferences', 14, 1),
(44, 400, 43, 'theme', 'preferences', 'theme', 'Theme', 2, 1),
(45, 400, 43, 'contact', 'preferences', 'address-card', 'Contact', 3, 1),
(46, 400, 43, 'social', 'preferences', 'user-group', 'Social', 4, 1),
(47, 400, 43, 'interface', 'preferences', 'sliders', 'Interface', 0, 1),
(48, 400, 43, 'seo', 'preferences', 'plugin-seo', 'SEO', 5, 1),
(49, 400, 43, 'activity', 'preferences', 'activity', 'Activity', 8, 1),
(50, 400, 43, 'tracker', 'preferences', 'tracker', 'Tracker', 10, 1),
(51, 400, 43, 'cart', 'preferences', 'shop-cart', 'Cart', 6, 1),
(52, 400, 43, 'database', 'preferences', 'database', 'Database', 11, 1),
(53, 400, 43, 'suggestion', 'preferences', 'idea', 'Suggestions', 7, 1),
(54, 400, 43, 'security', 'preferences', 'security', 'Security', 9, 1),
(55, 1000, 0, 'payments', 'payments', 'hosting', 'Payments', 17, 1),
(56, 400, 0, 'notification', 'notification', 'notification', 'Notifications', 16, 1),
(57, 400, 0, 'joblist', 'joblist', 'joblist', 'Job List', 18, 1),
(58, 900, 0, 'templates', 'templates', 'templates', 'Templates', 19, 1),
(59, 400, 43, 'a11y', 'preferences', 'a11y', 'Accessibility', 1, 1),
(60, 400, 3, 'activities', 'content', 'activities', 'Activities', 2, 1),
(61, 400, 0, 'course', 'course', 'education-cap', 'Courses', 6, 1),
(62, 400, 0, 'adverts', 'adverts', 'blocks', 'Adverts', 5, 1);

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
  `width` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord` bigint NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `ref`, `title`, `file`, `layout`, `width`, `ord`, `active`) VALUES
(1, 'dashboard', 'SEO Tutorial Links', 'seolinks.php', '', '6', 8, 1),
(2, 'dashboard', 'Unsolicited SEO Tips', 'seounsolicited.php', '', '6', 9, 1),
(3, 'dashboard', 'Visitor Stats', 'visitorstats.php', '', '6', 0, 1),
(4, 'dashboard', 'Top Ten Highest Viewed Pages', 'viewedpages.php', '', '6', 10, 1),
(8, 'dashboard', 'Top Ten Search Keywords This Month', 'topkeywords.php', '', '6', 8, 1),
(9, 'dashboard', 'Recent Admin Activity', 'recentadminactivity.php', '', '6', 11, 1),
(10, 'dashboard', 'Latest AuroraCMS Updates', 'auroracmsupdates.php', '', '6', 12, 1),
(11, 'content', 'SEO Content Help', 'seocontenthelp.php', '', '', 2, 1),
(12, 'content', 'Text Analysis', 'hemmingway.php', '', '', 1, 1),
(13, 'dashboard', 'Devices', 'devices.php', '', '3', 6, 1),
(14, 'dashboard', 'Browsers', 'browsers.php', '', '3', 4, 1),
(15, 'dashboard', 'Referrers', 'referrers.php', '', '3', 5, 1),
(16, 'dashboard', 'Countries', 'countries.php', '', '3', 7, 1),
(17, 'dashboard', 'Weather', 'weather.php', '', '6', 1, 1),
(18, 'dashboard', 'Sale Content Suggestions', 'salecontent.php', '', '12', 0, 1),
(20, 'content', 'Content Stats', 'contentstats.php', '', '', 3, 1),
(21, 'dashboard', 'Sales Stats', 'dashboardsalesstats.php', '', '6', 2, 1),
(22, 'dashboard', 'Latest Orders', 'dashboardlatestorders.php', '', '6', 3, 1);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `seo`
--
ALTER TABLE `seo`
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `sidebar`
--
ALTER TABLE `sidebar`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
