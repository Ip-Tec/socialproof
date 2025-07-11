UPDATE `settings` SET `value` = '{\"version\":\"44.0.0\", \"code\":\"4400\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table notifications add impressions bigint unsigned default 0 null after notification_key;

-- SEPARATOR --

alter table notifications add hovers bigint unsigned default 0 null after impressions;

-- SEPARATOR --

alter table notifications add clicks bigint unsigned default 0 null after hovers;

-- SEPARATOR --

alter table notifications add form_submissions bigint unsigned default 0 null after hovers;
