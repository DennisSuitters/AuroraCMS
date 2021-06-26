-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 26, 2021 at 01:48 AM
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
(1, 0, 0, 0, '11111111011100000001101110100101', 'default', '', '', '', 'Clippy', 'index,follow', '', '', '', '', 0, 'Business', '000 000 000', '0 Address St', 'Suburb', 'City', 'State', 'Country', 9999, '00 000 000', '0000 000 000', 'example@example.com', 0, 3600, 'M jS, Y g:i A', 1425893894, 3600, '<p>Sent using <a href=\"https://github.com/DiemenDesign/AuroraCMS\">AuroraCMS</a> the Australian Open Source Content Management System.</p>', 0, 300, 0, '', '#5484ed', '', 'en-AU', 'Australia/Hobart', 1209600, 'Order {order_number}', '<p>Hello {first},</p><p>Please find below Order {order_number} for payment.</p><p>To make a payment, refer to the Bank Details, or click the link directly below to pay via a Payment Gateway through our Website.</p><p><a href=\"{order_link}\">{order_link}</a></p><hr>', '', 1, '', '0', '0', '0', '0', '0', '0', '', '5', '5', '5', '5', 0, 0, 0, 0, 0, '%3Cp%3EHi%20%7Bname%7D%2C%3C/p%3E%3Cp%3EA%20Password%20Reset%20was%20requested%2C%20it%20is%20now%3A%20%7Bpassword%7D%3C/p%3E%3Cp%3EWe%20recommend%20changing%20the%20above%20password%20after%20logging%20in.%3C/p%3E', 'Password Reset {business}.', 'Account Activation for {username} from {site}.', '<p>Hi {username},</p><p>Below is the Activation Link to enable your Account at {site}.<br>{activation_link}</p><p>The username you signed up with was: {username}</p><p>The AutoGenerated password is: {password}</p><p><br></p><p>If this email is in error, and you did not sign up for an Account, please take the time to contact us to let us know, or alternatively ignore this email and your email will be purged from our system in a few days.</p>', '<p>This is a test template</p><p>Backup:</p><p><input type=\"checkbox\">&nbsp;Music</p><p><input type=\"checkbox\">&nbsp;Software</p><p><input type=\"checkbox\">&nbsp;Emails</p><p><br></p>', '{business} Booking Confirmation on {date}', '<p>Hi {first},</p><p>{details}</p><p>Please check the details above, and get in touch if any need correcting.</p><p>Kind Regards,<br>{business}<br></p>\r\n', 0, '{business} Booking Confirmation on {date}', '%3Cp%3EHi%20%7Bfirst%7D%2C%3C/p%3E%3Cp%3EThank%20you%20for%20contacting%20%7Bbusiness%7D%2C%20someone%20will%20get%20back%20to%20you%20ASAP.%3Cbr%3EPlease%20note%2C%20this%20email%20is%20not%20a%20confirmed%20booking%20-%20we%20will%20contact%20you%20to%20confirm%20the%20time%20and%20date%20of%20your%20booking.%3Cbr%3E%3C/p%3E%3Cp%3EKind%20Regards%2C%3Cbr%3E%7Bbusiness%7D%3Cbr%3E%3C/p%3E', '', '<p>By clicking this checkbox and or signing below, you agree that we are not responsible for any data loss.</p>', 3600, '{business} Contact Confirmation on {date}', '<p>Hi {first},</p><p>Thank you for contacting {business}, someone will get back to you ASAP.</p><p>Kind Regards,</p><p>{business}</p><p><br></p>', 0, 50, 5, '<br>\r\n<br>\r\n<p><span style=\"font-size: 10px;\">If you don\'t wish to continue to receive these Newsletters you can <a href=\"{optOutLink}\">Unsubscribe</a>.</span></p>', 'My Bank', 'My Name', '000 000 000', '0000', '', '', 'new', 10, 30, '', '', '', '', '', '', '', '', '', '', '', '', '', '-41.39651366867026,146.17034912109378', '1011111000000000', '', '', '', '5', '60', 1, 0, 1280, 1280, 250, 250, 88, 0, 0, 1602516248, 0, 0, '', 0, 0, 0);

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
(1, 0, 0, 1, '00000000', 'Dennis Suitters', 'Home', '', '', '', 'index', '', '', '', '', '', '', '', 'index', '', 'wood,turning,woodturned,timber,open,source,photography,digital,artwork,websit,design,development', '', '', 'head', '', 4, '0000000000000000', 1, 0, 0, 1624603684),
(2, 0, 0, 1, '00000000', 'Dennis Suitters', 'Blog', '', '', '', 'article', '', '', '', '', '', '', '', 'article', '', '', '', '', 'head', '', 8, '0000000000000000', 1, 0, 0, 1624603854),
(3, 0, 0, 1, '00000000', 'Dennis Suitters', 'Portfolio', '', '', '', 'portfolio', '', '', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '', 12, '0000000000000000', 1, 0, 0, 1624603960),
(4, 0, 0, 1, '00000000', 'Dennis Suitters', 'Bookings', '', '', '', 'bookings', '', '', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '', 6, '0000000000000000', 1, 0, 0, 1624603667),
(5, 0, 0, 1, '00000000', 'Dennis Suitters', 'Events', '', '', '', 'events', '', '', '', '', '', '', '', 'events', '', '', '', '', 'head', '', 13, '0000000000000000', 1, 0, 0, 1624603994),
(6, 0, 0, 1, '00000000', 'Anonymous', 'News', '', 'index,follow', '', 'news', '', '', '', '', '', '', '', 'news', '', '', '', '', 'head', '', 15, '0000000000000000', 1, 0, 0, 1585466222),
(7, 0, 0, 1, '00000000', 'Dennis Suitters', 'Testimonials', '', '', '', 'testimonials', '', '', '', '', '', '', '', 'testimonials', '', '', '', '', 'head', '', 7, '0000000000000000', 1, 0, 0, 1624603833),
(8, 0, 0, 1, '00000000', 'Dennis Suitters', 'Products', '', '', '', 'inventory', '', '', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '', 10, '0000000000000000', 1, 0, 0, 1624603911),
(9, 0, 0, 1, '11000000', 'Dennis Suitters', 'Services', '', '', '', 'services', '', '', '', 'https://youtu.be/FsXG1YSqcjU', '', '', '', 'service', '', '', '', '', 'head', '', 9, '0000000000000000', 1, 0, 0, 1624603892),
(10, 0, 0, 1, '00000000', 'Dennis Suitters', 'Gallery', '', '', '', 'gallery', '', '', '', '', '', '', '', 'gallery', '', '', '', '', 'head', '', 14, '0000000000000000', 1, 0, 0, 1624604025),
(11, 0, 0, 1, '00000000', 'Dennis Suitters', 'Contact', '', '', '', 'contactus', '', '', '', '', 'Contact Page Attribution', 'Anonymous', 'https://diemen.design/', 'contactus', '', '', '', '', 'head', '', 11, '0000000000000000', 1, 0, 0, 1624603926),
(12, 0, 0, 1, '00000000', 'Dennis Suitters', 'Cart', '', '', '', 'cart', '', '', '', '', '', '', '', 'cart', '', '', '', '', 'head', '', 16, '0000000000000000', 1, 0, 0, 1624604069),
(13, 0, 0, 1, '00000000', 'Anonymous', 'Terms of Service', '', 'index,follow', '', 'page', '', '', '', '', '', '', '', 'page', '', '', '', '', 'footer', '', 22, '0000000000000000', 1, 0, 0, 1585466323),
(14, 0, 0, 1, '00000000', 'Dennis Suitters', 'Search', 'Search Meta title', '', '', 'search', '', '', '', '', '', '', '', 'search', '', '', '', '', 'other', '', 23, '0000000000000000', 1, 0, 0, 1604631971),
(15, 0, 0, 1, '00000000', 'Dennis Suitters', 'About', '', '', '', 'aboutus', '', '', '', '', 'Contact Cover Attribution', 'Anonymous', 'https://diemen.design/', 'aboutus', '', '', '', '', 'head', '', 5, '0000000000000000', 1, 0, 0, 1624603715),
(16, 300, 0, 1, '00000000', 'Dennis Suitters', 'Proofs', 'Proofs', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'proofs', '', '', '', '', '', '', '', 'proofs', '', '', '', '', 'account', '', 1, '0000000000000000', 1, 0, 0, 1624604287),
(17, 0, 0, 1, '00000000', 'Dennis Suitters', 'Newsletters', '', '', '', 'newsletters', '', '', '', '', '', '', '', 'newsletters', '', '', '', '', 'footer', '', 19, '0000000000000000', 1, 0, 0, 1624604143),
(19, 0, 0, 1, '00000000', 'Anonymous', 'Distributors', 'Distributors', '', '', 'distributors', '', '', '', '', '', '', '', 'distributors', '', '', '', '', 'head', '', 17, '0000000000000000', 1, 0, 0, 1585466240),
(20, 0, 0, 1, '00000000', 'Anonymous', 'Privacy Policy', '', '', '', 'page', '', '', '', '', '', '', '', 'page', 'Article', '', '', '', 'footer', '', 21, '0000000000000000', 1, 0, 0, 1594213384),
(21, 0, 0, 1, '00000000', 'Dennis Suitters', 'Login', 'Login Meta Title', '', '', 'login', '', '', '', '', '', '', '', 'login', '', '', '', '', 'footer', '', 18, '0000000000000000', 1, 0, 0, 1624273520),
(22, 0, 0, 1, '00000000', 'Anonymous', 'Sitemap', 'Sitemap Meta Title', '', '', 'sitemap', '', '', '', '', '', '', '', 'sitemap', '', '', '', '', 'footer', '', 20, '0000000000000000', 1, 0, 0, 1594211774),
(23, 0, 0, 1, '00000000', 'Dennis Suitters', 'Coming Soon', 'Coming Soon Meta Title', '', '', 'comingsoon', '', '', '', '', '', '', '', 'comingsoon', '', '', '', '', 'none', '', 23, '0000000000000000', 1, 0, 0, 1622036017),
(24, 0, 0, 1, '00000000', 'Anonymous', 'Maintenance', 'Maintenance Meta Title', '', '', 'maintenance', '', '', '', '', '', '', '', 'maintenance', '', '', '', '', 'none', '', 24, '0000000000000000', 1, 0, 0, 1598020736),
(27, 300, 0, 1, '00000000', 'Dennis Suitters', 'Orders', 'Orders', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'orders', '', '', '', '', '', '', '', 'orders', '', '', '', '', 'account', '', 0, '0000000000000000', 1, 0, 0, 1624604264),
(28, 300, 0, 1, '00000000', 'Dennis Suitters', 'Profile', 'Profile', '', '', 'profile', '', '', '', '', '', '', '', 'profile', '', '', '', '', 'account', '', 2, '0000000000000000', 1, 0, 0, 1624604321),
(29, 300, 0, 1, '00000000', 'Dennis Suitters', 'Settings', 'Settings', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'settings', '', '', '', '', '', '', '', 'settings', '', '', '', '', 'account', '', 3, '0000000000000000', 1, 0, 0, 1624604341);

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

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
