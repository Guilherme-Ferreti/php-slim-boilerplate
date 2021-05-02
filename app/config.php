<?php

/**
 * @return string|bool|int|array
 */
function config(string $keys)
{
    $config = array(
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
            'path' => __DIR__ . '/Views/',
            'cache_path' => dirname(__FILE__, 2) . '/cache/',
        ],

        'logs' => [
            'path' => dirname(__FILE__, 2) . '/logs/',
        ],

        'cryptography' => [
            'openssl_key_path' => __DIR__ . '/Cryptography/keys/openssl.key',
            'sodium_key_path' => __DIR__ . '/Cryptography/keys/sodium.key',
        ],
    
    );

    $keys = explode('.', $keys);

    foreach ($keys as $key) {
        if (! isset($config[$key])) return null;

        $config = $config[$key];
    }

    return $config;
}
