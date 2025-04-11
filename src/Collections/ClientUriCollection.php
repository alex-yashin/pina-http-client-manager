<?php

namespace PinaHttpClientManager\Collections;

use Pina\Data\DataCollection;
use PinaHttpClientManager\SQL\ClientUriGateway;

class ClientUriCollection extends DataCollection
{

    public function makeQuery()
    {
        return ClientUriGateway::instance();
    }

}