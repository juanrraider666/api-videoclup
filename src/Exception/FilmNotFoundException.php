<?php


namespace App\Exception;

use Exception;

class FilmNotFoundException extends Exception
{
    public static function throwException($message)
    {
        throw new self($message ?: 'Film not found');
    }
}