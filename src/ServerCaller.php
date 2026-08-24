<?php

namespace TibFinanceSDK;

require(__DIR__ . "/TibCrypto.php");

/**
 * ServerCaller is a class that implements all TIB FINANCE API methods
 */
class ServerCaller
{
    private $tibCrypto;
 
    public function __construct()
    {
    }

    /**
     * Sets up the API URL.
     * @param string $url The API URL.
     */
    public function SetUrl($url)
    {
        $this->tibCrypto = new TibCrypto($url);
    }

    /**
     * Returns the crypto engine, guarding against use before SetUrl().
     */
    private function crypto()
    {
        if ($this->tibCrypto === null) {
            throw new \RuntimeException("Call SetUrl() before invoking API methods.");
        }
        return $this->tibCrypto;
    }

    
    /**
     * Creates the session.
     * @param string $clientId
     * @param string $username
     * @param string $password
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists the services.
     * @param string $sessionToken
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the service.
     * @param string $sessionToken
     * @param string $serviceId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves wallet information for a service, including the effective balance (wallet balance plus available delay buffer minus pending collections), the risk-adjusted withdrawable amount, processing status, and whether the new wallet feature is active.
     * @param string $sessionToken
     * @param string $serviceId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists the merchants.
     * @param string $sessionToken
     * @param string $serviceId
     * @param bool $includeClientMerchants
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves the payment provider boarding (onboarding) status for all merchants within a service. Returns each merchant's boarding progress with their current status.
     * @param string $sessionToken
     * @param string $boardingServiceId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
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
     * @param string $bankNumber
     * @param string $institutionNumber
     * @param string $accountNumber
     * @param string $routingNumber
     * @param string $checkDigit
     * @param string $provinceStateId
     * @param string $countryId
     * @param string $currency
     *
     * @return mixed
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
        $bankNumber,
        $institutionNumber,
        $accountNumber,
        $routingNumber,
        $checkDigit,
        $provinceStateId = null,
        $countryId = null,
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
                "Account" => [
                "AccountName" => $accountName,
                "Owner" => $owner,
                "BankNumber" => $bankNumber,
                "InstitutionNumber" => $institutionNumber,
                "AccountNumber" => $accountNumber,
                "RoutingNumber" => $routingNumber,
                "CheckDigit" => $checkDigit,
                "Currency" => $currency
            ]
            ],
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Adds a new bank account (i.e., new merchant in TIB's data model) to an existing fully-boarded service. Authorizes the new merchant on insert. One-shot semantic: no pending state, no approval workflow, no confirmation email. Owner and Currency are inherited from an active sibling merchant on the same service. This is a parallel path to CreateMerchant (which serves boarding's first-merchant insert).
     * @param string $sessionToken
     * @param string $serviceId
     * @param string $name
     * @param string $email
     * @param string $language
     * @param string $bankNumber
     * @param string $institutionNumber
     * @param string $accountNumber
     *
     * @return mixed
     */
    public function addBankAccount(
        $sessionToken,
        $serviceId,
        $name,
        $email,
        $language,
        $bankNumber,
        $institutionNumber,
        $accountNumber
    ) {
        $methodName = "/Data/AddBankAccount";

        $data = [
            "SessionToken" => $sessionToken,
            "ServiceId" => $serviceId,
            "Name" => $name,
            "Email" => $email,
            "Language" => $language,
            "BankNumber" => $bankNumber,
            "InstitutionNumber" => $institutionNumber,
            "AccountNumber" => $accountNumber,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the merchant.
     * @param string $sessionToken
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
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
     * @param string $bankNumber
     * @param string $institutionNumber
     * @param string $accountNumber
     * @param string $routingNumber
     * @param string $checkDigit
     * @param string $provinceStateId
     * @param string $countryId
     * @param string $currency
     *
     * @return mixed
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
        $bankNumber,
        $institutionNumber,
        $accountNumber,
        $routingNumber,
        $checkDigit,
        $provinceStateId = null,
        $countryId = null,
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
                "Account" => [
                "AccountName" => $accountName,
                "Owner" => $owner,
                "BankNumber" => $bankNumber,
                "InstitutionNumber" => $institutionNumber,
                "AccountNumber" => $accountNumber,
                "RoutingNumber" => $routingNumber,
                "CheckDigit" => $checkDigit,
                "Currency" => $currency
            ]
            ],
        ];

