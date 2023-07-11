# Events

Blocked Events:
* When a block is added most of the time multiple events are sent. You can simply catch the generic event or a more specific one if you like
* When a block is added there could be a notification sent out (see notifications in your config);

Suggestions
- When a block is added logging out the current user is advisable

| Event                       | When          | Description                                                                                                                           |
|-----------------------------|---------------|---------------------------------------------------------------------------------------------------------------------------------------|
| ChaskiBlockedEvent        | Block Created | generic unspecified what or where but a block just happend. This is a good case to logout the current user and redirect to login page |
| ChaskiBlockedIpEvent      | Block Created | When a block on ip is added                                                                                                           |
| ChaskiBlockedBrowserEvent | Block Created | When a block on browser fingerprint is added                                                                                          |
| ChaskiBlockedUserEvent    | Block Created | When a block on userId is added                                                                                                       |


## Typical use cases:
### ChaskiBlockedEvent
* User logout
* Send admin notification
