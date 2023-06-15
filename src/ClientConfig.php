<?php

namespace PinaHttpClientManager;

use Pina\Log;

/**
 * Класс с конфигурациями клиентских приложений
 */
class ClientConfig
{
    /**
     * @param $clientId
     * @return array|null
     */
    public static function load($clientId): array
    {
        if (!isset($clientId)) {
            Log::error('client-config', 'ClientID needed');
            return [];
        }
        $config = SQL\ClientGateway::instance()
            ->select('uri')
            ->select('secret')
            ->select('scopes')
            ->whereBy('id', $clientId)
            ->first();

        $config['scope'] = array_filter(preg_split("/[\s,]+/", $config['scope']));

        return $config;
    }

    public static function getScopeValues($scopes, $name)
    {
        $values = [];
        $prefix = $name . ':';
        foreach ($scopes as $i => $scope) {
            if (strpos($scope, $prefix) === 0) {
                $values[] = substr($scope, strlen($prefix));
            }
        }
        return $values;
    }
}
