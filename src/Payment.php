<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Jordanbain\FirstAtlanticCommerce\API\Alive;
use Jordanbain\FirstAtlanticCommerce\API\Transactions;

class Payment
{
    private Transactions $transaction;
    private string $token;

    public function __construct(string $token, bool $isStaging = true)
    {
        $this->transaction = new Transactions($isStaging);
        $this->token = $token;
    }

    public function send()
    {
        return $this->transaction->payment($this->token);
    }
}
