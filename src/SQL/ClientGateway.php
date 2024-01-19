<?php

namespace PinaHttpClientManager\SQL;

use Exception;
use Pina\Data\Schema;
use Pina\TableDataGateway;
use Pina\Types\BooleanType;
use Pina\Types\StringType;
use Pina\Types\TokenType;
use PinaHttpClientManager\Model\ClientConfiguration;

use PinaHttpClientManager\Model\InvalidClientConfiguration;

use function Pina\__;

class ClientGateway extends TableDataGateway
{
    protected static $table = 'client';

    /**
     * @return Schema
     * @throws Exception
     */
    public function getSchema()
    {
        $schema = new Schema();

        $schema->add('id', __('ID Клиента'), TokenType::class)->setMandatory()->setDefault('');
        $schema->add('title', __('Название'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('enabled', __('Активен'), BooleanType::class)->setDefault('Y');
        $schema->add('uri', __('Uri'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('secret', __('Secret'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('scopes', __('Scopes'), StringType::class)->setDefault('');
        $schema->addTimestamps();

        $schema->setPrimaryKey('id');

        return $schema;
    }

    public function firstClientConfiguration(): ClientConfiguration
    {
        $line = $this->select('uri')
            ->select('secret')
            ->select('scopes')
            ->first();

        if (empty($line)) {
            return new InvalidClientConfiguration();
        }

        return new ClientConfiguration($line['uri'], $line['secret'], $line['scopes']);
    }
}
