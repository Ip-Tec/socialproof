UPDATE `settings` SET `value` = '{\"version\":\"40.0.0\", \"code\":\"4000\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

CREATE TABLE `email_reports` (
`id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`campaign_id` int DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `user_id` (`user_id`),
KEY `campaign_id` (`campaign_id`),
KEY `email_reports_datetime_idx` (`datetime`) USING BTREE,
CONSTRAINT `email_reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `email_reports_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

alter table campaigns add email_reports text null after branding;

-- SEPARATOR --

alter table campaigns add email_reports_last_datetime datetime null after email_reports;

-- SEPARATOR --

update campaigns set email_reports_last_datetime = '2020-01-01';

-- SEPARATOR --

alter table blog_posts add image_description varchar(256) null after description;
