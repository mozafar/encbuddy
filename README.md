# encbuddy
Laravel package to encrypt response content and decrypt request body

## Installation
1- Install package using composer
```sh
composer require mozafar/encbuddy
```
2- Publish config file
```sh
php artisan vendor:publish --tag=encbuddy-config
```
3- Add it to laravel global middlewares
```php
protected $middleware = [
    .
    .
    .,
    \Mozafar\EncBuddy\EncBuddyMiddleware::class,
];
```
4- Register development routes
```php
Route::encryption();
```

## Custom key resolver
To get key from other sources like your DB or file you can use a class which implements `\Mozafar\EncBuddy\KeyResolverInterface` like following example:  
```php
namespace Your\Name\Space;

class MyKeyResolver implements KeyResolverInterface
{
    public function key(): string
    {
        return 'My custom key';
    }
}
```
You can add the implemented class in config file:
```php
/*
|--------------------------------------------------------------
| Custom class to get key and cipher
|--------------------------------------------------------------
| If set this config to null then constant key will
| be used
*/
'custom_key_resolver' => \Your\Name\Space\MyKeyResolver::class,
```