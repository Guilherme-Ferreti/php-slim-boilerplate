# PHP Slim Framework MVC Boilerplate

This project provides a simple Model-View-Controller skeleton for quickly setting up an [Slim Framework](https://www.slimframework.com/) application.

## Requirements

* PHP 7.3 or newer.

## Installation

Start by cloning this repository. 

``` git clone https://github.com/Guilherme-Ferreti/php-slim-boilerplate.git```

Make sure you have installed Composer. If not, please check its official [guide](http://getcomposer.org/doc/00-intro.md#installation).

When ready, install the dependencies by running the following command in your application's root folder:

```composer install```

Rename <b>settings-example.php</b> to <b>settings.php</b> inside the config folder.

Point your virtual host document root to application's public/ directory. 

If you are not using tools like WAMP or Apache, you may use PHP built-in server.

```php -S localhost:80 -t public```

That's it. Now create an awsome application.

## Features

This boilerplate comes with some features and basic folder structure. Feel free to change its structure anyway you want to.

#####  Built-in features and folder structure:

* Model, View and Controller pre-defined folders.
* ViewMaker class, powered by [Twig Template Engine](https://twig.symfony.com/).
* Web and Api routes files.
* CSRF and CORS Middleware protection.
* Database class.
* Rakit\Validation Library and Rules.
* Policies for authorazing actions.
* Application general logging, powered by famous [Monolog](https://seldaek.github.io/monolog/).
* Helper functions to deal with session, flash session, cryptography with OpenSSL and Sodium.
* PHPUnit for testing.

## Useful commands

• To generate encryption keys, run the following command from the root of your project:

```php src/Helpers/Cryptography/generate-keys.php```

• Remove dev dependencies and optimize composer's autoloader (deployment only):

```composer install --no-dev --optimize-autoloader```