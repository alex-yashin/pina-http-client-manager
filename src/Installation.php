<?php


namespace PinaHttpClientManager;


use Pina\Config;
use Pina\InstallationInterface;

/**
 *
 */
class Installation implements InstallationInterface
{
    /**
     * Выполняется перед патчем БД
     */
    public function prepare()
    {
    }

    /**
     * Выполняется после патча БД
     */
    public function install()
    {
        $dbClients = SQL\ClientGateway::instance()->select('*')->get();
        if (empty($dbClients)) {
            $clients = Config::get('clients');
            foreach ($clients as $key => $value) {
                $data = [
                    'id' => $key,
                    'title' => $key,
                    'enabled' => true,
                    'client_code' => $key,
                    'uri' => $value['uri'] ?? '',
                    'secret' => $value['secret'] ?? '',
//                    'currency' => isset($value['currency']) ? implode(',', $value['currency']) : '',
                    'scopes' => isset($value['scopes']) ? implode(',', $value['scopes']) : '',
                ];
                SQL\ClientGateway::instance()->put($data);
            }
        }
    }

    /**
     * Выполняется при удалении модуля
     */
    public function remove()
    {
    }
}
