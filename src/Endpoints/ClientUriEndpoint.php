<?php

namespace PinaHttpClientManager\Endpoints;

use Pina\App;
use Pina\Http\DelegatedCollectionEndpoint;
use Pina\Http\Request;

use PinaHttpClientManager\Collections\ClientUriCollection;

use function Pina\__;

class ClientUriEndpoint extends DelegatedCollectionEndpoint
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->composer->configure(__('URI'), __('Добавить URL'));
        $this->collection = App::load(ClientUriCollection::class);
    }


}