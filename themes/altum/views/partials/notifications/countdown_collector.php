<?php defined('ALTUMCODE') || die() ?>


<?php ob_start() ?>
<?php $date_ended = new \DateTime($notification->settings->countdown_end_date ?? '') < new \DateTime() ?>
<?php $date = (new \DateTime($notification->settings->countdown_end_date ?? ''))->diff(new \DateTime()) ?>
<?php if($notification->settings->custom_css && $user->plan_settings->custom_css_is_enabled): ?>
<style>
    <?= $notification->settings->custom_css ?>
</style>
<?php endif ?>

<?php $shadow_color = hex_to_rgb($notification->settings->shadow_color ?? '#000000'); ?>
<div id="<?= 'notification_' . $notification->notification_id ?>" role="dialog" class="altumcode-wrapper altumcode-wrapper-<?= $notification->settings->border_radius ?> <?= $notification->settings->shadow ? 'altumcode-wrapper-shadow-' . $notification->settings->shadow : null ?> <?= $notification->settings->hover_animation ? 'altumcode-wrapper-' . $notification->settings->hover_animation : null ?> <?= ($notification->settings->direction ?? 'ltr') == 'rtl' ? 'altumcode-rtl' : null ?> altumcode-countdown-collector-wrapper" style='font-family: <?= $notification->settings->font ?? 'inherit' ?>!important;background-color: <?= $notification->settings->background_color ?>;border-width: <?= $notification->settings->border_width ?>px;border-color: <?= $notification->settings->border_color ?>;<?= $notification->settings->background_pattern_svg ? 'background-image: url("' . $notification->settings->background_pattern_svg . '")' : null ?>;padding: <?= $notification->settings->internal_padding ?? 12 ?>px !important;<?= $notification->settings->background_blur ? 'backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px);-webkit-backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px)' : null ?>;--shadow-r: <?= $shadow_color['r'] ?>;--shadow-g: <?= $shadow_color['g'] ?>;--shadow-b: <?= $shadow_color['b'] ?>;'>
    <div class="altumcode-countdown-collector-content">
        <div class="altumcode-countdown-collector-header">
            <p class="altumcode-countdown-collector-title" style="color: <?= $notification->settings->title_color ?>"><?= $notification->settings->title ?></p>

            <button class="altumcode-close" style="color: <?= $notification->settings->close_button_color ?>;<?= $notification->settings->display_close_button ? null : 'display: none;' ?>">×</button>
        </div>
        <p class="altumcode-countdown-collector-description" style="color: <?= $notification->settings->description_color ?>"><?= $notification->settings->description ?></p>

        <p class="altumcode-countdown-collector-content-title" style="color: <?= $notification->settings->content_title_color ?>"><?= $notification->settings->content_title ?></p>

        <div class="altumcode-countdown-collector-timer">
            <input type="hidden" name="countdown_end_date" value="<?= (new \DateTime($notification->settings->countdown_end_date))->getTimestamp() ?>" />

            <div class="altumcode-countdown-collector-timer-block">
                <div class="altumcode-countdown-collector-time" style="color: <?= $notification->settings->time_color ?>;background: <?= $notification->settings->time_background_color ?>" data-type="days"><?= $date_ended ? '0' : $date->format('%a') ?></div>
                <p class="altumcode-countdown-collector-time-text"><?= l('notification.countdown_collector.days') ?></p>
            </div>

            <div class="altumcode-countdown-collector-timer-block">
                <div class="altumcode-countdown-collector-time" style="color: <?= $notification->settings->time_color ?>;background: <?= $notification->settings->time_background_color ?>" data-type="hours"><?= $date_ended ? '0' : $date->format('%h') ?></div>
                <p class="altumcode-countdown-collector-time-text"><?= l('notification.countdown_collector.hours') ?></p>
            </div>

            <div class="altumcode-countdown-collector-timer-block">
                <div class="altumcode-countdown-collector-time" style="color: <?= $notification->settings->time_color ?>;background: <?= $notification->settings->time_background_color ?>" data-type="minutes"><?= $date_ended ? '0' : $date->format('%i') ?></div>
                <p class="altumcode-countdown-collector-time-text"><?= l('notification.countdown_collector.minutes') ?></p>
            </div>

            <div class="altumcode-countdown-collector-timer-block">
                <div class="altumcode-countdown-collector-time" style="color: <?= $notification->settings->time_color ?>;background: <?= $notification->settings->time_background_color ?>" data-type="seconds"><?= $date_ended ? '0' : $date->format('%s') ?></div>
                <p class="altumcode-countdown-collector-time-text"><?= l('notification.countdown_collector.seconds') ?></p>
            </div>
        </div>

        <div>
            <form class="altumcode-countdown-collector-form" id="altumcode-countdown-collector-form" name="" action="" method="POST" role="form">
                <div class="altumcode-countdown-collector-row">
                    <input type="text" class="" name="input" placeholder="<?= $notification->settings->input_placeholder ?>" aria-label="<?= $notification->settings->input_placeholder ?>" required="required" />

                    <button type="submit" name="button" style="color: <?= $notification->settings->button_color ?>; background: <?= $notification->settings->button_background_color ?>"><?= $notification->settings->button_text ?></button>
                </div>

                <?php if($notification->settings->show_agreement): ?>
                    <div class="altumcode-agreement-checkbox">
                        <input type="checkbox" id="<?= 'notification_' . $notification->notification_id ?>" class="altumcode-agreement-checkbox-input" name="agreement" required="required" />
                        <label for="<?= 'notification_' . $notification->notification_id ?>" class="altumcode-agreement-checkbox-text" style="color: <?= $notification->settings->description_color ?>">
                            <?= $notification->settings->agreement_text ?>
                        </label>

                        <a href="<?= $notification->settings->agreement_url ?>" target="_blank">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.293 9.707A1 1 0 0 0 22 9V3a1 1 0 0 0-1-1h-6a1 1 0 0 0-.707 1.707l1.94 1.94-6.647 6.646a1 1 0 0 0 0 1.414l.707.707a1 1 0 0 0 1.414 0l6.647-6.646z" fill="#000"/><path d="M4.5 8a.5.5 0 0 1 .5-.5h5.063a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H5A3.5 3.5 0 0 0 1.5 8v11A3.5 3.5 0 0 0 5 22.5h11a3.5 3.5 0 0 0 3.5-3.5v-5.062a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1V19a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5z" fill="<?= $notification->settings->title_color ?>"/></svg>
                        </a>
                    </div>
                <?php endif ?>
            </form>

            <?php if(isset($notification->branding, $notification->branding->name, $notification->branding->url) && !empty($notification->branding->name) && !empty($notification->branding->url)): ?>
                <a href="<?= $notification->branding->url ?>" class="altumcode-site" style="display: <?= $notification->settings->display_branding ? 'inherit;' : 'none !important;' ?>"><?= $notification->branding->name ?></a>
            <?php else: ?>
                <a href="<?= url() ?>" class="altumcode-site" style="display: <?= $notification->settings->display_branding ? 'inherit;' : 'none !important;' ?>"><?= settings()->notifications->branding ?></a>
            <?php endif ?>
        </div>
    </div>
