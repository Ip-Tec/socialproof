<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<?php if($notification->settings->custom_css && $user->plan_settings->custom_css_is_enabled): ?>
<style>
    <?= $notification->settings->custom_css ?>
</style>
<?php endif ?>

<?php $shadow_color = hex_to_rgb($notification->settings->shadow_color ?? '#000000'); ?>
<div id="<?= 'notification_' . $notification->notification_id ?>" role="dialog" class="altumcode-wrapper altumcode-wrapper-<?= $notification->settings->border_radius ?> <?= $notification->settings->shadow ? 'altumcode-wrapper-shadow-' . $notification->settings->shadow : null ?> <?= $notification->settings->hover_animation ? 'altumcode-wrapper-' . $notification->settings->hover_animation : null ?> <?= ($notification->settings->direction ?? 'ltr') == 'rtl' ? 'altumcode-rtl' : null ?> altumcode-video-wrapper" style='font-family: <?= $notification->settings->font ?? 'inherit' ?>!important;background-color: <?= $notification->settings->background_color ?>;border-width: <?= $notification->settings->border_width ?>px;border-color: <?= $notification->settings->border_color ?>;<?= $notification->settings->background_pattern_svg ? 'background-image: url("' . $notification->settings->background_pattern_svg . '")' : null ?>;padding: <?= $notification->settings->internal_padding ?? 12 ?>px !important;<?= $notification->settings->background_blur ? 'backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px);-webkit-backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px)' : null ?>;--shadow-r: <?= $shadow_color['r'] ?>;--shadow-g: <?= $shadow_color['g'] ?>;--shadow-b: <?= $shadow_color['b'] ?>;'>
    <div class="altumcode-video-content">
        <div class="altumcode-video-header">
            <p class="altumcode-video-title" style="color: <?= $notification->settings->title_color ?>"><?= $notification->settings->title ?></p>

            <button class="altumcode-close" style="color: <?= $notification->settings->close_button_color ?>;<?= $notification->settings->display_close_button ? null : 'display: none;' ?>">×</button>
        </div>

        <?php if(!empty($notification->settings->video)): ?>

            <?php if($notification->settings->video_is_youtube): ?>
                <div class="altumcode-video-video-container">
                    <iframe class="altumcode-video-video-iframe"
                            src="<?= $notification->settings->video  ?>?controls=<?= (int) $notification->settings->video_controls ?>&autoplay=<?= (int) $notification->settings->video_autoplay ?>&loop=<?= (int) $notification->settings->video_loop ?>&mute=<?= (int) $notification->settings->video_muted ?>&playlist=<?= $notification->settings->youtube_video_id ?>"
                            frameborder="0"
                            allow="<?= $notification->settings->video_controls ? 'controls;' : null ?><?= $notification->settings->video_autoplay ? 'autoplay;' : null ?>accelerometer; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            <?php elseif($notification->settings->video_is_vimeo): ?>
                <div class="altumcode-video-video-container">
                    <iframe class="altumcode-video-video-iframe"
                            src="<?= $notification->settings->video ?>?autoplay=<?= (int) $notification->settings->video_autoplay ?>&loop=<?= (int) $notification->settings->video_loop ?>&muted=<?= (int) $notification->settings->video_muted ?>"
                            frameborder="0"
                            allow="<?= $notification->settings->video_autoplay ? 'autoplay;' : null ?>fullscreen; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            <?php else: ?>
                <div class="altumcode-video-video-container">
                    <video class="altumcode-video-video-iframe"
                           src="<?= $notification->settings->video ?>"
                        <?= $notification->settings->video_controls ? 'controls' : null ?>
                        <?= $notification->settings->video_autoplay ? 'autoplay' : null ?>
                        <?= $notification->settings->video_loop ? 'loop' : null ?>
                        <?= $notification->settings->video_muted ? 'muted' : null ?>>
                    </video>
                </div>
            <?php endif ?>

        <?php else: ?>
            <img src="<?= l('notification.video.thumbnail_default') ?>" class="altumcode-video-video-iframe" loading="lazy" referrerpolicy="no-referrer" />
        <?php endif ?>

        <a href="<?= $notification->settings->button_url ?>" class="altumcode-video-button" <?= $notification->settings->url_new_tab ? 'target="_blank"' : null ?> style="background: <?= $notification->settings->button_background_color ?>;color: <?= $notification->settings->button_color ?>;<?= empty($notification->settings->button_text) ? 'display: none!important;' : null ?>"><?= $notification->settings->button_text ?></a>

        <?php if(isset($notification->branding, $notification->branding->name, $notification->branding->url) && !empty($notification->branding->name) && !empty($notification->branding->url)): ?>
                <a href="<?= $notification->branding->url ?>" class="altumcode-site" style="display: <?= $notification->settings->display_branding ? 'inherit;' : 'none !important;' ?>"><?= $notification->branding->name ?></a>
            <?php else: ?>
                <a href="<?= url() ?>" class="altumcode-site" style="display: <?= $notification->settings->display_branding ? 'inherit;' : 'none !important;' ?>"><?= settings()->notifications->branding ?></a>
            <?php endif ?>
    </div>
</div>
<?php $html = ob_get_clean(); ?>


<?php ob_start() ?>
<script>
new AltumCodeManager({
    content: <?= json_encode($html) ?>,
    display_mobile: <?= json_encode($notification->settings->display_mobile) ?>,
    display_desktop: <?= json_encode($notification->settings->display_desktop) ?>,
    display_trigger: <?= json_encode($notification->settings->display_trigger) ?>,
    display_trigger_value: <?= json_encode($notification->settings->display_trigger_value) ?>,
    display_delay_type_after_close: <?= json_encode($notification->settings->display_delay_type_after_close) ?>,
    display_delay_value_after_close: <?= json_encode($notification->settings->display_delay_value_after_close) ?>,
    duration: <?= $notification->settings->display_duration === -1 ? -1 : $notification->settings->display_duration * 1000 ?>,
    url: '',
    url_new_tab: <?= json_encode($notification->settings->url_new_tab) ?>,
    close: <?= json_encode($notification->settings->display_close_button) ?>,
    display_frequency: <?= json_encode($notification->settings->display_frequency) ?>,
    position: <?= json_encode($notification->settings->display_position) ?>,
    trigger_all_pages: <?= json_encode($notification->settings->trigger_all_pages) ?>,
    triggers: <?= json_encode($notification->settings->triggers) ?>,
    on_animation: <?= json_encode($notification->settings->on_animation) ?>,
    off_animation: <?= json_encode($notification->settings->off_animation) ?>,
    animation: <?= json_encode($notification->settings->animation) ?>,
    animation_interval: <?= (int) $notification->settings->animation_interval ?>,

    notification_id: <?= $notification->notification_id ?>
}).initiate({
    displayed: main_element => {

        /* On click event to the button */
        main_element.querySelector('.altumcode-video-button').addEventListener('click', event => {

            let notification_id = main_element.getAttribute('data-notification-id');

            send_tracking_data({
                notification_id: notification_id,
                type: 'notification',
                subtype: 'click'
            });

        });

    }
});
</script>
<?php $javascript = ob_get_clean(); ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
