<?php

namespace App\Cryptography;

class Sodium 
{
    /**
     * Encrypt a string.
     */
    public static function encrypt(string $value) : string
    {
        $key = file_get_contents(config('cryptography.sodium_key_path'));

        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $ciphertext = sodium_crypto_secretbox($value, $nonce, $key);

        return base64_encode($nonce . $ciphertext);
    }

    /**
     * Decrypt a string.
     */
    public static function decrypt(string $value) : string
    {
        $key = file_get_contents(config('cryptography.sodium_key_path'));

        $value = base64_decode($value);

        $nonce = mb_substr($value, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        
        $ciphertext = mb_substr($value, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        return sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
    }
}
