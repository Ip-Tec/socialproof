<?php defined('ALTUMCODE') || die() ?>


<?php ob_start() ?>
<?php if($notification->settings->custom_css && $user->plan_settings->custom_css_is_enabled): ?>
<style>
    <?= $notification->settings->custom_css ?>
</style>
<?php endif ?>

<?php $shadow_color = hex_to_rgb($notification->settings->shadow_color ?? '#000000'); ?>
<div id="<?= 'notification_' . $notification->notification_id ?>" role="dialog" class="altumcode-wrapper altumcode-wrapper-<?= $notification->settings->border_radius ?> <?= $notification->settings->shadow ? 'altumcode-wrapper-shadow-' . $notification->settings->shadow : null ?> <?= $notification->settings->hover_animation ? 'altumcode-wrapper-' . $notification->settings->hover_animation : null ?> <?= ($notification->settings->direction ?? 'ltr') == 'rtl' ? 'altumcode-rtl' : null ?> altumcode-live-counter-wrapper" style='font-family: <?= $notification->settings->font ?? 'inherit' ?>!important;background-color: <?= $notification->settings->background_color ?>;border-width: <?= $notification->settings->border_width ?>px;border-color: <?= $notification->settings->border_color ?>;<?= $notification->settings->background_pattern_svg ? 'background-image: url("' . $notification->settings->background_pattern_svg . '")' : null ?>;padding: <?= $notification->settings->internal_padding ?? 12 ?>px !important;<?= $notification->settings->background_blur ? 'backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px);-webkit-backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px)' : null ?>;--shadow-r: <?= $shadow_color['r'] ?>;--shadow-g: <?= $shadow_color['g'] ?>;--shadow-b: <?= $shadow_color['b'] ?>;'>
    <div class="altumcode-live-counter-content">

        <div class="altumcode-live-counter-header">
            <div class="altumcode-live-counter-main">
                <div class="altumcode-toast-pulse-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64">
                        <g id="graph" fill="<?= $notification->settings->pulse_background_color ?>" fill-rule="evenodd" transform="translate(1 1)">
                            <circle cx="32" cy="32" r="6"/>
                            <circle cx="32" cy="32" r="6" opacity="0">
                                <animate attributeName="r" begin="0s" dur="2s" values="6;32" calcMode="linear" repeatCount="indefinite"/>
                                <animate attributeName="opacity" begin="0s" dur="2s" values="1;0" calcMode="linear" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="32" cy="32" r="6" opacity="0">
                                <animate attributeName="r" begin="1s" dur="2s" values="6;32" calcMode="linear" repeatCount="indefinite"/>
                                <animate attributeName="opacity" begin="1s" dur="2s" values="1;0" calcMode="linear" repeatCount="indefinite"/>
                            </circle>
                        </g>
                    </svg>
                </div>

                <div class="altumcode-live-counter-number" style="background: <?= $notification->settings->number_background_color ?>; color: <?= $notification->settings->number_color ?>">
                    <?= isset($notification->counter) && $notification->counter >= $notification->settings->display_minimum_activity ? $notification->counter : l('notification.live_counter.number_default') ?>
                </div>
            </div>

            <div class="altumcode-live-counter-close">
                <button class="altumcode-close" style="color: <?= $notification->settings->close_button_color ?>;<?= $notification->settings->display_close_button ? null : 'display: none;' ?>">×</button>
            </div>
        </div>

        <p class="altumcode-live-counter-description" style="color: <?= $notification->settings->description_color ?>"><?= $notification->settings->description ?></p>

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
    should_show: <?= json_encode(isset($notification->counter) && $notification->counter >= $notification->settings->display_minimum_activity) ?>,
    content: <?= json_encode($html) ?>,
    display_mobile: <?= json_encode($notification->settings->display_mobile) ?>,
    display_desktop: <?= json_encode($notification->settings->display_desktop) ?>,
    display_trigger: <?= json_encode($notification->settings->display_trigger) ?>,
    display_trigger_value: <?= json_encode($notification->settings->display_trigger_value) ?>,
    display_delay_type_after_close: <?= json_encode($notification->settings->display_delay_type_after_close) ?>,
    display_delay_value_after_close: <?= json_encode($notification->settings->display_delay_value_after_close) ?>,
    duration: <?= $notification->settings->display_duration === -1 ? -1 : $notification->settings->display_duration * 1000 ?>,
    url: <?= json_encode($notification->settings->url) ?>,
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
}).initiate();
</script>
<?php $javascript = ob_get_clean(); ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
