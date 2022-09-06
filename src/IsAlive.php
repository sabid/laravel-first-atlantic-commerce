<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Jordanbain\FirstAtlanticCommerce\API\Alive;

class IsAlive
{
    private $alive;
    private string $powerTranzID;
    private string $powerTranzPassword;

    public function __construct(string $powerTranzID, string $powerTranzPassword, bool $isStaging = false)
    {
        $this->powerTranzID = config('fac.powerTranzID');
        $this->powerTranzPassword  = config('fac.powerTransPassword');

        $this->alive = new Alive($this->powerTranzID, $this->powerTranzPassword, $isStaging);
    }

    public function __invoke()
    {
        return $this->alive->isAlive();
    }
}
