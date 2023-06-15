<?php

namespace PinaHttpClientManager\Commands;

use PinaHttpClientManager\SQL\ClientGateway;
use PinaHttpClientManager\SQL\WebhookGateway;
use Exception;
use Pina\Command;

class Notify extends Command
{

    /**
     * @param string $input
     * @throws Exception
     */
    protected function execute($input = '')
    {
        $packet = json_decode($input, true);

        $clientId = $packet['client_id'];
        $type = $packet['message']['type'] ?? '';

        if (empty($type)) {
            return;
        }

        $client = WebhookGateway::instance()
            ->whereBy('client_id', $clientId)
            ->whereBy('type', $type)
            ->whereBy('enabled', 'Y')
            ->innerJoin(
                ClientGateway::instance()->on('id', 'client_id')
                    ->onBy('enabled', 'Y')
                    ->select('secret')
            )
            ->select('url')
            ->first();

        if (empty($client)) {
            return;
        }

        $this->send(
            $client['url'] ?? '',
            $client['secret'] ?? '',
            json_encode($packet['message'] ?? '', JSON_UNESCAPED_UNICODE)
        );
    }

    /**
     * @param string $url
     * @param string $secret
     * @param string $data
     * @throws Exception
     */
    protected function send(string $url, string $secret, string $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . $secret,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ]
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($info['http_code'] !== 200) {
            //выбрасывание исключения перепоставит задачу в очередь после некоторой паузы
            throw new Exception('Невозможно отправить запрос');
        }
    }
}