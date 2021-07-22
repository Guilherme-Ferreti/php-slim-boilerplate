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
    $root = dirname(__FILE__, 2);

    $settings = array(
        'app' => [
            'environment'   => 'development',
            'root'          => $root,
            'timezone'      => 'America/Sao_Paulo',
            'domain'        => 'http://localhost',
        ],

        'container' => [
            'cache' => [
                'compilation_path' => $root . '/cache/container/',
                'proxies_path' => $root . '/cache/container/proxies/',
            ],
        ],
    
        'db' => [
            'connection'    => '',      // mysql, sqlsrv
            'host'          => '',
            'name'          => '',
            'username'      => '',
            'password'      => '',
        ],
    
        'views' => [
            'path'          => $root . '/resources/views/',
            'cache_path'    => $root . '/cache/views/',
            'extension'     => '.html'
        ],

        'logs' => [
            'path' => $root . '/logs/',
        ],

        'cryptography' => [
            'openssl_key_path'  => $root . '/src/Helpers/Cryptography/keys/openssl.key',
            'sodium_key_path'   => $root . '/src/Helpers/Cryptography/keys/sodium.key',
        ],

        'routes' => [
            'cache_path' => $root . '/cache/routes.php',
        ],

        'cors' => [
            'allowed_origins' => ['http://localhost'],
        ],

        'csrf_token' => [
            'max_time' => 60 * 60 * 24 // 24 hours
        ],

        'storage' => [
            'local' => [
                'public_disk_path' => $root . '/public/storage/',
                'private_disk_path' => $root . '/storage/',
                'public_disk_url' => '/storage/',
            ],
        ],
    
    );

    $keys = explode('.', $keys);

    foreach ($keys as $key) {
        if (! isset($settings[$key])) return null;

        $settings = $settings[$key];
    }

    return $settings;
}
