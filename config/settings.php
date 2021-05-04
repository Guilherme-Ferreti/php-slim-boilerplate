<?php

/**
 * Define application's settings.
 * Note that the settings function is available in all project.
 */

/**
 * @return string|bool|int|array
 */
function settings(string $keys)
{
    $settings = array(
        'app' => [
            'environment' => 'development',
            'root' => dirname(__FILE__, 2),
            'debug' => true,
            'timezone' => 'America/Sao_Paulo',
            'domain' => 'http://localhost',
        ],
    
        'db' => [
            'connection' => '', // mysql, sqlsrv
            'host' => '',
            'name' => '',
            'username' => '',
            'password' => '',
        ],
    
        'views' => [
            'path' => __DIR__ . '/../resources/views/',
            'cache_path' => __DIR__ . '/../cache/',
            'extension' => '.twig'
        ],

        'logs' => [
            'path' => __DIR__ . '/../logs/',
        ],

        'cryptography' => [
            'openssl_key_path' => __DIR__ . '/../src/Helpers/Cryptography/keys/openssl.key',
            'sodium_key_path' => __DIR__ . '/../src/Helpers/Cryptography/keys/sodium.key',
        ],

        'routes' => [
            'cache_path' => __DIR__ . '/../cache/routes.php',
        ],

        'cors' => [
            'allowed_origins' => ['http://localhost',],
        ],
    
    );

    $keys = explode('.', $keys);

    foreach ($keys as $key) {
        if (! isset($settings[$key])) return null;

        $settings = $settings[$key];
    }

    return $settings;
}
