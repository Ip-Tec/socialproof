CREATE TABLE `users` (
`user_id` int NOT NULL AUTO_INCREMENT,
`email` varchar(320) NOT NULL,
`password` varchar(128) DEFAULT NULL,
`name` varchar(64) NOT NULL,
`avatar` varchar(40) DEFAULT NULL,
`billing` text,
`api_key` varchar(32) DEFAULT NULL,
`token_code` varchar(32) DEFAULT NULL,
`twofa_secret` varchar(16) DEFAULT NULL,
`anti_phishing_code` varchar(8) DEFAULT NULL,
`one_time_login_code` varchar(32) DEFAULT NULL,
`pending_email` varchar(128) DEFAULT NULL,
`email_activation_code` varchar(32) DEFAULT NULL,
`lost_password_code` varchar(32) DEFAULT NULL,
`type` tinyint NOT NULL DEFAULT '0',
`status` tinyint NOT NULL DEFAULT '0',
`is_newsletter_subscribed` tinyint NOT NULL DEFAULT '0',
`has_pending_internal_notifications` tinyint NOT NULL DEFAULT '0',
`plan_id` varchar(16) NOT NULL DEFAULT '',
`plan_expiration_date` datetime DEFAULT NULL,
`plan_settings` text,
`plan_trial_done` tinyint(4) DEFAULT '0',
`plan_expiry_reminder` tinyint(4) DEFAULT '0',
`payment_subscription_id` varchar(64) DEFAULT NULL,
`payment_processor` varchar(16) DEFAULT NULL,
`payment_total_amount` float DEFAULT NULL,
`payment_currency` varchar(4) DEFAULT NULL,
`referral_key` varchar(32) DEFAULT NULL,
`referred_by` varchar(32) DEFAULT NULL,
`referred_by_has_converted` tinyint(4) DEFAULT '0',
`current_month_notifications_impressions` bigint DEFAULT '0',
`plan_notifications_impressions_limit_notice` tinyint DEFAULT '0',
`total_notifications_impressions` bigint unsigned DEFAULT '0',
`language` varchar(32) DEFAULT 'english',
`currency` varchar(4) DEFAULT NULL,
`timezone` varchar(32) DEFAULT 'UTC',
`preferences` text,
`extra` text,
`datetime` datetime DEFAULT NULL,
`next_cleanup_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
`ip` varchar(64) DEFAULT NULL,
`continent_code` varchar(8) DEFAULT NULL,
`country` varchar(8) DEFAULT NULL,
`city_name` varchar(32) DEFAULT NULL,
`device_type` varchar(16) DEFAULT NULL,
`browser_language` varchar(32) DEFAULT NULL,
`browser_name` varchar(32) DEFAULT NULL,
`os_name` varchar(16) DEFAULT NULL,
`last_activity` datetime DEFAULT NULL,
`total_logins` int DEFAULT '0',
`user_deletion_reminder` tinyint(4) DEFAULT '0',
`source` varchar(32) DEFAULT 'direct',
PRIMARY KEY (`user_id`),
KEY `plan_id` (`plan_id`),
KEY `api_key` (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

INSERT INTO `users` (`user_id`, `email`, `password`, `api_key`, `referral_key`, `name`, `type`, `status`, `plan_id`, `plan_expiration_date`, `plan_settings`, `datetime`, `ip`, `last_activity`, `preferences`)
VALUES (1,'admin','$2y$10$uFNO0pQKEHSFcus1zSFlveiPCB3EvG9ZlES7XKgJFTAl5JbRGFCWy', md5(rand()), md5(rand()), 'AltumCode',1,1,'custom','2030-01-01 12:00:00', '{"no_ads":true,"white_labeling_is_enabled":true,"export":{"pdf":true,"csv":true,"json":true},"email_reports_is_enabled":true,"removable_branding":true,"custom_branding":true,"api_is_enabled":true,"custom_css_is_enabled":true,"affiliate_commission_percentage":10,"campaigns_limit":-1,"notifications_limit":-1,"notifications_impressions_limit":-1,"track_notifications_retention":999,"track_conversions_retention":999,"domains_limit":-1,"teams_limit":-1,"team_members_limit":-1,"active_notification_handlers_per_resource_limit":-1,"enabled_notifications":{"INFORMATIONAL":true,"COUPON":true,"LIVE_COUNTER":true,"EMAIL_COLLECTOR":true,"CONVERSIONS":true,"CONVERSIONS_COUNTER":true,"VIDEO":true,"AUDIO":true,"SOCIAL_SHARE":true,"REVIEWS":true,"EMOJI_FEEDBACK":true,"COOKIE_NOTIFICATION":true,"SCORE_FEEDBACK":true,"REQUEST_COLLECTOR":true,"COUNTDOWN_COLLECTOR":true,"CUSTOM_HTML":true,"INFORMATIONAL_BAR":true,"IMAGE":true,"COLLECTOR_BAR":true,"COUPON_BAR":true,"BUTTON_BAR":true,"COLLECTOR_MODAL":true,"COLLECTOR_TWO_MODAL":true,"BUTTON_MODAL":true,"TEXT_FEEDBACK":true,"ENGAGEMENT_LINKS":true,"WHATSAPP_CHAT":true,"CONTACT_US":true,"INFORMATIONAL_MINI":true,"INFORMATIONAL_BAR_MINI":true},"notification_handlers_email_limit":-1,"notification_handlers_webhook_limit":-1,"notification_handlers_slack_limit":-1,"notification_handlers_discord_limit":-1,"notification_handlers_telegram_limit":-1,"notification_handlers_microsoft_teams_limit":-1,"notification_handlers_twilio_limit":-1,"notification_handlers_twilio_call_limit":-1,"notification_handlers_whatsapp_limit":-1,"notification_handlers_x_limit":-1}', NOW(),'',NOW(), '{"default_results_per_page":100,"default_order_type":"DESC","campaigns_default_order_by":"campaign_id","notifications_default_order_by":"notification_id","notification_handlers_default_order_by":"notification_handler_id","domains_default_order_by":"domain_id"}');

-- SEPARATOR --

CREATE TABLE `users_logs` (
`id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`type` varchar(64) DEFAULT NULL,
`ip` varchar(64) DEFAULT NULL,
`device_type` varchar(16) DEFAULT NULL,
`os_name` varchar(16) DEFAULT NULL,
`continent_code` varchar(8) DEFAULT NULL,
`country_code` varchar(8) DEFAULT NULL,
`city_name` varchar(32) DEFAULT NULL,
`browser_language` varchar(32) DEFAULT NULL,
`browser_name` varchar(32) DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `users_logs_user_id` (`user_id`),
KEY `users_logs_ip_type_datetime_index` (`ip`,`type`,`datetime`),
CONSTRAINT `users_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `campaigns` (
`campaign_id` int NOT NULL AUTO_INCREMENT,
`user_id` int NOT NULL,
`domain_id` int DEFAULT NULL,
`pixel_key` varchar(32) DEFAULT NULL,
`name` varchar(256) NOT NULL DEFAULT '',
`domain` varchar(256) NOT NULL DEFAULT '',
`branding` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
`email_reports` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
`email_reports_last_datetime` datetime DEFAULT NULL,
`is_enabled` tinyint NOT NULL DEFAULT '0',
`last_datetime` datetime DEFAULT NULL,
`datetime` datetime NOT NULL,
PRIMARY KEY (`campaign_id`),
KEY `user_id` (`user_id`),
KEY `campaigns_domain_index` (`domain`),
KEY `campaigns_pixel_key_index` (`pixel_key`),
KEY `campaigns_domains_domain_id_fk` (`domain_id`),
CONSTRAINT `campaigns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `notifications` (
`notification_id` int NOT NULL AUTO_INCREMENT,
`campaign_id` int NOT NULL,
`user_id` int NOT NULL,
`name` varchar(256) NOT NULL DEFAULT '',
`type` varchar(64) NOT NULL DEFAULT '',
`settings` longtext NOT NULL,
`notifications` text NULL,
`last_action_date` datetime DEFAULT NULL,
`notification_key` varchar(32) NOT NULL DEFAULT '',
`impressions` bigint unsigned DEFAULT '0',
`hovers` bigint unsigned DEFAULT '0',
`clicks` bigint unsigned DEFAULT '0',
`form_submissions` bigint unsigned DEFAULT '0',
`is_enabled` tinyint(4) NOT NULL DEFAULT '0',
`last_datetime` datetime DEFAULT NULL,
`datetime` datetime NOT NULL,
PRIMARY KEY (`notification_id`),
KEY `campaign_id` (`campaign_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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


-- SEPARATOR --

CREATE TABLE `plans` (
`plan_id` int NOT NULL AUTO_INCREMENT,
`name` varchar(64) NOT NULL DEFAULT '',
`description` varchar(256) NOT NULL DEFAULT '',
`translations` text NOT NULL,
`prices` text NOT NULL,
`trial_days` int unsigned NOT NULL DEFAULT '0',
`settings` longtext NOT NULL,
`taxes_ids` text,
`color` varchar(16) DEFAULT NULL,
`status` tinyint(4) NOT NULL,
`order` int(10) unsigned DEFAULT '0',
`datetime` datetime NOT NULL,
PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- SEPARATOR --

CREATE TABLE `pages_categories` (
`pages_category_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`url` varchar(256) NOT NULL,
`title` varchar(256) NOT NULL DEFAULT '',
`description` varchar(256) DEFAULT NULL,
`icon` varchar(32) DEFAULT NULL,
`order` int NOT NULL DEFAULT '0',
`language` varchar(32) DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`pages_category_id`),
KEY `url` (`url`),
KEY `pages_categories_url_language_index` (`url`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- SEPARATOR --

CREATE TABLE `pages` (
`page_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`pages_category_id` bigint unsigned DEFAULT NULL,
`url` varchar(256) NOT NULL,
`title` varchar(256) NOT NULL DEFAULT '',
`description` varchar(256) DEFAULT NULL,
`icon` varchar(32) DEFAULT NULL,
`keywords` varchar(256) CHARACTER SET utf8mb4 DEFAULT NULL,
`editor` varchar(16) DEFAULT NULL,
`content` longtext,
`type` varchar(16) DEFAULT '',
`position` varchar(16) NOT NULL DEFAULT '',
`language` varchar(32) DEFAULT NULL,
`open_in_new_tab` tinyint DEFAULT '1',
`order` int DEFAULT '0',
`total_views` bigint unsigned DEFAULT '0',
`is_published` tinyint DEFAULT '1',
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`page_id`),
KEY `pages_pages_category_id_index` (`pages_category_id`),
KEY `pages_url_index` (`url`),
KEY `pages_is_published_index` (`is_published`),
KEY `pages_language_index` (`language`),
CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`pages_category_id`) REFERENCES `pages_categories` (`pages_category_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

INSERT INTO `pages` (`pages_category_id`, `url`, `title`, `description`, `content`, `type`, `position`, `order`, `total_views`, `datetime`, `last_datetime`) VALUES
(NULL, 'https://altumcode.com/', 'Software by AltumCode', '', '', 'external', 'bottom', 1, 0, NOW(), NOW()),
(NULL, 'https://altumco.de/66socialproof', 'Built with 66socialproof', '', '', 'external', 'bottom', 0, 0, NOW(), NOW());

-- SEPARATOR --

CREATE TABLE `blog_posts_categories` (
`blog_posts_category_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`url` varchar(256) NOT NULL,
`title` varchar(256) NOT NULL DEFAULT '',
`description` varchar(256) DEFAULT NULL,
`order` int NOT NULL DEFAULT '0',
`language` varchar(32) DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`blog_posts_category_id`),
KEY `url` (`url`),
KEY `blog_posts_categories_url_language_index` (`url`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- SEPARATOR --

CREATE TABLE `blog_posts` (
`blog_post_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`blog_posts_category_id` bigint unsigned DEFAULT NULL,
`url` varchar(256) NOT NULL,
`title` varchar(256) NOT NULL DEFAULT '',
`description` varchar(256) DEFAULT NULL,
`keywords` varchar(256) CHARACTER SET utf8mb4 DEFAULT NULL,
`image` varchar(40) CHARACTER SET utf8mb4 DEFAULT NULL,
`image_description` varchar(256) DEFAULT NULL,
`editor` varchar(16) DEFAULT NULL,
`content` longtext,
`language` varchar(32) DEFAULT NULL,
`total_views` bigint unsigned DEFAULT '0',
`average_rating` float unsigned NOT NULL DEFAULT '0',
`total_ratings` bigint unsigned NOT NULL DEFAULT '0',
`is_published` tinyint DEFAULT '1',
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`blog_post_id`),
KEY `blog_post_id_index` (`blog_post_id`),
KEY `blog_post_url_index` (`url`),
KEY `blog_posts_category_id` (`blog_posts_category_id`),
KEY `blog_posts_is_published_index` (`is_published`),
KEY `blog_posts_language_index` (`language`),
CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`blog_posts_category_id`) REFERENCES `blog_posts_categories` (`blog_posts_category_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `blog_posts_ratings` (
`id` bigint unsigned NOT NULL AUTO_INCREMENT,
`blog_post_id` bigint unsigned DEFAULT NULL,
`user_id` int DEFAULT NULL,
`ip_binary` varbinary(16) DEFAULT NULL,
`rating` tinyint(1) DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `blog_posts_ratings_blog_post_id_ip_binary_idx` (`blog_post_id`,`ip_binary`) USING BTREE,
KEY `user_id` (`user_id`),
CONSTRAINT `blog_posts_ratings_ibfk_1` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`blog_post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `blog_posts_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `track_conversions` (
`id` int NOT NULL AUTO_INCREMENT,
`user_id` int NOT NULL,
`notification_id` int NOT NULL,
`type` varchar(32) NOT NULL DEFAULT '',
`data` longtext NOT NULL,
`url` varchar(2048) DEFAULT NULL,
`page_title` varchar(64) DEFAULT NULL,
`location` varchar(512) DEFAULT NULL,
`datetime` datetime NOT NULL,
PRIMARY KEY (`id`),
KEY `notification_id` (`notification_id`),
KEY `track_conversions_date_index` (`datetime`),
CONSTRAINT `track_conversions_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- SEPARATOR --

CREATE TABLE `track_logs` (
`id` int NOT NULL AUTO_INCREMENT,
`user_id` int NOT NULL,
`domain` varchar(256) NOT NULL,
`url` varchar(2048) NOT NULL,
`ip_binary` varbinary(16) DEFAULT NULL,
`datetime` datetime NOT NULL,
PRIMARY KEY (`id`),
KEY `user_id` (`user_id`),
KEY `domain` (`domain`),
KEY `track_logs_ip_binary_index` (`ip_binary`),
CONSTRAINT `track_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ROW_FORMAT=DYNAMIC ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `track_notifications` (
`id` int NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`campaign_id` int DEFAULT NULL,
`notification_id` int NOT NULL,
`type` varchar(32) NOT NULL DEFAULT '',
`url` text NOT NULL,
`datetime` datetime NOT NULL,
PRIMARY KEY (`id`),
KEY `notification_id` (`notification_id`),
KEY `track_notifications_date_index` (`datetime`),
KEY `track_notifications_campaign_id_index` (`campaign_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `track_notifications_campaigns_campaign_id_fk` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `track_notifications_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`notification_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `track_notifications_users_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `broadcasts` (
`broadcast_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(64) DEFAULT NULL,
`subject` varchar(128) DEFAULT NULL,
`content` text,
`segment` varchar(64) DEFAULT NULL,
`settings` text COLLATE utf8mb4_unicode_ci,
`users_ids` longtext CHARACTER SET utf8mb4,
`sent_users_ids` longtext,
`sent_emails` int unsigned DEFAULT '0',
`total_emails` int unsigned DEFAULT '0',
`status` varchar(16) DEFAULT NULL,
`views` bigint unsigned DEFAULT '0',
`clicks` bigint unsigned DEFAULT '0',
`last_sent_email_datetime` datetime DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
`last_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`broadcast_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `broadcasts_statistics` (
`id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`broadcast_id` bigint unsigned DEFAULT NULL,
`type` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`target` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `broadcast_id` (`broadcast_id`),
KEY `broadcasts_statistics_user_id_broadcast_id_type_index` (`broadcast_id`,`user_id`,`type`),
CONSTRAINT `broadcasts_statistics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `broadcasts_statistics_ibfk_2` FOREIGN KEY (`broadcast_id`) REFERENCES `broadcasts` (`broadcast_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `internal_notifications` (
`internal_notification_id` bigint unsigned NOT NULL AUTO_INCREMENT,
`user_id` int DEFAULT NULL,
`for_who` varchar(16) DEFAULT NULL,
`from_who` varchar(16) DEFAULT NULL,
`icon` varchar(64) DEFAULT NULL,
`title` varchar(128) DEFAULT NULL,
`description` varchar(1024) DEFAULT NULL,
`url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`is_read` tinyint unsigned DEFAULT '0',
`datetime` datetime DEFAULT NULL,
`read_datetime` datetime DEFAULT NULL,
PRIMARY KEY (`internal_notification_id`),
KEY `user_id` (`user_id`),
KEY `users_notifications_for_who_idx` (`for_who`) USING BTREE,
CONSTRAINT `internal_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

CREATE TABLE `settings` (
`id` int NOT NULL AUTO_INCREMENT,
`key` varchar(64) NOT NULL DEFAULT '',
`value` longtext NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SEPARATOR --

SET @cron_key = MD5(RAND());

-- SEPARATOR --

INSERT INTO `settings` (`key`, `value`)
VALUES
('main', '{"title":"Maker","default_language":"english","default_theme_style":"light","default_timezone":"UTC","index_url":"","terms_and_conditions_url":"","privacy_policy_url":"","not_found_url":"","ai_scraping_is_allowed":true,"se_indexing":true,"display_index_plans":true,"display_index_testimonials":true,"display_index_faq":true,"display_index_latest_blog_posts":true,"default_results_per_page":100,"default_order_type":"DESC","auto_language_detection_is_enabled":true,"blog_is_enabled":false,"api_is_enabled":true,"theme_style_change_is_enabled":true,"logo_light":"","logo_dark":"","logo_email":"","opengraph":"","favicon":"","openai_api_key":"","openai_model":"gpt-4o","force_https_is_enabled":false,"broadcasts_statistics_is_enabled":true,"breadcrumbs_is_enabled":true,"display_pagination_when_no_pages":false,"chart_cache":12,"chart_days":30,   "maintenance_is_enabled": false,"admin_spotlight_is_enabled": false,"user_spotlight_is_enabled": false,"x_is_enabled": false,"google_chat_is_enabled": false,"internal_notification_is_enabled": false,"translations": {"english": {"name": "Free","description": "Basic plan","price": 0}}}'),
('languages', '{"english":{"status":"active"}}'),
('custom_images', '{}'),
('users', '{"email_confirmation":false,"welcome_email_is_enabled":false,"register_is_enabled":true,"register_only_social_logins":false,"register_social_login_require_password":false,"register_display_newsletter_checkbox":false,"login_rememberme_checkbox_is_checked":true,"login_rememberme_cookie_days":90,"auto_delete_unconfirmed_users":3,"auto_delete_inactive_users":30,"user_deletion_reminder":0,"blacklisted_domains":[],"blacklisted_countries":[],"login_lockout_is_enabled":true,"login_lockout_max_retries":3,"login_lockout_time":10,"lost_password_lockout_is_enabled":true,"lost_password_lockout_max_retries":3,"lost_password_lockout_time":10,"resend_activation_lockout_is_enabled":true,"resend_activation_lockout_max_retries":3,"resend_activation_lockout_time":10,"register_lockout_is_enabled":true,"register_lockout_max_registrations":3,"register_lockout_time":10}'),
('ads', '{"ad_blocker_detector_is_enabled":true,"ad_blocker_detector_lock_is_enabled":false,"ad_blocker_detector_delay":5,"header":"","footer":"","header_biolink":"","footer_biolink":"","header_splash":"","footer_splash":""}'),
('captcha', '{"type":"basic","recaptcha_public_key":"","recaptcha_private_key":"","login_is_enabled":0,"register_is_enabled":0,"lost_password_is_enabled":0,"resend_activation_is_enabled":0}'),
('cron', concat('{\"key\":\"', @cron_key, '\"}')),
('email_notifications', '{"emails":"","new_user":false,"delete_user":false,"new_payment":false,"new_domain":false,"new_affiliate_withdrawal":false,"contact":false}'),
('internal_notifications', '{"users_is_enabled":true,"admins_is_enabled":true,"new_user":true,"delete_user":true,"new_newsletter_subscriber":true,"new_payment":true,"new_affiliate_withdrawal":true}'),
('content', '{"blog_is_enabled":true,"blog_share_is_enabled":true,"blog_search_widget_is_enabled":false,"blog_categories_widget_is_enabled":true,"blog_popular_widget_is_enabled":true,"blog_views_is_enabled":true,"pages_is_enabled":true,"pages_share_is_enabled":true,"pages_popular_widget_is_enabled":true,"pages_views_is_enabled":true}'),
('sso', '{"is_enabled":true,"display_menu_items":true,"websites":{}}'),
('facebook', '{"is_enabled":false,"app_id":"","app_secret":""}'),
('google', '{"is_enabled":false,"client_id":"","client_secret":""}'),
('twitter', '{"is_enabled":false,"consumer_api_key":"","consumer_api_secret":""}'),
('discord', '{"is_enabled":false,"client_id":"","client_secret":""}'),
('linkedin', '{"is_enabled":false,"client_id":"","client_secret":""}'),
('microsoft', '{"is_enabled":false,"client_id":"","client_secret":""}'),
('plan_custom', '{"plan_id":"custom","name":"Custom","description":"Contact us for enterprise pricing.","price":"Custom","custom_button_url":"mailto:sample@example.com","color":null,"status":2,"settings":{}}'),
('plan_free', '{"plan_id":"free","name":"Free","days":null,"status":1,"settings":{"no_ads":false,"export": {"pdf": true,"csv": true,"json": true},"removable_branding":false,"custom_branding":false,"api_is_enabled":true,"affiliate_is_enabled":false,"campaigns_limit":5,"notifications_limit":25,"notifications_impressions_limit":100000,"enabled_notifications":{"INFORMATIONAL":true,"COUPON":true,"LIVE_COUNTER":true,"EMAIL_COLLECTOR":true,"LATEST_CONVERSION":true,"CONVERSIONS_COUNTER":true,"VIDEO":true,"SOCIAL_SHARE":true,"RANDOM_REVIEW":true,"EMOJI_FEEDBACK":true,"COOKIE_NOTIFICATION":true,"SCORE_FEEDBACK":true,"REQUEST_COLLECTOR":true,"COUNTDOWN_COLLECTOR":true,"INFORMATIONAL_BAR":true,"IMAGE":true,"COLLECTOR_BAR":true,"COUPON_BAR":true,"BUTTON_BAR":true,"COLLECTOR_MODAL":true,"COLLECTOR_TWO_MODAL":true,"BUTTON_MODAL":true,"TEXT_FEEDBACK":true,"ENGAGEMENT_LINKS":true}}}'),
('payment', '{"is_enabled":false,"type":"both","default_payment_frequency":"monthly","currencies":{"USD":{"code":"USD","symbol":"$","default_payment_processor":"offline_payment"}},"default_currency":"USD","codes_is_enabled":true,"taxes_and_billing_is_enabled":true,"invoice_is_enabled":true,"user_plan_expiry_reminder":0,"user_plan_expiry_checker_is_enabled":0,"currency_exchange_api_key":""}'),
('paypal', '{\"is_enabled\":\"0\",\"mode\":\"sandbox\",\"client_id\":\"\",\"secret\":\"\"}'),
('stripe', '{\"is_enabled\":\"0\",\"publishable_key\":\"\",\"secret_key\":\"\",\"webhook_secret\":\"\"}'),
('offline_payment', '{\"is_enabled\":\"0\",\"instructions\":\"Your offline payment instructions go here..\"}'),
('coinbase', '{"is_enabled":false,"api_key":"","webhook_secret":"","currencies":["USD"]}'),
('payu', '{"is_enabled":false,"mode":"sandbox","merchant_pos_id":"","signature_key":"","oauth_client_id":"","oauth_client_secret":"","currencies":["USD"]}'),
('iyzico', '{"is_enabled":false,"mode":"live","api_key":"","secret_key":"","currencies":["USD"]}'),
('paystack', '{"is_enabled":false,"public_key":"","secret_key":"","currencies":["USD"]}'),
('razorpay', '{"is_enabled":false,"key_id":"","key_secret":"","webhook_secret":"","currencies":["USD"]}'),
('mollie', '{"is_enabled":false,"api_key":""}'),
('yookassa', '{"is_enabled":false,"shop_id":"","secret_key":""}'),
('paddle', '{"is_enabled":false,"mode":"sandbox","vendor_id":"","api_key":"","public_key":"","currencies":["USD"]}'),
('crypto_com', '{"is_enabled":false,"publishable_key":"","secret_key":"","webhook_secret":""}'),
('mercadopago', '{"is_enabled":false,"access_token":"","currencies":["USD"]}'),
('midtrans', '{"is_enabled":false,"server_key":"","mode":"sandbox","currencies":["USD"]}'),
('flutterwave', '{"is_enabled":false,"secret_key":"","currencies":["USD"]}'),
('lemonsqueezy', '{"is_enabled":false,"api_key":"","signing_secret":"","store_id":"","one_time_monthly_variant_id":"","one_time_annual_variant_id":"","one_time_lifetime_variant_id":"","recurring_monthly_variant_id":"","recurring_annual_variant_id":"","currencies":["USD"]}'),
('myfatoorah', '{"is_enabled":1,"api_endpoint":"apitest.myfatoorah.com","api_key":"","secret_key":"","currencies":["KWD"]}'),
('smtp', '{"from_name":"AltumCode","from":"","reply_to_name":"","reply_to":"","cc":"","bcc":"","host":"","encryption":"tls","port":"","auth":0,"username":"","password":"","display_socials":false,"company_details":""}'),
('theme', '{"light_is_enabled": false, "dark_is_enabled": false}'),
('custom', '{"body_content":"","head_js":"","head_css":""}'),
('socials', '{"threads":"","youtube":"","facebook":"","x":"","instagram":"","tiktok":"","linkedin":"","whatsapp":"","email":""}'),
('announcements', '{"guests_is_enabled":0,"guests_id":"035cc337f6de075434bc24807b7ad9af","guests_content":"","guests_text_color":"#000000","guests_background_color":"#000000","users_is_enabled":0,"users_id":"035cc337f6de075434bc24807b7ad9af","users_content":"","users_text_color":"#000000","users_background_color":"#000000","translations":{"english":{"guests_content":"","users_content":""}}}'),
('business', '{\"invoice_is_enabled\":\"0\",\"name\":\"\",\"address\":\"\",\"city\":\"\",\"county\":\"\",\"zip\":\"\",\"country\":\"\",\"email\":\"\",\"phone\":\"\",\"tax_type\":\"\",\"tax_id\":\"\",\"custom_key_one\":\"\",\"custom_value_one\":\"\",\"custom_key_two\":\"\",\"custom_value_two\":\"\"}'),
('webhooks', '{"user_new":"","user_delete":"","payment_new":"","code_redeemed":"","contact":"","cron_start":"","cron_end":"","domain_new":"","domain_update":""}'),
('notifications', '{"branding":"Verified by 66socialproof","analytics_is_enabled":1,"pixel_cache":0,"domains_is_enabled":0,"domains_custom_main_ip":"","blacklisted_domains":[],"email_reports_is_enabled":"weekly","image_size_limit":2,"audio_size_limit":2}'),
('notification_handlers', '{"twilio_sid":"","twilio_token":"","twilio_number":"","whatsapp_number_id":"","whatsapp_access_token":"","email_is_enabled":true,"webhook_is_enabled":true,"slack_is_enabled":true,"discord_is_enabled":true,"telegram_is_enabled":true,"microsoft_teams_is_enabled":true,"twilio_is_enabled":false,"twilio_call_is_enabled":false,"whatsapp_is_enabled":false}'),
('cookie_consent', '{"is_enabled":false,"logging_is_enabled":false,"necessary_is_enabled":true,"analytics_is_enabled":true,"targeting_is_enabled":true,"layout":"bar","position_y":"middle","position_x":"center"}'),
('license', '{\"license\":\"\",\"type\":\"\"}'),
('product_info', '{\"version\":\"48.0.0\", \"code\":\"4800\"}');
