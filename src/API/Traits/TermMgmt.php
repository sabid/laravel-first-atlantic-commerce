<?php

namespace Jordanbain\FirstAtlanticCommerce\API\Trait;

/**
 * TermMgmt Trait
 */
trait TermMgmt
{
    public function details(array $params = [], array $headers = [])
    {
        return $this->get('TermMgmt/LocalBins', $params, $headers);
    }
}
