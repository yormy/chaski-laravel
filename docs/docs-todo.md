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

# Register routes
Route::ChaskiUnsubscribeRoutes();
as guest routes to be able to unsubscribe

# Extending
## Sending
See if it is possible to send out delayed notifcations that have a continue to not be send if something happend in the mean time.
1 store class+ user + channel ? if present then not send => remove from database when triggered
2 call a determiner function to send or not send. How  to abstract and make this determiner ?
3 unittesting

# Mail Creation Extension
### Create one of mails
Ability to send a mail and enter a existing user
or select a list of users
Lastigheid hierbij is dat mails een unique mailtemplate class hebben en bij admin created mails is die class niet unique
custom mailables zijn niet unsubscribable omdat die manual zijn

### Create manual templates
Create a template / delete
Select template to send to one or more users manually
Translatables
Lastigheid hierbij is dat mails een unique mailtemplate class hebben en bij admin created mails is die class niet unique


