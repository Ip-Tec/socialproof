UPDATE `settings` SET `value` = '{\"version\":\"38.0.0\", \"code\":\"3800\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

CREATE TABLE `notification_handlers` (
`notification_handler_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`type` varchar(32) DEFAULT NULL,
`name` varchar(128) DEFAULT NULL,
`settings` text,
`is_enabled` tinyint NOT NULL DEFAULT '1',
`last_datetime` datetime DEFAULT NULL,
`datetime` datetime NOT NULL,
PRIMARY KEY (`notification_handler_id`),
UNIQUE KEY `notification_handler_id` (`notification_handler_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `notification_handlers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

INSERT IGNORE INTO `settings` (`key`, `value`) VALUES ('notification_handlers', '{}');

-- SEPARATOR --

alter table notifications add notifications text null after settings;

