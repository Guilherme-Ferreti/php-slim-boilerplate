## Project name

Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore optio numquam reprehenderit quaerat vitae facere doloremque esse ea commodi. Earum alias, ipsa magnam illum nulla aspernatur magni et natus. Cumque? (Description)

## Project Stack

- Language: PHP (version x.x.x) using [Slim Framework](https://www.slimframework.com/) (version 4.7.0)

- Database: MySQL

## Project setup

1 - Download

2 - Server entry point must be the index.php file int the public folder.

3 - All good

## Usefull commands

• Start development server locally:
```php -S localhost:80 -t public```

• To generate encryption keys, run the following command from the root of your project:

```php src/Helpers/Cryptography/generate-keys.php```

• Remove dev dependencies and optimize composer's autoloader (deployment only):

```composer install --no-dev --optimize-autoloader```

## Project documentation

The documentation can be found here: https://github.com/docshere