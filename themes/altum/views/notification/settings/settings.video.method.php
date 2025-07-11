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

defined('ALTUMCODE') || die();

/* Create the content for each tab */
$html = [];

/* Extra Javascript needed */
$javascript = '';
?>

<?php /* Basic Tab */ ?>
<?php ob_start() ?>
    <div class="form-group">
        <label for="settings_name"><i class="fas fa-fw fa-sm fa-signature text-muted mr-1"></i> <?= l('notification.settings.name') ?></label>
        <input type="text" id="settings_name" name="name" class="form-control" value="<?= $data->notification->name ?>" maxlength="256" required="required" />
    </div>

    <div class="form-group">
        <label for="settings_title"><i class="fas fa-fw fa-sm fa-heading text-muted mr-1"></i> <?= l('notification.settings.title') ?></label>
        <input type="text" id="settings_title" name="title" class="form-control" value="<?= e($data->notification->settings->title) ?>" maxlength="256" />
    <small class="form-text text-muted" data-toggle="tooltip" title="<?= l('notification.settings.html_info_tooltip') ?>"><?= l('notification.settings.html_info') ?></small>
    </div>

    <div class="form-group">
        <label for="settings_video"><i class="fas fa-fw fa-sm fa-film text-muted mr-1"></i> <?= l('notification.settings.video') ?></label>
        <input type="url" id="settings_video" name="video" class="form-control" value="<?= $data->notification->settings->video ?>" />
        <small class="form-text text-muted"><?= l('notification.settings.video_help') ?></small>
    </div>

    <div class="form-group custom-control custom-switch">
        <input
                type="checkbox"
                class="custom-control-input"
                id="settings_video_autoplay"
                name="video_autoplay"
            <?= $data->notification->settings->video_autoplay ? 'checked="checked"' : null ?>
        >
        <label class="custom-control-label" for="settings_video_autoplay"><?= l('notification.settings.video_autoplay') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input
                type="checkbox"
                class="custom-control-input"
                id="settings_video_controls"
                name="video_controls"
            <?= $data->notification->settings->video_controls ? 'checked="checked"' : null ?>
        >
        <label class="custom-control-label" for="settings_video_controls"><?= l('notification.settings.video_controls') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input
                type="checkbox"
                class="custom-control-input"
                id="settings_video_loop"
                name="video_loop"
            <?= $data->notification->settings->video_loop ? 'checked="checked"' : null ?>
        >
        <label class="custom-control-label" for="settings_video_loop"><?= l('notification.settings.video_loop') ?></label>
    </div>

    <div class="form-group custom-control custom-switch">
        <input
                type="checkbox"
                class="custom-control-input"
                id="settings_video_muted"
                name="video_muted"
            <?= $data->notification->settings->video_muted ? 'checked="checked"' : null ?>
        >
        <label class="custom-control-label" for="settings_video_muted"><?= l('notification.settings.video_muted') ?></label>
    </div>

    <div class="form-group">
        <label for="settings_button_url"><i class="fas fa-fw fa-sm fa-link text-muted mr-1"></i> <?= l('notification.settings.button_url') ?></label>
        <input type="url" id="settings_button_url" name="button_url" class="form-control" value="<?= $data->notification->settings->button_url ?>" placeholder="<?= l('global.url_placeholder') ?>" maxlength="2048" />
    </div>

    <div class="form-group">
        <label for="settings_button_text"><i class="fas fa-fw fa-sm fa-quote-left text-muted mr-1"></i> <?= l('notification.settings.button_text') ?></label>
        <input type="text" id="settings_button_text" name="button_text" class="form-control" value="<?= e($data->notification->settings->button_text) ?>" maxlength="128" />
    <small class="form-text text-muted" data-toggle="tooltip" title="<?= l('notification.settings.html_info_tooltip') ?>"><?= l('notification.settings.html_info') ?></small>
        <small class="form-text text-muted"><?= l('notification.settings.button_text_help') ?></small>
    </div>

    <div class="form-group custom-control custom-switch">
        <input
                type="checkbox"
                class="custom-control-input"
                id="settings_url_new_tab"
                name="url_new_tab"
            <?= $data->notification->settings->url_new_tab ? 'checked="checked"' : null ?>
        >

        <label class="custom-control-label" for="settings_url_new_tab"><?= l('notification.settings.url_new_tab') ?></label>

        <div>
            <small class="form-text text-muted"><?= l('notification.settings.url_new_tab_help') ?></small>
        </div>
    </div>
