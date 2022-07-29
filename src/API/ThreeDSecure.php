<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use Jordanbain\FirstAtlanticCommerce\API\AbstractAPI;

/**
 * ThreeDSecure Trait
 */
class ThreeDSecure extends AbstractAPI
{
    public function auth3DS2(string $token, array $headers = [])
    {
        return $this->post('3DS2/Authenticate', [$token], $headers);
    }

    public function auth3DS1(string $token, array $headers = [])
    {
        return $this->post('3DS1/Authenticate', [$token], $headers);
    }
}
