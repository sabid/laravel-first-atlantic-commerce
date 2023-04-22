<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use Jordanbain\FirstAtlanticCommerce\Support\ValidationRules;

/**
 * SpiTransaction trait
 */
class Transactions extends AbstractAPI
{
    public function __construct(bool $isStaging, ?string $powerTranzID = null, ?string $powerTranzPassword = null)
    {
        parent::__construct($isStaging, $powerTranzID, $powerTranzPassword);
    }

    public function auth(bool $isSPI, array $params = [], array $headers = [])
    {
        $path = $isSPI ? 'spi/Auth' : 'Auth';

        return $this->post($path, $params, $headers, ValidationRules::auth());
    }

    public function incrementalAuth(array $params = [], array $headers = [])
    {
        return $this->post('IncrementalAuth', $params, $headers, ValidationRules::auth());
    }

    public function sale(bool $isSPI, array $params = [], array $headers = [])
    {
        $path = $isSPI ? 'spi/Sale' : 'Sale';

        return $this->post($path, $params, $headers, ValidationRules::sale());
    }

    public function riskMgmt(bool $isSPI, array $params = [], array $headers = [])
    {
        $path = $isSPI ? 'spi/RiskMgmt' : 'RiskMgmt';

        return $this->post($path, $params, $headers, ValidationRules::riskMgmt());
    }

    public function payment(bool $isSPI, string $token, array $headers = [])
    {
        $path = $isSPI ? 'spi/Payment' : 'Payment';

        return $this->postSingle($path, $token, $headers);
    }

    public function captureRequest(array $params = [], array $headers = [])
    {
        return $this->post('Capture', $params, $headers, ValidationRules::capture());
    }

    public function refundRequest(array $params = [], array $headers = [])
    {
        return $this->post('Refund', $params, $headers, ValidationRules::refund());
    }

    public function voidRequest(array $params = [], array $headers = [])
    {
        return $this->post('Void', $params, $headers, ValidationRules::void());
    }
}
