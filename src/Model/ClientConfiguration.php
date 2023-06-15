<?php


namespace PinaHttpClientManager\Model;

class ClientConfiguration
{

    protected $uri = '';
    protected $secret = '';
    protected $scopes = [];

    public function __construct(string $uri, string $secret, string $scopes)
    {
        $this->uri = $uri;
        $this->secret = $secret;
        $this->scopes = array_filter(preg_split("/[\s,]+/", $scopes));
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
}