

# MAIL CONTENT

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

### UI
- Select from address/ name from database
- Preview template in browser
- send out for spam score ?
