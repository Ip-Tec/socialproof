<?php defined('ALTUMCODE') || die() ?>


<?php ob_start() ?>
<?php if($notification->settings->custom_css && $user->plan_settings->custom_css_is_enabled): ?>
<style>
    <?= $notification->settings->custom_css ?>
</style>
<?php endif ?>

<?php $shadow_color = hex_to_rgb($notification->settings->shadow_color ?? '#000000'); ?>
<div id="<?= 'notification_' . $notification->notification_id ?>" role="dialog" class="altumcode-wrapper altumcode-wrapper-<?= $notification->settings->border_radius ?> <?= $notification->settings->shadow ? 'altumcode-wrapper-shadow-' . $notification->settings->shadow : null ?> <?= $notification->settings->hover_animation ? 'altumcode-wrapper-' . $notification->settings->hover_animation : null ?> <?= ($notification->settings->direction ?? 'ltr') == 'rtl' ? 'altumcode-rtl' : null ?> altumcode-score-feedback-wrapper" style='font-family: <?= $notification->settings->font ?? 'inherit' ?>!important;background-color: <?= $notification->settings->background_color ?>;border-width: <?= $notification->settings->border_width ?>px;border-color: <?= $notification->settings->border_color ?>;<?= $notification->settings->background_pattern_svg ? 'background-image: url("' . $notification->settings->background_pattern_svg . '")' : null ?>;padding: <?= $notification->settings->internal_padding ?? 12 ?>px !important;<?= $notification->settings->background_blur ? 'backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px);-webkit-backdrop-filter: blur(' . ($notification->settings->background_blur ?? 0). 'px)' : null ?>;--shadow-r: <?= $shadow_color['r'] ?>;--shadow-g: <?= $shadow_color['g'] ?>;--shadow-b: <?= $shadow_color['b'] ?>;'>
    <div class="altumcode-score-feedback-content">
        <div class="altumcode-score-feedback-header">
            <p class="altumcode-score-feedback-title" style="color: <?= $notification->settings->title_color ?>"><?= $notification->settings->title ?></p>

            <button class="altumcode-close" style="color: <?= $notification->settings->close_button_color ?>;<?= $notification->settings->display_close_button ? null : 'display: none;' ?>">×</button>
        </div>

        <div class="altumcode-score-feedback-scores">
            <button type="button" class="altumcode-score-feedback-button" data-score="1" style="background: <?= $notification->settings->button_background_color ?>;color: <?= $notification->settings->button_color ?>"><?= l('notification.score_feedback.feedback_score_1') ?></button>
            <button type="button" class="altumcode-score-feedback-button" data-score="2" style="background: <?= $notification->settings->button_background_color ?>;color: <?= $notification->settings->button_color ?>"><?= l('notification.score_feedback.feedback_score_2') ?></button>
            <button type="button" class="altumcode-score-feedback-button" data-score="3" style="background: <?= $notification->settings->button_background_color ?>;color: <?= $notification->settings->button_color ?>"><?= l('notification.score_feedback.feedback_score_3') ?></button>
            <button type="button" class="altumcode-score-feedback-button" data-score="4" style="background: <?= $notification->settings->button_background_color ?>;color: <?= $notification->settings->button_color ?>"><?= l('notification.score_feedback.feedback_score_4') ?></button>
            <button type="button" class="altumcode-score-feedback-button" data-score="5" style="background: <?= $notification->settings->button_background_color ?>;color: <?= $notification->settings->button_color ?>"><?= l('notification.score_feedback.feedback_score_5') ?></button>
        </div>

        <?php if($notification->settings->description): ?>
        <p class="altumcode-score-feedback-description" style="color: <?= $notification->settings->description_color ?>"><?= $notification->settings->description ?></p>
        <?php endif ?>

        <?php if(isset($notification->branding, $notification->branding->name, $notification->branding->url) && !empty($notification->branding->name) && !empty($notification->branding->url)): ?>
                <a href="<?= $notification->branding->url ?>" class="altumcode-site" style="display: <?= $notification->settings->display_branding ? 'inherit;' : 'none !important;' ?>"><?= $notification->branding->name ?></a>
            <?php else: ?>
                <a href="<?= url() ?>" class="altumcode-site" style="display: <?= $notification->settings->display_branding ? 'inherit;' : 'none !important;' ?>"><?= settings()->notifications->branding ?></a>
            <?php endif ?>
    </div>
</div>
<?php $html = ob_get_clean() ?>


<?php ob_start() ?>
<script>
new AltumCodeManager({
    should_show: !localStorage.getItem('notification_<?= $notification->notification_id ?>_converted'),
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

        /* On click event to the button */
        let scores = main_element.querySelectorAll('.altumcode-score-feedback-button');

        for(let score of scores) {
            score.addEventListener('click', event => {

                /* Trigger the animation */
                score.className += ' altumcode-score-feedback-button-clicked';

                /* Get all the other emojis and remove them */
                let other_scores = main_element.querySelectorAll('.altumcode-score-feedback-button:not(.altumcode-score-feedback-button-clicked)');
                for(let other_score of other_scores) {
                    other_score.remove();
                }

                let notification_id = main_element.getAttribute('data-notification-id');
                let feedback = score.getAttribute('data-score');

                send_tracking_data({
                    notification_id: notification_id,
                    type: 'notification',
                    subtype: 'click'
                });

                send_tracking_data({
                    notification_id: notification_id,
                    type: 'notification',
                    subtype: `feedback_score_${feedback}`
                });

                /* Make sure to let the browser know of the conversion so that it is not shown again */
                localStorage.setItem(`notification_${notification_id}_converted`, true);

                setTimeout(() => {
                    AltumCodeManager.remove_notification(main_element);
                }, 950);

                /* Redirect the user to thank you url if needed */
                let thank_you_url = <?= json_encode($notification->settings->thank_you_url) ?>;

                if(thank_you_url.trim() != '') {
                    setTimeout(() => {
                        window.location.href = thank_you_url;
                    }, 350);
                }

            });
        }


    }
});
</script>
<?php $javascript = ob_get_clean(); ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
