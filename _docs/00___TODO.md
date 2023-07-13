# notification subscriptions

artisan command to send dummy email to x... for testing

# Handle unsubscribe link click (additional route)
- controller 
- unit test
- process unsubscribe
- forward to where when unsubscribed (in case of success or failire)

# CLEANUP
- pint
- ide models (php artisan iets met vendor bin ?)
- psalm

- 
# Composer
- why does xid package include laravel ?


# MAIL CONTENT
# # Mail Content template:
- footer unsubscribe links. - nicest would be below grey, but that is not controlled by template but by ????? $title
- delayed notification (als pri qr)


# Unittest:
- TestTemplateNotification shouldSend as false;


# Refactor 
naming TestTemplateNotificationDTO etc
rename: mail_preventable => mail_unsubscribable


## MAIL CREATE FRONTEND
- preview
- 
WelcomeMail::getVariables();
to show what placeholders can be used and how should be used, test if all required parameters are filled in
$placeholders = [
'action_title',
'action_description',
'signature',
'marketingsnippit'
];

## MAILTRACK FRONTEND
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

## MISC FRONTEND - Mark read: email / notificaion
moet in de frontend een lijst met notifications of een lijst met emails of een lijst met notifcations met de link naar de email?
