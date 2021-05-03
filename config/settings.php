<?php

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
            'connection' => 'sqlsrv',
            'host' => "localhost\SQLEXPRESS",
            'name' => 'E_COMMERCE_TESTE',
            'username' => 'sa',
            'password' => 'root',
        ],
    
        'views' => [
            'path' => __DIR__ . '../src/Views/',
            'cache_path' => __DIR__ . '../cache/',
        ],

        'logs' => [
            'path' => __DIR__ . '../logs/',
        ],

        'cryptography' => [
            'openssl_key_path' => __DIR__ . '../Cryptography/keys/openssl.key',
            'sodium_key_path' => __DIR__ . '../Cryptography/keys/sodium.key',
        ],

        'routes' => [
            'cache_path' => __DIR__ . '../cache/routes.php',
        ],
    
    );

    $keys = explode('.', $keys);

    foreach ($keys as $key) {
        if (! isset($settings[$key])) return null;

        $settings = $settings[$key];
    }

    return $settings;
}
