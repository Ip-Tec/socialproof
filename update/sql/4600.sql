UPDATE `settings` SET `value` = '{\"version\":\"46.0.0\", \"code\":\"4600\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table users add plan_notifications_impressions_limit_notice tinyint default 0 null after current_month_notifications_impressions;

-- SEPARATOR --

alter table users modify current_month_notifications_impressions bigint unsigned default 0 null;

-- SEPARATOR --

alter table users modify total_notifications_impressions bigint unsigned default 0 null;

-- SEPARATOR --

INSERT INTO `settings` (`key`, `value`) VALUES ('myfatoorah', '{}');
