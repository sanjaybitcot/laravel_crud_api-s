<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Passport Intrigate in laravel 7 Follow below Steps

## Installation packege
```
composer require laravel/passport
```

## Run Migration and Install
```
php artisan migrate
php artisan passport:install
```

## Passport configration for model app/User.php
-> Add below code in file <br>
```
use Laravel\Passport\HasApiTokens;//Passport configration
```

-> Replace code instend of use HasApiTokens;<br>
```
use HasApiTokens, Notifiable;//Passport configration
```

## Passport configration for provider app\Providers\AuthServiceProvider.php

-> Add below code <br>
```
use Laravel\Passport\Passport;//Passport configration
```

-> Replace below code <br>
```
protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',//Passport configration
    ];
```     
-> Add code insdie function boot() <br>
```
 Passport::routes(); 
```

## configuration file , replace below array in config/auth.php <br>
```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

## For Enable Authentication <br>
```
composer require laravel/ui

php artisan ui vue --auth
```
