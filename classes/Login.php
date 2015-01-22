<?php

/**
 * Class Login
 */
class Login
{
    /**
     * Convert a string to hash
     *
     * @param null $string
     * @return string
     */
    public static function stringToHash($string = null)
    {
        if (!empty($string))
        {
            return hash('sha512', $string);
        }
    }
}