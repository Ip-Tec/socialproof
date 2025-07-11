<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 * 🌍 View all other existing AltumCode projects via https://altumcode.com/
 * 📧 Get in touch for support or general queries via https://altumcode.com/contact
 * 📤 Download the latest version via https://altumcode.com/downloads
 *
 * 🐦 X/Twitter: https://x.com/AltumCode
 * 📘 Facebook: https://facebook.com/altumcode
 * 📸 Instagram: https://instagram.com/altumcode
 */

namespace Altum\Controllers;

use Altum\Response;

defined('ALTUMCODE') || die();

class CampaignsAjax extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        if(!empty($_POST) && (\Altum\Csrf::check('token') || \Altum\Csrf::check('global_token')) && isset($_POST['request_type'])) {

            switch($_POST['request_type']) {

                /* Status toggle */
                case 'is_enabled_toggle': $this->is_enabled_toggle(); break;

                /* Custom Branding Set */
                case 'custom_branding': $this->custom_branding(); break;

                /* Create */
                case 'create': $this->create(); break;

                /* Update */
                case 'update': $this->update(); break;

            }

        }

        die();
    }

    private function is_enabled_toggle() {
        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Response::json('Please create an account on the demo to test out this function.', 'error');

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('update.campaigns')) {
            Response::json(l('global.info_message.team_no_access'), 'error');
        }

        $_POST['campaign_id'] = (int) $_POST['campaign_id'];

        /* Get the current status */
        $is_enabled = db()->where('campaign_id', $_POST['campaign_id'])->getValue('campaigns', 'is_enabled');

        /* Update data in database */
        db()->where('campaign_id', $_POST['campaign_id'])->where('user_id', $this->user->user_id)->update('campaigns', [
            'is_enabled' => (int) !$is_enabled,
        ]);

        /* Clear the cache */
        cache()->deleteItemsByTag('campaign_id=' . $_POST['campaign_id']);

        Response::json('', 'success');
    }

    private function custom_branding() {
        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Response::json('Please create an account on the demo to test out this function.', 'error');

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('update.campaigns')) {
            Response::json(l('global.info_message.team_no_access'), 'error');
        }

        $_POST['campaign_id'] = (int) $_POST['campaign_id'];
        $_POST['name'] = input_clean($_POST['name'], 128);
        $_POST['url'] = get_url($_POST['url']);

        /* Make sure the user has access to the custom branding method */
        if(!$this->user->plan_settings->custom_branding) {
            die();
        }

        /* Check for possible errors */
        if(!isset($_POST['name'], $_POST['url'])) {
            Response::json(l('global.error_message.empty_fields'), 'error');
        }

        $campaign_branding = json_encode([
            'name' => $_POST['name'],
            'url'   => $_POST['url']
        ]);

        /* Update data in database */
        db()->where('campaign_id', $_POST['campaign_id'])->where('user_id', $this->user->user_id)->update('campaigns', [
            'branding' => $campaign_branding,
        ]);

        /* Clear the cache */
        cache()->deleteItemsByTag('campaign_id=' . $_POST['campaign_id']);

        Response::json(l('global.success_message.update2'), 'success');
    }

    private function create() {
        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Response::json('Please create an account on the demo to test out this function.', 'error');

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('create.campaigns')) {
            Response::json(l('global.info_message.team_no_access'), 'error');
        }

        $_POST['name'] = input_clean($_POST['name'], 256);
        $_POST['email_reports_is_enabled'] = $this->user->plan_settings->email_reports_is_enabled ? (int) isset($_POST['email_reports_is_enabled']) : 0;

        $is_enabled = 1;

        /* Get available custom domains */
        $domain_id = null;
        if(isset($_POST['domain_id'])) {
            $domain = (new \Altum\Models\Domain())->get_domain_by_domain_id($_POST['domain_id']);

            if($domain && $domain->user_id == $this->user->user_id) {
                $domain_id = $domain->domain_id;
            }
        }

        /* Domain checking */
        $_POST['domain'] = mb_strtolower(input_clean($_POST['domain']));

        if(string_starts_with('http://', $_POST['domain']) || string_starts_with('https://', $_POST['domain'])) {
            if(function_exists('idn_to_utf8')) {
                $_POST['domain'] = parse_url(idn_to_utf8($_POST['domain']), PHP_URL_HOST);
            }
        } else {
            if(function_exists('idn_to_utf8')) {
                $_POST['domain'] = parse_url(idn_to_utf8('https://' . $_POST['domain']), PHP_URL_HOST);
            }
        }

        if(function_exists('idn_to_ascii')) {
            $_POST['domain'] = idn_to_ascii($_POST['domain']);
        }

        /* Check for possible errors */
        if(empty($_POST['name']) || empty($_POST['domain'])) {
            Response::json(l('global.error_message.empty_fields'), 'error');
        }

        if(in_array($_POST['domain'], settings()->notifications->blacklisted_domains)) {
            Response::json(l('campaigns.error_message.blacklisted_domain'), 'error');
        }

        /* Make sure that the user didn't exceed the limit */
        $account_total_campaigns = database()->query("SELECT COUNT(*) AS `total` FROM `campaigns` WHERE `user_id` = {$this->user->user_id}")->fetch_object()->total;
        if($this->user->plan_settings->campaigns_limit != -1 && $account_total_campaigns >= $this->user->plan_settings->campaigns_limit) {
            Response::json(l('global.info_message.plan_feature_limit'), 'error');
        }

        /* Generate a unique pixel key for the website */
        $pixel_key = string_generate(32);
        while(db()->where('pixel_key', $pixel_key)->getValue('campaigns', 'pixel_key')) {
            $pixel_key = string_generate(32);
        }

        /* Get available notification handlers */
        $notification_handlers = (new \Altum\Models\NotificationHandlers())->get_notification_handlers_by_user_id($this->user->user_id);

        /* Notification handlers */
        $_POST['email_reports'] = array_map(
            function($notification_handler_id) {
                return (int) $notification_handler_id;
            },
            array_filter($_POST['email_reports'] ?? [], function($notification_handler_id) use ($notification_handlers) {
                return array_key_exists($notification_handler_id, $notification_handlers);
            })
        );

        /* Insert to database */
        $campaign_id = db()->insert('campaigns', [
            'user_id' => $this->user->user_id,
            'domain_id' => $domain_id,
            'pixel_key' => $pixel_key,
            'name' => $_POST['name'],
            'domain' => $_POST['domain'],
            'branding' => json_encode([
                'name' => '',
                'url' => '',
            ]),
            'email_reports' => json_encode($_POST['email_reports']),
            'is_enabled' => $is_enabled,
            'datetime' => get_date(),
        ]);

        /* Clear the cache */
        cache()->deleteItemsByTag('campaign_id=' . $campaign_id);
        cache()->deleteItem('campaigns_total?user_id=' . $this->user->user_id);
        cache()->deleteItem('notifications_total?user_id=' . $this->user->user_id);

        /* Set a nice success message */
        Response::json(sprintf(l('global.success_message.create1'), '<strong>' . filter_var($_POST['name']) . '</strong>'), 'success', ['campaign_id' => $campaign_id]);

    }

    private function update() {
        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Response::json('Please create an account on the demo to test out this function.', 'error');

        /* Team checks */
        if(\Altum\Teams::is_delegated() && !\Altum\Teams::has_access('update.campaigns')) {
            Response::json(l('global.info_message.team_no_access'), 'error');
        }

        $_POST['campaign_id'] = (int) $_POST['campaign_id'];
        $_POST['name'] = input_clean($_POST['name'], 256);
        $_POST['email_reports_is_enabled'] = $this->user->plan_settings->email_reports_is_enabled ? (int) isset($_POST['email_reports_is_enabled']) : 0;

        /* Get available custom domains */
        $domain_id = null;
        if(isset($_POST['domain_id'])) {
            $domain = (new \Altum\Models\Domain())->get_domain_by_domain_id($_POST['domain_id']);

            if($domain && $domain->user_id == $this->user->user_id) {
                $domain_id = $domain->domain_id;
            }
        }

        /* Domain checking */
        $_POST['domain'] = mb_strtolower(input_clean($_POST['domain']));

        if(string_starts_with('http://', $_POST['domain']) || string_starts_with('https://', $_POST['domain'])) {
            if(function_exists('idn_to_utf8')) {
                $_POST['domain'] = parse_url(idn_to_utf8($_POST['domain']), PHP_URL_HOST);
            }
        } else {
            if(function_exists('idn_to_utf8')) {
                $_POST['domain'] = parse_url(idn_to_utf8('https://' . $_POST['domain']), PHP_URL_HOST);
            }
        }

        if(function_exists('idn_to_ascii')) {
            $_POST['domain'] = idn_to_ascii($_POST['domain']);
        }

        /* Check for possible errors */
        if(empty($_POST['name']) || empty($_POST['domain'])) {
            Response::json(l('global.error_message.empty_fields'), 'error');
        }

        if(in_array($_POST['domain'], settings()->notifications->blacklisted_domains)) {
            Response::json(l('campaigns.error_message.blacklisted_domain'), 'error');
        }

        /* Get available notification handlers */
        $notification_handlers = (new \Altum\Models\NotificationHandlers())->get_notification_handlers_by_user_id($this->user->user_id);

        /* Notification handlers */
        $_POST['email_reports'] = array_map(
            function($notification_handler_id) {
                return (int) $notification_handler_id;
            },
            array_filter($_POST['email_reports'] ?? [], function($notification_handler_id) use ($notification_handlers) {
                return array_key_exists($notification_handler_id, $notification_handlers);
            })
        );

        /* Insert to database */
        db()->where('campaign_id', $_POST['campaign_id'])->where('user_id', $this->user->user_id)->update('campaigns', [
            'domain_id' => $domain_id,
            'name' => $_POST['name'],
            'domain' => $_POST['domain'],
            'email_reports' => json_encode($_POST['email_reports']),
            'last_datetime' => get_date(),
        ]);

        /* Clear the cache */
        cache()->deleteItemsByTag('campaign_id=' . $_POST['campaign_id']);

        /* Set a nice success message */
        Response::json(sprintf(l('global.success_message.update1'), '<strong>' . filter_var($_POST['name']) . '</strong>'), 'success', ['campaign_id' => $_POST['campaign_id']]);
    }

}
