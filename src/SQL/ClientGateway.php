<?php

namespace PinaHttpClientManager\SQL;

use Exception;
use Pina\Data\Schema;
use Pina\TableDataGateway;
use Pina\Types\CheckedEnabledType;
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
        $schema = parent::getSchema();

        $schema->add('id', __('ID Клиента'), TokenType::class)->setMandatory()->setDefault('');
        $schema->add('title', __('Название'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('enabled', __('Активен'), CheckedEnabledType::class)->setDefault('Y');
        //@deprecated
        $schema->add('uri', __('Uri'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('secret', __('Secret'), StringType::class)->setMandatory()->setDefault('');
        $schema->add('scopes', __('Scopes'), StringType::class)->setDefault('');
        $schema->addTimestamps();

        $schema->setPrimaryKey('id');

        return $schema;
    }

    public function firstClientConfiguration(): ClientConfiguration
    {
        $line = $this
            ->select('id')
            ->select('secret')
            ->select('scopes')
            ->first();

        if (empty($line)) {
            return new InvalidClientConfiguration();
        }

        return new ClientConfiguration($line['id'], $line['secret'], $line['scopes']);
    }
}
