<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use Jordanbain\FirstAtlanticCommerce\API\AbstractAPI;

/**
 * TermMgmt Trait
 */
class TermMgmt extends AbstractAPI
{
    public function termMgmt(array $params = [], array $headers = [])
    {
        return $this->get('TermMgmt/LocalBins', $params, $headers);
    }
}
