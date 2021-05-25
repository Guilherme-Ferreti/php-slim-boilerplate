<?php

namespace App\Helpers;

class Session
{
    const FLASH_KEY = 'flash_session';
    const DONT_FLASH = ['password'];
    const SERIALIZE = ['errorBag'];

    public static function set(string $key, $value)
    {
        if (in_array($key, self::SERIALIZE)) {
            $value = serialize($value);
        }

        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        if (! isset($_SESSION[$key])) {
            return $default;
        }

        $value = $_SESSION[$key];

        if (in_array($key, self::SERIALIZE)) {
            $value = unserialize($value);
        }

        return $value;
    }

    /**
     * Retrive all session values.
     */
    public static function getAll() : array
    {
        return $_SESSION;
    }

    /**
     * Set a $key => $value pair in the flash session.
     */
    public static function setFlash(string $key, $value)
    {
        if (! in_array($key, self::DONT_FLASH)) {

            if (in_array($key, self::SERIALIZE)) {
                $value = serialize($value);
            }
            
            $_SESSION[self::FLASH_KEY][$key] = $value;
        }
    }

    /**
     * Retrieve value from the flash session.
     */
    public static function getFlash(string $key, $default = null)
    {
        if (! isset($GLOBALS[self::FLASH_KEY][$key])) {
            return $default;
        }

        $value = $GLOBALS[self::FLASH_KEY][$key];

        unset($GLOBALS[self::FLASH_KEY][$key]);

        if (in_array($key, self::SERIALIZE)) {
            $value = unserialize($value);
        }

        return $value;
    }

    public static function clearFlash()
    {
        unset($_SESSION[self::FLASH_KEY]);
    }
}
