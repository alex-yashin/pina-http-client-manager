<?php

namespace PinaHttpClientManager;

class AuthToken
{

    public static function parse(): string
    {
        $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        if (empty($auth)) {
            return '';
        }

        $type = 'Bearer';
        if (strncasecmp($auth, $type, strlen($type)) !== 0) {
            return '';
        }

        return trim(substr($auth, strlen($type) + 1));
    }

    public static function isValid(string $clientId, array $scopes = [])
    {
        return Clients::get($clientId)->isValid(static::parse(), $scopes);
    }

}