<?php $html['basic'] = ob_get_clean() ?>


<?php /* Customize Tab */ ?>
<?php ob_start() ?>
    <div class="form-group">
        <label for="settings_title_color"><?= l('notification.settings.title_color') ?></label>
        <input type="hidden" id="settings_title_color" name="title_color" class="form-control" value="<?= $data->notification->settings->title_color ?>" />
        <div id="settings_title_color_pickr"></div>
    </div>

    <div class="form-group">
        <label for="settings_background_color"><?= l('notification.settings.background_color') ?></label>
        <input type="hidden" id="settings_background_color" name="background_color" class="form-control" value="<?= $data->notification->settings->background_color ?>" />
        <div id="settings_background_color_pickr"></div>
    </div>

    <div class="form-group">
        <label for="settings_background_pattern"><?= l('notification.settings.background_pattern') ?></label>
        <div class="row btn-group-toggle" data-toggle="buttons">
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= $data->notification->settings->background_pattern == '' ? 'active"' : null?>">
                    <input type="radio" name="background_pattern" value="" class="custom-control-input" <?= $data->notification->settings->background_pattern == '' ? 'checked="checked"' : null?> />
                    <?= l('global.none') ?>
                </label>
            </div>

            <?php foreach(get_notifications_background_patterns() as $key => $value): ?>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= $data->notification->settings->background_pattern == $key ? 'active' : null?>" style="background-image: url(<?= $value ?>);">
                    <input type="radio" name="background_pattern" value="<?= $key ?>" class="custom-control-input" <?= $data->notification->settings->background_pattern == $key ? 'checked="checked"' : null?> data-value="<?= $value ?>" />
                    <?= l('notification.settings.background_pattern_' . $key) ?>
                </label>
            </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="form-group">
        <label for="settings_button_background_color"><?= l('notification.settings.button_background_color') ?></label>
        <input type="hidden" id="settings_button_background_color" name="button_background_color" class="form-control" value="<?= $data->notification->settings->button_background_color ?>" />
        <div id="settings_button_background_color_pickr"></div>
    </div>

    <div class="form-group">
        <label for="settings_button_color"><?= l('notification.settings.button_color') ?></label>
        <input type="hidden" id="settings_button_color" name="button_color" class="form-control" value="<?= $data->notification->settings->button_color ?>" />
        <div id="settings_button_color_pickr"></div>
    </div>

<div class="form-group">
        <label for="settings_close_button_color"><?= l('notification.settings.close_button_color') ?></label>
        <input type="hidden" id="settings_close_button_color" name="close_button_color" class="form-control" value="<?= $data->notification->settings->close_button_color ?>" />
        <div id="settings_close_button_color_pickr"></div>
    </div>

<div class="form-group" data-range-counter data-range-counter-suffix="px">
    <label for="settings_internal_padding"><i class="fas fa-fw fa-expand-arrows-alt fa-sm text-muted mr-1"></i> <?= l('notification.settings.internal_padding') ?></label>
    <input type="range" min="5" max="25" id="settings_internal_padding" name="internal_padding" class="form-control-range" value="<?= $data->notification->settings->internal_padding ?>" />
</div>

<div class="form-group" data-range-counter data-range-counter-suffix="px">
    <label for="background_blur"><i class="fas fa-fw fa-low-vision fa-sm text-muted mr-1"></i> <?= l('notification.settings.background_blur') ?></label>
    <input id="background_blur" type="range"  min="0" max="30" class="form-control-range" name="background_blur" value="<?= $data->notification->settings->background_blur ?? 0 ?>" />
    <small class="form-text text-muted"><?= l('notification.settings.background_blur_help') ?></small>
