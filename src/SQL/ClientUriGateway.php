<?php

namespace PinaHttpClientManager\SQL;

use Exception;
use Pina\Data\Schema;
use Pina\TableDataGateway;
use Pina\Types\CheckedEnabledType;
use Pina\Types\StringType;
use Pina\Types\TokenType;

use function Pina\__;

class ClientUriGateway  extends TableDataGateway
{
    public function getTable(): string
    {
        return 'client_uri';
    }

    /**
     * @return Schema
     * @throws Exception
     */
    public function getSchema(): Schema
    {
        $schema = parent::getSchema();

        $schema->addAutoincrementPrimaryKey();

        $schema->add('client_id', __('ID Клиента'), TokenType::class)->setMandatory();
        $schema->add('uri', __('Uri'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('enabled', __('Активен'), CheckedEnabledType::class)->setDefault('Y');
        $schema->addTimestamps();

        return $schema;
    }

}