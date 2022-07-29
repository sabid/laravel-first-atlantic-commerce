<?php

namespace Jordanbain\FirstAtlanticCommerce\Support;

use Illuminate\Support\Arr;
use stdClass;

/**
 * Parameters trait
 */
trait Parameters
{
    public bool $isSPI = false, $addressMatch = false;

    public function setAmount(
        float $total,
        float $tip = 0,
        float $tax = 0,
        float $other = 0
    )
    {
        $this->body->TotalAmount = $total;
        $this->body->TipAmount = $tip;
        $this->body->TaxAmount = $tax;
        $this->body->OtherAmount = $other;

        return $this;
    }

    public function setCurrency(string $currency)
    {
        $this->body->Currency = $currency;

        return $this;
    }

    public function setCard(
        string $number,
        string $expiry,
        string $cvv,
        string $holderName
    )
    {
        $card = is_array($number)
            ? $number
            : [
                'CardPan' => $number,
                'CardExpiry' => $expiry,
                'CardCVV' => $cvv,
                'CardHolderName' => $holderName,
            ]
        ;

        $this->body->Source = $card;
    }

    public function setCardOptions(
        bool $cardPresent = false,
        bool $cardEMVFallback = false,
        bool $manuelEntry = false,
        bool $debit = false,
        string $accountType = null,
        bool $contactless = false,
        string $maskedPan = null,
        string $token = null,
        string $tokenType = null,
        array $additionalOptions = []
    )
    {
        $this->body->Source = Arr::collapse([
            'CardPresent' => $cardPresent,
            'CardEMVFallback' => $cardEMVFallback,
            'ManualEntry' => $manuelEntry,
            'Debit' => $debit,
            'AccountType' => $accountType,
            'Contactless' => $contactless,
            'MaskedPan' => $maskedPan,
            'Token' => $token,
            'TokenType' => $tokenType
        ], $additionalOptions);

        return $this;
    }

    public function setBillingAddress(
        string $firstName,
        string $lastName = null,
        string $city = null,
        string $state = null,
        string $country = null,
        string $postalCode = null,
        string $countryCode = null,
        string $phone = null,
        string $email = null
    )
    {
        $billingAddress = is_array($firstName)
            ? $firstName
            : [
                'FirstName' => $firstName,
                'LastName' => $lastName,
                'City' => $city,
                'State' => $state,
                'Country' => $country,
                'PostalCode' => $postalCode,
                'CountryCode' => $countryCode,
                'Phone' => $phone,
                'EmailAddress' => $email,
            ]
        ;

        $this->body->BillingAddress = $billingAddress;

        return $this;
    }

    public function setShippingAddress(
        string $firstName,
        string $lastName = null,
        string $city = null,
        string $state = null,
        string $country = null,
        string $postalCode = null,
        string $countryCode = null,
        string $phone = null,
        string $email = null
    )
    {
        $shippingAddress = is_array($firstName)
            ? $firstName
            : [
                'FirstName' => $firstName,
                'LastName' => $lastName,
                'City' => $city,
                'State' => $state,
                'Country' => $country,
                'PostalCode' => $postalCode,
                'CountryCode' => $countryCode,
                'Phone' => $phone,
                'EmailAddress' => $email,
            ]
        ;

        $this->body->ShippingAddress = $shippingAddress;

        return $this;
    }

    public function set3DS(
        int $challengeWindowSize = 1,
        int $challendeIndicator = 01,
        array $accountInfo = [],
        array $additionalOptions = []
    )
    {
        $this->body->ThreeDSecure = true;
        $this->body->ExtendedData['ThreeDSecure'] = Arr::collapse([[
            'ChallengeWindowSize' => $challengeWindowSize,
            'ChallengeIndicator' => $challendeIndicator,
        ], ['AccountInfo' => $accountInfo], $additionalOptions]);

        return $this;
    }

    /**
     * Get the values of Recurring
     *
     * @return void
     */
    public function getRecurring()
    {
        return $this->body->Recurring;
    }

    /**
     * Set the values of Recurring
     *
     * @param string $startDate
     * @param string $frequency
     * @param string $epiryDate
     * @return self
     */
    public function setRecurring(
        string $startDate,
        string $frequency,
        string $epiryDate
    )
    {
        $this->body->Recurring = true;
        $this->body->ExtendedData->Recurring = [
            'StartDate' => $startDate,
            'Frequency' => $frequency,
            'ExpiryDate' => $epiryDate,
        ];

        return $this;
    }
    
    /**
     * Get the value of BrowserInfo
     */ 
    public function getBrowserInfo()
    {
        return $this->body->BrowserInfo;
    }

