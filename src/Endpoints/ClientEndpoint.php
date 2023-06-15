<?php

namespace PinaHttpClientManager\Endpoints;

use Pina\App;
use Pina\Http\DelegatedCollectionEndpoint;
use Pina\Http\Request;
use PinaHttpClientManager\Collections\ClientCollection;

use function Pina\__;

/**
 *
 */
class ClientEndpoint extends DelegatedCollectionEndpoint
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->composer->configure(__('Клиенты'), __('Добавить Клиента'));
        $this->collection = App::load(ClientCollection::class);
    }

}
