# Docs:
Encrypting:
Overwrite models and set in config
// set your overrideesfor encryption
'sent_email' => SentEmail::class,
'sent_email_log' => SentEmailLog::class,
There you can handle the encryption


# Subscriptions
Add the HasNotificationSubscriptions  trait to your User model:

use Illuminate\Database\Eloquent\Model;
use Yormy\ChaskiLaravel\Traits\Subscriptions\HasNotificationSubscriptions;

class User extends Model
{
use HasNotificationSubscriptions;

    // ...
}