</div>
<?php $html = ob_get_clean() ?>


<?php ob_start() ?>
<script>
new AltumCodeManager({
    should_show: <?= json_encode(!$date_ended) ?>,
    content: <?= json_encode($html) ?>,
    display_mobile: <?= json_encode($notification->settings->display_mobile) ?>,
    display_desktop: <?= json_encode($notification->settings->display_desktop) ?>,
    display_trigger: <?= json_encode($notification->settings->display_trigger) ?>,
    display_trigger_value: <?= json_encode($notification->settings->display_trigger_value) ?>,
    display_delay_type_after_close: <?= json_encode($notification->settings->display_delay_type_after_close) ?>,
    display_delay_value_after_close: <?= json_encode($notification->settings->display_delay_value_after_close) ?>,
    duration: <?= $notification->settings->display_duration === -1 ? -1 : $notification->settings->display_duration * 1000 ?>,
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

        /* Countdown */
        let countdown_end_date = new Date(main_element.querySelector('[name="countdown_end_date"]').value);

        let countdown = () => {
            let days_element = main_element.querySelector('[data-type="days"]');
            let hours_element = main_element.querySelector('[data-type="hours"]');
            let minutes_element = main_element.querySelector('[data-type="minutes"]');
            let seconds_element = main_element.querySelector('[data-type="seconds"]');

            let days = parseInt(days_element.innerText);
            let hours = parseInt(hours_element.innerText);
            let minutes = parseInt(minutes_element.innerText);
            let seconds = parseInt(seconds_element.innerText);

            let new_days = days;
            let new_hours = hours;
            let new_minutes = minutes;
            let new_seconds = seconds - 1;

            if(new_seconds < 0 && new_minutes > 0) {
                new_seconds = 60;
                new_minutes--;

                if(new_minutes < 0 && new_hours > 0) {
                    new_minutes = 60;
                    new_hours--;

                    if(new_hours < 0 && new_days > 0) {
                        new_hours = 60;
                        new_days--;

                        if(new_days < 0) {
                            new_days = 0;
                        }
                    }
                }
            }

            /* Check if the timer is up */
            if(days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
                clearInterval(countdown_interval);

                AltumCodeManager.remove_notification(main_element);
            }

            /* Set the new values */
            days_element.innerText = new_days;
            hours_element.innerText = new_hours;
            minutes_element.innerText = new_minutes;
            seconds_element.innerText = new_seconds;
        };

        let countdown_interval = setInterval(countdown, 1000);

        /* Form submission */
        main_element.querySelector('#altumcode-countdown-collector-form').addEventListener('submit', event => {

            let input = event.currentTarget.querySelector('[name="input"]').value;
            let notification_id = main_element.getAttribute('data-notification-id');


            if(input.trim() != '') {

                /* Data collection from the form */
                send_tracking_data({
                    notification_id: notification_id,
                    type: 'collector',
                    page_title: document.title,
                    input
                });

                AltumCodeManager.remove_notification(main_element);

                /* Make sure to let the browser know of the conversion so that it is not shown again */
                localStorage.setItem('notification_<?= $notification->notification_id ?>_converted', true);

                /* Redirect the user to thank you url if needed */
                let thank_you_url = <?= json_encode($notification->settings->thank_you_url) ?>;

                if(thank_you_url.trim() != '') {
                    setTimeout(() => {
                        window.location.href = thank_you_url;
                    }, 350);
                }

            }

            event.preventDefault();
        });

    }
});
</script>
<?php $javascript = ob_get_clean(); ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
