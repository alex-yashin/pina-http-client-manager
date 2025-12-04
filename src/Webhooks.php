<?php

namespace PinaHttpClientManager;

use PinaHttpClientManager\Model\WebhookMessage;
use PinaHttpClientManager\SQL\WebhookGateway;

class Webhooks
{

    public static function notify(WebhookMessage $message)
    {
        $subscribers = WebhookGateway::instance()
            ->whereActive($message->getType())
            ->column('client_id');

        foreach ($subscribers as $clientId) {
            //запускаем в фоновом режиме с помощью доступного сервера очередей
            Commands\Notify::enqueue($clientId);
        }
    }

}