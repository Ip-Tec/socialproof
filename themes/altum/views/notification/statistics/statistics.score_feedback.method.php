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

<?php /* Feedback Chart */ ?>
<?php ob_start() ?>
<div class="card mb-5">
    <div class="card-body">
        <div class="chart-container">
            <canvas id="clicks_chart"></canvas>
        </div>
    </div>
</div>
<?php $html['charts'] = ob_get_clean() ?>


<?php

$types = [
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
];

ob_start();

/* Logs for the charts */
$result = database()->query("
    SELECT
         `type`,
         COUNT(`id`) AS `total`
    FROM
         `track_notifications`
    WHERE
        `notification_id` = {$data->notification->notification_id}
        AND (`datetime` BETWEEN '{$data->datetime['query_start_date']}' AND '{$data->datetime['query_end_date']}')
        AND `type` LIKE 'feedback_score_%'
    GROUP BY
        `type`
    ORDER BY
        `total` DESC
");

?>

<h2 class="h3 mt-5 mb-3"><?= l('notification.statistics.header_feedback') ?></h2>

<div class="table-responsive table-custom-container">
    <table class="table table-custom">
        <thead>
        <tr>
            <th><?= l('notification.statistics.feedback') ?></th>
            <th><?= l('notification.statistics.feedback_total') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_object()): ?>
            <?php $type = str_replace('feedback_score_', '', $row->type); ?>
            <?php $types[$type] += $row->total; ?>

            <tr>
                <td class="text-nowrap">
                    <i class="<?= l('notification.score_feedback.icon') ?>"></i> <?= l('notification.score_feedback.' . $row->type) ?>
                </td>
                <td class="text-nowrap"><?= nr($row->total) ?></td>
            </tr>
        <?php endwhile ?>
        </tbody>
    </table>
</div>
<?php $html['feedback'] = ob_get_clean() ?>

<?php ob_start(); ?>
<?php foreach ($types as $key => $value): ?>
    <div class="col-12 col-md-6 col-lg-4 p-2">
        <div class="card h-100">
            <div class="card-body d-flex">
                <div>
                    <div class="card bg-gray-200 text-gray-700 mr-3">
                        <div class="p-3 d-flex align-items-center justify-content-between">
                            <?= nr($key) ?>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card-title h4 m-0"><?= nr($value) ?></div>
                    <small class="form-text text-muted"><?= l('notification.score_feedback.name') ?></small>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<?php $html['widgets'] = ob_get_clean() ?>

<?php ob_start() ?>
<script>
    let clicks_chart = document.getElementById('clicks_chart').getContext('2d');

    new Chart(clicks_chart, {
        type: 'line',
        data: {
            labels: <?= $data->logs_chart['labels'] ?>,
            datasets: [
                {
                    label: <?= json_encode(l('notification.score_feedback.feedback_score_1')) ?>,
                    data: <?= $data->logs_chart['feedback_score_1'] ?? '[]' ?>,
                    borderColor: '#ED4956',
                    fill: false
                },
                {
                    label: <?= json_encode(l('notification.score_feedback.feedback_score_2')) ?>,
                    data: <?= $data->logs_chart['feedback_score_2'] ?? '[]' ?>,
                    borderColor: '#ed804c',
                    fill: false
                },
                {
                    label: <?= json_encode(l('notification.score_feedback.feedback_score_3')) ?>,
                    data: <?= $data->logs_chart['feedback_score_3'] ?? '[]' ?>,
                    borderColor: '#8f8f8f',
                    fill: false
                },
                {
                    label: <?= json_encode(l('notification.score_feedback.feedback_score_4')) ?>,
                    data: <?= $data->logs_chart['feedback_score_4'] ?? '[]' ?>,
                    borderColor: '#6c94ed',
                    fill: false
                },
                {
                    label: <?= json_encode(l('notification.score_feedback.feedback_score_5')) ?>,
                    data: <?= $data->logs_chart['feedback_score_5'] ?? '[]' ?>,
                    borderColor: '#4aed92',
                    fill: false
                }
            ]
        },
        options: chart_options
    });
</script>
<?php $javascript = ob_get_clean() ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>
