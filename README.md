# action-log
Laravel 5 The operation log is automatically recorded


## Installation

The ActionLog Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`qylinfly/action-log` package and setting the `minimum-stability` to `dev` (required for Laravel 5) in your
project's `composer.json`.

```json
{
    "require": {
       
        "qylinfly/action-log": "2.0.*"
    },
   
}
```

or

Require this package with composer:
```
composer require qylinfly/action-log 
```

Update your packages with ```composer update``` or install with ```composer install```.



## Usage

To use the ActionLog Service Provider, you must register the provider when bootstrapping your Laravel application. There are
essentially two ways to do this.

Find the `providers` key in `config/app.php` and register the ActionLog Service Provider.

```php
    'providers' => [
        // ...
        'Qylinfly\ActionLog\ActionLogServiceProvider',
    ]
```
for Laravel 5.1+
```php
    'providers' => [
        // ...
        Qylinfly\ActionLog\ActionLogServiceProvider::class,
    ]
```

Find the `aliases` key in `config/app.php`.

```php
    'aliases' => [
        // ...
        'ActionLog' => 'Qylinfly\ActionLog\Facades\ActionLogFacade',
    ]
```
for Laravel 5.1+
```php
    'aliases' => [
        // ...
        'ActionLog' => Qylinfly\ActionLog\Facades\ActionLogFacade::class,
    ]
```



## Configuration

You can publish the migration with:
```bash
php artisan vendor:publish --provider="Qylinfly\ActionLog\ActionLogServiceProvider" --tag="migrations"
```

The package assumes that your users table name is called "users". If this is not the case
you should manually edit the published migration to use your custom table name.

After the migration has been published you can create the role- and permission-tables by
running the migrations:

```bash
php artisan migrate
```

You can publish the config-file with:
```bash
php artisan vendor:publish --provider="Qylinfly\ActionLog\ActionLogServiceProvider" --tag="config"
```
To use your own settings, publish config.
`config/actionlog.php`
```php
return [
    //Middleware which records the request method
    'request_methods'=>['post','get'],
    //Fill in the name of the model to be logged, which can be multiple
    'models'=>['\App\User'],
    //Whether it is open
    'enable'=>true
];
```


## Demo
Automatically record the operation log, the database operation should be as follows:
```php

update

$users = Users::find(1);
$users->name = "myname";
$users->save();

add

$users = new Users();
$users->name = "myname";
$users->save()

delete

Users:destroy(1);

```

Active log operation log

```php

use ActionLog

ActionLog::createActionLog($type,$content);

```

Middleware

```php
class Kernel extends HttpKernel
{
    protected $middleware = [
       \Qylinfly\ActionLog\Middleware\UserActionLog::class
    ];
```