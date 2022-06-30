<?php

namespace Jordanbain\FirstAtlanticCommerce\API\Trait;

use Jordanbain\FirstAtlanticCommerce\Support\ValidationRules;

/**
 * SpiTransaction trait
 */
trait Transactions
{
    public function auth(array $params = [], array $headers = [])
    {
        return $this->post('Auth', $params, $headers, ValidationRules::auth());
    }

    public function incrementalAuth(array $params = [], array $headers = [])
    {
        return $this->post('IncrementalAuth', $params, $headers, ValidationRules::auth());
    }

    public function sale(array $params = [], array $headers = [])
    {
        return $this->post('Sale', $params, $headers, ValidationRules::sale());
    }

    public function riskMgmt(array $params = [], array $headers = [])
    {
        return $this->post('RiskMgmt', $params, $headers, ValidationRules::riskMgmt());
    }

    public function payment(string $token, array $headers =[])
    {
        return $this->post('Payment', [$token], $headers);
    }

    public function capture(array $params = [], array $headers = [])
    {
        return $this->post('Capture', $params, $headers, ValidationRules::capture());
    }

    public function refund(array $params = [], array $headers = [])
    {
        return $this->post('Refund', $params, $headers, ValidationRules::refund());
    }

    public function void(array $params = [], array $headers = [])
    {
        return $this->post('Void', $params, $headers, ValidationRules::void());
    }
}
