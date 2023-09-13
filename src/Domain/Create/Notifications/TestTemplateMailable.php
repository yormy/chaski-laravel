<?php

namespace Yormy\ChaskiLaravel\Domain\Create\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\HtmlString;
use Spatie\MailTemplates\TemplateMailable;
use Yormy\ChaskiLaravel\Domain\Create\Models\TranslatableMailTemplate;
use Yormy\ChaskiLaravel\Domain\Shared\Services\Encryption;
use Yormy\ChaskiLaravel\Domain\Shared\Services\StringableUser;

class TestTemplateMailable extends BaseTemplateMailable
{

}
