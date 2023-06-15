<?php

namespace PinaHttpClientManager;

use PinaHttpClientManager\Model\ClientConfiguration;

/**
 * Класс с конфигурациями клиентских приложений
 */
class Clients
{
    /**
     * @param string $clientId
     * @return array
     */
    public static function get(string $clientId): ClientConfiguration
    {
        return SQL\ClientGateway::instance()
            ->whereBy('id', $clientId)
            ->firstClientConfiguration();
    }

}
