-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 29, 2021 at 05:36 PM
-- Server version: 8.0.25-0ubuntu0.20.04.1
-- PHP Version: 7.3.28-2+ubuntu20.04.1+deb.sury.org+1

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
  `stockStatus` tinytext COLLATE utf8_bin NOT NULL,
  `points` int NOT NULL,
  `si` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` bigint UNSIGNED NOT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `rid` bigint UNSIGNED NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rank` int UNSIGNED NOT NULL,
  `icon` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `port` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `flag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `value` int NOT NULL,
  `f` decimal(10,2) NOT NULL,
  `t` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `tis` int NOT NULL,
  `tie` int NOT NULL,
  `ord` bigint NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rid` bigint UNSIGNED NOT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `cid` bigint UNSIGNED NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gravatar` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `active` tinyint UNSIGNED NOT NULL,
  `tie` int NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` tinyint UNSIGNED NOT NULL,
  `development` int NOT NULL,
  `maintenance` int NOT NULL,
  `comingsoon` int NOT NULL,
  `options` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `metaRobots` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoRSSTitle` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoRSSNotes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoRSSLink` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoRSSAuthor` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoRSSti` bigint NOT NULL,
  `business` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `abn` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `suburb` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `city` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `state` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `country` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `postcode` mediumint UNSIGNED NOT NULL,
  `phone` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mobile` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `vti` int UNSIGNED NOT NULL,
  `sti` int UNSIGNED NOT NULL,
  `dateFormat` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email_check` int NOT NULL,
  `email_interval` int NOT NULL,
  `email_signature` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `storemessages` int NOT NULL,
  `message_check_interval` int NOT NULL,
  `chatAutoRemove` int NOT NULL,
  `messengerFBCode` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `messengerFBColor` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `messengerFBGreeting` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `language` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `timezone` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `orderPayti` int UNSIGNED NOT NULL,
  `orderEmailSubject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `orderEmailLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `orderEmailNotes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `orderEmailReadNotification` tinyint(1) NOT NULL,
  `austPostAPIKey` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gst` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `memberLimit` varchar(6) COLLATE utf8_bin NOT NULL,
  `memberLimitSilver` varchar(6) COLLATE utf8_bin NOT NULL,
  `memberLimitBronze` varchar(6) COLLATE utf8_bin NOT NULL,
  `memberLimitGold` varchar(6) COLLATE utf8_bin NOT NULL,
  `memberLimitPlatinum` varchar(6) COLLATE utf8_bin NOT NULL,
  `wholesaleLimit` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `wholesaleLimitSilver` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `wholesaleLimitBronze` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `wholesaleLimitGold` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `wholesaleLimitPlatinum` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `wholesaleTime` int NOT NULL,
  `wholesaleTimeSilver` int NOT NULL,
  `wholesaleTimeBronze` int NOT NULL,
  `wholesaleTimeGold` int NOT NULL,
  `wholesaleTimePlatinum` int NOT NULL,
  `passwordResetLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `passwordResetSubject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `accountActivationSubject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `accountActivationLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingNoteTemplate` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingEmailSubject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingEmailLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingEmailReadNotification` tinyint(1) NOT NULL,
  `bookingAutoReplySubject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingAutoReplyLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingAttachment` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingAgreement` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bookingBuffer` int NOT NULL,
  `contactAutoReplySubject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `contactAutoReplyLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `newslettersEmbedImages` int NOT NULL,
  `newslettersSendMax` int NOT NULL,
  `newslettersSendDelay` int NOT NULL,
  `newslettersOptOutLayout` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bank` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bankAccountName` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bankAccountNumber` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bankBSB` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payPalClientID` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `payPalSecret` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `defaultOrder` varchar(8) COLLATE utf8_bin NOT NULL DEFAULT 'old',
  `showItems` int NOT NULL,
  `idleTime` int NOT NULL,
  `ga_clientID` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ga_tracking` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ga_verification` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `reCaptchaClient` text COLLATE utf8_bin NOT NULL,
  `reCaptchaServer` text COLLATE utf8_bin NOT NULL,
  `seo_msvalidate` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seo_yandexverification` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seo_alexaverification` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seo_domainverify` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seo_pinterestverify` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mapapikey` varchar(128) COLLATE utf8_bin NOT NULL,
  `geo_region` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `geo_placename` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `geo_position` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `php_options` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `php_APIkey` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `php_honeypot` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `php_quicklink` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `formMinTime` varchar(8) COLLATE utf8_bin NOT NULL,
  `formMaxTime` varchar(8) COLLATE utf8_bin NOT NULL,
  `spamfilter` int NOT NULL,
  `notification_volume` int NOT NULL,
  `mediaMaxWidth` int NOT NULL,
  `mediaMaxHeight` int NOT NULL,
  `mediaMaxWidthThumb` int NOT NULL,
  `mediaMaxHeightThumb` int NOT NULL,
  `mediaQuality` int NOT NULL,
  `suggestions` int NOT NULL,
  `bti` int UNSIGNED NOT NULL,
  `backup_ti` int NOT NULL,
  `uti` int NOT NULL,
  `uti_freq` int NOT NULL,
  `update_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `navstat` int NOT NULL,
  `iconsColor` int NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `development`, `maintenance`, `comingsoon`, `options`, `theme`, `seoTitle`, `seoDescription`, `seoCaption`, `seoKeywords`, `metaRobots`, `seoRSSTitle`, `seoRSSNotes`, `seoRSSLink`, `seoRSSAuthor`, `seoRSSti`, `business`, `abn`, `address`, `suburb`, `city`, `state`, `country`, `postcode`, `phone`, `mobile`, `email`, `vti`, `sti`, `dateFormat`, `email_check`, `email_interval`, `email_signature`, `storemessages`, `message_check_interval`, `chatAutoRemove`, `messengerFBCode`, `messengerFBColor`, `messengerFBGreeting`, `language`, `timezone`, `orderPayti`, `orderEmailSubject`, `orderEmailLayout`, `orderEmailNotes`, `orderEmailReadNotification`, `austPostAPIKey`, `gst`, `memberLimit`, `memberLimitSilver`, `memberLimitBronze`, `memberLimitGold`, `memberLimitPlatinum`, `wholesaleLimit`, `wholesaleLimitSilver`, `wholesaleLimitBronze`, `wholesaleLimitGold`, `wholesaleLimitPlatinum`, `wholesaleTime`, `wholesaleTimeSilver`, `wholesaleTimeBronze`, `wholesaleTimeGold`, `wholesaleTimePlatinum`, `passwordResetLayout`, `passwordResetSubject`, `accountActivationSubject`, `accountActivationLayout`, `bookingNoteTemplate`, `bookingEmailSubject`, `bookingEmailLayout`, `bookingEmailReadNotification`, `bookingAutoReplySubject`, `bookingAutoReplyLayout`, `bookingAttachment`, `bookingAgreement`, `bookingBuffer`, `contactAutoReplySubject`, `contactAutoReplyLayout`, `newslettersEmbedImages`, `newslettersSendMax`, `newslettersSendDelay`, `newslettersOptOutLayout`, `bank`, `bankAccountName`, `bankAccountNumber`, `bankBSB`, `payPalClientID`, `payPalSecret`, `defaultOrder`, `showItems`, `idleTime`, `ga_clientID`, `ga_tracking`, `ga_verification`, `reCaptchaClient`, `reCaptchaServer`, `seo_msvalidate`, `seo_yandexverification`, `seo_alexaverification`, `seo_domainverify`, `seo_pinterestverify`, `mapapikey`, `geo_region`, `geo_placename`, `geo_position`, `php_options`, `php_APIkey`, `php_honeypot`, `php_quicklink`, `formMinTime`, `formMaxTime`, `spamfilter`, `notification_volume`, `mediaMaxWidth`, `mediaMaxHeight`, `mediaMaxWidthThumb`, `mediaMaxHeightThumb`, `mediaQuality`, `suggestions`, `bti`, `backup_ti`, `uti`, `uti_freq`, `update_url`, `navstat`, `iconsColor`, `ti`) VALUES
(1, 0, 0, 0, '10111111011100000011101110100101', 'animeexcess', '', '', '', 'Clippy', 'index,follow', '', '', '', '', 0, 'Business', '000 000 000', '0 Address St', 'Suburb', 'City', 'State', 'Country', 9999, '00 000 000', '0000 000 000', 'example@example.com', 0, 3600, 'M jS, Y g:i A', 1425893894, 3600, '<p>Sent using <a href=\"https://github.com/DiemenDesign/AuroraCMS\">AuroraCMS</a> the Australian Open Source Content Management System.</p>', 0, 300, 0, '', '#5484ed', '', 'en-AU', 'Australia/Hobart', 1209600, 'Order {order_number}', '<p>Hello {first},</p><p>Please find below Order {order_number} for payment.</p><p>To make a payment, refer to the Bank Details, or click the link directly below to pay via a Payment Gateway through our Website.</p><p><a href=\"{order_link}\">{order_link}</a></p><hr>', '', 1, '', '0', '0', '0', '0', '0', '0', '', '5', '5', '5', '5', 0, 0, 0, 0, 0, '%3Cp%3EHi%20%7Bname%7D%2C%3C/p%3E%3Cp%3EA%20Password%20Reset%20was%20requested%2C%20it%20is%20now%3A%20%7Bpassword%7D%3C/p%3E%3Cp%3EWe%20recommend%20changing%20the%20above%20password%20after%20logging%20in.%3C/p%3E', 'Password Reset {business}.', 'Account Activation for {username} from {site}.', '<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>The username you signed up with was: {username}</p><p>The AutoGenerated password is: {password}</p><p><br></p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>', '<p>This is a test template</p><p>Backup:</p><p><input type=\"checkbox\">&nbsp;Music</p><p><input type=\"checkbox\">&nbsp;Software</p><p><input type=\"checkbox\">&nbsp;Emails</p><p><br></p>', '{business} Booking Confirmation on {date}', '<p>Hi {first},</p><p>{details}</p><p>Please check the details above, and get in touch if any need correcting.</p><p>Kind Regards,<br>{business}<br></p>\r\n', 0, '{business} Booking Confirmation on {date}', '%3Cp%3EHi%20%7Bfirst%7D%2C%3C/p%3E%3Cp%3EThank%20you%20for%20contacting%20%7Bbusiness%7D%2C%20someone%20will%20get%20back%20to%20you%20ASAP.%3Cbr%3EPlease%20note%2C%20this%20email%20is%20not%20a%20confirmed%20booking%20-%20we%20will%20contact%20you%20to%20confirm%20the%20time%20and%20date%20of%20your%20booking.%3Cbr%3E%3C/p%3E%3Cp%3EKind%20Regards%2C%3Cbr%3E%7Bbusiness%7D%3Cbr%3E%3C/p%3E', '', '<p>By clicking this checkbox and or signing below, you agree that we are not responsible for any data loss.</p>', 3600, '{business} Contact Confirmation on {date}', '<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>', 0, 50, 5, '<br>\r\n<br>\r\n<p><span style=\"font-size: 10px;\">If you don\'t wish to continue to receive these Newsletters you can <a href=\"{optOutLink}\">Unsubscribe</a>.</span></p>', 'My Bank', 'My Name', '000 000 000', '0000', '', '', 'new', 10, 30, '', '', '', '', '', '', '', '', '', '', '', '', '', '-41.39651366867026,146.17034912109378', '1011111000000000', '', '', '', '5', '60', 1, 0, 1280, 1280, 250, 250, 88, 0, 0, 1602516248, 0, 0, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` bigint UNSIGNED NOT NULL,
  `mid` bigint DEFAULT NULL,
  `options` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0000000000000000',
  `rank` int DEFAULT '0',
  `rid` bigint UNSIGNED DEFAULT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `login_user` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cid` bigint UNSIGNED DEFAULT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `contentType` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `schemaType` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `barcode` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `fccid` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `brand` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `urlSlug` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `category_1` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `category_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `category_3` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `category_4` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `business` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `suburb` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `city` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `state` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `country` varchar(40) COLLATE utf8_bin NOT NULL,
  `postcode` mediumint UNSIGNED NOT NULL,
  `phone` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mobile` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `thumb` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `file` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fileURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `fileALT` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `videoURL` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `signature` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `agreementCheck` int NOT NULL,
  `attributionImageTitle` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifISO` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifAperture` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifFocalLength` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifShutterSpeed` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifCamera` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifLens` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifFilename` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifti` bigint NOT NULL,
  `rrp` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `rCost` decimal(10,2) NOT NULL,
  `dCost` decimal(10,2) NOT NULL,
  `sold` bigint NOT NULL,
  `weight` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `weightunit` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'kg',
  `width` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `widthunit` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'mm',
  `height` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `heightunit` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'mm',
  `length` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lengthunit` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'mm',
  `subject` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionContentName` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionContentURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quantity` mediumint UNSIGNED NOT NULL,
  `itemCondition` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `metaRobots` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `stockStatus` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `service` bigint UNSIGNED NOT NULL,
  `internal` tinyint UNSIGNED NOT NULL,
  `featured` tinyint UNSIGNED NOT NULL,
  `bookable` tinyint(1) NOT NULL,
  `fti` bigint UNSIGNED NOT NULL,
  `assoc` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ord` bigint UNSIGNED NOT NULL,
  `views` bigint UNSIGNED NOT NULL,
  `points` int NOT NULL,
  `rating` int NOT NULL,
  `suggestions` int NOT NULL,
  `checklist` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0000000000000000',
  `active` tinyint UNSIGNED NOT NULL,
  `coming` tinyint NOT NULL DEFAULT '0',
  `geo_position` tinytext COLLATE utf8_bin NOT NULL,
  `pin` tinyint(1) NOT NULL,
  `tis` bigint UNSIGNED NOT NULL,
  `tie` bigint UNSIGNED NOT NULL,
  `lti` bigint UNSIGNED NOT NULL,
  `ti` bigint UNSIGNED NOT NULL,
  `eti` bigint NOT NULL,
  `pti` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `iplist`
--

CREATE TABLE `iplist` (
  `id` bigint NOT NULL,
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `oti` int NOT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `livechat`
--

CREATE TABLE `livechat` (
  `id` bigint NOT NULL,
  `aid` bigint NOT NULL,
  `sid` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `who` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip` varchar(64) COLLATE utf8_bin NOT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `phpChecked` int DEFAULT NULL,
  `status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` bigint UNSIGNED NOT NULL,
  `options` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '00000000000000000000000000000000',
  `theme` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bio_options` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '00000000000000000000000000000000',
  `username` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tags` text COLLATE utf8_bin NOT NULL,
  `cover` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `coverURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageTitle` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `avatar` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gravatar` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `business` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `www` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `experience` int NOT NULL,
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `emailPassword` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email_check` int NOT NULL,
  `liveChatNotification` int NOT NULL,
  `email_signature` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `suburb` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `city` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `state` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `postcode` mediumint UNSIGNED NOT NULL,
  `country` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `abn` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `phone` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mobile` varchar(14) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `caption` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoDescription` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `resume_notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `active` tinyint UNSIGNED NOT NULL,
  `activate` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `newsletter` int NOT NULL DEFAULT '0',
  `language` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `timezone` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rank` int UNSIGNED NOT NULL,
  `discount` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `spent` decimal(10,2) NOT NULL,
  `points` int NOT NULL,
  `purchaseLimit` varchar(6) COLLATE utf8_bin NOT NULL,
  `purchaseTime` int NOT NULL,
  `lti` int NOT NULL,
  `userAgent` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `userIP` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pti` int NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `username` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `view` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `refTable` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `refColumn` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `oldda` longblob,
  `newda` longblob NOT NULL,
  `action` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint NOT NULL,
  `rank` int DEFAULT '0',
  `pid` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `file` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fileALT` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `category_1` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `category_2` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `category_3` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `category_4` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifISO` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifAperture` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifFocalLength` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifShutterSpeed` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifCamera` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifLens` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifFilename` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `exifti` int NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `views` bigint NOT NULL,
  `suggestions` int NOT NULL,
  `ord` bigint NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint UNSIGNED NOT NULL,
  `rank` int DEFAULT NULL,
  `mid` bigint NOT NULL DEFAULT '0',
  `uid` bigint NOT NULL,
  `options` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '00000000',
  `login_user` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoTitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `metaRobots` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `file` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fileALT` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cover` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coverURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coverVideo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageTitle` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageName` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attributionImageURL` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `contentType` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `schemaType` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoKeywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoDescription` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `seoCaption` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `menu` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ord` bigint UNSIGNED NOT NULL,
  `checklist` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0000000000000000',
  `active` tinyint UNSIGNED NOT NULL,
  `views` bigint NOT NULL,
  `suggestions` int NOT NULL,
  `eti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `rank`, `mid`, `uid`, `options`, `login_user`, `title`, `seoTitle`, `metaRobots`, `url`, `file`, `fileALT`, `cover`, `coverURL`, `coverVideo`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `checklist`, `active`, `views`, `suggestions`, `eti`) VALUES
(1, 0, 0, 1, '00000000', 'Dennis Suitters', 'Home', '', '', '', 'index', '', '', '', '', '', '', '', 'index', '', 'wood,turning,woodturned,timber,open,source,photography,digital,artwork,websit,design,development', '', '', 'head', '<p>Billabong tickets on yourself smokes suss. Trackies up yourself bloke chuck a sickie pokies tucker bush oyster bottlo we\'re going cut lunch. Shazza coathanger bizzo also dole bludger greenie watch out for the. Jumbuck slaps scratchy pub bail out built like a boogie board sheila onya bike. Wobbly moolah grundies mates truckie. Oldies cockie pinga ocker troppo wrap your laughing gear \'round that chook dero fair go, mate hottie. Toads mate footy roadie. Cranky dog\'s balls pint garbo bundy cracker flick.</p><p>Brickie runners rello throw-down corker chook rack off skeg. Bizzo tucker-bag bail head like a dropped pie no worries hottie daks a cold one dardy whit. Bikie greenie dardy cooee chock a block ute burk kelpie. Road train slappa bloody rello donga bushman\'s handkerchief no wuckin\' furries. Fair go, mate mozzie figjam unit postie straya. Booze knock hit the turps gyno piss up good oil your shout dob.</p>', 4, '0000000000000000', 1, 445, 0, 1624761287),
(2, 0, 0, 1, '00000000', 'Dennis Suitters', 'Blog', '', '', '', 'article', '', '', '', '', '', '', '', 'article', '', '', '', '', 'head', '', 8, '0000000000000000', 1, 62, 0, 1624603854),
(3, 0, 0, 1, '00000000', 'Dennis Suitters', 'Portfolio', '', '', '', 'portfolio', '', '', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '', 12, '0000000000000000', 0, 1, 0, 1624603960),
(4, 0, 0, 1, '00000000', 'Dennis Suitters', 'Bookings', '', '', '', 'bookings', '', '', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '<p>Loose cannon struth ratbag hit the frog and toad no wuckin\' furries dunny deadset carry on like a pork chop. Bottle-o you little ripper she\'ll be right cobber. Rage on better than a kick up the backside garbo boogie board flick and. Better than a ham sandwich no wuckin\' furries bail up prezzy boogie board mates. Dry as as dead dingo\'s donga brass razoo shark biscuit brolly bingle freckle. Ratbag two up avos knackered defo. Skull trackies chook butcher loose cannon blue pash not my cup of tea sheila what\'s crackin\' rage on footy. Ankle biter cut snake sunnies chin wag coppers fair dinkum. Maccas bloody hard yakka fossicker. Dardy bottlo amber fluid porky lippy.</p><p>Blow in the bag outback slappa home grown where cracker dill suss it out. Up the duff g\'day dinky-di grab us a catcus lappy. Mullet onya bike tucker-bag a few sandwiches short of a picnic roo bar freo vb. Deadset tucker plonk fairy floss. Tucker-bag bloke servo bloke grouse. Battler flanny a few sandwiches short of a picnic also pozzy jumbuck defo pav.</p><p>Compo sandgropper grouse crow eaters. Digger pull the wool over their eyes cark it goon bag. Chock a block parma doovalacky bonza oi heaps stickybeak. Dag ugg boots corker mate\'s rates shoey. Ten clicks away furthy rapt pav fair suck of the sauce bottle chuck a spaz how. Bloody ripper rack off fisho boil-over skull aussie salute milk bar mates eureka as dry as a lippy dardy. Ken oath middy bities spit the dummy shag on a rock bloody oath.</p><p>Dero shazza got us some metho brizzie tucker-bag mickey mouse mate rock up offsider carry on like a pork chop. Cobber iffy swag bingle bushman\'s handkerchief bastard chock a block decent nik pull the wool over their eyes. Tradie better than a kick up the backside throw-down laughing gear middy fremantle doctor kindie. Shazza sickie footy slaps as dry as a gutta. Brass razoo ciggies arvo thunderbox gutta dog\'s breakfast furthy. Sick drongo fruit loop accadacca buckley\'s chance offsider nuddy chewie stubby pissed suss it out bradman. Slacker bushranger goon bag barbie chuck a yewy carrying on like a pork chop dead horse bushman\'s handkerchief smokes. Shazza built like a bazza ugg piss up dog\'s eye come a tosser road train taking the piss. Butcher schooner goon whit shazza got us some middy prezzy lollies.</p><p>Pozzy leg it chunder mozzie. Throw-down longneck parma going off. Avo brizzie to he\'s got a massive he\'s dreaming. Cark it trackie dacks footy moolah bogged skeg piker shoey. Bush he\'s got a massive thunderbox piss off. Brisvegas like a madwoman\'s shit down under billy. Flamin\' good oil as dry as a sook hottie.</p>', 6, '0000000000000000', 1, 30, 0, 1624719096),
(5, 0, 0, 1, '00000000', 'Dennis Suitters', 'Events', '', '', '', 'events', '', '', '', '', '', '', '', 'events', '', '', '', '', 'head', '', 13, '0000000000000000', 0, 1, 0, 1624603994),
(6, 0, 0, 1, '00000000', 'Anonymous', 'News', '', 'index,follow', '', 'news', '', '', '', '', '', '', '', 'news', '', '', '', '', 'head', '', 15, '0000000000000000', 0, 2, 0, 1585466222),
(7, 0, 0, 1, '00000000', 'Dennis Suitters', 'Testimonials', '', '', '', 'testimonials', '', '', '', '', '', '', '', 'testimonials', '', '', '', '', 'head', '', 7, '0000000000000000', 1, 34, 0, 1624603833),
(8, 0, 0, 1, '00000000', 'Dennis Suitters', 'Products', '', '', '', 'inventory', '', '', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '', 10, '0000000000000000', 1, 172, 0, 1624603911),
(9, 0, 0, 1, '11000000', 'Dennis Suitters', 'Services', '', '', '', 'services', '', '', '', 'https://youtu.be/FsXG1YSqcjU', '', '', '', 'service', '', '', '', '', 'head', '', 9, '0000000000000000', 1, 6, 0, 1624603892),
(10, 0, 0, 1, '00000000', 'Dennis Suitters', 'Gallery', '', '', '', 'gallery', '', '', '', '', '', '', '', 'gallery', '', '', '', '', 'head', '', 14, '0000000000000000', 0, 2, 0, 1624604025),
(11, 0, 0, 1, '00000000', 'Dennis Suitters', 'Contact', '', '', '', 'contactus', '', '', '', '', 'Contact Page Attribution', 'Anonymous', 'https://diemen.design/', 'contactus', '', '', '', '', 'head', '', 11, '0000000000000000', 1, 7, 0, 1624603926),
(12, 0, 0, 1, '00000000', 'Dennis Suitters', 'Cart', '', '', '', 'cart', '', '', '', '', '', '', '', 'cart', '', '', '', '', 'head', '', 16, '0000000000000000', 1, 29, 0, 1624604069),
(13, 0, 0, 1, '00000000', 'Anonymous', 'Terms of Service', '', 'index,follow', '', 'page', '', '', '', '', '', '', '', 'page', '', '', '', '', 'footer', '', 22, '0000000000000000', 1, 0, 0, 1585466323),
(14, 0, 0, 1, '00000000', 'Dennis Suitters', 'Search', 'Search Meta title', '', '', 'search', '', '', '', '', '', '', '', 'search', '', '', '', '', 'other', '', 23, '0000000000000000', 1, 0, 0, 1604631971),
(15, 0, 0, 1, '00000000', 'Dennis Suitters', 'About', '', '', '', 'aboutus', '', '', '', '', 'Contact Cover Attribution', 'Anonymous', 'https://diemen.design/', 'aboutus', '', '', '', '', 'head', '<p>Carry on like a pork chop dipstick sandgropper jackaroo iffy strewth. Home grown burk frothy troppo accadacca like a madwoman\'s shit thongs yobbo. Clucky tell your story walkin\' brumby outback. Snag rotten thongs captain cook trackies paddock a few stubbies short of a six-pack outback. Chunder maccas dry as as dead dingo\'s donga hooroo bizzo rellie apples a few sandwiches short of a picnic. Bail up mate ugg boots fossicker do the harry coldie quid. As dry as a dog\'s eye heaps booze put a sock in it pokies how.</p><p>Rellie flat out like a as cross as a pull the wool over their eyes. Do the harry barbie cracker mozzie good onya figjam brickie bunyip bluey. Barbie rip snorter snag bail out dag troppo. As cross as a roo bar have a captain cook toads facey bloody ripper stonkered bloke. Rage on squizz no worries fair go, mate show pony blue flanny. Gutta ratbag ute what\'s crackin\' moolah barrack yobbo joey billabong no-hoper. Watch out for the give it a burl fair dinkum butcher.</p><p>No wuckin\' furries two pot screamer sheila rotten galah. Bingle flake lippy esky mates cut lunch commando. Not my cup of tea garbo mongrel pozzy flake skeg spit the dummy. Ciggies ute avos bail out true blue. Feral bull bar get a dog up ya chokkie avos gobsmacked brumby brisvegas. Kero a cold one how ugg bonza down under daks. Captain cook skull coldie bradman cab sav as cross as a heaps chuck a yewy schooner. Ute doovalacky schooner durry cut snake bradman freckle up the duff onya bike bundy wrap your laughing gear \'round that. Full boar rack off on the cans show pony knock. Cleanskin oldies gutful of fair suck of the sauce bottle reckon. Sickie bloke lets throw a watch out for the cranky my. Dry as as dead dingo\'s donga put a sock in it wobbly goon bag strewth. Dog\'s balls cobber slaps feral watch out for the billabong.</p><p>Stubby no wucka\'s chin wag no worries, mate, she\'ll be right clucky freckle squizz dipstick. Mokkies fair suck of the sauce bottle aussie rules footy flanno greenie waggin\' school schooner trackies roadie. Bludger slab joey straya pelican. Down under boil-over get a dog up ya straight to the pool room strides. Shazza got us some bruce nipper goon bag bonza sunnies dry as as dead dingo\'s donga. Oldies bikie rort hottie good onya no wucka\'s tucker-bag yabber ironman ute porky. Skite heaps hard yakka up the duff as cunning as a gobful buckley\'s chance bludger. He hasn\'t got a dropkick have a captain cook skite fisho shoot through fair dinkum. Fair crack of the whip runners sickie yakka. Donga brolly how stoked ute yakka holy dooley.</p><p>Chook flake maccas cleanskin mokkies pull the wool over your eyes. Rock up bogan get a dog up ya no wuckin\' furries cranky you little ripper. Cleanskin brumby gyno like a madwoman\'s shit spag bol. Root rat mad as a true blue dunny bundy. Ute roadie catcus have a go, you mug figjam tell him he\'s dreaming. Crack the shits no worries grundies pissed runners bloody ripper.</p>', 5, '0000000000000000', 1, 63, 0, 1624766769),
(16, 300, 0, 1, '00000000', 'Dennis Suitters', 'Proofs', 'Proofs', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'proofs', '', '', '', '', '', '', '', 'proofs', '', '', '', '', 'account', '', 1, '0000000000000000', 1, 3, 0, 1624604287),
(17, 0, 0, 1, '00000000', 'Dennis Suitters', 'Newsletters', '', '', '', 'newsletters', '', '', '', '', '', '', '', 'newsletters', '', '', '', '', 'footer', '', 19, '0000000000000000', 1, 0, 0, 1624604143),
(19, 0, 0, 1, '00000000', 'Dennis Suitters', 'Distributors', 'Distributors', '', '', 'distributors', '', '', '', '', '', '', '', 'distributors', '', '', '', '', 'footer', '', 17, '0000000000000000', 1, 3, 0, 1624804668),
(20, 0, 0, 1, '00000000', 'Anonymous', 'Privacy Policy', '', '', '', 'page', '', '', '', '', '', '', '', 'page', 'Article', '', '', '', 'footer', '', 21, '0000000000000000', 1, 2, 0, 1594213384),
(21, 0, 0, 1, '00000000', 'Dennis Suitters', 'Login', 'Login Meta Title', '', '', 'login', '', '', '', '', '', '', '', 'login', '', '', '', '', 'other', '', 18, '0000000000000000', 1, 4, 0, 1624762165),
(22, 0, 0, 1, '00000000', 'Anonymous', 'Sitemap', 'Sitemap Meta Title', '', '', 'sitemap', '', '', '', '', '', '', '', 'sitemap', '', '', '', '', 'footer', '', 20, '0000000000000000', 1, 0, 0, 1594211774),
(23, 0, 0, 1, '00000000', 'Dennis Suitters', 'Coming Soon', 'Coming Soon Meta Title', '', '', 'comingsoon', '', '', '', '', '', '', '', 'comingsoon', '', '', '', '', 'none', '', 23, '0000000000000000', 1, 0, 0, 1622036017),
(24, 0, 0, 1, '00000000', 'Anonymous', 'Maintenance', 'Maintenance Meta Title', '', '', 'maintenance', '', '', '', '', '', '', '', 'maintenance', '', '', '', '', 'none', '', 24, '0000000000000000', 1, 0, 0, 1598020736),
(27, 300, 0, 1, '00000000', 'Dennis Suitters', 'Orders', 'Orders', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'orders', '', '', '', '', '', '', '', 'orders', '', '', '', '', 'account', '', 0, '0000000000000000', 1, 37, 0, 1624604264),
(28, 300, 0, 1, '00000000', 'Dennis Suitters', 'Profile', 'Profile', '', '', 'profile', '', '', '', '', '', '', '', 'profile', '', '', '', '', 'account', '', 2, '0000000000000000', 1, 4, 0, 1624604321),
(29, 300, 0, 1, '00000000', 'Dennis Suitters', 'Settings', 'Settings', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'settings', '', '', '', '', '', '', '', 'settings', '', '', '', '', 'account', '', 3, '0000000000000000', 1, 21, 0, 1624604341);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mid` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rmid` bigint NOT NULL,
  `folder` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `to_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `to_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_business` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_phone` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_mobile` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_address` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_suburb` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_city` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_state` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_postcode` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `subject` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `starred` int NOT NULL,
  `important` int NOT NULL,
  `notes_raw` text CHARACTER SET utf8 COLLATE utf8_bin,
  `notes_raw_mime` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes_html` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes_html_mime` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `attachments` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email_date` int NOT NULL,
  `size` bigint NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` bigint NOT NULL,
  `oid` bigint UNSIGNED NOT NULL,
  `iid` bigint UNSIGNED NOT NULL,
  `cid` bigint NOT NULL,
  `title` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `quantity` mediumint UNSIGNED NOT NULL,
  `cost` decimal(10,2) UNSIGNED NOT NULL,
  `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `points` int NOT NULL,
  `ti` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint NOT NULL,
  `cid` bigint UNSIGNED NOT NULL,
  `uid` bigint UNSIGNED NOT NULL,
  `contentType` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `qid` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `qid_ti` bigint UNSIGNED NOT NULL,
  `iid` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `iid_ti` bigint UNSIGNED NOT NULL,
  `did` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `did_ti` bigint UNSIGNED NOT NULL,
  `aid` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `aid_ti` bigint UNSIGNED NOT NULL,
  `due_ti` bigint UNSIGNED NOT NULL,
  `rid` bigint NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `postageCode` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `postageOption` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `postageCost` decimal(6,2) NOT NULL,
  `payOption` tinytext COLLATE utf8_bin NOT NULL,
  `payMethod` int NOT NULL,
  `payCost` decimal(6,2) NOT NULL,
  `recurring` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `points` int NOT NULL,
  `ti` bigint UNSIGNED NOT NULL,
  `eti` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` bigint NOT NULL,
  `code` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `method` int NOT NULL,
  `value` int NOT NULL,
  `quantity` int NOT NULL,
  `tis` int NOT NULL,
  `tie` int NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `id` bigint NOT NULL,
  `contentType` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

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
(151, 'seotips', '', '', 'There is not such thing as a &#39;duplicate content penalty&#39;. Unless your site is pure spam, you&#39;re not going to be harmed if someone copies a page of yours or if you have some copied content. It may get filtered out of a search result but you&#39;re not going to get your site penalised.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tags` text COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` bigint NOT NULL,
  `rid` bigint NOT NULL,
  `uid` bigint NOT NULL,
  `t` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `c` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `reason` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tracker`
--

CREATE TABLE `tracker` (
  `id` bigint NOT NULL,
  `pid` bigint NOT NULL,
  `urlDest` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `urlFrom` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `userAgent` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `keywords` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `browser` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `os` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sid` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `whitelist`
--

CREATE TABLE `whitelist` (
  `id` bigint NOT NULL,
  `ip` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ti` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
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
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

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
-- AUTO_INCREMENT for table `tracker`
--
ALTER TABLE `tracker`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `whitelist`
--
ALTER TABLE `whitelist`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
