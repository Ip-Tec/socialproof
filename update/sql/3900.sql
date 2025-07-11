UPDATE `settings` SET `value` = '{\"version\":\"39.0.0\", \"code\":\"3900\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

ALTER TABLE track_conversions ADD COLUMN page_title VARCHAR(64) AFTER url;

-- SEPARATOR --

alter table users add next_cleanup_datetime datetime default CURRENT_TIMESTAMP null after datetime;
