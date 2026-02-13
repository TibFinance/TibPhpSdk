<?php

namespace TibFinanceSDK;

require("Crypto/TibCrypto.php");

/**
 * ServerCaller is a class who implemet all TIB FINANCE API methods
 */
class ServerCaller
{
    private $tibCrypto;
 
    public function __construct()
    {
        // $this->tibCrypto = new TibCrypto($url);
    }

    /**
     * Set up the Api Url .
     * @param string tha api's Url  
     * 
     */
    public function SetUrl($url)
    {
        $this->tibCrypto = new TibCrypto($url);
    }

    
    /**
     * Creates the session.
      * @param string $clientId
 * @param string $username
 * @param string $password

     *
     * @return json
     */
    public function createSession(
        $clientId,
$username,
$password
    ) {
        $methodName = "/Data/CreateSession";

        $data = [
            "ClientId" => $clientId,
"Username" => $username,
"Password" => $password,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the services.
      * @param string $sessionToken
 * @param string $merchantId

     *
     * @return json
     */
    public function listServices(
        $sessionToken,
$merchantId = null
    ) {
        $methodName = "/Data/ListServices";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the service.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $merchantId

     *
     * @return json
     */
    public function getService(
        $sessionToken,
$serviceId,
$merchantId = null
    ) {
        $methodName = "/Data/GetService";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the service.
      * @param string $sessionToken
 * @param string $serviceId

     *
     * @return json
     */
    public function getWalletInformationsByService(
        $sessionToken,
$serviceId
    ) {
        $methodName = "/Data/GetWalletInformationsByService";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the merchants.
      * @param string $sessionToken
 * @param string $serviceId
 * @param bool $includeClientMerchants
 * @param string $merchantId

     *
     * @return json
     */
    public function listMerchants(
        $sessionToken,
$serviceId,
$includeClientMerchants,
$merchantId = null
    ) {
        $methodName = "/Data/ListMerchants";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"MerchantId" => $merchantId,
"IncludeClientMerchants" => $includeClientMerchants,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the merchants with boarding.
      * @param string $sessionToken
 * @param string $boardingServiceId

     *
     * @return json
     */
    public function getServiceBoardingStatus(
        $sessionToken,
$boardingServiceId
    ) {
        $methodName = "/Data/GetServiceBoardingStatus";

        $data = [
            "SessionToken" => $sessionToken,
"BoardingServiceId" => $boardingServiceId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the merchant.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $merchantName
 * @param string $externalSystemId
 * @param string $externalSystemGroupId
 * @param string $merchantCurrency
 * @param string $language
 * @param string $email
 * @param string $emailCopyTo
 * @param string $phoneNumber
 * @param string $merchantDescription
 * @param string $streetAddress
 * @param string $addressCity
 * @param string $postalZipCode
 * @param string $accountName
 * @param string $owner
 * @param string $firstName
 * @param string $lastName
 * @param string $bankNumber
 * @param string $institutionNumber
 * @param string $accountNumber
 * @param string $routingNumber
 * @param string $checkDigit
 * @param string $fullAccountNumber
 * @param string $accountNumberWithCheckDigit
 * @param string $previewString
 * @param string $provinceStateId
 * @param string $countryId
 * @param string $favoriteProvider
 * @param string $accountType
 * @param string $currency

     *
     * @return json
     */
    public function createMerchant(
        $sessionToken,
$serviceId,
$merchantName,
$externalSystemId,
$externalSystemGroupId,
$merchantCurrency,
$language,
$email,
$emailCopyTo,
$phoneNumber,
$merchantDescription,
$streetAddress,
$addressCity,
$postalZipCode,
$accountName,
$owner,
$firstName,
$lastName,
$bankNumber,
$institutionNumber,
$accountNumber,
$routingNumber,
$checkDigit,
$fullAccountNumber,
$accountNumberWithCheckDigit,
$previewString,
$provinceStateId = null,
$countryId = null,
$favoriteProvider = null,
$accountType = null,
$currency = null
    ) {
        $methodName = "/Data/CreateMerchant";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"MerchantInfo" => [
"MerchantName" => $merchantName,
"ExternalSystemId" => $externalSystemId,
"ExternalSystemGroupId" => $externalSystemGroupId,
"MerchantCurrency" => $merchantCurrency,
"Language" => $language,
"Email" => $email,
"EmailCopyTo" => $emailCopyTo,
"PhoneNumber" => $phoneNumber,
"MerchantDescription" => $merchantDescription,
"Address" => [
"StreetAddress" => $streetAddress,
"AddressCity" => $addressCity,
"ProvinceStateId" => $provinceStateId,
"CountryId" => $countryId,
"PostalZipCode" => $postalZipCode
],
"FavoriteProvider" => $favoriteProvider,
"Account" => [
"AccountName" => $accountName,
"Owner" => $owner,
"FirstName" => $firstName,
"LastName" => $lastName,
"AccountType" => $accountType,
"BankNumber" => $bankNumber,
"InstitutionNumber" => $institutionNumber,
"AccountNumber" => $accountNumber,
"RoutingNumber" => $routingNumber,
"CheckDigit" => $checkDigit,
"Currency" => $currency,
"FullAccountNumber" => $fullAccountNumber,
"AccountNumberWithCheckDigit" => $accountNumberWithCheckDigit,
"PreviewString" => $previewString
]
],
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the merchant.
      * @param string $sessionToken
 * @param string $merchantId

     *
     * @return json
     */
    public function getMerchant(
        $sessionToken,
$merchantId
    ) {
        $methodName = "/Data/GetMerchant";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Saves the merchant.
      * @param string $sessionToken
 * @param string $merchantId
 * @param string $merchantName
 * @param string $externalSystemId
 * @param string $externalSystemGroupId
 * @param string $merchantCurrency
 * @param string $language
 * @param string $email
 * @param string $emailCopyTo
 * @param string $phoneNumber
 * @param string $merchantDescription
 * @param string $streetAddress
 * @param string $addressCity
 * @param string $postalZipCode
 * @param string $accountName
 * @param string $owner
 * @param string $firstName
 * @param string $lastName
 * @param string $bankNumber
 * @param string $institutionNumber
 * @param string $accountNumber
 * @param string $routingNumber
 * @param string $checkDigit
 * @param string $fullAccountNumber
 * @param string $accountNumberWithCheckDigit
 * @param string $previewString
 * @param string $provinceStateId
 * @param string $countryId
 * @param string $favoriteProvider
 * @param string $accountType
 * @param string $currency

     *
     * @return json
     */
    public function saveMerchant(
        $sessionToken,
$merchantId,
$merchantName,
$externalSystemId,
$externalSystemGroupId,
$merchantCurrency,
$language,
$email,
$emailCopyTo,
$phoneNumber,
$merchantDescription,
$streetAddress,
$addressCity,
$postalZipCode,
$accountName,
$owner,
$firstName,
$lastName,
$bankNumber,
$institutionNumber,
$accountNumber,
$routingNumber,
$checkDigit,
$fullAccountNumber,
$accountNumberWithCheckDigit,
$previewString,
$provinceStateId = null,
$countryId = null,
$favoriteProvider = null,
$accountType = null,
$currency = null
    ) {
        $methodName = "/Data/SaveMerchant";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"MerchantInfo" => [
"MerchantName" => $merchantName,
"ExternalSystemId" => $externalSystemId,
"ExternalSystemGroupId" => $externalSystemGroupId,
"MerchantCurrency" => $merchantCurrency,
"Language" => $language,
"Email" => $email,
"EmailCopyTo" => $emailCopyTo,
"PhoneNumber" => $phoneNumber,
"MerchantDescription" => $merchantDescription,
"Address" => [
"StreetAddress" => $streetAddress,
"AddressCity" => $addressCity,
"ProvinceStateId" => $provinceStateId,
"CountryId" => $countryId,
"PostalZipCode" => $postalZipCode
],
"FavoriteProvider" => $favoriteProvider,
"Account" => [
"AccountName" => $accountName,
"Owner" => $owner,
"FirstName" => $firstName,
"LastName" => $lastName,
"AccountType" => $accountType,
"BankNumber" => $bankNumber,
"InstitutionNumber" => $institutionNumber,
"AccountNumber" => $accountNumber,
"RoutingNumber" => $routingNumber,
"CheckDigit" => $checkDigit,
"Currency" => $currency,
"FullAccountNumber" => $fullAccountNumber,
"AccountNumberWithCheckDigit" => $accountNumberWithCheckDigit,
"PreviewString" => $previewString
]
],
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Saves the merchant basic information.
      * @param string $sessionToken
 * @param string $merchantId
 * @param string $merchantName
 * @param string $externalSystemId
 * @param string $externalSystemGroupId
 * @param string $merchantCurrency
 * @param string $language
 * @param string $email
 * @param string $emailCopyTo
 * @param string $phoneNumber
 * @param string $merchantDescription
 * @param string $streetAddress
 * @param string $addressCity
 * @param string $postalZipCode
 * @param string $provinceStateId
 * @param string $countryId
 * @param string $favoriteProvider

     *
     * @return json
     */
    public function saveMerchantBasicInfo(
        $sessionToken,
$merchantId,
$merchantName,
$externalSystemId,
$externalSystemGroupId,
$merchantCurrency,
$language,
$email,
$emailCopyTo,
$phoneNumber,
$merchantDescription,
$streetAddress,
$addressCity,
$postalZipCode,
$provinceStateId = null,
$countryId = null,
$favoriteProvider = null
    ) {
        $methodName = "/Data/SaveMerchantBasicInfo";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"MerchantInfo" => [
"MerchantName" => $merchantName,
"ExternalSystemId" => $externalSystemId,
"ExternalSystemGroupId" => $externalSystemGroupId,
"MerchantCurrency" => $merchantCurrency,
"Language" => $language,
"Email" => $email,
"EmailCopyTo" => $emailCopyTo,
"PhoneNumber" => $phoneNumber,
"MerchantDescription" => $merchantDescription,
"Address" => [
"StreetAddress" => $streetAddress,
"AddressCity" => $addressCity,
"ProvinceStateId" => $provinceStateId,
"CountryId" => $countryId,
"PostalZipCode" => $postalZipCode
],
"FavoriteProvider" => $favoriteProvider
],
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Saves the merchant account information.
      * @param string $sessionToken
 * @param string $merchantId
 * @param string $accountName
 * @param string $owner
 * @param string $firstName
 * @param string $lastName
 * @param string $bankNumber
 * @param string $institutionNumber
 * @param string $accountNumber
 * @param string $routingNumber
 * @param string $checkDigit
 * @param string $fullAccountNumber
 * @param string $accountNumberWithCheckDigit
 * @param string $previewString
 * @param string $accountType
 * @param string $currency

     *
     * @return json
     */
    public function saveMerchantAccountInfo(
        $sessionToken,
$merchantId,
$accountName,
$owner,
$firstName,
$lastName,
$bankNumber,
$institutionNumber,
$accountNumber,
$routingNumber,
$checkDigit,
$fullAccountNumber,
$accountNumberWithCheckDigit,
$previewString,
$accountType = null,
$currency = null
    ) {
        $methodName = "/Data/SaveMerchantAccountInfo";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"Account" => [
"AccountName" => $accountName,
"Owner" => $owner,
"FirstName" => $firstName,
"LastName" => $lastName,
"AccountType" => $accountType,
"BankNumber" => $bankNumber,
"InstitutionNumber" => $institutionNumber,
"AccountNumber" => $accountNumber,
"RoutingNumber" => $routingNumber,
"CheckDigit" => $checkDigit,
"Currency" => $currency,
"FullAccountNumber" => $fullAccountNumber,
"AccountNumberWithCheckDigit" => $accountNumberWithCheckDigit,
"PreviewString" => $previewString
],
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Deletes the merchant.
      * @param string $sessionToken
 * @param string $merchantId

     *
     * @return json
     */
    public function deleteMerchant(
        $sessionToken,
$merchantId
    ) {
        $methodName = "/Data/DeleteMerchant";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the merchants by external identifier.
      * @param string $sessionToken
 * @param string $externalSystemId
 * @param string $externalSystemGroupId

     *
     * @return json
     */
    public function getMerchantsByExternalId(
        $sessionToken,
$externalSystemId,
$externalSystemGroupId
    ) {
        $methodName = "/Data/GetMerchantsByExternalId";

        $data = [
            "SessionToken" => $sessionToken,
"ExternalSystemId" => $externalSystemId,
"ExternalSystemGroupId" => $externalSystemGroupId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the customers.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $merchantId
 * @param float $amount
 * @param string $mode
 * @param bool $useInterac

     *
     * @return json
     */
    public function adjustWallet(
        $sessionToken,
$serviceId,
$merchantId,
$amount,
$mode,
$useInterac
    ) {
        $methodName = "/Data/AdjustWallet";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"MerchantId" => $merchantId,
"Amount" => $amount,
"Mode" => $mode,
"UseInterac" => $useInterac,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the customers.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $merchantId

     *
     * @return json
     */
    public function listCustomers(
        $sessionToken,
$serviceId,
$merchantId = null
    ) {
        $methodName = "/Data/ListCustomers";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the customer.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $customerName
 * @param string $customerExternalId
 * @param string $customerDescription
 * @param string $customerEmail
 * @param Guid $paymentMethodId
 * @param bool $isCustomerAutomaticPaymentMethod
 * @param string $paymentMethodType
 * @param string $paymentMethodDescription
 * @param string $accountPreview
 * @param string $owner
 * @param Guid $merchantId
 * @param string $merchantName
 * @param ContactInfoModel $contactInfo
 * @param string $language
 * @param DateTime $expirationDate

     *
     * @return json
     */
    public function createCustomer(
        $sessionToken,
$serviceId,
$customerName,
$customerExternalId,
$customerDescription,
$customerEmail,
$paymentMethodId,
$isCustomerAutomaticPaymentMethod,
$paymentMethodType,
$paymentMethodDescription,
$accountPreview,
$owner,
$merchantId,
$merchantName,
$contactInfo,
$language = null,
$expirationDate = null
    ) {
        $methodName = "/Data/CreateCustomer";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"Customer" => [
"CustomerName" => $customerName,
"CustomerExternalId" => $customerExternalId,
"Language" => $language,
"CustomerDescription" => $customerDescription,
"CustomerEmail" => $customerEmail,
"PaymentMethods" => [
"PaymentMethodId" => $paymentMethodId,
"IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
"PaymentMethodType" => $paymentMethodType,
"PaymentMethodDescription" => $paymentMethodDescription,
"AccountPreview" => $accountPreview,
"ExpirationDate" => $expirationDate,
"Owner" => $owner,
"PreauthorizedMerchants" => [
"MerchantId" => $merchantId,
"MerchantName" => $merchantName
]
],
"ContactInfo" => $contactInfo
],
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the customer.
      * @param string $sessionToken
 * @param string $customerId
 * @param string $merchantId

     *
     * @return json
     */
    public function getCustomer(
        $sessionToken,
$customerId,
$merchantId = null
    ) {
        $methodName = "/Data/GetCustomer";

        $data = [
            "SessionToken" => $sessionToken,
"CustomerId" => $customerId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Saves the customer.
      * @param string $sessionToken
 * @param string $customerName
 * @param string $customerExternalId
 * @param string $customerDescription
 * @param string $customerEmail
 * @param Guid $paymentMethodId
 * @param bool $isCustomerAutomaticPaymentMethod
 * @param string $paymentMethodType
 * @param string $paymentMethodDescription
 * @param string $accountPreview
 * @param string $owner
 * @param Guid $merchantId
 * @param string $merchantName
 * @param ContactInfoModel $contactInfo
 * @param Guid $customerId
 * @param string $language
 * @param DateTime $expirationDate

     *
     * @return json
     */
    public function saveCustomer(
        $sessionToken,
$customerName,
$customerExternalId,
$customerDescription,
$customerEmail,
$paymentMethodId,
$isCustomerAutomaticPaymentMethod,
$paymentMethodType,
$paymentMethodDescription,
$accountPreview,
$owner,
$merchantId,
$merchantName,
$contactInfo,
$customerId,
$language = null,
$expirationDate = null
    ) {
        $methodName = "/Data/SaveCustomer";

        $data = [
            "SessionToken" => $sessionToken,
"Customer" => [
"CustomerName" => $customerName,
"CustomerExternalId" => $customerExternalId,
"Language" => $language,
"CustomerDescription" => $customerDescription,
"CustomerEmail" => $customerEmail,
"PaymentMethods" => [
"PaymentMethodId" => $paymentMethodId,
"IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
"PaymentMethodType" => $paymentMethodType,
"PaymentMethodDescription" => $paymentMethodDescription,
"AccountPreview" => $accountPreview,
"ExpirationDate" => $expirationDate,
"Owner" => $owner,
"PreauthorizedMerchants" => [
"MerchantId" => $merchantId,
"MerchantName" => $merchantName
]
],
"ContactInfo" => $contactInfo,
"CustomerId" => $customerId
],
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Deletes the customer.
      * @param string $sessionToken
 * @param string $customerId

     *
     * @return json
     */
    public function deleteCustomer(
        $sessionToken,
$customerId
    ) {
        $methodName = "/Data/DeleteCustomer";

        $data = [
            "SessionToken" => $sessionToken,
"CustomerId" => $customerId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the customers by external identifier.
      * @param string $sessionToken
 * @param string $externalCustomerId
 * @param string $merchantId

     *
     * @return json
     */
    public function getCustomersByExternalId(
        $sessionToken,
$externalCustomerId,
$merchantId = null
    ) {
        $methodName = "/Data/GetCustomersByExternalId";

        $data = [
            "SessionToken" => $sessionToken,
"ExternalCustomerId" => $externalCustomerId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the payment methods.
      * @param string $sessionToken
 * @param string $customerId
 * @param string $merchantId

     *
     * @return json
     */
    public function listPaymentMethods(
        $sessionToken,
$customerId,
$merchantId = null
    ) {
        $methodName = "/Data/ListPaymentMethods";

        $data = [
            "SessionToken" => $sessionToken,
"CustomerId" => $customerId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the credit card payment method.
      * @param string $sessionToken
 * @param string $currency
 * @param string $customerId
 * @param bool $isCustomerAutomaticPaymentMethod
 * @param string $creditCardDescription
 * @param ulong $pan
 * @param string $cVD
 * @param int $expirationMonth
 * @param int $expirationYear
 * @param string $cardOwner
 * @param string $streetAddress
 * @param string $addressCity
 * @param string $postalZipCode
 * @param DateTime $expirationDate
 * @param string $formatedCreditCardString
 * @param string $previewString
 * @param string $zipCode
 * @param string $provinceStateId
 * @param string $countryId
 * @param string $language

     *
     * @return json
     */
    public function createCreditCardPaymentMethod(
        $sessionToken,
$currency,
$customerId,
$isCustomerAutomaticPaymentMethod,
$creditCardDescription,
$pan,
$cVD,
$expirationMonth,
$expirationYear,
$cardOwner,
$streetAddress,
$addressCity,
$postalZipCode,
$expirationDate,
$formatedCreditCardString,
$previewString,
$zipCode,
$provinceStateId = null,
$countryId = null,
$language = null
    ) {
        $methodName = "/Data/CreateCreditCardPaymentMethod";

        $data = [
            "SessionToken" => $sessionToken,
"Currency" => $currency,
"CustomerId" => $customerId,
"IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
"CreditCard" => [
"CreditCardDescription" => $creditCardDescription,
"Pan" => $pan,
"CVD" => $cVD,
"ExpirationMonth" => $expirationMonth,
"ExpirationYear" => $expirationYear,
"CardOwner" => $cardOwner,
"CreditCardRegisteredAddress" => [
"StreetAddress" => $streetAddress,
"AddressCity" => $addressCity,
"ProvinceStateId" => $provinceStateId,
"CountryId" => $countryId,
"PostalZipCode" => $postalZipCode
],
"ExpirationDate" => $expirationDate,
"FormatedCreditCardString" => $formatedCreditCardString,
"PreviewString" => $previewString
],
"ZipCode" => $zipCode,
"Language" => $language,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the direct account payment method.
      * @param string $sessionToken
 * @param string $customerId
 * @param bool $isCustomerAutomaticPaymentMethod
 * @param string $accountName
 * @param string $owner
 * @param string $firstName
 * @param string $lastName
 * @param string $bankNumber
 * @param string $institutionNumber
 * @param string $accountNumber
 * @param string $routingNumber
 * @param string $checkDigit
 * @param string $fullAccountNumber
 * @param string $accountNumberWithCheckDigit
 * @param string $previewString
 * @param string $accountType
 * @param string $currency
 * @param string $language

     *
     * @return json
     */
    public function createDirectAccountPaymentMethod(
        $sessionToken,
$customerId,
$isCustomerAutomaticPaymentMethod,
$accountName,
$owner,
$firstName,
$lastName,
$bankNumber,
$institutionNumber,
$accountNumber,
$routingNumber,
$checkDigit,
$fullAccountNumber,
$accountNumberWithCheckDigit,
$previewString,
$accountType = null,
$currency = null,
$language = null
    ) {
        $methodName = "/Data/CreateDirectAccountPaymentMethod";

        $data = [
            "SessionToken" => $sessionToken,
"CustomerId" => $customerId,
"IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
"Account" => [
"AccountName" => $accountName,
"Owner" => $owner,
"FirstName" => $firstName,
"LastName" => $lastName,
"AccountType" => $accountType,
"BankNumber" => $bankNumber,
"InstitutionNumber" => $institutionNumber,
"AccountNumber" => $accountNumber,
"RoutingNumber" => $routingNumber,
"CheckDigit" => $checkDigit,
"Currency" => $currency,
"FullAccountNumber" => $fullAccountNumber,
"AccountNumberWithCheckDigit" => $accountNumberWithCheckDigit,
"PreviewString" => $previewString
],
"Language" => $language,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the Interac payment method.
      * @param string $sessionToken
 * @param string $customerId
 * @param bool $isCustomerAutomaticPaymentMethod
 * @param string $description
 * @param string $owner
 * @param string $targetEmailAddress
 * @param string $targetMobilePhoneNumber
 * @param string $interacQuestion
 * @param string $interacAnswer
 * @param string $language
 * @param string $merchantId

     *
     * @return json
     */
    public function createInteracPaymentMethod(
        $sessionToken,
$customerId,
$isCustomerAutomaticPaymentMethod,
$description,
$owner,
$targetEmailAddress,
$targetMobilePhoneNumber,
$interacQuestion,
$interacAnswer,
$language = null,
$merchantId = null
    ) {
        $methodName = "/Data/CreateInteracPaymentMethod";

        $data = [
            "SessionToken" => $sessionToken,
"CustomerId" => $customerId,
"IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
"InteracInformation" => [
"Description" => $description,
"Owner" => $owner,
"TargetEmailAddress" => $targetEmailAddress,
"TargetMobilePhoneNumber" => $targetMobilePhoneNumber,
"InteracQuestion" => $interacQuestion,
"InteracAnswer" => $interacAnswer
],
"Language" => $language,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the payment method.
      * @param string $sessionToken
 * @param string $paymentMethodId

     *
     * @return json
     */
    public function getPaymentMethod(
        $sessionToken,
$paymentMethodId
    ) {
        $methodName = "/Data/GetPaymentMethod";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentMethodId" => $paymentMethodId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Deletes the payment method.
      * @param string $sessionToken
 * @param string $paymentMethodId

     *
     * @return json
     */
    public function deletePaymentMethod(
        $sessionToken,
$paymentMethodId
    ) {
        $methodName = "/Data/DeletePaymentMethod";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentMethodId" => $paymentMethodId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Sets the default payment method.
      * @param string $sessionToken
 * @param string $customerId
 * @param string $paymentMethodId

     *
     * @return json
     */
    public function setDefaultPaymentMethod(
        $sessionToken,
$customerId,
$paymentMethodId
    ) {
        $methodName = "/Data/SetDefaultPaymentMethod";

        $data = [
            "SessionToken" => $sessionToken,
"CustomerId" => $customerId,
"PaymentMethodId" => $paymentMethodId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the bills.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $merchantId
 * @param \DateTime $fromDateTime
 * @param \DateTime $toDateTime

     *
     * @return json
     */
    public function listBills(
        $sessionToken,
$serviceId,
$merchantId = null,
$fromDateTime = null,
$toDateTime = null
    ) {
        $methodName = "/Data/ListBills";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"MerchantId" => $merchantId,
"FromDateTime" => $fromDateTime,
"ToDateTime" => $toDateTime,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the bill.
      * @param string $sessionToken
 * @param Guid $merchantId
 * @param string $billTitle
 * @param string $billDescription
 * @param decimal $billAmount
 * @param string $externalSystemBillNumber1
 * @param string $externalSystemBillNumber2
 * @param string $externalSystemBillNumber3
 * @param bool $useConvenientFeeRule
 * @param bool $breakIfMerchantNeverBeenAuthorized
 * @param string $billCurrency
 * @param string $language
 * @param Guid $relatedCustomerId

     *
     * @return json
     */
    public function createBill(
        $sessionToken,
$merchantId,
$billTitle,
$billDescription,
$billAmount,
$externalSystemBillNumber1,
$externalSystemBillNumber2,
$externalSystemBillNumber3,
$useConvenientFeeRule,
$breakIfMerchantNeverBeenAuthorized,
$billCurrency = null,
$language = null,
$relatedCustomerId = null
    ) {
        $methodName = "/Data/CreateBill";

        $data = [
            "SessionToken" => $sessionToken,
"BillData" => [
"MerchantId" => $merchantId,
"BillTitle" => $billTitle,
"BillDescription" => $billDescription,
"BillAmount" => $billAmount,
"ExternalSystemBillNumber1" => $externalSystemBillNumber1,
"ExternalSystemBillNumber2" => $externalSystemBillNumber2,
"ExternalSystemBillNumber3" => $externalSystemBillNumber3,
"BillCurrency" => $billCurrency,
"Language" => $language,
"RelatedCustomerId" => $relatedCustomerId,
"UseConvenientFeeRule" => $useConvenientFeeRule
],
"BreakIfMerchantNeverBeenAuthorized" => $breakIfMerchantNeverBeenAuthorized,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the bill.
      * @param string $sessionToken
 * @param string $billId
 * @param string $merchantId

     *
     * @return json
     */
    public function getBill(
        $sessionToken,
$billId,
$merchantId = null
    ) {
        $methodName = "/Data/GetBill";

        $data = [
            "SessionToken" => $sessionToken,
"BillId" => $billId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Deletes the bill.
      * @param string $sessionToken
 * @param string $billId
 * @param string $merchantId

     *
     * @return json
     */
    public function deleteBill(
        $sessionToken,
$billId,
$merchantId = null
    ) {
        $methodName = "/Data/DeleteBill";

        $data = [
            "SessionToken" => $sessionToken,
"BillId" => $billId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the transfers.
      * @param string $sessionToken
 * @param bool $markResolvedOnly
 * @param string $transferGroupId
 * @param string $transferType
 * @param string $externalMerchantGroupId
 * @param bool $onlyWithErrors
 * @param string $paymentFilterLevel
 * @param string $levelFilterId
 * @param \DateTime $fromDate
 * @param \DateTime $toDate

     *
     * @return json
     */
    public function listTransfers(
        $sessionToken,
$markResolvedOnly,
$transferGroupId,
$transferType,
$externalMerchantGroupId,
$onlyWithErrors,
$paymentFilterLevel = null,
$levelFilterId = null,
$fromDate = null,
$toDate = null
    ) {
        $methodName = "/Data/ListTransfers";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentFilterLevel" => $paymentFilterLevel,
"LevelFilterId" => $levelFilterId,
"MarkResolvedOnly" => $markResolvedOnly,
"FromDate" => $fromDate,
"ToDate" => $toDate,
"TransferGroupId" => $transferGroupId,
"TransferType" => $transferType,
"ExternalMerchantGroupId" => $externalMerchantGroupId,
"OnlyWithErrors" => $onlyWithErrors,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the transfers.
      * @param string $sessionToken
 * @param string $serviceId
 * @param string $transferGroupId
 * @param string $transferType
 * @param bool $markResolvedOnly
 * @param string $externalMerchantGroupId
 * @param bool $onlyWithErrors
 * @param \DateTime $fromDate
 * @param \DateTime $toDate
 * @param string $merchantId

     *
     * @return json
     */
    public function listTransfersFast(
        $sessionToken,
$serviceId,
$transferGroupId,
$transferType,
$markResolvedOnly,
$externalMerchantGroupId,
$onlyWithErrors,
$fromDate = null,
$toDate = null,
$merchantId = null
    ) {
        $methodName = "/Data/ListTransfersFast";

        $data = [
            "SessionToken" => $sessionToken,
"FromDate" => $fromDate,
"ToDate" => $toDate,
"ServiceId" => $serviceId,
"MerchantId" => $merchantId,
"TransferGroupId" => $transferGroupId,
"TransferType" => $transferType,
"MarkResolvedOnly" => $markResolvedOnly,
"ExternalMerchantGroupId" => $externalMerchantGroupId,
"OnlyWithErrors" => $onlyWithErrors,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the transfers of a bill.
      * @param string $sessionToken
 * @param string $merchantId
 * @param string $billId

     *
     * @return json
     */
    public function listTransfersForBillFast(
        $sessionToken,
$merchantId,
$billId
    ) {
        $methodName = "/Data/ListTransfersForBillFast";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"BillId" => $billId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $serviceId

     *
     * @return json
     */
    public function getRecuringTransfers(
        $sessionToken,
$serviceId
    ) {
        $methodName = "/Data/GetRecuringTransfers";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $recuringTransferId

     *
     * @return json
     */
    public function deleteRecuringTransfer(
        $sessionToken,
$recuringTransferId
    ) {
        $methodName = "/Data/DeleteRecuringTransfer";

        $data = [
            "SessionToken" => $sessionToken,
"RecuringTransferId" => $recuringTransferId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the payment.
      * @param string $sessionToken
 * @param string $billId
 * @param bool $setPaymentCustomerFromBill
 * @param string $customerEmail
 * @param string $paymentFlow
 * @param string $transferFrequency
 * @param string $groupId
 * @param string $externalReferenceIdentification
 * @param bool $isDeleted
 * @param string $externalReferenceId
 * @param bool $safetyToBreakIfOverRemainingBillAmount
 * @param bool $doNotSendEmail
 * @param string $statementDescription
 * @param string $language
 * @param Guid $relatedCustomerId
 * @param DateTime $dueDate
 * @param decimal $paymentAmount
 * @param Guid $forcedCustomerPaymentMethodId
 * @param string $autorizedPaymentMethod
 * @param bool $askForCustomerConsent
 * @param string $merchantId
 * @param bool $immediateTransfer

     *
     * @return json
     */
    public function createPayment(
        $sessionToken,
$billId,
$setPaymentCustomerFromBill,
$customerEmail,
$paymentFlow,
$transferFrequency,
$groupId,
$externalReferenceIdentification,
$isDeleted,
$externalReferenceId,
$safetyToBreakIfOverRemainingBillAmount,
$doNotSendEmail,
$statementDescription,
$language = null,
$relatedCustomerId = null,
$dueDate = null,
$paymentAmount = null,
$forcedCustomerPaymentMethodId = null,
$autorizedPaymentMethod = null,
$askForCustomerConsent = null,
$merchantId = null,
$immediateTransfer = null
    ) {
        $methodName = "/Data/CreatePayment";

        $data = [
            "SessionToken" => $sessionToken,
"BillId" => $billId,
"SetPaymentCustomerFromBill" => $setPaymentCustomerFromBill,
"CustomerEmail" => $customerEmail,
"PaymentInfo" => [
"PaymentFlow" => $paymentFlow,
"Language" => $language,
"RelatedCustomerId" => $relatedCustomerId,
"DueDate" => $dueDate,
"TransferFrequency" => $transferFrequency,
"PaymentAmount" => $paymentAmount,
"ForcedCustomerPaymentMethodId" => $forcedCustomerPaymentMethodId,
"GroupId" => $groupId,
"ExternalReferenceIdentification" => $externalReferenceIdentification,
"AutorizedPaymentMethod" => $autorizedPaymentMethod,
"AskForCustomerConsent" => $askForCustomerConsent,
"IsDeleted" => $isDeleted
],
"MerchantId" => $merchantId,
"ExternalReferenceId" => $externalReferenceId,
"SafetyToBreakIfOverRemainingBillAmount" => $safetyToBreakIfOverRemainingBillAmount,
"AutorizedPaymentMethod" => $autorizedPaymentMethod,
"DoNotSendEmail" => $doNotSendEmail,
"ImmediateTransfer" => $immediateTransfer,
"StatementDescription" => $statementDescription,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the payment.
      * @param string $sessionToken
 * @param string $paymentId

     *
     * @return json
     */
    public function getPayment(
        $sessionToken,
$paymentId
    ) {
        $methodName = "/Data/GetPayment";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentId" => $paymentId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Deletes the payment.
      * @param string $sessionToken
 * @param string $paymentId

     *
     * @return json
     */
    public function deletePayment(
        $sessionToken,
$paymentId
    ) {
        $methodName = "/Data/DeletePayment";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentId" => $paymentId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the direct Interac transaction
      * @param string $sessionToken
 * @param string $merchantId
 * @param string $description
 * @param string $owner
 * @param string $targetEmailAddress
 * @param string $targetMobilePhoneNumber
 * @param string $interacQuestion
 * @param string $interacAnswer
 * @param string $transferDirection
 * @param float $amount
 * @param string $statementDescription
 * @param string $referenceNumber
 * @param \DateTime $dueDate
 * @param string $currency
 * @param string $language

     *
     * @return json
     */
    public function createDirectInteracTransaction(
        $sessionToken,
$merchantId,
$description,
$owner,
$targetEmailAddress,
$targetMobilePhoneNumber,
$interacQuestion,
$interacAnswer,
$transferDirection,
$amount,
$statementDescription,
$referenceNumber,
$dueDate = null,
$currency = null,
$language = null
    ) {
        $methodName = "/Data/CreateDirectInteracTransaction";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"InteracInformation" => [
"Description" => $description,
"Owner" => $owner,
"TargetEmailAddress" => $targetEmailAddress,
"TargetMobilePhoneNumber" => $targetMobilePhoneNumber,
"InteracQuestion" => $interacQuestion,
"InteracAnswer" => $interacAnswer
],
"TransferDirection" => $transferDirection,
"DueDate" => $dueDate,
"Amount" => $amount,
"StatementDescription" => $statementDescription,
"Currency" => $currency,
"Language" => $language,
"ReferenceNumber" => $referenceNumber,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the transaction from raw.
      * @param string $sessionToken
 * @param string $rawAcpFileContent
 * @param string $merchantId

     *
     * @return json
     */
    public function createTransactionFromRaw(
        $sessionToken,
$rawAcpFileContent,
$merchantId = null
    ) {
        $methodName = "/Data/CreateTransactionFromRaw";

        $data = [
            "SessionToken" => $sessionToken,
"RawAcpFileContent" => $rawAcpFileContent,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Lists the executed operations.
      * @param string $sessionToken
 * @param string $transferType
 * @param string $transferGroupId
 * @param bool $onlyWithErrors
 * @param \DateTime $fromDate
 * @param \DateTime $toDate
 * @param string $merchantId
 * @param string $dateType
 * @param string $serviceId

     *
     * @return json
     */
    public function listExecutedOperations(
        $sessionToken,
$transferType,
$transferGroupId,
$onlyWithErrors,
$fromDate = null,
$toDate = null,
$merchantId = null,
$dateType = null,
$serviceId = null
    ) {
        $methodName = "/Data/ListExecutedOperations";

        $data = [
            "SessionToken" => $sessionToken,
"FromDate" => $fromDate,
"ToDate" => $toDate,
"TransferType" => $transferType,
"TransferGroupId" => $transferGroupId,
"OnlyWithErrors" => $onlyWithErrors,
"MerchantId" => $merchantId,
"DateType" => $dateType,
"ServiceId" => $serviceId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Forces the payment process.
      * @param string $sessionToken
 * @param string $paymentId

     *
     * @return json
     */
    public function forcePaymentProcess(
        $sessionToken,
$paymentId
    ) {
        $methodName = "/Data/ForcePaymentProcess";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentId" => $paymentId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Gets the drop in public token.
      * @param string $sessionToken
 * @param float $amount
 * @param string $transferType
 * @param string $dropInAuthorizedPaymentMethod
 * @param string $externalReferenceNumber
 * @param bool $showCustomerExistingPaymentMethods
 * @param string $language
 * @param int $expirationDays
 * @param string $title
 * @param string $description
 * @param string $merchantId
 * @param string $customerId
 * @param string $billId
 * @param \DateTime $paymentDueDate

     *
     * @return json
     */
    public function getDropInPublicToken(
        $sessionToken,
$amount,
$transferType,
$dropInAuthorizedPaymentMethod,
$externalReferenceNumber,
$showCustomerExistingPaymentMethods,
$language,
$expirationDays,
$title,
$description,
$merchantId = null,
$customerId = null,
$billId = null,
$paymentDueDate = null
    ) {
        $methodName = "/Data/GetDropInPublicToken";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"CustomerId" => $customerId,
"BillId" => $billId,
"Amount" => $amount,
"TransferType" => $transferType,
"DropInAuthorizedPaymentMethod" => $dropInAuthorizedPaymentMethod,
"ExternalReferenceNumber" => $externalReferenceNumber,
"ShowCustomerExistingPaymentMethods" => $showCustomerExistingPaymentMethods,
"Language" => $language,
"ExpirationDays" => $expirationDays,
"Title" => $title,
"Description" => $description,
"PaymentDueDate" => $paymentDueDate,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * Creates the free operation.
      * @param string $sessionToken
 * @param string $paymentMethodId
 * @param string $transferType
 * @param string $referenceNumber
 * @param float $amount
 * @param string $language
 * @param string $transferTitle
 * @param string $transferDescription
 * @param string $transferExternalSystemNumber
 * @param string $transferFrequency
 * @param string $groupId
 * @param string $statementDescription
 * @param string $merchantId
 * @param string $billId
 * @param string $customerId
 * @param \DateTime $transactionDueDate
 * @param bool $immediateTransfer
 * @param bool $stopSameIdentifications

     *
     * @return json
     */
    public function createFreeOperation(
        $sessionToken,
$paymentMethodId,
$transferType,
$referenceNumber,
$amount,
$language,
$transferTitle,
$transferDescription,
$transferExternalSystemNumber,
$transferFrequency,
$groupId,
$statementDescription,
$merchantId = null,
$billId = null,
$customerId = null,
$transactionDueDate = null,
$immediateTransfer = null,
$stopSameIdentifications = null
    ) {
        $methodName = "/Data/CreateFreeOperation";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"BillId" => $billId,
"CustomerId" => $customerId,
"PaymentMethodId" => $paymentMethodId,
"TransferType" => $transferType,
"ReferenceNumber" => $referenceNumber,
"Amount" => $amount,
"Language" => $language,
"TransactionDueDate" => $transactionDueDate,
"TransferTitle" => $transferTitle,
"TransferDescription" => $transferDescription,
"TransferExternalSystemNumber" => $transferExternalSystemNumber,
"TransferFrequency" => $transferFrequency,
"GroupId" => $groupId,
"ImmediateTransfer" => $immediateTransfer,
"StatementDescription" => $statementDescription,
"StopSameIdentifications" => $stopSameIdentifications,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param array $freeOperationBatchList
 * @param string $groupId
 * @param bool $stopSameIdentifications

     *
     * @return json
     */
    public function createFreeOperationBatch(
        $sessionToken,
$freeOperationBatchList,
$groupId,
$stopSameIdentifications = null
    ) {
        $methodName = "/Data/CreateFreeOperationBatch";

        $data = [
            "SessionToken" => $sessionToken,
"FreeOperationBatchList" => $freeOperationBatchList,
"GroupId" => $groupId,
"StopSameIdentifications" => $stopSameIdentifications,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $transferId

     *
     * @return json
     */
    public function revertTransfer(
        $sessionToken,
$transferId
    ) {
        $methodName = "/Data/RevertTransfer";

        $data = [
            "SessionToken" => $sessionToken,
"TransferId" => $transferId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $interacPaymentMethodId
 * @param string $interacQuestion
 * @param string $interacAnswer
 * @param string $merchantId

     *
     * @return json
     */
    public function changeInteracPaymentMethodQuestionAndAnswer(
        $sessionToken,
$interacPaymentMethodId,
$interacQuestion,
$interacAnswer,
$merchantId = null
    ) {
        $methodName = "/Data/ChangeInteracPaymentMethodQuestionAndAnswer";

        $data = [
            "SessionToken" => $sessionToken,
"InteracPaymentMethodId" => $interacPaymentMethodId,
"InteracQuestion" => $interacQuestion,
"InteracAnswer" => $interacAnswer,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $serviceId

     *
     * @return json
     */
    public function initBoarding(
        $sessionToken,
$serviceId
    ) {
        $methodName = "/Data/InitBoarding";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $name
 * @param string $language
 * @param string $currency

     *
     * @return json
     */
    public function createSubClient(
        $sessionToken,
$name,
$language,
$currency
    ) {
        $methodName = "/Data/CreateSubClient";

        $data = [
            "SessionToken" => $sessionToken,
"Name" => $name,
"Language" => $language,
"Currency" => $currency,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $paymentId
 * @param string $merchantId

     *
     * @return json
     */
    public function resendPaymentEmail(
        $sessionToken,
$paymentId,
$merchantId = null
    ) {
        $methodName = "/Data/ResendPaymentEmail";

        $data = [
            "SessionToken" => $sessionToken,
"PaymentId" => $paymentId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $transferId
 * @param string $merchantId

     *
     * @return json
     */
    public function relaunchMerchantFailedTransfer(
        $sessionToken,
$transferId,
$merchantId = null
    ) {
        $methodName = "/Data/RelaunchMerchantFailedTransfer";

        $data = [
            "SessionToken" => $sessionToken,
"TransferId" => $transferId,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $merchantId
 * @param float $amount
 * @param \DateTime $transferDueDate
 * @param string $targetMerchantId
 * @param string $currency
 * @param string $language
 * @param string $transferFrequency
 * @param string $billNumber
 * @param string $billDescription
 * @param string $billTitle

     *
     * @return json
     */
    public function createSupplierTransfer(
        $sessionToken,
$merchantId,
$amount,
$transferDueDate,
$targetMerchantId,
$currency,
$language,
$transferFrequency,
$billNumber,
$billDescription,
$billTitle
    ) {
        $methodName = "/Data/CreateSupplierTransfer";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"Amount" => $amount,
"TransferDueDate" => $transferDueDate,
"TargetMerchantId" => $targetMerchantId,
"Currency" => $currency,
"Language" => $language,
"TransferFrequency" => $transferFrequency,
"BillNumber" => $billNumber,
"BillDescription" => $billDescription,
"BillTitle" => $billTitle,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $merchantId

     *
     * @return json
     */
    public function getSuppliers(
        $sessionToken,
$merchantId
    ) {
        $methodName = "/Data/GetSuppliers";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $merchantId
 * @param string $supplierName
 * @param string $supplierEmail
 * @param string $currency
 * @param string $language
 * @param string $accountNumber
 * @param string $bankNumber
 * @param string $institutionNumber

     *
     * @return json
     */
    public function createSupplier(
        $sessionToken,
$merchantId,
$supplierName,
$supplierEmail,
$currency,
$language,
$accountNumber,
$bankNumber,
$institutionNumber
    ) {
        $methodName = "/Data/CreateSupplier";

        $data = [
            "SessionToken" => $sessionToken,
"MerchantId" => $merchantId,
"SupplierName" => $supplierName,
"SupplierEmail" => $supplierEmail,
"Currency" => $currency,
"Language" => $language,
"AccountNumber" => $accountNumber,
"BankNumber" => $bankNumber,
"InstitutionNumber" => $institutionNumber,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    /**
     * 
      * @param string $sessionToken
 * @param string $serviceId
 * @param \DateTime $from
 * @param \DateTime $to

     *
     * @return json
     */
    public function getWalletOperations(
        $sessionToken,
$serviceId,
$from,
$to
    ) {
        $methodName = "/Data/GetWalletOperations";

        $data = [
            "SessionToken" => $sessionToken,
"ServiceId" => $serviceId,
"From" => $from,
"To" => $to,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


   
}