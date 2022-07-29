<?php

namespace Jordanbain\FirstAtlanticCommerce\Support;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ValidationRules
{
    private const REGULAR = [
        'TransactionIdentifier' =>'required|string|max:36',
        'TotalAmount' => 'required|numeric|min:3|max:18',
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
    ],
    
    SOURCE = [
        'Source' => 'required|array',
        Arr::dot([
            'Source' => [
                'CardPan' => 'required|integer|max:19',
                'CardCvv' => 'integer|max:4',
                'CardExpiration' => 'required|numeric|max:4',
                'CardholderName' => 'required|string|min:2|max:45',
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
                'CardholderName' => 'string'
            ]
        ])
    ],
    
    EXTENDEDDATA = [
        'ExtendedData'=> 'required|array',
        Arr::dot([
            'ExtendedData' => [
                $this->address('Secondary'),
                'CustomData'=> 'string',
                'Level2CustomData'=> 'string',
                'Level3CustomData'=> 'string',
                'ThreeDSecure' => 'required|array',
                SELF::THREEDSECURE,
                'Recurring' => 'array',
                SELF::RECURRING,
                'BrowserInfo' => 'array',
                SELF::BROWSERINFO,
                'MerchantResponseUrl'=> 'string|max:255',
                'HostedPage' => 'array',
                SELF::HOSTEDPAGE
            ]
        ])
    ],
    
    THREEDSECURE = Arr::dot([
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
            SELF::ACCOUNTINFO,
        ]
    ]),
    
    ACCOUNTINFO = Arr::dot([
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
    ]),
    
    RECURRING = Arr::dot([
        'Recurring'=> [
            'StartDate'=> 'string',
            'Frequency'=> 'string',
            'ExpiryDate'=> 'string'
        ]
    ]),
    
    BROWSERINFO = Arr::dot([
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
    ]),
    
    HOSTEDPAGE = Arr::dot([
        'HostedPage'=> [
            'PageSet'=> 'string',
            'PageName'=> 'string'
        ]
    ]);

    private function address(string $type = 'Billing')
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
        SELF::REGULAR,
        SELF::SOURCE,
        SELF::EXTENDEDDATA
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
            SELF::REGULAR,
            SELF::SOURCE,
            SELF::EXTENDEDDATA
        ]);    
    }

    public static function sale()
    {
        return Arr::collapse([
            SELF::REGULAR,
            SELF::SOURCE,
            SELF::EXTENDEDDATA
        ]);
    }

    public static function riskMgmt()
    {
        return Arr::collapse([
            SELF::REGULAR,
            SELF::SOURCE,
            SELF::EXTENDEDDATA
        ]);
    }

    public static function capture()
    {
        return SELF::CAPTURE;
    }

    public static function refund()
    {
        return SELF::REFUND;
    }

    public static function void()
    {
        return SELF::VOID;
    }
}
