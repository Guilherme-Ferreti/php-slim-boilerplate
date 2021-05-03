<?php

try {
    $path = __DIR__ . '/../Cryptography/keys';

    file_put_contents("$path/sodium.key", random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES));

    file_put_contents("$path/openssl.key", random_bytes(32));

    echo 'Keys generated successfully!';
} catch (Exception $e) {
    echo 'Could not generate keys!';

    echo $e->getMessage();
}
