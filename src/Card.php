<?php

namespace Jordanbain\FirstAtlanticCommerce;

use Closure;
use Jordanbain\FirstAtlanticCommerce\API\Transactions;
use Jordanbain\FirstAtlanticCommerce\Support\Parameters;

class Card
{
    use Parameters;

    //private object $body = new \stdClass();
    private object $body;
    private object $transactions;
    private string $powerTranzID;
    private string $powerTranzPassword;
    //private bool $isSPI = false;

    public function __construct(
        string $powerTranzID,
        string $powerTranzPassword,
        bool $isStaging = true
    )
    {
        $this->powerTranzID = $powerTranzID; // config('fac.powerTranzID');
        $this->powerTranzPassword  = $powerTranzPassword; // config('fac.powerTransPassword');
        $this->body = new \stdClass();
        $this->isSPI = true; // This set true if the commerce have it own website to process payment.

        $this->transactions = new Transactions($isStaging, $this->powerTranzID, $this->powerTranzPassword);
    }

    public function authorize(Closure $closure = null)
    {
        if ($closure) {
            $closure($this);
            $this->body->transactionType = 'authorize';
            return $this;
        }

        return $this->transactions->auth($this->isSPI, $this->toArray());
    }

    public function purchase(Closure $closure = null)
    {
        if ($closure) {
            $closure($this);
            $this->body->transactionType = 'purchase';
            return $this;
        }

        return $this->transactions->sale($this->isSPI, $this->toArray());
    }

    public function riskManagement(Closure $closure = null)
    {
        if ($closure) {
            $closure($this);
            $this->body->transactionType = 'riskManagement';
            return $this;
        }

        return $this->transactions->riskMgmt($this->isSPI, $this->toArray());
    }

    public function capture(
        string $transactionIdentifier,
        int $totalAmount,
        int $tipAmount = 0,
        int $taxAmount = 0,
        int $otherAmount = 0,
        string $externalIdentifier = null,
        string $externalGroupIdentifier = null
    )
    {
        return $this->transactions->captureRequest([
            'TransactionIdentifier' => $transactionIdentifier,
            'TotalAmount' => $totalAmount,
            'TipAmount' => $tipAmount,
            'TaxAmount' => $taxAmount,
            'OtherAmount' => $otherAmount,
            'ExternalIdentifier' => $externalIdentifier,
            'ExternalGroupIdentifier' => $externalGroupIdentifier,
        ]);
    }

    public function refund(Closure $closure = null)
    {
        if ($closure) $closure($this);

        return $this->transactions->refundRequest();
    }

    public function void()
    {
        return $this->transactions->voidRequest();
    }

    public function toArray(): array
    {
        return collect($this->body)->toArray();
    }

    public function validate()
    {
        return $this;
    }

    public function send()
    {
        return $this->{$this->body->transactionType};
    }
}