    /**
     * Set the value of BrowserInfo
     *  
     * @param string $acceptHeader,
     * @param string $language,
     * @param string $screenHeight,
     * @param string $screenWidth,
     * @param string $timeZone,
     * @param string $userAgent,
     * @param string $iP,
     * @param string $colorDepth,
     * @param bool $javaEnabled = false,
     * @param bool $javascriptEnabled = false
     * @return  self
     */
    public function setBrowserInfo(
        string $acceptHeader,
        string $language,
        string $screenHeight,
        string $screenWidth,
        string $timeZone,
        string $userAgent,
        string $iP,
        string $colorDepth,
        bool $javaEnabled = false,
        bool $javascriptEnabled = false
    )
    {
        $this->body->BrowserInfo = [
            'AcceptHeader' => $acceptHeader,
            'Language' => $language,
            'ScreenHeight' => $screenHeight,
            'ScreenWidth' => $screenWidth,
            'TimeZone' => $timeZone,
            'UserAgent' => $userAgent,
            'IP' => $iP,
            'ColorDepth' => $colorDepth,
            'JavaEnabled' => $javaEnabled,
            'JavascriptEnabled' => $javascriptEnabled,
        ];

        return $this;
    }
    
    /**
     * Get the value of HostedPage
     */ 
    public function getHostedPage()
    {
        return $this->body->HostedPage;
    }

    /**
     * Set the values of Hosted Payment Page 
     *
     * @param string $pageSet
     * @param string $pageName
     * @return void
     */
    public function setHostedPage(string $pageSet, string $pageName)
    {
        $this->body->HostedPage = [
            'PageSet' => $pageSet,
            'PageName' => $pageName,
        ];

        return $this;
    }
    
    /**
     * Get the value of accountVerification
     */ 
    public function getAccountVerification()
    {
        return $this->Body->AccountVerification;
    }

    /**
     * Set the value of accountVerification
     *
     * @return  self
     */ 
    public function setAccountVerification(bool $accountVerification)
    {
        $this->body->AccountVerification = $accountVerification;

        return $this;
    }

    /**
     * Get the value of cardOnFile
     */ 
    public function getCardOnFile()
    {
        return $this->body->CardOnFile;
    }

    /**
     * Set the value of cardOnFile
     *
     * @return  self
     */ 
    public function setCardOnFile(bool $cardOnFile)
    {
        $this->body->CardOnFile = $cardOnFile;

        return $this;
    }

    /**
     * Get the value of recurringInitial
     */ 
    public function getRecurringInitial()
    {
        return $this->body->RecurringInitial;
    }

    /**
     * Set the value of recurringInitial
     *
     * @return  self
     */ 
    public function setRecurringInitial(bool $recurringInitial)
    {
        $this->body->RecurringInitial = $recurringInitial;

        return $this;
    }

    /**
     * Get the value of fruadCheck
     */ 
    public function getFruadCheck()
    {
        return $this->body->FruadCheck;
    }

    /**
     * Set the value of fruadCheck
     *
     * @return  self
     */ 
    public function setFruadCheck(bool $fruadCheck)
    {
        $this->Body->FruadCheck = $fruadCheck;

        return $this;
    }

    /**
     * Get the value of binCheck
     */ 
    public function getBinCheck()
    {
        return $this->body->binCheck;
    }

    /**
     * Set the value of binCheck
     *
     * @return  self
     */ 
    public function setBinCheck(bool $binCheck)
    {
        $this->body->BinCheck = $binCheck;

        return $this;
    }

    /**
     * Get the value of addressVerification
     */ 
    public function getAddressVerification()
    {
        return $this->body->addressVerification;
    }

    /**
     * Set the value of addressVerification
     *
     * @return  self
     */ 
    public function setAddressVerification(bool $addressVerification)
    {
        $this->body->AddressVerification = $addressVerification;

        return $this;
    }

    /**
     * Get the value of transactionIdentifier
     */ 
    public function getTransactionIdentifier()
    {
        return $this->TransactionIdentifier;
    }

    /**
     * Set the value of transactionIdentifier
     *
     * @return  self
     */ 
    public function setTransactionIdentifier(string $transactionIdentifier)
    {
        $this->body->TransactionIdentifier = $transactionIdentifier;

        return $this;
    }

    /**
     * Get the value of merchantResponseUrl
     */ 
    public function getMerchantResponseUrl()
    {
        return $this->body->MerchantResponseUrl;
    }

    /**
     * Set the value of merchantResponseUrl
     *
     * @return  self
     */ 
    public function setMerchantResponseUrl(string $merchantResponseUrl)
    {
        $this->body->MerchantResponseUrl = $merchantResponseUrl;

        return $this;
    }
}
