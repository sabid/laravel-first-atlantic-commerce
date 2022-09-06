<?php

namespace Jordanbain\FirstAtlanticCommerce\Support;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ValidationRules
{
    private const REGULAR = [
        'TransactionIdentifier' =>'required|string|max:200', // max_36
        //'TotalAmount' => 'required|numeric|min:3|max:18', // El campo total amount no debe ser mayor a 18
        'TotalAmount' => 'required|numeric', // El campo total amount no debe ser mayor a 18
        'TipAmount' => 'numeric',
        'TaxAmount' => 'numeric',
        'OtherAmount' => 'numeric',
        'CurrencyCode' => 'required|max:4',
        'LocalTime' => 'string',
        'LocalDate' => 'string',
        'AddressVerification' => 'boolean',
        'ThreeDSecure' => 'required|boolean',
        'BinCheck' => 'boolean',
        'FraudCheck' => 'boolean',
        'RecurringInitial' => 'boolean',
        'Recurring' => 'boolean',
        'CardOnFile' => 'boolean',
        'AccountVerification' => 'boolean',
        'Tokenize' => 'boolean',
        'OrderIdentifier' => 'required|string|max:255',
        'AddressMatch' => 'boolean',
        //* Terminal
        'TerminalId' => 'string',
        'TerminalCode' => 'string',
        'TerminalSerialNumber' => 'string',
        //* External Identifier
        'ExternalIdentifier' => 'string',
        'ExternalBatchIdentifier' => 'string',
        'ExternalGroupIdentifier' => 'string',
    ];

    private const SOURCE = [
        'Source' => 'required|array'
    ];

    /**
     * @return array
     */
    public static function getSource(): array
    {
        return
            Arr::collapse([
                self::SOURCE,
                Arr::dot([
                    'Source' => [
                        'CardPan' => 'required|numeric',
                        'CardCvv' => 'numeric',
                        'CardExpiration' => 'required|numeric',
                        'CardHolderName' => 'required|string',
                        'Token' => 'string|max:100',
                        'TokenType' => Rule::in(['PG2']),
                        'CardTrack1Data' => 'string',
                        'CardTrack2Data' => 'string',
                        'CardTrack3Data' => 'string',
                        'CardTrackData' => 'string',
                        'EncryptedCardTrack1Data' => 'string',
                        'EncryptedCardTrack2Data' => 'string',
                        'EncryptedCardTrack3Data' => 'string',
                        'EncryptedCardTrackData' => 'string',
                        'Ksn' => 'string',
                        'EncryptedPinBlock' => 'string',
                        'PinBlockKsn' => 'string',
                        'CardEmvData' => 'string',
                        //'CardholderName' => 'string'
                    ]
                ])
            ]);
    }

    private const EXTENDED_DATA = [
        'ExtendedData'=> 'required|array',
    ];

    public static function getExtendedData(): array
    {
        return
            Arr::collapse([
                self::EXTENDED_DATA,
                Arr::dot([
                    'ExtendedData' => [
                        //self::address('Secondary'),
                        'CustomData'=> 'string',
                        'Level2CustomData'=> 'string',
                        'Level3CustomData'=> 'string',
                        'ThreeDSecure' => 'required|array',
                        //self::THREE_D_SECURE,
                        self::getTheeDSecure(),
                        'Recurring' => 'array',
                        //self::RECURRING,
                        self::getReccurring(),
                        'BrowserInfo' => 'array',
                        //self::BROWSER_INFO,
                        self::getBrowserInfo(),
                        'MerchantResponseUrl'=> 'string|max:255',
                        'HostedPage' => 'array',
                        //self::HOSTED_PAGE
                        self::getHostedPage(),
                    ]
                ])
            ]);
    }

    public static function getTheeDSecure() : array
    {
        return Arr::dot([
            'ThreeDSecure'=> [
                'Eci'=> 'string',
                'Cavv'=> 'string',
                'Xid'=> 'string',
                'AuthenticationStatus'=> 'string',
                'ProtocolVersion'=> 'string',
                'DSTransId'=> 'string',
                'ChallengeWindowSize'=> Rule::in([1,2,3,4,5]),
                'ChannelIndicator'=> Rule::in([01,02,03,04]),
                'RiIndicator'=> 'string',
                'ChallengeIndicator'=> 'string',
                'AuthenticationIndicator'=> 'string',
                'MessageCategory'=> 'string',
                'TransactionType'=> 'string',
                'AccountInfo' => 'array',
                //self::ACCOUNTINFO,
            ]
        ]);
    }

