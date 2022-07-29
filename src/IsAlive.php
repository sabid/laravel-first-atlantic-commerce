<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Jordanbain\FirstAtlanticCommerce\API\Alive;

class IsAlive
{
    private $alive;

    public function __construct(
        string $powerTranzID = config('fac.powerTranzID'),
        string $powerTranzPassword  = config('fac.powerTransPassword'),
        bool $isStaging = false,
    )
    {
        $this->alive = new Alive($powerTranzID, $powerTranzPassword, $isStaging);
    }

    public function __invoke()
    {
        return $this->alive->isAlive();
    }
}
