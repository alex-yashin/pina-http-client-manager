<?php


namespace PinaHttpClientManager\Model;


class InvalidClientConfiguration extends ClientConfiguration
{

    public function __construct()
    {
        parent::__construct('', '', '');
    }

    public function isValid(string $token, array $scopes = [])
    {
        return false;
    }

}