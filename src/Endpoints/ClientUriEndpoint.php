<?php

namespace PinaHttpClientManager\Endpoints;

use Pina\App;
use Pina\Data\DataCollection;
use Pina\Http\DelegatedCollectionEndpoint;

use PinaHttpClientManager\Collections\ClientUriCollection;

use function Pina\__;

class ClientUriEndpoint extends DelegatedCollectionEndpoint
{
    protected function getCollectionTitle(): string
    {
        return __('URI');
    }

    protected function makeDataCollection(): DataCollection
    {
        return App::load(ClientUriCollection::class);
    }
}