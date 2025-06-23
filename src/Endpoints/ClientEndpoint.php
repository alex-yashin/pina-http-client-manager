<?php

namespace PinaHttpClientManager\Endpoints;

use Pina\App;
use Pina\Data\DataCollection;
use Pina\Http\DelegatedCollectionEndpoint;
use PinaHttpClientManager\Collections\ClientCollection;

use function Pina\__;

/**
 *
 */
class ClientEndpoint extends DelegatedCollectionEndpoint
{
    protected function getCollectionTitle(): string
    {
        return __('Клиенты');
    }

    protected function makeDataCollection(): DataCollection
    {
        return App::load(ClientCollection::class);
    }
}
