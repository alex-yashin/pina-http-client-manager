<?php

namespace PinaHttpClientManager\Endpoints;

use Pina\Data\DataCollection;
use PinaHttpClientManager\Collections\WebhookCollection;
use Pina\App;
use Pina\Http\DelegatedCollectionEndpoint;
use Pina\Http\Request;

use function Pina\__;

class WebhookEndpoint extends DelegatedCollectionEndpoint
{
    protected function getCollectionTitle(): string
    {
        return __('Вебхуки');
    }

    protected function makeDataCollection(): DataCollection
    {
        return App::load(WebhookCollection::class);
    }
}
