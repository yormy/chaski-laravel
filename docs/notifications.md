# Notifications

Every notification is a mailable definable in the database

# sending

```
currentUser()->notify(new PebbleCreated());
```

## toMail

The entire mailable is sent out

## toXXX / ie toDatabase

the subject is the header, and the summary is the body of the notification to be shown

# Subscribable

Notifications can be unsubscribed.

package: https://github.com/liran-co/laravel-notification-subscriptions

By default, all notifications will be sent if no subscribe/unsubscribe record is found

### Getting subscriptions

```
$user->notificationSubscriptions();
```

### Unsubscribe from notification

Default the database channel is ignored on unsubscribe options

All channels

```
$user->unsubscribe(InvoicePaid::class);
``` 

or Specific Channel

```
$user->unsubscribe(InvoicePaid::class, 'mail');
```

### Resetting subscriptions

This package makes no assumptions about how your application manages notifications and subscriptions. For example, if
you unsubscribe a user from a particular notification channel, and later subscribe them to all channels, the previous
record won't be deleted. To reset the notifications on a user:

```
$user->resetSubscriptions(InvoicePaid::class);
```

Chaining

```
$user->resetSubscriptions(InvoicePaid::class)->subscribe(InvoicePaid::class);
```