</div>

<button class="btn btn-block btn-gray-200 my-4" type="button" data-toggle="collapse" data-target="#borders_container" aria-expanded="false" aria-controls="borders_container">
    <i class="fas fa-fw fa-border-style fa-sm mr-1"></i> <?= l('notification.settings.borders') ?>
</button>

<div class="collapse" id="borders_container">
    <div class="form-group">
        <label for="settings_shadow"><i class="fas fa-fw fa-cloud fa-sm text-muted mr-1"></i> <?= l('notification.settings.shadow') ?></label>
        <div class="row btn-group-toggle" data-toggle="buttons">
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->shadow  ?? null) == '' ? 'active"' : null?>">
                    <input type="radio" name="shadow" value="" class="custom-control-input" <?= ($data->notification->settings->shadow  ?? null) == '' ? 'checked="checked"' : null?> />
                    <?= l('global.none') ?>
                </label>
            </div>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->shadow  ?? null) == 'subtle' ? 'active' : null?>">
                    <input type="radio" name="shadow" value="subtle" class="custom-control-input" <?= ($data->notification->settings->shadow  ?? null) == 'subtle' ? 'checked="checked"' : null?> />
                    <?= l('notification.settings.shadow.subtle') ?>
                </label>
            </div>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->shadow  ?? null) == 'feather' ? 'active' : null?>">
                    <input type="radio" name="shadow" value="feather" class="custom-control-input" <?= ($data->notification->settings->shadow  ?? null) == 'feather' ? 'checked="checked"' : null?> />
                    <?= l('notification.settings.shadow.feather') ?>
                </label>
            </div>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->shadow  ?? null) == '3d' ? 'active' : null?>">
                    <input type="radio" name="shadow" value="3d" class="custom-control-input" <?= ($data->notification->settings->shadow  ?? null) == '3d' ? 'checked="checked"' : null?> />
                    <?= l('notification.settings.shadow.3d') ?>
                </label>
            </div>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->shadow  ?? null) == 'layered' ? 'active' : null?>">
                    <input type="radio" name="shadow" value="layered" class="custom-control-input" <?= ($data->notification->settings->shadow  ?? null) == 'layered' ? 'checked="checked"' : null?> />
                    <?= l('notification.settings.shadow.layered') ?>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="settings_shadow_color"><i class="fas fa-fw fa-cloud-sun fa-sm text-muted mr-1"></i> <?= l('notification.settings.shadow_color') ?></label>
        <input type="hidden" id="settings_shadow_color" name="shadow_color" class="form-control border-left-0" value="<?= $data->notification->settings->shadow_color ?>" />
        <div id="settings_shadow_color_pickr"></div>
    </div>

    <div class="form-group" data-range-counter data-range-counter-suffix="px">
        <label for="settings_border_width"><i class="fas fa-fw fa-border-top-left fa-sm text-muted mr-1"></i> <?= l('notification.settings.border_width') ?></label>
        <input type="range" min="0" max="5" id="settings_border_width" name="border_width" class="form-control-range" value="<?= $data->notification->settings->border_width ?>" />
    </div>

    <div class="form-group">
        <label for="settings_border_color"><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('notification.settings.border_color') ?></label>
        <input type="hidden" id="settings_border_color" name="border_color" class="form-control border-left-0" value="<?= $data->notification->settings->border_color ?>" />
        <div id="settings_border_color_pickr"></div>
    </div>

    <div class="form-group">
        <label for="settings_border_radius"><i class="fas fa-fw fa-border-all fa-sm text-muted mr-1"></i> <?= l('notification.settings.border_radius') ?></label>
        <div class="row btn-group-toggle" data-toggle="buttons">
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->border_radius  ?? null) == 'straight' ? 'active"' : null?>">
                    <input type="radio" name="border_radius" value="straight" class="custom-control-input" <?= ($data->notification->settings->border_radius  ?? null) == 'straight' ? 'checked="checked"' : null?> />
                    <i class="fas fa-fw fa-square-full fa-sm mr-1"></i> <?= l('notification.settings.border_radius_straight') ?>
                </label>
            </div>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->border_radius  ?? null) == 'rounded' ? 'active' : null?>">
                    <input type="radio" name="border_radius" value="rounded" class="custom-control-input" <?= ($data->notification->settings->border_radius  ?? null) == 'rounded' ? 'checked="checked"' : null?> />
                    <i class="fas fa-fw fa-square fa-sm mr-1"></i> <?= l('notification.settings.border_radius_rounded') ?>
                </label>
            </div>
            <div class="col-4 p-2">
                <label class="btn btn-gray-200 btn-block text-truncate mb-0 <?= ($data->notification->settings->border_radius  ?? null) == 'highly_rounded' ? 'active' : null?>">
                    <input type="radio" name="border_radius" value="highly_rounded" class="custom-control-input" <?= ($data->notification->settings->border_radius  ?? null) == 'highly_rounded' ? 'checked="checked"' : null?> />
                    <i class="fas fa-fw fa-square fa-sm mr-1"></i> <?= l('notification.settings.border_radius_highly_rounded') ?>
                </label>
            </div>
        </div>
    </div>
