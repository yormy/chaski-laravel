# CLEANUP
- pint
- psalm
- ide-helpers

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

### UI
- Select from address/ name from database
- Preview template in browser
- send out for spam score ?

