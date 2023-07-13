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

# How to create your onw notification, mailable, DTO
overwrite and what to do

Promo and signature allows basic html (b, h, links)

# Signature / promo
Can be set in the code per notification
can be set hardcoded and translatables
Can be edited in blade with variables
