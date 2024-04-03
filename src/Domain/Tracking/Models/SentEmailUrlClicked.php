<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use jdavidbakr\MailTracker\Model\SentEmailUrlClicked as BaseSentEmailUrlClicked;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;

class SentEmailUrlClicked extends BaseSentEmailUrlClicked
{
    use PackageFactoryTrait;
}
