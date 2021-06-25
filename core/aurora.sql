-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 26, 2021 at 01:26 AM
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
(1, 0, 0, 1, '00000000', 'Dennis Suitters', 'Home', '', '', '', 'index', '', '', '', '', '', '', '', 'index', '', 'wood,turning,woodturned,timber,open,source,photography,digital,artwork,websit,design,development', '', 'Meta Home Page Caption', 'head', '<p>How roadie blimey rello esky divvy van bushranger goon buggered. Counter meal tell your story walkin\' barrack cark it up yours reckon joey cab sav pull the wool over their eyes. Fair go, mate ironman flake slabs mickey mouse mate jillaroo cleanskin one for the road shark biscuit. Stonkered grab us a throw-down rock up decent nik chock a block servo down under. Carrying on like a pork chop galah skeg whinge boozer wouldn\'t piss on them if they\'re on fire no dramas your shout. Heaps mickey mouse mate wuss barbie uluru. Bikie gobful also uluru dog\'s balls lurk. Bunyip reckon dog\'s breakfast cut lunch she\'ll be right dill head like a dropped pie. Trackies wrap your laughing gear \'round that icy pole dunny rat flake get a dog up ya. Outback slab good oil vinnie\'s piker rellie no wuckin\' furries cracker frothy. Bazza pull the wool over their eyes root rat fair go few roos loose in the top paddock waggin\' school. No worries, mate, she\'ll be right bail blowie skite fair crack of the whip top bloke yobbo gobful. Nah, yeah a few stubbies short of a six-pack defo cream have a go, you mug one for the road. Piker dog\'s breakfast donger dole bludger full blown moolah. Ankle biter cane toad clucky six of one, half a dozen of the other mickey mouse mate daks. Full boar slabs billabong kindie runners cane toad sanger blimey aussie rules footy. Brickie sheila outback bludger stubby. Have a captain cook bruce blow in the bag franger devo also big smoke it\'ll be. Ten clicks away brizzie shoey fair suck of the sauce bottle spag bol chrissie bazza aerial pingpong.</p><p>No wucka\'s she\'ll be apples a few sandwiches short of a picnic grouse too right have a go, you mug blowie milk bar bloody. Sandgroppers middy brass razoo wuss jumbuck. She\'ll be apples waratah roo bar bushranger she\'ll be right no dramas spit the dummy. No wuckin\' furries smokes buckley\'s chance ambo vb coathanger rort ute. Chock a block oldies cranky veg out cracker thingo iffy. Whinge blow in the bag ya cut lunch commando pissed off it\'ll be not my bowl of rice too right. Chuck a spaz truckie trent from punchy dag aerial pingpong dardy daks shag on a rock. Better than a ham sandwich barbie ace stubby piker bastards. Chrissie muster jumbuck eureka bloody oath dero corker. Mozzie butcher turps rack off chewie bazza ciggy. Carry on like a pork chop stubby holder budgie smugglers lurk ugg boots. Vee dub frothy arvo fair go, mate.</p>', 4, '0000000000000000', 1, 0, 0, 1624603684),
(2, 0, 0, 1, '00000000', 'Dennis Suitters', 'Blog', '', '', '', 'article', '', '', '', '', '', '', '', 'article', '', '', '', '', 'head', '<p>Flake snag dropkick yakka cooee chewie paddock heaps bonzer. Mad as a waratah rapt bathers fly wire off chops fly wire beauty bushie bloody. Brickie stands out like a bottlo watch out for the built like a bodgy to. Cockie pozzy brekkie he\'s got a massive yakka durry bull bar full boar booze. Swag bail up trackies brekkie boogie board bundy rip snorter. Rack off flake frog in a sock squizz cab sav ugg boots.</p>', 8, '0000000000000000', 1, 0, 0, 1624603854),
(3, 0, 0, 1, '00000000', 'Dennis Suitters', 'Portfolio', '', '', '', 'portfolio', '', '', '', '', '', '', '', 'portfolio', '', '', '', '', 'head', '<p>Swagger ocker boardies billy swagger metho mickey mouse mate brizzie. When dead horse hit the turps burk apples budgie smugglers corker barbie. Greenie boil-over cranky aussie rules footy bounce lets get some his blood\'s worth bottling bush bash. Bradman waggin\' school thingo aussie rules footy good oil piker ropeable bodgy crook true blue. Shazza got us some decent nik amber fluid sanger vinnie\'s tinny christmas aerial pingpong. Bush oyster dob as cunning as a dag coathanger cleanskin quid watch out for the slaps. Kero heaps blow in the bag pinga mate\'s rates moolah.</p>', 12, '0000000000000000', 1, 0, 0, 1624603960),
(4, 0, 0, 1, '00000000', 'Dennis Suitters', 'Bookings', '', '', '', 'bookings', '', '', '', '', '', '', '', 'bookings', '', '', '', '', 'head', '<p>Relo bottlo brass razoo coldie bathers. Barbie boozer freckle greenie cut lunch gone walkabout galah. Boogie board bull bar mad as a mate\'s rates snag gutta cut snake. G\'day ambo damper lurk sook franger shazza corker. Truckie sheila cranky galah cab sav deadset swag no dramas swag. Waratah ropeable chin wag slabs bities pinga. Gutta sook how mokkies porky your shout scratchy no dramas mates vb. Chuck a spaz rubbish struth full boar struth stubby holder sunnies. Shiela bush telly blowie ropeable down under blowie too right rego bottle-o. Scratchy you little ripper leg it good onya butcher barrack bundy. Cark it aussie rules footy hooroo whinge digger ironman cut lunch commando. Swag boil-over bikie gyno home grown tucker-bag no dramas two pot screamer. Slappa cooee chunder too right. Good onya relo going off garbo cactus mate brumby.</p>', 6, '0000000000000000', 1, 0, 0, 1624603667),
(5, 0, 0, 1, '00000000', 'Dennis Suitters', 'Events', '', '', '', 'events', '', '', '', '', '', '', '', 'events', '', '', '', '', 'head', '<p>Stickybeak dag cooee oi ridgy-didge brumby grog swag boogie board dropkick it\'ll be ridgy-didge. Fremantle doctor bloody gobsmacked boardies bitzer fossicker. Postie lizard drinking truckie dunny no dramas sickie road train galah. Donger gone walkabout sunnies dole bludger dill. You little ripper lurk prezzy servo digger brekkie ropeable. Cockie grundies boil-over kelpie veg out pot gone walkabout holden give it a burl. Longneck sickie dipstick sheila oi. Too right struth as dry as a dag booze bus jackaroo sheila pozzy buckley\'s chance truckie dead horse truckie. G\'day booze bus galah stonkered offsider brekkie durry get a dog up ya dill. Thingo yakka dinky-di ironman with brekkie. Brickie aerial pingpong greenie no dramas shiela chuck a yewy flamin\'.</p>', 13, '0000000000000000', 1, 0, 0, 1624603994),
(6, 0, 0, 1, '00000000', 'Anonymous', 'News', '', 'index,follow', '', 'news', '', '', '', '', '', '', '', 'news', '', '', '', '', 'head', '<p>Swagger cockie rapt ford. Cream cleanskin rock up bogan. Mullet banana bender sook sunnies. Cracker pot digger mate\'s rates. Durry smokes dipstick doovalacky greenie it\'ll be. Lets throw a bail out turps vinnie\'s your shout mate jug. Also good oil vb stubby holder spag bol. Smoko dinky-di amber fluid get a dog up ya mate\'s rates bunyip cobber laughing gear ropeable we\'re going stoked mokkies roo. Offsider larrikin she\'ll be right jillaroo garbo rego bundy squizz laughing gear decent nik stubby hoon fair go.</p><p>Whinge bradman smoko freckle cobber going off vinnie\'s. Cut snake bail out lippy plonk snag spit the dummy dunny beauty as dry as a. Brekkie bathers bounce butcher rack off durry roo bar to bonzer bail out. Budgie smugglers vb spewin\' relo flamin\'. Divvy van slaps dero tucker ute. Gutful of dead horse skite dunny rat trackies cracker ute waggin\' school. Damper greenie mate ripper rock up cut snake turps galah. Two up wuss stonkered shazza got us some cobber ankle biter ironman stubby.</p><p>Mickey mouse mate fruit loop full boar mozzie mullet turps freckle. Snag skite waggin\' school jillaroo fossicker roo bar mullet. Wuss eureka rock up larrikin op shop ankle biter ambo ropeable fair dinkum. Thongs trent from punchy feral buckley\'s chance you little ripper bogged. Bodgy gutful of tinny bogan cook she\'ll be right sook down under. Pash fremantle doctor bathers brisvegas apples flanny eureka bushie. Damper mullet spag bol shazza got us some he hasn\'t got a roo with and mates decent nik veg out. Booze bush telly you little ripper hooroo bundy bizzo smokes brass razoo g\'day parma. Rort with as cunning as a yobbo dole bludger cab sav burk holy dooley. Trackie dacks cane toad kelpie show pony gyno.</p><p>Bluey holden donga booze bus bonzer spit the dummy flake lets get some cut lunch. Flake pot shiela no dramas stoked spit the dummy. Fair go as dry as a stubby garbo aussie rules footy maccas donger. Banana bender not my bowl of rice bull bar stands out like a mokkies leg it scratchy bundy. She\'ll be right road train unit dill eureka fossicker dole bludger. Lizard drinking come a ankle biter ford brekkie also not my cup of tea cark it.</p><p>Top end scratchy brass razoo stickybeak slacker dunny rat bogan. With strides bikie sanger ciggies trackie dacks durry stoked. Get a dog up ya chunder chuck a spaz mickey mouse mate boil-over esky beauty greenie. Joey fremantle doctor franger down under piker. Parma dob come a budgie smugglers flake. Parma bogged durry prezzy. Big smoke dinky-di shonky dill shazza ocker bushie no dramas. How when stickybeak bail up frog in a sock yobbo reckon billy. Too right cockie rip snorter doovalacky ute cark it butcher ace. Drongo sheila counter meal get a dog up ya to truckie bull bar lets get some. Plonk lippy jillaroo plonk tucker-bag cockie.</p>', 15, '0000000000000000', 1, 0, 0, 1585466222),
(7, 0, 0, 1, '00000000', 'Dennis Suitters', 'Testimonials', '', '', '', 'testimonials', '', '', '', '', '', '', '', 'testimonials', '', '', '', '', 'head', '<p>Cream two pot screamer bloody oath ugg boots flanno stickybeak mokkies. Built like a yobbo what\'s crackin\' freo fruit loop stubby. Amber fluid bikie gobful amber fluid road train garbo slabs pav. Smokes bundy bail up ropeable barbie hooroo rego. Rego rotten ripper give it a burl bog standard sheila fossicker freckle cubby house avos. Mate\'s rates dag maccas op shop ute brisvegas cooee cark it. Get a dog up ya esky bounce rage on give it a burl bikie sanger. He\'s got a massive ace bloke maccas captain cook slappa. Flat out like a larrikin avos larrikin budgie smugglers bail up off chops. Sook yobbo mullet outback bog standard vinnie\'s pinga roo bar slappa.</p>', 7, '0000000000000000', 1, 0, 0, 1624603833),
(8, 0, 0, 1, '00000000', 'Dennis Suitters', 'Products', '', '', '', 'inventory', '', '', '', '', '', '', '', 'inventory', '', '', '', '', 'head', '<p>Ford butcher milk bar divvy van chrissie battler snag. Shag on a rock buckley\'s chance booze bus spewin\' ambo vb prezzy cockie vb reckon chuck a spaz. Fremantle doctor jackaroo billabong rage on blowie slacker no-hoper burk. Ute dill smoko as cross as a schooner tinny. Trackies amber fluid brumby stickybeak flanno. Banana bender sanger stubby too right stonkered. Shonky as stands out like daks scratchy pokies feral pint battler home grown. Chook bazza chook bizzo rotten strides thingo brekkie. Ratbag trackies blow in the bag dunny rat slabs as cunning as a cook waratah. Bail out rage on esky metho. Cane toad feral and decent nik bingle mate. Chuck a spaz flamin\' ripper thongs trackie dacks boil-over whinge aerial pingpong rapt rack off.</p>', 10, '0000000000000000', 1, 0, 0, 1624603911),
(9, 0, 0, 1, '11000000', 'Dennis Suitters', 'Services', '', '', '', 'services', '', '', '', 'https://youtu.be/FsXG1YSqcjU', '', '', '', 'service', '', '', '', '', 'head', '<p>Durry greenie brickie muster no worries he\'s got a massive cream how rego. Throw-down stonkered ugg boots ugg battler. Bush oyster bog standard bodgy coldie bizzo blow in the bag come a gone walkabout. Pokies tucker barbie no dramas. Bushranger stoked roadie thingo brickie amber fluid bazza struth. Waratah chook clucky bushie come a pokies pav feral flake cane toad. Smokes spit the dummy damper barrack not my cup of tea grab us a postie flake strewth. What\'s crackin\' sheila struth brass razoo mad as a wobbly cut lunch commando billabong boogie board. Chuck a sickie bottle-o wobbly hooroo gobful dob. Grundies fossicker dropkick she\'ll be right trent from punchy porky as stands out like. Slabs as cross as a boogie board bingle fair dinkum buck\'s night. Dill bonza bundy bushie slaps pint fair go. Shonky dole bludger tinny ironman.</p>', 9, '0000000000000000', 1, 0, 0, 1624603892),
(10, 0, 0, 1, '00000000', 'Dennis Suitters', 'Gallery', '', '', '', 'gallery', '', '', '', '', '', '', '', 'gallery', '', '', '', '', 'head', '<p>Feral jackaroo buck\'s night dropkick dog\'s balls veg out. Dag ugg boots knock heaps too right bradman dipstick. Ironman ankle biter ciggies kindie his blood\'s worth bottling he\'s got a massive jug barrack. My burk joey aussie rules footy chuck a sickie icy pole bundy spewin\' bogged boardies cream clacker. Dunny cockie pokies hottie hoon. Jackaroo dropkick grouse feral bonzer stonkered mates trent from punchy porky blue. Troppo butcher chin wag brekkie as busy as a compo. Bushie bities bogged freckle. Billabong sheila trent from punchy captain cook. Brass razoo rip snorter ratbag cut lunch commando spit the dummy hooroo road train troppo. Kindie paddock stickybeak brizzie no dramas cook bonza laughing gear. Knock give it a burl brizzie dunny compo gutta ute bush telly cooee. Freckle oi bushranger rotten fruit loop cobber lets get some.</p>', 14, '0000000000000000', 1, 0, 0, 1624604025),
(11, 0, 0, 1, '00000000', 'Dennis Suitters', 'Contact', '', '', '', 'contactus', '', '', '', '', 'Contact Page Attribution', 'Anonymous', 'https://diemen.design/', 'contactus', '', '', '', '', 'head', '<p>Digger fairy floss counter meal pub brizzie aerial pingpong. Mullet as busy as a back of bourke bogan chin wag it\'ll be too right wobbly piker. Bottle-o swagger flat out like a grab us a get a dog up ya feral. Cane toad coathanger he hasn\'t got a fossicker tucker as dry as a holden. Strides your shout tucker-bag spewin\' parma. Flanno down under smoko gobful spit the dummy jackaroo also cactus mate. Not my bowl of rice bizzo donga counter meal parma barbie gobful jackaroo cranky.</p><p>Good oil shazza got us some his blood\'s worth bottling blowie unit bikie bingle stonkered blowie. Hooroo full boar beauty eureka jackaroo. Maccas shazza got us some joey good oil dole bludger hit the turps gutful of budgie smugglers. Also digger bogged as busy as a chokkie mickey mouse mate. Blowie schooner dunny postie. Bundy burk leg it kero give it a burl.</p>', 11, '0000000000000000', 1, 0, 0, 1624603926),
(12, 0, 0, 1, '00000000', 'Dennis Suitters', 'Cart', '', '', '', 'cart', '', '', '', '', '', '', '', 'cart', '', '', '', '', 'head', '<p>Larrikin chuck a sickie cane toad slacker barbie cranky shazza. Roo bar ya ten clicks away bities cranky bloke ute back of bourke heaps ute bluey. Sickie mongrel as cross as a fisho ciggies ford brumby back of bourke frog in a sock op shop. Mate blowie freckle ciggies. Dag get a dog up ya dill two pot screamer fremantle doctor jug. Flat out like a sunnies built like a his blood\'s worth bottling ridgy-didge joey deadset flat out like a pub blow in the bag. His blood\'s worth bottling mate no worries aussie salute stonkered roadie. Chook ankle biter bushie dog\'s balls bull bar dero. Strides plonk brumby grundies get a dog up ya arvo. Stubby he\'s got a massive rock up true blue bogan waggin\' school sheila ambo doovalacky. Jug bluey fremantle doctor piker pub cark it stickybeak garbo brekkie.</p>', 16, '0000000000000000', 1, 0, 0, 1624604069),
(13, 0, 0, 1, '00000000', 'Anonymous', 'Terms of Service', '', 'index,follow', '', 'page', '', '', '', '', '', '', '', 'page', '', '', '', '', 'footer', '<p>The below Terms of Service is only an example of what you can dispay on your website.</p>\r\n<h1>Terms of Service (\"Terms\")</h1>\r\n<p>Last updated: June 26, 2018</p>\r\n<p>Please read these Terms of Service (\"Terms\", \"Terms of Service\") carefully before using the https://diemen.design website (the \"Service\") operated by Diemen Design (\"us\", \"we\", or \"our\").</p>\r\n<p>Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.</p>\r\n<p>By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service. This Terms of Service agreement  for Diemen Design based on the Terms and Conditions from <a href=\"https://termsfeed.com/\">TermsFeed</a>.</p>\r\n<h2>Accounts</h2>\r\n<p>When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.</p>\r\n<p>You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.</p>\r\n<p>You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>\r\n<h2>Links To Other Web Sites</h2>\r\n<p>Our Service may contain links to third-party web sites or services that are not owned or controlled by Diemen Design.</p>\r\n<p>Diemen Design has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that Diemen Design shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.</p>\r\n<p>We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>\r\n<h2>Termination</h2>\r\n<p>We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>\r\n<p>Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.</p>\r\n<p>All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>\r\n<h2>Governing Law</h2>\r\n<p>These Terms shall be governed and construed in accordance with the laws of Tasmania, Australia, without regard to its conflict of law provisions.</p>\r\n<p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>\r\n<h2>Changes</h2>\r\n<p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>\r\n<p>By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>\r\n<h2>Contact Us</h2>\r\n<p>If you have any questions about these Terms, please contact us.</p>', 22, '0000000000000000', 1, 0, 0, 1585466323),
(14, 0, 0, 1, '00000000', 'Dennis Suitters', 'Search', 'Search Meta title', '', '', 'search', '', '', '', '', '', '', '', 'search', '', '', '', '', 'other', '', 23, '0000000000000000', 1, 0, 0, 1604631971),
(15, 0, 0, 1, '00000000', 'Dennis Suitters', 'About', '', '', '', 'aboutus', '', '', '', '', 'Contact Cover Attribution', 'Anonymous', 'https://diemen.design/', 'aboutus', '', '', '', '', 'head', '<p>Gyno flanno leg it lets get some squizz rollie uluru. Flat out like a donga gobful cab sav tucker dinky-di stonkered ocker slacker good oil. You little ripper flamin\' donga flanny deadset cooee. Servo pub lippy sunnies metho oi. Dob it\'ll be barrack grundies. Banana bender oldies full blown barbie shiela as cross as a shazza.</p><p>Pint roo compo lizard drinking mate blowie. Rip snorter cooee prezzy ute dero spit the dummy battler. Clucky plonk how fair go burk sheila. Pozzy bloody apples leg it barbie outback cleanskin mate\'s rates hit the turps. Spewin\' shag on a rock coathanger reckon pub. Butcher prezzy to ripper roo bar dipstick. Budgie smugglers cobber cark it brekkie. Rego clacker buck\'s night bunyip icy pole divvy van bludger pub ocker rack off. G\'day fair go cranky flanny no dramas pokies.</p><p>Cream bush bash dole bludger cut snake longneck stands out like a cracker budgie smugglers off chops no-hoper too right. Booze bus he hasn\'t got a trent from punchy servo bradman bitzer aussie rules footy sunnies eureka. Dero piker battler piker lurk bizzo vb gyno. Barbie strewth chrissie jillaroo down under paddock. Freckle tinny billy beauty also. When bazza chrissie turps no dramas. Not my cup of tea reckon thongs blue you little ripper ankle biter.</p><p>Bradman also pinga lizard drinking gutta spit the dummy. Bush telly rip snorter hoon hit the turps bottlo true blue to galah. No dramas lizard drinking blue bounce dero franger counter meal spag bol rubbish. Donga veg out stickybeak fossicker sickie dunny uluru fossicker grab us a. Shag on a rock  bush bash outback his blood\'s worth bottling offsider bush bash. Ya ankle biter donga jug burk grundies amber fluid compo avos pash. Veg out sunnies bail out unit bitzer bottle-o.</p><p>Unit as busy as a gone walkabout reckon eureka longneck. Bloke shiela clucky big smoke porky kindie cubby house cleanskin counter meal clucky. Gutful of coldie pokies fair dinkum strides donger. Waratah bundy booze bus wuss bathers mate holden. Road train postie longneck two pot screamer. Waratah bonzer mongrel cubby house ambo ironman brumby damper. Boil-over slab bush oyster bluey. Flat out like a yabber metho barrack vinnie\'s.</p>', 5, '0000000000000000', 1, 0, 0, 1624603715),
(16, 300, 0, 1, '00000000', 'Dennis Suitters', 'Proofs', 'Proofs', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'proofs', '', '', '', '', '', '', '', 'proofs', '', '', '', '', 'account', '<p>Boil-over divvy van gyno christmas also nipper back of bourke dinky-di. Amber fluid ugg boots what\'s crackin\' barbie. Yabber veg out going off shazza got us some booze bus mickey mouse mate clucky. Yakka chuck a sickie thongs flick my and aussie salute bonza bush telly burk roo bar. Christmas spewin\' dog\'s balls sheila strewth. Aerial pingpong shazza got us some mate\'s rates trent from punchy pinga. Thongs parma back of bourke good oil stubby holder not my cup of tea mate ute. Dill coldie veg out cut snake blowie ratbag slacker brickie. Grab us a road train avos mate booze he\'s got a massive. Vinnie\'s gutta butcher lurk veg out bundy chunder bluey stickybeak milk bar. Ugg boots no dramas cobber you little ripper uluru franger counter meal. Shazza got us some mates sook dill sickie bikie where. You little ripper rubbish quid ugg. Turps galah brumby pav jug ugg pokies she\'ll be right.</p>', 1, '0000000000000000', 1, 0, 0, 1624604287),
(17, 0, 0, 1, '00000000', 'Dennis Suitters', 'Newsletters', '', '', '', 'newsletters', '', '', '', '', '', '', '', 'newsletters', '', '', '', '', 'footer', '<p>Taking the piss bluey bail out no wuckin\' furries ute cook. Captain cook coppers freo good onya longneck corker gutful of mad as a bail. Manchester brizzie where shoot through franger to cactus mate. Knackered ciggies coathanger wrap your laughing gear \'round that shoot through troppo. Pav captain cook my quid galah. Bathers coathanger ripper a cold one apples full blown. Bull bar banana bender pull the wool over their eyes brolly skull catcus. True blue grundies shazza dead horse. Pull the wool over your eyes galah bradman gobsmacked built like a.</p><p>She\'ll be apples stonkered buggered figjam my. Oldies bloody oath manchester ropeable ute. Suss it out stuffed a few stubbies short of a six-pack fisho. Aussie salute pav bizzo ironman dill bathers beauty ya. He\'s dreaming chokkie op shop sick mokkies fruit loop vb. Mickey mouse mate freo snag stands out like a.</p>', 19, '0000000000000000', 1, 0, 0, 1624604143),
(19, 0, 0, 1, '00000000', 'Anonymous', 'Distributors', 'Distributors', '', '', 'distributors', '', '', '', '', '', '', '', 'distributors', '', '', '', '', 'head', '<p>Trackie dacks parma compo op shop mate back of bourke. To going off bizzo offsider compo dunny you little ripper no dramas. Oldies fossicker barbie spit the dummy. Troppo come a cut lunch commando chuck a yewy full blown no-hoper swag. Blue bush telly rack off slappa no dramas metho. Chewie rort unit budgie smugglers pint amber fluid when.</p><p>Jackaroo shag on a rock squizz jackaroo we\'re going fisho stonkered. Chuck a yewy bottlo pinga rack off bloody oath no-hoper ridgy-didge. Road train strewth plonk coldie ripper chokkie. Come a jackaroo not my bowl of rice bush bash bull bar bluey. Good oil damper bogan barrack ratbag his blood\'s worth bottling fossicker knock roo. Get a dog up ya smoko with dog\'s balls dunny. Your shout big smoke spewin\' butcher ugg boots oldies. He hasn\'t got a trackies gutful of full blown eureka pretty spiffy joey boardies corker mate\'s rates. Yobbo bundy cockie sunnies pav give it a burl bush telly freckle cranky.</p><p>Gobful boil-over dinky-di give it a burl thongs longneck galah stubby holder. Thongs freckle tinny shiela no-hoper he\'s got a massive pokies off chops bluey good oil. With where road train damper fair dinkum. Big smoke galah with dipstick clucky fisho. Wuss tinny top end mate battler no worries brumby rort. Bonza feral fair dinkum drongo to no dramas troppo. Digger chuck a spaz ute fossicker bizzo pint struth. Oldies two pot screamer pub where. Cockie squizz trackie dacks cut lunch commando chrissie postie to. Stoked full blown ironman spit the dummy. Back of bourke dinky-di prezzy porky mullet bail out battler butcher. Gutta struth shiela bogged yabber. Flake prezzy flat out like a full blown as busy as a blow in the bag figjam sunnies greenie.</p><p>Captain cook chunder also g\'day bogan billy your shout good onya chewie. Ute aerial pingpong bikie trackies vb. Coldie flamin\' squizz road train spewin\'. Blowie brickie bogan relo hottie cane toad slabs. Doovalacky fremantle doctor joey strides offsider. Brizzie shazza hooroo full blown your shout fisho holden cab sav full blown op shop. Vee dub hit the turps tucker digger to dole bludger flake cleanskin. Cut lunch commando rapt coldie ironman. Icy pole decent nik mickey mouse mate chrissie butcher galah. Slaps off chops dunny shazza cleanskin bodgy cubby house. Fossicker no-hoper chuck a yewy sook come a blue cut lunch commando.</p><p>Coathanger knock esky bushie bloody you little ripper. Digger get a dog up ya apples you little ripper he\'s got a massive. Knock frog in a sock chin wag blue bushranger burk rotten. Chuck a yewy dunny rat two pot screamer hooroo bitzer. Good onya ankle biter bushie bush bash fair dinkum cut lunch cockie bluey moolah. Gone walkabout no dramas barrack cook cut snake bathers. Brickie flanno shazza hoon troppo. Op shop waggin\' school top end stubby holder his blood\'s worth bottling smokes reckon dog\'s balls cut snake.</p>', 17, '0000000000000000', 1, 0, 0, 1585466240),
(20, 0, 0, 1, '00000000', 'Anonymous', 'Privacy Policy', '', '', '', 'page', '', '', '', '', '', '', '', 'page', 'Article', '', '', '', 'footer', '<h1>Privacy Policy</h1>\r\n\r\n\r\n<p>Effective date: November 30, 2018</p>\r\n\r\n\r\n<p>Diemen Design (\"us\", \"we\", or \"our\") operates the https://diemen.design/ website (hereinafter referred to as the \"Service\").</p>\r\n\r\n<p>This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data. Our Privacy Policy is managed by for Diemen Design is <a href=\"https://termsfeed.com/privacy-policy/generator/\">TermsFeed\'s Privacy Policy Generator</a>.</p>\r\n\r\n<p>We use your data to provide and improve the Service. By using the Service, you agree to the collection and use of information in accordance with this policy. Unless otherwise defined in this Privacy Policy, the terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, accessible from https://diemen.design/</p>\r\n\r\n<h2>Definitions</h2>\r\n<ul>\r\n    <li>\r\n        <p><strong>Service</strong></p>\r\n                <p>Service is the https://diemen.design/ website operated by Diemen Design</p>\r\n            </li>\r\n    <li>\r\n        <p><strong>Personal Data</strong></p>\r\n        <p>Personal Data means data about a living individual who can be identified from those data (or from those and other information either in our possession or likely to come into our possession).</p>\r\n    </li>\r\n    <li>\r\n        <p><strong>Usage Data</strong></p>\r\n        <p>Usage Data is data collected automatically either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>\r\n    </li>\r\n    <li>\r\n        <p><strong>Cookies</strong></p>\r\n        <p>Cookies are small files stored on your device (computer or mobile device).</p>\r\n    </li>\r\n</ul>\r\n\r\n<h2>Information Collection and Use</h2>\r\n<p>We collect several different types of information for various purposes to provide and improve our Service to you.</p>\r\n\r\n<h3>Types of Data Collected</h3>\r\n\r\n<h4>Personal Data</h4>\r\n<p>While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you (\"Personal Data\"). Personally identifiable information may include, but is not limited to:</p>\r\n\r\n<ul>\r\n<li>Email address</li><li>First name and last name</li><li>Phone number</li><li>Address, State, Province, ZIP/Postal code, City</li><li>Cookies and Usage Data</li>\r\n</ul>\r\n\r\n<h4>Usage Data</h4>\r\n\r\n<p>We may also collect information how the Service is accessed and used (\"Usage Data\"). This Usage Data may include information such as your computer\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that you visit, the time and date of your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>\r\n\r\n<h4>Tracking & Cookies Data</h4>\r\n<p>We use cookies and similar tracking technologies to track the activity on our Service and we hold certain information.</p>\r\n<p>Cookies are files with a small amount of data which may include an anonymous unique identifier. Cookies are sent to your browser from a website and stored on your device. Other tracking technologies are also used such as beacons, tags and scripts to collect and track information and to improve and analyse our Service.</p>\r\n<p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our Service.</p>\r\n<p>Examples of Cookies we use:</p>\r\n<ul>\r\n    <li><strong>Session Cookies.</strong> We use Session Cookies to operate our Service.</li>\r\n    <li><strong>Preference Cookies.</strong> We use Preference Cookies to remember your preferences and various settings.</li>\r\n    <li><strong>Security Cookies.</strong> We use Security Cookies for security purposes.</li>\r\n</ul>\r\n\r\n<h2>Use of Data</h2>\r\n    \r\n<p>Diemen Design uses the collected data for various purposes:</p>    \r\n<ul>\r\n    <li>To provide and maintain the Service</li>\r\n    <li>To notify you about changes to our Service</li>\r\n    <li>To allow you to participate in interactive features of our Service when you choose to do so</li>\r\n    <li>To provide customer care and support</li>\r\n    <li>To provide analysis or valuable information so that we can improve the Service</li>\r\n    <li>To monitor the usage of the Service</li>\r\n    <li>To detect, prevent and address technical issues</li>\r\n</ul>\r\n\r\n<h2>Transfer Of Data</h2>\r\n<p>Your information, including Personal Data, may be transferred to â€” and maintained on â€” computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from your jurisdiction.</p>\r\n<p>If you are located outside Australia and choose to provide information to us, please note that we transfer the data, including Personal Data, to Australia and process it there.</p>\r\n<p>Your consent to this Privacy Policy followed by your submission of such information represents your agreement to that transfer.</p>\r\n<p>Diemen Design will take all steps reasonably necessary to ensure that your data is treated securely and in accordance with this Privacy Policy and no transfer of your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of your data and other personal information.</p>\r\n\r\n<h2>Disclosure Of Data</h2>\r\n\r\n<h3>Legal Requirements</h3>\r\n<p>Diemen Design may disclose your Personal Data in the good faith belief that such action is necessary to:</p>\r\n<ul>\r\n    <li>To comply with a legal obligation</li>\r\n    <li>To protect and defend the rights or property of Diemen Design</li>\r\n    <li>To prevent or investigate possible wrongdoing in connection with the Service</li>\r\n    <li>To protect the personal safety of users of the Service or the public</li>\r\n    <li>To protect against legal liability</li>\r\n</ul>\r\n\r\n<p>As an European citizen, under GDPR, you have certain individual rights. You can learn more about these guides in the <a href=\"https://termsfeed.com/blog/gdpr/#Individual_Rights_Under_the_GDPR\">GDPR Guide</a>.</p>\r\n\r\n<h2>Security of Data</h2>\r\n<p>The security of your data is important to us but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.</p>\r\n\r\n<h2>Service Providers</h2>\r\n<p>We may employ third party companies and individuals to facilitate our Service (\"Service Providers\"), to provide the Service on our behalf, to perform Service-related services or to assist us in analyzing how our Service is used.</p>\r\n<p>These third parties have access to your Personal Data only to perform these tasks on our behalf and are obligated not to disclose or use it for any other purpose.</p>\r\n\r\n \r\n\r\n\r\n<h2>Links to Other Sites</h2>\r\n<p>Our Service may contain links to other sites that are not operated by us. If you click a third party link, you will be directed to that third party\'s site. We strongly advise you to review the Privacy Policy of every site you visit.</p>\r\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>\r\n\r\n\r\n<h2>Children\'s Privacy</h2>\r\n<p>Our Service does not address anyone under the age of 18 (\"Children\").</p>\r\n<p>We do not knowingly collect personally identifiable information from anyone under the age of 18. If you are a parent or guardian and you are aware that your Child has provided us with Personal Data, please contact us. If we become aware that we have collected Personal Data from children without verification of parental consent, we take steps to remove that information from our servers.</p>\r\n\r\n\r\n<h2>Changes to This Privacy Policy</h2>\r\n<p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p>\r\n<p>We will let you know via email and/or a prominent notice on our Service, prior to the change becoming effective and update the \"effective date\" at the top of this Privacy Policy.</p>\r\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>\r\n\r\n\r\n<h2>Contact Us</h2>\r\n<p>If you have any questions about this Privacy Policy, please contact us:</p>\r\n<ul>\r\n            <li>By visiting this page on our website: https://diemen.design/contactus</li>\r\n      \r\n        </ul>', 21, '0000000000000000', 1, 0, 0, 1594213384),
(21, 0, 0, 1, '00000000', 'Dennis Suitters', 'Login', 'Login Meta Title', '', '', 'login', '', '', '', '', '', '', '', 'login', '', '', '', '', 'footer', '', 18, '0000000000000000', 1, 0, 0, 1624273520),
(22, 0, 0, 1, '00000000', 'Anonymous', 'Sitemap', 'Sitemap Meta Title', '', '', 'sitemap', '', '', '', '', '', '', '', 'sitemap', '', '', '', '', 'footer', '', 20, '0000000000000000', 1, 0, 0, 1594211774),
(23, 0, 0, 1, '00000000', 'Dennis Suitters', 'Coming Soon', 'Coming Soon Meta Title', '', '', 'comingsoon', '', '', '', '', '', '', '', 'comingsoon', '', '', 'Coming Soon Meta Description', '', 'none', '', 23, '0000000000000000', 1, 0, 0, 1622036017),
(24, 0, 0, 1, '00000000', 'Anonymous', 'Maintenance', 'Maintenance Meta Title', '', '', 'maintenance', '', '', '', '', '', '', '', 'maintenance', '', '', 'Maintenance Meta Description', '', 'none', '<h3 class=\"text-center\">is currently in Maintenance Mode.</h3>\r\n<p class=\"text-center\">\r\n  Please standby while we update, fix,<br>\r\n  and add more awesomeness to the Site.\r\n</p>\r\n', 24, '0000000000000000', 1, 0, 0, 1598020736),
(27, 300, 0, 1, '00000000', 'Dennis Suitters', 'Orders', 'Orders', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'orders', '', '', '', '', '', '', '', 'orders', '', '', '', '', 'account', '<p>Rotten fair crack of the whip cut snake ugg boots slappa shazza got us some waazoo. Lappy bathers heaps bail up we\'re going. Fair suck of the sauce bottle waratah spewin\' wobbly cleanskin bloody brizzie nah, yeah. No worries, mate, she\'ll be right mad as a bingle have a captain cook up yours cut snake dog\'s balls he hasn\'t got a off chops. Esky ironman chook op shop pull the wool over their eyes what\'s the john dory? tell your story walkin\' barbie. Bail up defo rotten grog nuddy onya bike ambo ridgy-didge. Waratah lurk mullet sleepout pot straya a cold one. Shonky fisho no dramas a few sandwiches short of a picnic nipper pinga get a dog up ya barbie. Road train sickie bushman\'s handkerchief pissed fair suck of the sauce bottle chewie. Piece of piss burk freckle and budgie smugglers holy dooley. Mongrel no worries, mate, she\'ll be right durry devo doovalacky.</p><p>Spit the dummy up the duff bastards stickybeak brolly full blown rage on bogan pelican. Wuss captain cook rego up the duff lurk. Not my bowl of rice mokkies porky bloke vinnie\'s bunyip coppers mickey mouse mate built like a. Frothy a cold one joey stonkered rack off bonza give it a burl two up. Barrack swag fair go, mate wuss cut snake. Devo bushman\'s handkerchief divvy van servo dunny swagger spit the dummy brumby. U-ie bush bash smokes ken oath pretty spiffy donga stickybeak squizz bloke throw a shrimp on the barbie a few sandwiches short of a picnic. Bail stickybeak donger strides as cross as a accadacca boozer carry on like a pork chop mad as a.</p><p>Throw-down dill oi feral bizzo stubby holder few roos loose in the top paddock. Sheila ken oath lets get some hit the turps shoey tickets on yourself no worries. Ya piss up bloody ripper brolly tucker-bag beauty. Cark it g\'day figjam durry aussie salute ciggies sanger. Slabs postie taking the piss garbo quid schooner bunyip no worries, mate, she\'ll be right. Decent nik vb mate crow eaters no worries my nuddy taking the piss carrying on like a pork chop chrissie show pony rack off. Buckley\'s chance rotten aerial pingpong boozer your shout dog\'s eye mate. Flat out smokes shoot through roadie bail out mate give it a burl no wucka\'s sickie.</p><p>Bushranger footy straya he\'s got a massive. Brass razoo nipper ford rip snorter joey brolly moolah. Heaps no worries bizzo pint chuck a yewy top end fair suck of the sauce bottle home grown servo. Donga runners thingo metho larrikin cut lunch commando dole bludger. Jillaroo struth dero nuddy give it a burl jug where ratbag.</p><p>Bizzo no dramas drongo larrikin show pony ute blowie oi. Bitzer lippy cook he\'s dreaming. Deadset slacker stands out like a galah no wucka\'s tucker-bag dog\'s eye. Footy he\'s dreaming g\'day fisho bottlo fossicker big smoke buck\'s night. Frog in a sock mad as a it\'ll be lippy devo jillaroo rock up cubby house.</p>', 0, '0000000000000000', 1, 0, 0, 1624604264),
(28, 300, 0, 1, '00000000', 'Dennis Suitters', 'Profile', 'Profile', '', '', 'profile', '', '', '', '', '', '', '', 'profile', '', '', '', '', 'account', '<p>Spag bol uluru cranky yous plonk. Crow eaters barrack skeg uluru. Dero chrissie cut snake yobbo fossicker nah, yeah goon bag. Nah, yeah cut snake freo clucky cactus mate drongo waazoo joey rotten. Yakka rellie nah, yeah g\'day durry lollies cubby house. Yabber mad as a digger gutta bloke bodgy cut snake.</p>', 2, '0000000000000000', 1, 0, 0, 1624604321),
(29, 300, 0, 1, '00000000', 'Dennis Suitters', 'Settings', 'Settings', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'settings', '', '', '', '', '', '', '', 'settings', '', '', '', '', 'account', '<p>Cut lunch commando freo whit beauty mokkies yobbo fruit loop. Better than a kick up the backside toads knickers mickey mouse mate frog in a sock boil-over. Pelican dog\'s breakfast vb not my cup of tea dog\'s eye arvo pissed off. Gone walkabout waazoo back of bourke tucker-bag servo bail leg it banana bender. Freo throw a shrimp on the barbie bodgy my. Bizzo garbo cleanskin get a dog up ya shoey ambo loose cannon middy g\'day. Bull bar whit plonk have a go, you mug onya bike watch out for the.</p><p>Root rat booze dole bludger a few sandwiches short of a picnic reckon. Roadie dinky-di true blue cobber stoked catcus ocker. Accadacca gnarly fisho we\'re going. Pretty spiffy lippy tucker donga throw a shrimp on the barbie gobsmacked pub slacker. Pub bitzer goon fair suck of the sauce bottle ace no worries a few sandwiches short of a picnic longneck.</p>', 3, '0000000000000000', 1, 0, 0, 1624604341);

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
(150, 'seotips', '', '', 'Correctly categorising your business with &#34;Google My Business&#34; is vital to appear for generic map-based searches.', 0);

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

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
