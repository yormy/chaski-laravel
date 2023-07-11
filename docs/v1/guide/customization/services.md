# Extending Service Helpers
There are a few helper services that Chaski uses that you can overwrite with your own implementations

## IpAddress
This service simply returns the IP address of the user. This IP is used for logging and blocking. If you need to get the IP address in a different way do the following

* Create a new class (ie ```MyIp```) and extend from ```Yormy\ChaskiLaravel\Services\IpAddress```
* Overwrite the functions you need to change

Specify to use this n your config ```chaski.php``` 
```php
    ->services(
        RequestSource::class,
        User::class, 
        MyIp::class // [!code focus]
    )
```
 
## RequestSource
This service has a few helpers to determine the device where request came from

* Create a new class (ie ```MySource```) and extend from ```Yormy\ChaskiLaravel\Services\RequestSource```
* Overwrite the functions you need to change

Specify to use this in your config ```chaski.php```
```php
    ->services(
        MySource::class,  // [!code focus]
        User::class, 
        IpAddress::class
    )
```

## User
This service has a few helpers to get the userId and userType (for polymorphic relations)

* Create a new class (ie ```MyUser```) and extend from ```Yormy\ChaskiLaravel\Services\User```
* Overwrite the functions you need to change
* 
Specify to use this n your config ```chaski.php```
```php
    ->services(
        RequestSource::class,
        MyUser::class,   // [!code focus]
        IpAddress::class
    )
```





