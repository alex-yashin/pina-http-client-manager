<?php


namespace PinaHttpClientManager;


use PinaHttpClientManager\Model\WebhookMessage;
use PinaHttpClientManager\SQL\WebhookGateway;
use Pina\Events\QueueableCommand;

class Webhooks
{

    public static function notify(WebhookMessage $message)
    {
        $subscribers = WebhookGateway::instance()
            ->whereActive($message->getType())
            ->column('client_id');

        foreach ($subscribers as $clientId) {
            //запускаем в фоновом режиме с помощью доступного сервера очередей
            $command = new QueueableCommand(Commands\Notify::class);
            $command($message->getPacket($clientId));
        }
    }

}