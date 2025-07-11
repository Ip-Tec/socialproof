UPDATE `settings` SET `value` = '{\"version\":\"41.0.0\", \"code\":\"4100\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

UPDATE settings SET `value` = JSON_SET(`value`, '$.blacklisted_domains', JSON_ARRAY()) WHERE `key` = 'users';

-- SEPARATOR --

UPDATE settings SET `value` = JSON_SET(`value`, '$.blacklisted_domains', JSON_ARRAY()) WHERE `key` = 'notifications';
