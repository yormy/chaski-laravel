<?php

namespace Yormy\ChaskiLaravel\Tests\Traits;

trait ConfigMailTrait
{
    private function configMail()
    {
        config(['mail.default' => 'smtp']);
        config(['mail.mailers.smtp.host' => 'maildev']);
        config(['mail.mailers.smtp.port' => 25]);
        config(['mail.mailers.smtp.encryption' => null]);
        config(['mail.mailers.smtp.verify_peer' => false]);
    }
}
