<?php

namespace PinaHttpClientManager\Collections;

use Pina\Data\DataCollection;
use Pina\Data\Schema;
use PinaHttpClientManager\SQL\ClientGateway;

class ClientCollection extends DataCollection
{
    public function getFilterSchema($context = []): Schema
    {
        return $this->getSchema()
            ->fieldset(['title', 'code', 'enabled', 'uri', 'secret', 'scopes', 'currency'])
            ->setMandatory(false)
            ->setNullable()
            ->makeSchema();
    }

    public function makeQuery(): ClientGateway
    {
        //этот запрос будет использоваться везде, и в выборке, и в обновлениях и в пагинации, поэтому здесь
        //только общие фильтры, которые коллекцию определяют и никаких данных для выборки
        return ClientGateway::instance();
    }


}
