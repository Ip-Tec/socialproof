<?php defined('ALTUMCODE') || die() ?>
<script>
(() => {
    let pixel_url_base = <?= json_encode(SITE_URL) ?>;
    let pixel_title = <?= json_encode(settings()->main->title) ?>;
    let pixel_key = <?= json_encode($data->pixel_key) ?>;
    let pixel_analytics = <?= json_encode((bool) settings()->notifications->analytics_is_enabled) ?>;
    let pixel_css_loaded = false;
    let campaign_domain = <?= json_encode($data->campaign->domain) ?>;
    if(campaign_domain.startsWith('www.')) {
        campaign_domain = campaign_domain.replace('www.', '');
    }

    /* Make sure the campaign loads only where expected */
    if(
        window.location.hostname !== campaign_domain && window.location.hostname !== `www.${campaign_domain}`
    ) {
        console.log(`${pixel_title} (${pixel_url_base}): Campaign does not match the set domain/subdomain.`);
        return;
    }

    /* Make sure to include the external css file */
    let link = document.createElement('link');
    link.href = '<?= ASSETS_FULL_URL . 'css/pixel.min.css' ?>';
    link.type = 'text/css';
    link.rel = 'stylesheet';
    link.media = 'screen,print';
    link.onload = function() { pixel_css_loaded = true };
    document.getElementsByTagName('head')[0].appendChild(link);

    /* Pixel header including all the needed code */
    <?php require_once ASSETS_PATH . 'js/pixel/pixel-header.js' ?>

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

foreach($data->notifications as $notification) {

        echo \Altum\Notification::get($notification->type, $notification, $data->user)->javascript;

    }
    ?>

    /* Send basic tracking data */
    send_tracking_data({type: 'track'});
})();
</script>
