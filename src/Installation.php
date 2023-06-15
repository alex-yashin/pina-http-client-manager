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
                $scopes = $value['scopes'] ?? '';
                $scopes = is_array($scopes) ? implode(' ', $scopes) : $scopes;

                $currencies = $value['currency'] ?? [];
                foreach ($currencies as $currency) {
                    $scopes .= ' currency:' . $currency;
                }
                $data = [
                    'id' => $key,
                    'title' => $key,
                    'uri' => $value['uri'] ?? '',
                    'secret' => $value['secret'] ?? '',
                    'scopes' => $scopes
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
