<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * @property string  $type            Element type. One of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”, “address”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”, “phone_number”, “email”
 * @property bool    $selfie          Optional. Use this parameter if you want to request a selfie with the document as well. Available for “passport”, “driver_license”, “identity_card” and “internal_passport”
 * @property bool    $translation     Optional. Use this parameter if you want to request a translation of the document as well. Available for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration”. Note: We suggest to only request translations after you have received a valid document that requires one.
 * @property bool    $nativeNames     Optional. Use this parameter to request the first, last and middle name of the user in the language of the user's country of residence. Available for “personal_details”
 *
 * @link https://core.telegram.org/bots/api#passportscopeelementone
 */
class PassportScopeElementOne extends PassportScopeElement
{
}
