<?php

namespace PinaHttpClientManager\SQL;

use Exception;
use Pina\Data\Schema;
use Pina\TableDataGateway;
use Pina\Types\BooleanType;
use Pina\Types\StringType;
use Pina\Types\TokenType;
use PinaHttpClientManager\Types\WebhookTypeType;

use function Pina\__;

class WebhookGateway extends TableDataGateway
{
    protected static $table = 'webhook';

    /**
     * @return Schema
     * @throws Exception
     */
    public function getSchema()
    {
        $schema = parent::getSchema();

        $schema->add('client_id', __('ID Клиента'), TokenType::class)->setMandatory();
        $schema->add('type', __('Тип'), WebhookTypeType::class)->setMandatory();
        $schema->add('url', __('URL'), StringType::class)->setDefault('');
        $schema->add('enabled', __('Активен'), BooleanType::class)->setDefault('Y');
        $schema->addTimestamps();

        $schema->setPrimaryKey(['client_id', 'type']);

        return $schema;
    }

    public function whereActive($type)
    {
        return $this->whereBy('type', $type)
            ->whereBy('enabled', 'Y')
            ->innerJoin(
                ClientGateway::instance()->on('id', 'client_id')
                    ->onBy('enabled', 'Y')
            );
    }

}
