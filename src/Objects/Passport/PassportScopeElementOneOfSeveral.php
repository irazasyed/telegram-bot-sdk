<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * @property PassportScopeElementOne[]  $oneOf           List of elements one of which must be provided; must contain either several of “passport”, “driver_license”, “identity_card”, “internal_passport” or several of “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”, “temporary_registration”
 * @property bool                       $selfie          Optional. Use this parameter if you want to request a selfie with the document from this list that the user chooses to upload.
 * @property bool                       $translation     Optional. Use this parameter if you want to request a translation of the document from this list that the user chooses to upload. Note: We suggest to only request translations after you have received a valid document that requires one.
 *
 * @link https://core.telegram.org/bots/api#passportscopeelementoneofseveral
 */
class PassportScopeElementOneOfSeveral extends PassportScopeElement
{
}
