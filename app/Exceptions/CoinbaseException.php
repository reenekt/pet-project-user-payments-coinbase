<?php


namespace App\Exceptions;


class CoinbaseException extends \Exception
{
    public static function webhookException($message = 'Invalid coinbase webhook request')
    {
        return new static($message, 1);
    }
}
