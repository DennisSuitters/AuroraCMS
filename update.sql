INSERT INTO `menu` (`id`, `rank`, `mid`, `uid`, `options`, `login_user`, `title`, `seoTitle`, `metaRobots`, `url`, `file`, `fileALT`, `cover`, `coverURL`, `coverVideo`, `attributionImageTitle`, `attributionImageName`, `attributionImageURL`, `contentType`, `schemaType`, `seoKeywords`, `seoDescription`, `seoCaption`, `menu`, `notes`, `ord`, `checklist`, `active`, `views`, `suggestions`, `eti`) VALUES ('30', '300', '0', '1', '00000000', 'Dennis Suitters', 'Settings', 'Checkout', 'noindex,noimageindex,nofollow,noarchive,nocache,nosnippet,noodp,noydir', '', 'checkout', '', '', '', '', '', '', '', 'checkout', '', '', '', '', 'other', '', '30', '0000000000000000', '1', '2', '0', '1624604341');
ALTER TABLE `config` ADD `stripe_publishkey` TEXT NOT NULL AFTER `payPalSecret`;
ALTER TABLE `config` ADD `stripe_secretkey` TEXT NOT NULL AFTER `stripe_publishkey`;
ALTER TABLE `orders` ADD `txn_id` VARCHAR(50) NOT NULL AFTER `points`;
ALTER TABLE `orders` ADD `paid_email` TINYTEXT NOT NULL AFTER `txn_id`;
ALTER TABLE `orders` ADD `paid_name` TINYTEXT NOT NULL AFTER `paid_email`;
ALTER TABLE `orders` ADD `paid_amount` VARCHAR(10) NOT NULL AFTER `paid_name`;
ALTER TABLE `orders` ADD `payment_status` VARCHAR(25) NOT NULL AFTER `paid_amount`;
ALTER TABLE `orders` ADD `paid_ti` INT(10) NOT NULL AFTER `paid_amount`;
ALTER TABLE `orders` ADD `paid_via` TINYTEXT NOT NULL AFTER `points`;