    public static function getAccountInfo() : array
    {
        return Arr::dot([
            'AccountInfo'=> [
                'AccountAgeIndicator'=> 'string',
                'AccountChangeDate'=> 'string',
                'AccountChangeIndicator'=> 'string',
                'AccountDate'=> 'string',
                'AccountPasswordChangeDate'=> 'string',
                'AccountPasswordChangeIndicator'=> 'string',
                'AccountPurchaseCount'=> 'string',
                'AccountProvisioningAttempts'=> 'string',
                'AccountDayTransactions'=> 'string',
                'AccountYearTransactions'=> 'string',
                'PaymentAccountAge'=> 'string',
                'PaymentAccountAgeIndicator'=> 'string',
                'ShipAddressUsageDate'=> 'string',
                'ShipAddressUsageIndicator'=> 'string',
                'ShipNameIndicator'=> 'string',
                'SuspiciousAccountActivity'=> 'string'
            ]
        ]);
    }

    public static function getReccurring() : array
    {
        return Arr::dot([
            'Recurring'=> [
                'StartDate'=> 'string',
                'Frequency'=> 'string',
                'ExpiryDate'=> 'string'
            ]
        ]);
    }

    public static function getBrowserInfo() : array
    {
        return Arr::dot([
            'BrowserInfo'=> [
                'AcceptHeader'=> 'string',
                'Language'=> 'string',
                'ScreenHeight'=> 'string',
                'ScreenWidth'=> 'string',
                'TimeZone'=> 'string',
                'UserAgent'=> 'string',
                'IP'=> 'string',
                'JavaEnabled'=> 'boolean',
                'JavascriptEnabled'=> 'boolean',
                'ColorDepth'=> 'string'
            ]
        ]);
    }

    public static function getHostedPage() : array
    {
        return Arr::dot([
            'HostedPage'=> [
                'PageSet'=> 'string',
                'PageName'=> 'string'
            ]
        ]);
    }

    private static function address(string $type = 'Billing'): array
    {
        return [
            $type . 'Address' => 'required|array',
            Arr::dot([
                $type . 'Address' => [
                    'FirstName' => 'max:30',
                    'LastName' => 'max:30',
                    'Line1' => 'max:30',
                    'Line2' => 'max:50',
                    'City' => 'max:25',
                    'County' => 'max:25',
                    'State' => 'max:25',
                    'PostalCode' => 'max:10',
                    'CountryCode' => 'max:3',
                    'EmailAddress' => 'max:50',
                    'PhoneNumber' => 'max:20',
                    'PhoneNumber2' => 'max:20',
                    'PhoneNumber3' => 'max:20'
                ]
            ])
        ];
    }

    private const CAPTURE = [
        'TransactionIdentifier' => 'required|string',
        'TotalAmount' => 'required|numeric',
        'TipAmount' => 'numeric',
        'TaxAmount' => 'numeric',
        'OtherAmount' => 'numeric',
        'ExternalIdentifier' => 'string',
        'ExternalGroupIdentifier' => 'string'
    ],

    REFUND = [
        'Refund' => 'required|boolean',
        self::REGULAR,
        self::SOURCE,
        self::EXTENDEDDATA
    ],

    VOID = [
        'TransactionIdentifier' => 'required|string',
        'ExternalIdentifier' => 'string',
        'ExternalGroupIdentifier' => 'string',
        'EmvData' => 'string',
        'TerminalCode' => 'string',
        'TerminalSerialNumber' => 'string',
        'AutoReversal' => 'boolean'
    ];

    public static function auth()
    {
        return Arr::collapse([
            self::REGULAR,
            self::getSource(),
            self::getExtendedData(),
        ]);
    }

    public static function sale()
    {
        return Arr::collapse([
            self::REGULAR,
            self::SOURCE,
            self::EXTENDEDDATA
        ]);
    }

    public static function riskMgmt()
    {
        return Arr::collapse([
            self::REGULAR,
            self::getSource(),
            self::getExtendedData(),
            self::address('Billing')
        ]);
    }

    public static function capture()
    {
        return self::CAPTURE;
    }

    public static function refund()
    {
        return self::REFUND;
    }

    public static function void()
    {
        return self::VOID;
    }
}
