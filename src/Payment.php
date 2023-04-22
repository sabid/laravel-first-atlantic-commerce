<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Jordanbain\FirstAtlanticCommerce\API\Alive;
use Jordanbain\FirstAtlanticCommerce\API\Transactions;
use Jordanbain\FirstAtlanticCommerce\Support\Parameters;

class Payment
{
    use Parameters;

    private object $body;
    private object $transaction;

    public function __construct(bool $isStaging = true)
    {
        $this->transaction = new Transactions($isStaging);
        $this->body = new \stdClass();
        $this->isSPI = true; // This set true if the commerce have it own website to process payment.
    }

    public function send()
    {
        return $this->transaction->payment($this->isSPI, $this->body->SpiToken);
    }

}