        return $this->crypto()->performCall($methodName, $data);
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
     *
     * @return mixed
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
        $countryId = null
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
            ]
            ],
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Saves the merchant account information. This operation is protected by two-factor authentication. On first use the response carries two-factor setup instructions (TwoFactorStatus and TwoFactorSetupData); see the Two-factor authentication guide.
     * @param string $sessionToken
     * @param string $merchantId
     * @param string $accountName
     * @param string $owner
     * @param string $bankNumber
     * @param string $institutionNumber
     * @param string $accountNumber
     * @param string $routingNumber
     * @param string $checkDigit
     * @param string $twoFactorCode
     * @param string $twoFactorSecurityAnswer
     * @param string $currency
     *
     * @return mixed
     */
    public function saveMerchantAccountInfo(
        $sessionToken,
        $merchantId,
        $accountName,
        $owner,
        $bankNumber,
        $institutionNumber,
        $accountNumber,
        $routingNumber,
        $checkDigit,
        $twoFactorCode,
        $twoFactorSecurityAnswer,
        $currency = null
    ) {
        $methodName = "/Data/SaveMerchantAccountInfo";

        $data = [
            "SessionToken" => $sessionToken,
            "MerchantId" => $merchantId,
            "Account" => [
                "AccountName" => $accountName,
                "Owner" => $owner,
                "BankNumber" => $bankNumber,
                "InstitutionNumber" => $institutionNumber,
                "AccountNumber" => $accountNumber,
                "RoutingNumber" => $routingNumber,
                "CheckDigit" => $checkDigit,
                "Currency" => $currency
            ],
            "TwoFactorCode" => $twoFactorCode,
            "TwoFactorSecurityAnswer" => $twoFactorSecurityAnswer,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Deletes the merchant.
     * @param string $sessionToken
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the merchants by external identifier.
     * @param string $sessionToken
     * @param string $externalSystemId
     * @param string $externalSystemGroupId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Adjusts a merchant's wallet balance. IncreaseWallet collects the amount from the merchant (by EFT, or by Interac when requested) and credits the wallet; DecreaseWallet withdraws it from the wallet balance, subject to the risk-adjusted withdrawable balance. Requires the wallet feature to be enabled for the service. This operation supports idempotency via the IdempotencyKey field.
     * @param string $sessionToken
     * @param string $serviceId
     * @param string $merchantId
     * @param float $amount
     * @param string $mode
     * @param bool $useInterac
     * @param string $idempotencyKey
     *
     * @return mixed
     */
    public function adjustWallet(
        $sessionToken,
        $serviceId,
        $merchantId,
        $amount,
        $mode,
        $useInterac,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/AdjustWallet";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "ServiceId" => $serviceId,
            "MerchantId" => $merchantId,
            "Amount" => $amount,
            "Mode" => $mode,
            "UseInterac" => $useInterac,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists the customers.
     * @param string $sessionToken
     * @param string $serviceId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the customer.
     * @param string $sessionToken
     * @param string $serviceId
     * @param string $customerName
     * @param string $customerExternalId
     * @param string $customerDescription
     * @param string $customerEmail
     * @param array $paymentMethods
     * @param mixed $contactInfo
     * @param string $language
     *
     * @return mixed
     */
    public function createCustomer(
        $sessionToken,
        $serviceId,
        $customerName,
        $customerExternalId,
        $customerDescription,
        $customerEmail,
        $paymentMethods,
        $contactInfo,
        $language = null
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
                "PaymentMethods" => $paymentMethods,
                "ContactInfo" => $contactInfo
            ],
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the customer.
     * @param string $sessionToken
     * @param string $customerId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Saves the customer.
     * @param string $sessionToken
     * @param string $customerName
     * @param string $customerExternalId
     * @param string $customerDescription
     * @param string $customerEmail
     * @param array $paymentMethods
     * @param mixed $contactInfo
     * @param string $customerId
     * @param string $language
     * @param string $merchantId
     *
     * @return mixed
     */
    public function saveCustomer(
        $sessionToken,
        $customerName,
        $customerExternalId,
        $customerDescription,
        $customerEmail,
        $paymentMethods,
        $contactInfo,
        $customerId,
        $language = null,
        $merchantId = null
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
                "PaymentMethods" => $paymentMethods,
                "ContactInfo" => $contactInfo,
                "CustomerId" => $customerId
            ],
            "MerchantId" => $merchantId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Updates only a customer's contact information (email, phone, address, language) without touching the rest of the customer record. Use this when editing the contact card in isolation: fields left null preserve the stored value, empty strings clear it, and non-empty values overwrite.
     * @param string $sessionToken
     * @param string $customerId
     * @param mixed $contactInfo
     *
     * @return mixed
     */
    public function saveCustomerContactInfo(
        $sessionToken,
        $customerId,
        $contactInfo
    ) {
        $methodName = "/Data/SaveCustomerContactInfo";

        $data = [
            "SessionToken" => $sessionToken,
            "CustomerId" => $customerId,
            "ContactInfo" => $contactInfo,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Deletes the customer.
     * @param string $sessionToken
     * @param string $customerId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the customers by external identifier.
     * @param string $sessionToken
     * @param string $externalCustomerId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists the payment methods.
     * @param string $sessionToken
     * @param string $customerId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the credit card payment method.
     * @param string $sessionToken
     * @param string $currency
     * @param string $customerId
     * @param bool $isCustomerAutomaticPaymentMethod
     * @param string $creditCardDescription
     * @param int $pan
     * @param string $cVD
     * @param int $expirationMonth
     * @param int $expirationYear
     * @param string $cardOwner
     * @param string $streetAddress
     * @param string $addressCity
     * @param string $postalZipCode
     * @param string $zipCode
     * @param string $provinceStateId
     * @param string $countryId
     * @param string $language
     *
     * @return mixed
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
            ]
            ],
            "ZipCode" => $zipCode,
            "Language" => $language,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the direct account payment method.
     * @param string $sessionToken
     * @param string $customerId
     * @param bool $isCustomerAutomaticPaymentMethod
     * @param string $accountName
     * @param string $owner
     * @param string $bankNumber
     * @param string $institutionNumber
     * @param string $accountNumber
     * @param string $routingNumber
     * @param string $checkDigit
     * @param string $currency
     * @param string $language
     *
     * @return mixed
     */
    public function createDirectAccountPaymentMethod(
        $sessionToken,
        $customerId,
        $isCustomerAutomaticPaymentMethod,
        $accountName,
        $owner,
        $bankNumber,
        $institutionNumber,
        $accountNumber,
        $routingNumber,
        $checkDigit,
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
                "BankNumber" => $bankNumber,
                "InstitutionNumber" => $institutionNumber,
                "AccountNumber" => $accountNumber,
                "RoutingNumber" => $routingNumber,
                "CheckDigit" => $checkDigit,
                "Currency" => $currency
            ],
            "Language" => $language,
        ];

        return $this->crypto()->performCall($methodName, $data);
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
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the payment method.
     * @param string $sessionToken
     * @param string $paymentMethodId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Deletes the payment method.
     * @param string $sessionToken
     * @param string $paymentMethodId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Sets the default payment method.
     * @param string $sessionToken
     * @param string $customerId
     * @param string $paymentMethodId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists the bills.
     * @param string $sessionToken
     * @param string $serviceId
     * @param string $merchantId
     * @param \DateTime $fromDateTime
     * @param \DateTime $toDateTime
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the bill.
     * @param string $sessionToken
     * @param string $merchantId
     * @param string $billTitle
     * @param string $billDescription
     * @param float $billAmount
     * @param string $externalSystemBillNumber1
     * @param string $externalSystemBillNumber2
     * @param string $externalSystemBillNumber3
     * @param bool $useConvenientFeeRule
     * @param bool $breakIfMerchantNeverBeenAuthorized
     * @param string $billCurrency
     * @param string $language
     * @param string $relatedCustomerId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the bill.
     * @param string $sessionToken
     * @param string $billId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Deletes the bill.
     * @param string $sessionToken
     * @param string $billId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
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
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves a filtered, summarized list of transfers for a service using an optimized query. Supports filtering by transfer type, date range, merchant, transfer group, error status, and resolved status.
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
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists the transfers of a bill.
     * @param string $sessionToken
     * @param string $merchantId
     * @param string $billId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves all active recurring transfers for a given service, including their next scheduled recurrence date and associated merchant information.
     * @param string $sessionToken
     * @param string $serviceId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Deletes a recurring transfer by its identifier, stopping all future scheduled occurrences.
     * @param string $sessionToken
     * @param string $recuringTransferId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the payment. This operation supports idempotency via the IdempotencyKey field.
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
     * @param string $relatedCustomerId
     * @param \DateTime $dueDate
     * @param float $paymentAmount
     * @param string $forcedCustomerPaymentMethodId
     * @param string $autorizedPaymentMethod
     * @param bool $askForCustomerConsent
     * @param string $merchantId
     * @param bool $immediateTransfer
     * @param string $idempotencyKey
     *
     * @return mixed
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
        $immediateTransfer = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/CreatePayment";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
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
            "DoNotSendEmail" => $doNotSendEmail,
            "ImmediateTransfer" => $immediateTransfer,
            "StatementDescription" => $statementDescription,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Gets the payment.
     * @param string $sessionToken
     * @param string $paymentId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Deletes the payment.
     * @param string $sessionToken
     * @param string $paymentId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the direct Interac transaction. This operation supports idempotency via the IdempotencyKey field.
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
     * @param string $idempotencyKey
     *
     * @return mixed
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
        $language = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/CreateDirectInteracTransaction";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the transaction from raw. This operation supports idempotency via the IdempotencyKey field.
     * @param string $sessionToken
     * @param string $rawAcpFileContent
     * @param string $merchantId
     * @param bool $isImmediate
     * @param string $idempotencyKey
     *
     * @return mixed
     */
    public function createTransactionFromRaw(
        $sessionToken,
        $rawAcpFileContent,
        $merchantId = null,
        $isImmediate = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/CreateTransactionFromRaw";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "RawAcpFileContent" => $rawAcpFileContent,
            "MerchantId" => $merchantId,
            "IsImmediate" => $isImmediate,
        ];

        return $this->crypto()->performCall($methodName, $data);
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
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Forces immediate processing of a transfer that would otherwise wait for the next scheduled run. For supplier transfers, only the paying merchant (fee-payer) can force-process; the recipient supplier cannot force-execute a transfer they did not create. This operation supports idempotency via the IdempotencyKey field.
     * @param string $sessionToken
     * @param string $paymentId
     * @param string $idempotencyKey
     *
     * @return mixed
     */
    public function forcePaymentProcess(
        $sessionToken,
        $paymentId,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/ForcePaymentProcess";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "PaymentId" => $paymentId,
        ];

        return $this->crypto()->performCall($methodName, $data);
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
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates the free operation. This operation supports idempotency via the IdempotencyKey field.
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
     * @param \DateTime $recurringEndDate
     * @param bool $immediateTransfer
     * @param bool $stopSameIdentifications
     * @param string $idempotencyKey
     *
     * @return mixed
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
        $recurringEndDate = null,
        $immediateTransfer = null,
        $stopSameIdentifications = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/CreateFreeOperation";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
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
            "RecurringEndDate" => $recurringEndDate,
            "GroupId" => $groupId,
            "ImmediateTransfer" => $immediateTransfer,
            "StatementDescription" => $statementDescription,
            "StopSameIdentifications" => $stopSameIdentifications,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates a batch of free operations (deposits or collections) in a single call. Validates that client onboarding (KYC) is completed before allowing free deposit operations. This operation supports idempotency via the IdempotencyKey field.
     * @param string $sessionToken
     * @param array $freeOperationBatchList
     * @param string $groupId
     * @param bool $stopSameIdentifications
     * @param string $idempotencyKey
     *
     * @return mixed
     */
    public function createFreeOperationBatch(
        $sessionToken,
        $freeOperationBatchList,
        $groupId,
        $stopSameIdentifications = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/CreateFreeOperationBatch";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "FreeOperationBatchList" => $freeOperationBatchList,
            "GroupId" => $groupId,
            "StopSameIdentifications" => $stopSameIdentifications,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Reverts (cancels or reverses) a transfer. For pending gateway payments, deletes the transfer and its public token. For processed payments, creates reversal operations for each non-fee operation. Rejects transfers over $5,000 or wallet-type transfers. For supplier transfers, only the paying merchant (fee-payer) can revert; the recipient supplier cannot revert a transfer they did not create. This operation supports idempotency via the IdempotencyKey field.
     * @param string $sessionToken
     * @param string $transferId
     * @param string $idempotencyKey
     *
     * @return mixed
     */
    public function revertTransfer(
        $sessionToken,
        $transferId,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/RevertTransfer";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "TransferId" => $transferId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Updates the security question and answer on an existing Interac payment method. Creates a replacement payment method with the new credentials and deletes the old one. The answer is encrypted via the external data vault, and both question and answer are obfuscated in logs.
     * @param string $sessionToken
     * @param string $interacPaymentMethodId
     * @param string $interacQuestion
     * @param string $interacAnswer
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates a new sub-client (child service) under the authenticated client's account. The sub-client is represented as a service entity with its own name, language, and currency.
     * @param string $sessionToken
     * @param string $name
     * @param string $language
     * @param string $currency
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Resends the payment notification email to the customer associated with a specific payment.
     * @param string $sessionToken
     * @param string $paymentId
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Relaunches (retries) a previously failed transfer for a merchant. Resets the failed payment in the database for reprocessing and sends an internal notification email with the transfer details. This operation supports idempotency via the IdempotencyKey field.
     * @param string $sessionToken
     * @param string $transferId
     * @param string $merchantId
     * @param string $idempotencyKey
     *
     * @return mixed
     */
    public function relaunchMerchantFailedTransfer(
        $sessionToken,
        $transferId,
        $merchantId = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/RelaunchMerchantFailedTransfer";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "TransferId" => $transferId,
            "MerchantId" => $merchantId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates a payment transfer from the calling merchant to a supplier. Validates both merchants, runs business rules on the sending merchant's limits, creates the transfer as a free collection, and optionally creates a bill. Notifies the supplier unless client approval is required. This operation supports idempotency via the IdempotencyKey field.
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
     * @param \DateTime $recurringEndDate
     * @param string $idempotencyKey
     *
     * @return mixed
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
        $billTitle,
        $recurringEndDate = null,
        $idempotencyKey = null
    ) {
        $methodName = "/Data/CreateSupplierTransfer";

        $data = [
            "SessionToken" => $sessionToken,
            "IdempotencyKey" => $idempotencyKey,
            "MerchantId" => $merchantId,
            "Amount" => $amount,
            "TransferDueDate" => $transferDueDate,
            "TargetMerchantId" => $targetMerchantId,
            "Currency" => $currency,
            "Language" => $language,
            "TransferFrequency" => $transferFrequency,
            "RecurringEndDate" => $recurringEndDate,
            "BillNumber" => $billNumber,
            "BillDescription" => $billDescription,
            "BillTitle" => $billTitle,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves the list of suppliers associated with a merchant, returning each supplier's name and identifier.
     * @param string $sessionToken
     * @param string $merchantId
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Creates or registers a supplier for a merchant. If a supplier with the given email already exists, reuses that supplier; otherwise provisions a new client, service, merchant, and login. Links the supplier to the calling merchant and creates a reciprocal customer record in the supplier's service.
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
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists suppliers linked to the specified merchant, including detailed information such as supplier name, email address, and creation date. For a lightweight name-and-ID-only list, use GetSuppliers instead.
     * @param string $sessionToken
     * @param string $merchantId
     *
     * @return mixed
     */
    public function listSuppliers(
        $sessionToken,
        $merchantId = null
    ) {
        $methodName = "/Data/ListSuppliers";

        $data = [
            "SessionToken" => $sessionToken,
            "MerchantId" => $merchantId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Updates the display name (alias) that the payer uses to identify a supplier. The alias is a payer-side label and does not affect the supplier's own merchant name.
     * @param string $sessionToken
     * @param string $merchantSupplierId
     * @param string $supplierName
     * @param string $merchantId
     *
     * @return mixed
     */
    public function updateSupplierAlias(
        $sessionToken,
        $merchantSupplierId,
        $supplierName,
        $merchantId = null
    ) {
        $methodName = "/Data/UpdateSupplierAlias";

        $data = [
            "SessionToken" => $sessionToken,
            "MerchantId" => $merchantId,
            "MerchantSupplierId" => $merchantSupplierId,
            "SupplierName" => $supplierName,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Soft-deletes a supplier link for the specified merchant. The supplier's merchant account is not affected — only the payer-to-supplier association is removed.
     * @param string $sessionToken
     * @param string $merchantSupplierId
     * @param string $merchantId
     *
     * @return mixed
     */
    public function deleteSupplier(
        $sessionToken,
        $merchantSupplierId,
        $merchantId = null
    ) {
        $methodName = "/Data/DeleteSupplier";

        $data = [
            "SessionToken" => $sessionToken,
            "MerchantId" => $merchantId,
            "MerchantSupplierId" => $merchantSupplierId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists supplier transfers initiated by the calling merchant (identified via FeeMerchantId). Returns transfers where the caller is the fee-payer, with optional date/status filters.
     * @param string $sessionToken
     * @param bool $onlyWithErrors
     * @param bool $markResolvedOnly
     * @param string $transferGroupId
     * @param string $merchantId
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @param string $supplierMerchantId
     *
     * @return mixed
     */
    public function listSupplierTransfers(
        $sessionToken,
        $onlyWithErrors,
        $markResolvedOnly,
        $transferGroupId,
        $merchantId = null,
        $fromDate = null,
        $toDate = null,
        $supplierMerchantId = null
    ) {
        $methodName = "/Data/ListSupplierTransfers";

        $data = [
            "SessionToken" => $sessionToken,
            "MerchantId" => $merchantId,
            "FromDate" => $fromDate,
            "ToDate" => $toDate,
            "OnlyWithErrors" => $onlyWithErrors,
            "MarkResolvedOnly" => $markResolvedOnly,
            "TransferGroupId" => $transferGroupId,
            "SupplierMerchantId" => $supplierMerchantId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves a single supplier transfer by ID. Accessible to both the fee-payer and the supplier. Returns the transfer details along with the counterparty name and the caller's role.
     * @param string $sessionToken
     * @param string $transferId
     *
     * @return mixed
     */
    public function getSupplierTransfer(
        $sessionToken,
        $transferId
    ) {
        $methodName = "/Data/GetSupplierTransfer";

        $data = [
            "SessionToken" => $sessionToken,
            "TransferId" => $transferId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists recurring supplier transfers initiated by the calling merchant. Returns recurring transfer configurations where the caller is the fee-payer.
     * @param string $sessionToken
     * @param string $merchantId
     *
     * @return mixed
     */
    public function listSupplierRecurringTransfers(
        $sessionToken,
        $merchantId = null
    ) {
        $methodName = "/Data/ListSupplierRecurringTransfers";

        $data = [
            "SessionToken" => $sessionToken,
            "MerchantId" => $merchantId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Lists recurring supplier transfers across an entire service. Returns every non-deleted recurring supplier transfer where any merchant in the given service is the fee-payer, with the supplier merchant's name on each entry. Use this to view all recurring supplier payments service-wide; use ListSupplierRecurringTransfers when scoping to a single fee-paying merchant.
     * @param string $sessionToken
     * @param string $serviceId
     *
     * @return mixed
     */
    public function listSupplierRecurringTransfersByService(
        $sessionToken,
        $serviceId
    ) {
        $methodName = "/Data/ListSupplierRecurringTransfersByService";

        $data = [
            "SessionToken" => $sessionToken,
            "ServiceId" => $serviceId,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Retrieves wallet operation history for a service within a specified date range. Returns the list of daily operations, the wallet balance as of the start date, and the configured delay buffer amount.
     * @param string $sessionToken
     * @param string $serviceId
     * @param \DateTime $from
     * @param \DateTime $to
     *
     * @return mixed
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

        return $this->crypto()->performCall($methodName, $data);
    }


    /**
     * Verifies the 2FA setup after user scans QR code and enters the code. Enables 2FA for the user once verification succeeds.
     * @param string $sessionToken
     * @param string $twoFactorCode
     *
     * @return mixed
     */
    public function verify2FASetup(
        $sessionToken,
        $twoFactorCode
    ) {
        $methodName = "/Data/Verify2FASetup";

        $data = [
            "SessionToken" => $sessionToken,
            "TwoFactorCode" => $twoFactorCode,
        ];

        return $this->crypto()->performCall($methodName, $data);
    }


   
}