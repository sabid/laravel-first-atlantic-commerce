<?php

namespace Jordanbain\FirstAtlanticCommerce\API\Trait;

/**
 * Alive trait
 */
trait Alive
{
    public function isAlive(array $params = [], array $headers = [])
    {
        return $this->get('alive', $params, $headers);
    }
}
