<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property SecureValue  $personalDetails          Optional. Credentials for encrypted personal details
 * @property SecureValue  $passport                 Optional. Credentials for encrypted passport
 * @property SecureValue  $internalPassport         Optional. Credentials for encrypted internal passport
 * @property SecureValue  $driverLicense            Optional. Credentials for encrypted driver license
 * @property SecureValue  $identityCard             Optional. Credentials for encrypted ID card
 * @property SecureValue  $address                  Optional. Credentials for encrypted residential address
 * @property SecureValue  $utilityBill              Optional. Credentials for encrypted utility bill
 * @property SecureValue  $bankStatement            Optional. Credentials for encrypted bank statement
 * @property SecureValue  $rentalAgreement        	Optional. Credentials for encrypted rental agreement
 * @property SecureValue  $passportRegistration     Optional. Credentials for encrypted registration from internal passport
 * @property SecureValue  $temporaryRegistration    Optional. Credentials for encrypted temporary registration
 *
 * @link https://core.telegram.org/bots/api#securedata
 */
class SecureData extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'personal_details'       => SecureValue::class,
            'passport'               => SecureValue::class,
            'internal_passport'      => SecureValue::class,
            'driver_license'         => SecureValue::class,
            'identity_card'          => SecureValue::class,
            'address'                => SecureValue::class,
            'utility_bill'           => SecureValue::class,
            'bank_statement'         => SecureValue::class,
            'rental_agreement'       => SecureValue::class,
            'passport_registration'  => SecureValue::class,
            'temporary_registration' => SecureValue::class,
        ];
    }
}
