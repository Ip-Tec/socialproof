UPDATE `settings` SET `value` = '{\"version\":\"36.0.0\", \"code\":\"3600\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table users add extra text null after preferences;
-- SEPARATOR --

alter table track_notifications
    add user_id int null after id;
-- SEPARATOR --

create index user_id
    on track_notifications (user_id);
-- SEPARATOR --

alter table track_notifications
    add constraint track_notifications_users_user_id_fk
        foreign key (user_id) references users (user_id);

-- SEPARATOR --

update track_notifications left join campaigns on `track_notifications`.`campaign_id` = `campaigns`.`campaign_id` set `track_notifications`.`user_id` = `campaigns`.`user_id`;

-- SEPARATOR --

alter table track_conversions add user_id int null after id;

-- SEPARATOR --

alter table track_conversions add constraint track_conversions_users_user_id_fk foreign key (user_id) references users (user_id);

-- SEPARATOR --

update track_conversions left join notifications on `track_conversions`.`notification_id` = `notifications`.`notification_id` set `track_conversions`.`user_id` = `notifications`.`user_id`;

-- SEPARATOR --

alter table campaigns add domain_id int null after user_id;

-- SEPARATOR --

CREATE TABLE `domains` (
`domain_id` int NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`scheme` varchar(8) NOT NULL DEFAULT '',
`host` varchar(128) NOT NULL DEFAULT '',
`custom_index_url` varchar(256) DEFAULT NULL,
`custom_not_found_url` varchar(256) DEFAULT NULL,
`is_enabled` tinyint(4) DEFAULT '0',
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`domain_id`),
KEY `user_id` (`user_id`),
KEY `host` (`host`),
CONSTRAINT `domains_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ROW_FORMAT=DYNAMIC ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SEPARATOR --

alter table campaigns add constraint campaigns_domains_domain_id_fk foreign key (domain_id) references domains (domain_id) on update cascade on delete set null;