</div>
<?php $html['customize'] = ob_get_clean() ?>


<?php ob_start() ?>
<script>
    /* Notification Preview Handlers */
    $('#settings_title').on('change paste keyup', event => {
        $('#notification_preview .altumcode-video-title').text($(event.currentTarget).val());
    });

    $('#settings_video').on('change paste keyup', event => {
        if($('#notification_preview iframe')) {
            $('#notification_preview iframe').attr('src', $(event.currentTarget).val());
        }
        if($('#notification_preview video')) {
            $('#notification_preview video').attr('src', $(event.currentTarget).val());
        }
    });

    $('#settings_button_text').on('change paste keyup', event => {
        let text = $(event.currentTarget).val();

        if(text.trim() == '') {
            $('#notification_preview .altumcode-video-button').hide();
        } else {
            $('#notification_preview .altumcode-video-button').show().text(text);
        }
    });


    /* Title Color Handler */
    let settings_title_color_pickr = Pickr.create({
        el: '#settings_title_color_pickr',
        default: $('#settings_title_color').val(),
        ...pickr_options
    });

    settings_title_color_pickr.on('change', hsva => {
        $('#settings_title_color').val(hsva.toHEXA().toString());

        /* Notification Preview Handler */
        $('#notification_preview .altumcode-video-title').css('color', hsva.toHEXA().toString());
    });


    /* Background Color Handler */
    let settings_background_color_pickr = Pickr.create({
        el: '#settings_background_color_pickr',
        default: $('#settings_background_color').val(),
        ...pickr_options
    });

    settings_background_color_pickr.on('change', hsva => {
        $('#settings_background_color').val(hsva.toHEXA().toString());

        /* Notification Preview Handler */
        $('#notification_preview .altumcode-wrapper').css('background-color', hsva.toHEXA().toString());
    });

    /* Button Background Color Handler */
    let settings_button_background_color_pickr = Pickr.create({
        el: '#settings_button_background_color_pickr',
        default: $('#settings_button_background_color').val(),
        ...pickr_options
    });

    settings_button_background_color_pickr.on('change', hsva => {
        $('#settings_button_background_color').val(hsva.toHEXA().toString());

        /* Notification Preview Handler */
        $('#notification_preview .altumcode-video-button').css('background', hsva.toHEXA().toString());
    });

    /* Button Color Handler */
    let settings_button_color_pickr = Pickr.create({
        el: '#settings_button_color_pickr',
        default: $('#settings_button_color').val(),
        ...pickr_options
    });

    settings_button_color_pickr.on('change', hsva => {
        $('#settings_button_color').val(hsva.toHEXA().toString());

        /* Notification Preview Handler */
        $('#notification_preview .altumcode-video-button').css('color', hsva.toHEXA().toString());
    });

</script>
<?php $javascript = ob_get_clean() ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
