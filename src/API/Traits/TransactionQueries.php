<?php

namespace Jordanbain\FirstAtlanticCommerce\API\Trait;

/**
 * TransactionQueries Trait
 */
trait TransactionQueries
{
    public function search(array $params = [], array $headers = [])
    {
        return $this->get('Transactions/Search', $params, $headers);
    }

    public function details(string $transactionID, array $params = [], array $headers)
    {
        return $this->get('Transactions/' . $transactionID, $params, $headers);
    }

    public function orderSearch(string $transactionID, array $params = [], array $headers = [])
    {
        return $this->get('Transactions/OrderSearch/' . $transactionID, $headers, $headers);
    }
}
