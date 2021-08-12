# PHP Slim Framework MVC Boilerplate

This project provides a simple Model-View-Controller skeleton for quickly setting up a [Slim Framework](https://www.slimframework.com/) application.

## Requirements

* PHP 8.0.0 or newer.

## Installation

Start by cloning this repository. 

``` git clone https://github.com/Guilherme-Ferreti/php-slim-boilerplate.git```

Make sure you have installed Composer. If not, please check its official [guide](http://getcomposer.org/doc/00-intro.md#installation).

When ready, install the dependencies by running the following command in your application's root folder:

```composer install```

Create a brand new *settings.php* inside the config folder by copying *settings-example.php*.

```cp config/settings-example.php config/settings.php```

Point your virtual host document root to application's public/ directory. 

If you are not using tools like WAMP or Apache, you may use PHP built-in server, or our pre-defined composer script.

```php -S localhost:80 -t public```

```composer serve```

That's it. Now create an awesome application.

## Features

This boilerplate comes with some features and basic folder structure. Feel free to change its structure anyway you want to.

####  Built-in features and folder structure:

* Model, View and Controller pre-defined folders.
* ViewMaker class, powered by [Twig Template Engine](https://twig.symfony.com/).
* Web and API routes files.
* CSRF and CORS Middleware protection.
* Database class.
* [Rakit\Validation Library](https://github.com/rakit/validation) and Rules.
* Policies for authorazing actions.
* Application general logging, powered by famous [Monolog](https://seldaek.github.io/monolog/).
* Helper functions to deal with session, flash session, cryptography with OpenSSL and Sodium.
* PHPUnit for testing.

## Useful commands

• To generate encryption keys, run the following command from the root of your project:

```composer generate-keys```

• Clear application cache: 
```composer cache-clear``` 

• Remove dev dependencies and optimize composer's autoloader (deployment only):

```composer install --no-dev --optimize-autoloader```

## RoadMap
Future additions to this project include:
* Migrations
* Better command line usage
* Repository Pattern