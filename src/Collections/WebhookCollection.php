<?php

namespace PinaHttpClientManager\Collections;

use PinaHttpClientManager\SQL\WebhookGateway;
use Pina\Data\DataCollection;
use Pina\Data\Schema;
use Pina\TableDataGateway;

class WebhookCollection extends DataCollection
{
    public function getFilterSchema(): Schema
    {
        return new Schema();
    }

    public function makeQuery(): TableDataGateway
    {
        //этот запрос будет использоваться везде, и в выборке, и в обновлениях и в пагинации, поэтому здесь
        //только общие фильтры, которые коллекцию определяют и никаких данных для выборки
        return WebhookGateway::instance();
    }


}
