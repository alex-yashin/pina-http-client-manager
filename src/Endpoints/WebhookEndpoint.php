<?php

namespace PinaHttpClientManager\Endpoints;

use PinaHttpClientManager\Collections\WebhookCollection;
use Pina\App;
use Pina\Http\DelegatedCollectionEndpoint;
use Pina\Http\Request;

use function Pina\__;

class WebhookEndpoint extends DelegatedCollectionEndpoint
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->composer->configure(__('Вебхуки'), __('Добавить вебхук'));
        $this->collection = App::load(WebhookCollection::class);
    }

}
