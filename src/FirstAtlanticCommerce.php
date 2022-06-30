<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Jordanbain\FirstAtlanticCommerce\API\AbstractAPI;
use Jordanbain\FirstAtlanticCommerce\API\Trait\{Alive, SpiTransactions, TermMgmt, ThreeDSecure, TransactionQueries, Transactions};

class FirstAtlanticCommerce extends AbstractAPI
{
    use Alive, SpiTransactions, TermMgmt, ThreeDSecure, TransactionQueries, Transactions;
}
