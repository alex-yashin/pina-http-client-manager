<?php


namespace PinaHttpClientManager\Model;


class WebhookMessage
{

    protected $type = '';
    protected $payload;

    public function __construct(string $type, $payload)
    {
        $this->type = $type;
        $this->payload = $payload;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPacket($clientId): string
    {
        return json_encode(
            [
                'client_id' => $clientId,
                'message' => [
                    'type' => $this->type,
                    'data' => $this->payload
                ]
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

}