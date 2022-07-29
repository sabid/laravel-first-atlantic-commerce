<?php

namespace Jordanbain\FirstAtlanticCommerce\API;

use Jordanbain\FirstAtlanticCommerce\API\AbstractAPI;

/**
 * TransactionQueries Trait
 */
class TransactionQueries extends AbstractAPI
{
    public function search(array $params = [], array $headers = [])
    {
        return $this->get('Transactions/Search', $params, $headers);
    }

    public function transactionQuiriesDetails(string $transactionID, array $params = [], array $headers)
    {
        return $this->get('Transactions/' . $transactionID, $params, $headers);
    }

    public function orderSearch(string $transactionID, array $params = [], array $headers = [])
    {
        return $this->get('Transactions/OrderSearch/' . $transactionID, $headers, $headers);
    }
}
