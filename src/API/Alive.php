<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use Jordanbain\FirstAtlanticCommerce\API\AbstractAPI;

/**
 * Alive trait
 */
class Alive extends AbstractAPI
{
    public function isAlive(array $params = [], array $headers = [])
    {
        return $this->get('alive', $params, $headers);
    }
}
