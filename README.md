# encbuddy
Laravel package to encrypt response content and decrypt request body

## installation
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