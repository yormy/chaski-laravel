# notification subscriptions
is signature/ promo translatable ?
can promo contain link?

## Unsubscribe link template:
- Nu moet ik het per taal en per notification instellen, kan het generieker ?
- 

# Handle unsubscribe link click (additional route)
--- forward to where when unsubscribed (in case of success or failire)
rename: mail_preventable => mail_unsubscribable

# Mark read: email / notificaion
moet in de frontend een lijst met notifications of een lijst met emails of een lijst met notifcations met de link naar de email?

# CLEANUP
- pint
- ide models
- psalm

- 
# Composer
- why does xid package include laravel ?

## UI
- views from mailtrack ?
-     /**
    * Where should the admin route be?
      */
      'admin-route' => [
      'enabled' => true, // Should the admin routes be enabled?
      'prefix' => 'email-manager',
      'middleware' => [
      'web',
      'can:see-sent-emails'
      ],
      ],

  'admin-template' => [
  'name' => 'emailTrakingViews::layouts.app',
  'section' => 'content',
  ],

# MAIL CONTENT
# # Mail Content template:
- footer unsubscribe links. - nicest would be below grey, but that is not controlled by template but by ????? $title
- delayed notification (als pri qr)
- mail preview


# Unittest:
- TestTemplateNotification shouldSend as false;


# Refactor 
naming TestTemplateNotificationDTO etc

# Vite press

## Features
1 test notification (rest in clients, ie users has notifications, bounty has notifications)

# UI
WelcomeMail::getVariables();
to show what placeholders can be used and how should be used, test if all required parameters are filled in
$placeholders = [
'action_title',
'action_description',
'signature',
'marketingsnippit'
];

        $plain = [
            'name' => 'PASSWORD_CHANGED',
            'mailable' => PasswordChangedMailable::class,
            'notification' => PasswordChangedNotification::class,
            'placeholders' => $placeholders,
        ];
