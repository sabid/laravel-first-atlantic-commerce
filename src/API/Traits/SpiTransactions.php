<?php

namespace Jordanbain\FirstAtlanticCommerce\API\Trait;

use Jordanbain\FirstAtlanticCommerce\Support\ValidationRules;

/**
 * SpiTransaction trait
 */
trait SpiTransactions
{
    public function auth(array $params = [], array $headers = [])
    {
        return $this->post('spi/Auth', $params, $headers, ValidationRules::auth());
    }

    public function sale(array $params = [], array $headers = [])
    {
        return $this->post('spi/Sale', $params, $headers, ValidationRules::auth());
    }

    public function riskMgmt(array $params = [], array $headers = [])
    {
        return $this->post('spi/RiskMgmt', $params, $headers, ValidationRules::auth());
    }

    public function payment(string $token, array $headers =[])
    {
        return $this->post('spi/Payment', [$token], $headers);
    }
}
