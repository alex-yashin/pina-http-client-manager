<?php

namespace PinaHttpClientManager\SQL;

use Pina\Data\Schema;
use Pina\TableDataGateway;
use Pina\Types\BooleanType;
use Pina\Types\StringType;
use Pina\Types\TokenType;
use function Pina\__;

class ClientGateway extends TableDataGateway
{
    protected static $table = 'client';

    /**
     * @return Schema
     * @throws \Exception
     */
    public function getSchema()
    {
        $schema = new Schema();

        $schema->add('id', __('ID Клиента'), TokenType::class)->setMandatory()->setDefault('');
        $schema->add('title', __('Название'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('enabled', __('Активен'), BooleanType::class)->setDefault('Y');
        $schema->add('uri', __('Uri'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('secret', __('Secret'), TokenType::class)->setMandatory()->setDefault('');
        $schema->add('scopes', __('Scopes'), TokenType::class)->setDefault('');
        $schema->addTimestamps();

        $schema->setPrimaryKey('id');

        return $schema;
    }
}
