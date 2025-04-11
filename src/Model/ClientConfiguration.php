<?php


namespace PinaHttpClientManager\Model;

use PinaHttpClientManager\SQL\ClientGateway;
use PinaHttpClientManager\SQL\ClientUriGateway;

class ClientConfiguration
{

    protected $id = '';
    protected $secret = '';
    protected $scopes = [];

    public function __construct(string $id, string $secret, string $scopes)
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->scopes = array_filter(preg_split("/[\s,]+/", $scopes));
    }

    public function isConfigured(): bool
    {
        return !empty($this->id) && !empty($this->secret);
    }

    public function getTitle(): string
    {
        return ClientGateway::instance()->whereId($this->id)->value('title');
    }

    public function hasScope(string $scope): bool
    {
        return in_array($scope, $this->scopes);
    }

    public function getScopeValues($name)
    {
        $values = [];
        $prefix = $name . ':';
        foreach ($this->scopes as $i => $scope) {
            if (strpos($scope, $prefix) === 0) {
                $values[] = substr($scope, strlen($prefix));
            }
        }
        return $values;
    }

    public function isValid(string $token, array $scopes = [])
    {
        if ($token != $this->secret) {
            return false;
        }

        if (!empty($scopes) && !empty($this->scopes)) {
            $neededScopeCount = count($scopes);
            $permittedScopeCount = count(array_intersect($scopes, $this->scopes));
            if ($neededScopeCount != $permittedScopeCount) {
                return false;
            }
        }

        return true;
    }

    public function isValidUrl(string $url)
    {
        $approvedUrls = ClientUriGateway::instance()
            ->whereBy('client_id', $this->id)
            ->whereBy('enabled', 'Y')
            ->column('uri');

        if (empty($url) && !empty($approvedUrls)) {
            return false;
        }

        foreach ($approvedUrls as $approvedUrl) {
            if (stripos($url, $approvedUrl) === 0) {
                return true;
            }
        }

        return false;
    }

    public function isValidBasicToken($clientId, $token)
    {
        return $token == base64_encode($clientId . ":" . $this->secret);
    }
}