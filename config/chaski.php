<?php

use Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;

return [

    'default_language' => 'en',
    'languages' => [
        'en',
        'nl',
    ],

    'models' => [
        // List here all the models that are notifyables.
        // if you send notifications to users and admins, list them both
        'notifiables' => [
            Member::class,
            Admin::class,
        ],

        'member' => Member::class,
        'admin' => Admin::class,

        // set your overrideesfor encryption
        'sent_email' => SentEmail::class,
        'sent_email_log' => SentEmailLog::class,
    ],

    'mail_tracker' => [
        // do not log the following messages content
        'prevent_content_logging' => [
            TranslatableMailTemplate::class,
        ],
    ],

    'prevented_content_logging' => '*** CONTENT NOT STORED FOR SECURITY ***',

    'default_layout' => [
        'html' => 'chaski-laravel::layouts.html.default',
        'text' => 'chaski-laravel::layouts.text.default',
    ],

    'unsubscribe_view' => [
        'invalid_token' => 'chaski-laravel::unsubscribe.invalid',
        'success' => 'chaski-laravel::unsubscribe.success',
        'prevented' => 'chaski-laravel::unsubscribe.prevented',
    ],

    'default_signature' => [
        'chaski::mail.signature.line_1',
        'chaski::mail.signature.line_2',
    ],

    'branding' => [
        'app_name' => 'Your App Name',
        'app_abbreviation' => 'YA', // keep it short, 2 or 3 letters
    ],
];
