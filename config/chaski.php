<?php

use Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog;
use Yormy\ChaskiLaravel\Tests\Models\User;

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
            User::class,
            //Admin::class,
        ],

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
        'html' => 'chaski-laravel::layouts.html.red',
        'text' => 'chaski-laravel::layouts.text.main',
    ],

    'unsubscribe_view' => [
        'invalid_token' => 'chaski-laravel::unsubscribe.invalid',
        'success' => 'chaski-laravel::unsubscribe.success',
        'prevented' => 'chaski-laravel::unsubscribe.prevented',
    ],
];
