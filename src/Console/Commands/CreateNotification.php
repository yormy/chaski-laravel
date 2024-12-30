<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateNotification extends Command
{
    protected $signature = 'make:chaski-notification {name}';

    protected $description = 'Create a custom file for your application';

    public function handle()
    {
        $name = $this->argument('name');

        $notificationsPath = "Notifications/{$name}";
        $filePath = app_path("{$notificationsPath}/{$name}");

        if (File::exists($filePath)) {
            $this->error("The file {$name}.php already exists!");
            return Command::FAILURE;
        }

        File::ensureDirectoryExists(app_path($notificationsPath));

//        $this->createDataClass($filePath, $name);
//        $this->createMailableClass($filePath, $name);
//        $this->createNotificationClass($filePath, $name);
        $this->createSeeder($filePath, $name);

        return Command::SUCCESS;
    }


    private function createDataClass(string $filePath, string $name): void
    {
        $fileContent = <<<PHP
<?php

declare(strict_types=1);

namespace Mexion\TestappCore\Domain\User\Notifications\UserPasswordUpdated;

use Mexion\TestappCore\Domain\Shared\Notifications\TestAppNotificationData;

class {$name}Data extends TestAppNotificationData
{
    // ...
}
PHP;

        File::put($filePath . 'Data.php', $fileContent);

        $this->info("Data class: {$name}.php created successfully!");
    }

    private function createMailableClass(string $filePath, string $name): void
    {
        $fileContent = <<<PHP
<?php

declare(strict_types=1);

namespace Mexion\TestappCore\Domain\User\Notifications\UserPasswordUpdated;

use Yormy\ChaskiLaravel\Domain\Create\Notifications\BaseTemplateMailable;

class {$name}Mailable extends BaseTemplateMailable
{
    // ...
}
PHP;

        File::put($filePath . 'Mailable.php', $fileContent);

        $this->info("Mailable class: {$name}.php created successfully!");
    }

    private function createNotificationClass(string $filePath, string $name): void
    {
        $fileContent = <<<PHP
<?php

declare(strict_types=1);

namespace Mexion\TestappCore\Domain\User\Notifications\\{$name};

use Mexion\TestappCore\Domain\Billing\Notifications\BaseNotification;

class {$name}Notification extends BaseNotification
{
    protected \$channels = ['mail'];

    protected \$mailable = {$name}Mailable::class;

    public function __construct({$name}Data \$data)
    {
        parent::__construct(\$data);
    }
}
PHP;

        File::put($filePath . 'Notification.php', $fileContent);

        $this->info("Notification class: {$name}.php created successfully!");
    }

    private function createSeeder(string $filePath, string $name): void
    {
        $fileContent = $this->seederContent($filePath, $name);
        File::put($filePath . 'Seeder.php', $fileContent);

        $this->info("Seeder class: {$name}.php created successfully!");
    }


    private function seederContent(string $filePath, string $name): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace Mexion\TestappCore\Domain\User\Database\Seeders\Notifications;

use Mexion\TestappCore\Domain\Billing\Database\Seeders\Notifications\BaseNotificationSeeder;
use Mexion\TestappCore\Domain\User\Notifications\EmailOTP\EmailOTPMailable;
use Mexion\TestappCore\Domain\User\Notifications\EmailOTP\EmailOTPNotification;

class {$name}MailSeeder extends BaseNotificationSeeder
{
    protected \$mailable = {$name}Mailable::class;

    protected \$notification = {$name}Notification::class;

    public function run(): void
    {
        \$template = \$this->defineTemplate();

        \$this->createEnglish(\$template);

        \$this->store(\$template);
    }

    private function createEnglish(\$template)
    {
        \$title = 'Email Code';

        \$notificationTitle = \$title;
        \$notificationContent = "{{ appName }}: {\$title}";

        \$mailSubject = "{{ appName }}: {\$title}";

        \$summary = <<<'HTML'
HTML;
        \$textTemplate = <<<'HTML'

HTML;

        \$htmlTemplate = <<<'HTML'
<h1>{{ userName }}, </h1>

<p>
You need to confirm your email address by copying the following code
[[code:{{custom.code}}]]

HTML;

    return \$this->setContent(\$template, 'en', \$mailSubject, \$summary, \$htmlTemplate, \$textTemplate, \$notificationTitle, \$notificationContent);
    }
}

PHP;
    }
}
