<?php


namespace PinaHttpClientManager;


use Exception;
use Pina\Access;
use Pina\App;
use Pina\ModuleInterface;

class Module implements ModuleInterface
{
    public function getPath()
    {
        return __DIR__;
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getTitle()
    {
        return 'Clients';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function http()
    {
        return $this->initRouter();
    }

    public function initRouter()
    {
        App::router()->register('clients', Endpoints\ClientEndpoint::class);
        App::router()->register('clients/:client_id/webooks', Endpoints\WebhookEndpoint::class, ['client_id']);

        Access::permit('clients', 'registered');
        return [];
    }
}
