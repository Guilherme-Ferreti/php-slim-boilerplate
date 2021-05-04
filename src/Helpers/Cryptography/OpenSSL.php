<?php

namespace App\Helpers\Cryptography;

class OpenSSL 
{
    const CIPHER = 'AES-128-CBC';

    /**
     * Encrypt a string.
     */
    public static function encrypt(string $value) : string
    {
        $key = file_get_contents(settings('cryptography.openssl_key_path'));

        $iv = random_bytes(openssl_cipher_iv_length(OpenSSL::CIPHER));

        $ciphertext = openssl_encrypt($value, OpenSSL::CIPHER, $key, OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $ciphertext);
    }

    /**
     * Decrypt a string.
     */
    public static function decrypt(string $value) : string
    {
        $key = file_get_contents(settings('cryptography.openssl_key_path'));

        $value = base64_decode($value);

        $iv = mb_substr($value, 0, openssl_cipher_iv_length(OpenSSL::CIPHER), '8bit');

        $ciphertext = mb_substr($value, openssl_cipher_iv_length(OpenSSL::CIPHER), null, '8bit');

        return openssl_decrypt($ciphertext, OpenSSL::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
    }
}
