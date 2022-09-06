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
     * Creates new session Guid 
     * @param string userName 
     * @param string password 
     * @param Guid clientId 
     * 
     */
    public function CreateSession($clientId, $userName, $password)
    {
        $methodName = "/Data/CreateSession";

        $data = [
            "ClientId" => $clientId,
            "Username" => $userName,
            "Password" => $password,
        ];
        return $this->tibCrypto->performCall($methodName, $data);
    }

    // Customer Methods
    /**
     * Create a new customer
     * @param string $customerName
     * @param string $customerExternalId
     * @param string $language
     * @param string $customerDescription
     * @param Guid $ServiceId
     *
     * @return json
     */
    public function createCustomer($customerName, $customerExternalId, $language, $customerEmail, $customerDescription, $serviceId, $SessionToken)
    {
        $methodName = "/Data/CreateCustomer";

        $data = [
            "ServiceId" => $serviceId,
            "SessionToken" => $SessionToken,
            "Customer" => [
                "CustomerName" => $customerName,
                "CustomerExternalId" => $customerExternalId,
                "Language" => $language,
                "CustomerDescription" => $customerDescription, 
                "CustomerEmail" => $customerEmail
            ]
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Get's List of customers for a spedific service Unique Identifier 
     * @param guid $serviceId
     * @param guid $SessionId
     *
     * @return json
     */
    public function listCustomers($serviceId, $SessionToken)
    {
        $methodName = "/Data/ListCustomers";

        $data = [
            "ServiceId" => $serviceId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Method to get a single customer with its payment methods based on the customer ID.
     * @param string $customerId
     *
     * @return json
     */
    public function getCustomer($customerId, $SessionToken)
    {
        $methodName = "/Data/GetCustomer";

        $data = [
            "CustomerId" => $customerId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Because the external identification is not forced by the API to be unique, 
     * the call returns a list of matching customers. 
     * A normal usage would always return only 1 element as a good practice would be to ensure to provide unique external number per customer.
     * 
     * @param string $externalCustomerId     *
     * @return json
     */
    public function getCustomersByExternalId($externalCustomerId, $SessionToken)
    {
        $methodName = "/Data/GetCustomersByExternalId";

        $data = [
            "ExternalCustomerId" => $externalCustomerId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * 
     * Method to modify the customer information. This has no impact on its payment methods.
     * 
     * @param string $customerId
     * @param string $customerName
     * @param string $customerExternalId
     * @param string $language
     * @param string $customerDescription
     *
     * @return json
     */
    public function saveCustomer($customerId, $customerName, $customerExternalId, $language, $customerEmail, $customerDescription, $SessionToken)
    {
        $methodName = "/Data/SaveCustomer";

        $data = [
            "Customer" => [
                "CustomerId" => $customerId,
                "CustomerName" => $customerName,
                "CustomerExternalId" => $customerExternalId,
                "Language" => $language,
                "CustomerDescription" => $customerDescription,
                "CustomerEmail" => $customerEmail
            ],
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * delete specefic Customer
     * @param string $customerId
     *
     * @return json
     */
    public function deleteCustomer($customerId, $SessionToken)
    {
        $methodName = "/Data/DeleteCustomer";

        $data = [
            "CustomerId" => $customerId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }
    // Merchant Methods

    /** Creates a New Merchant in a Specific Service
     * @param Array merchantObj
     * @param Guid SessionToken
     * @param Guid ServiceId
     */
    public function  CreateMerchant($merchantInfo, $serviceId, $sessionToken)
    {
        $methodName = "/Data/CreateMerchant";

        $data = [
            "ServiceId" => $serviceId,
            "MerchantInfo" => $merchantInfo,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    public function ListTransfers($sessionToken, $fromDate, $toDate, $externalMerchantGroupId, $levelFilterId, $markResolvedOnly, $paymentFilterLevel, $transferType, $transferGroupId, $onlyWithErrors)
    {
        $methodName = "/data/ListTransfers";
        $data = [
            "SessionToken" => $sessionToken,
            "FromDate" => $fromDate,
            "ExternalMerchantGroupId" => $externalMerchantGroupId,
            "LevelFilterId" => $levelFilterId,
            "MarkResolvedOnly" => $markResolvedOnly,
            "PaymentFilterLevel" => $paymentFilterLevel,
            "TransferType" => $transferType,
            "ToDate" >= $toDate,
            "TransferGroupId" => $transferGroupId,
            "OnlyWithErrors" => $onlyWithErrors,
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    public function ListTransfersFast($sessionToken, $merchantId, $fromDate, $toDate, $externalMerchantGroupId, $markResolvedOnly, $transferType, $transferGroupId, $onlyWithErrors)
    {
        $methodName = "/data/ListTransfersFast";

        $data = [
            "SessionToken" => $sessionToken,
            "FromDate" => $fromDate,
            "ExternalMerchantGroupId" => $externalMerchantGroupId,
            "MarkResolvedOnly" => $markResolvedOnly,
            "TransferType" => $transferType,
            "ToDate" => $toDate,
            "TransferGroupId" => $transferGroupId,
            "OnlyWithErrors" => $onlyWithErrors,
            "MerchantId" => $merchantId, // Merchant Id
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }


    public function ListTransfersForBillFast($sessionToken, $merchantId, $billId)
    {
        $methodName = "/data/ListTransfersForBillFast";
        $data = [
            "SessionToken" => $sessionToken,
            "BillId" => $merchantId, // the bill Id 
            "MerchantId" => $billId // The Merchant Id .
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }
    /**
     * Lists the Merchants available for a specific Service.
     * @param Guid ServiceId 
     * @param Guid SessionToken
     */
    public function ListMerchants($serviceId, $sessionToken)
    {
        $methodName = "/Data/ListMerchants";

        $data = [
            "ServiceId" => $serviceId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Gets a specific Merchant Information
     * @param Guid MerchantId 
     * @param Guid SessionToken
     */
    public function GetMerchant($merchantId, $sessionToken)
    {
        $methodName = "/Data/GetMerchant";

        $data = [
            "MerchantId" => $merchantId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Updates a specific merchant Information 
     * @param Guid merchantId 
     * @param Array MerchantInfo
     * @param guid SessionToken
     */
    public function SaveMerchant($merchantId, $merchantInfo, $sessionToken)
    {
        $methodName = "/Data/SaveMerchant";

        $data = [
            "MerchantId" => $merchantId,
            "MerchantInfo" => $merchantInfo,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * updates  a specific merchant Basic information 
     * @param Guid MerchantId
     * @param Array MerchantBasicInformation
     * @param Guid SessionToken
     */
    public function SaveMerchantBasicInfo($merchantId, $merchantBasicInfo, $sessionToken)
    {
        $methodName = "/Data/SaveMerchantBasicInfo";

        $data = [
            "MerchantId" => $merchantId,
            "MerchantInfo" => $merchantBasicInfo,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Updates a specific merchant Account information 
     * @param Guid MerchantId 
     * @param Array MerchantAccount 
     * @param Guid SessionToken 
     */
    public function SaveMerchantAccountInfo($merchantId, $merchantAccount, $sessionToken)
    {
        $methodName = "/Data/SaveMerchantAccountInfo";

        $data = [
            "MerchantId" => $merchantId,
            "Account" => $merchantAccount,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Deletes a Merchant
     * @param Guid MerchantId
     * @param Guid SessionToken
     */
    public function DeleteMerchant($merchantId, $sessionToken)
    {
        $methodName = "/Data/DeleteMerchant";

        $data = [
            "MerchantId" => $merchantId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    // Payment methods
    /**
     * create Direct Account Payment Method (Account, CreditCard, Intertac)
     * 
     * @param string $customerId
     * @param boolean $isCustomerAutomaticPaymentMethod
     * @param array $payementObj
     * @param string $type change the type to whatever payment method object you wanna user (Account, CreditCard or Interac)
     *
     * @return json
     */
    public function createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $payementObj, $type, $SessionToken)
    {
        $types = ["Account" => "Account", "CreditCard" => "CreditCard", "Interac" => "InteracInformation"];
        $methodNames = [
            "Account" => "/Data/CreateDirectAccountPaymentMethod",
            "CreditCard" => "/Data/CreateCreditCardPaymentMethod",
            "Interac" => "/Data/CreateInteracPaymentMethod"
        ];

        $data = [
            "CustomerId" => $customerId,
            "IsCustomerAutomaticPaymentMethod" => $isCustomerAutomaticPaymentMethod,
            "SessionToken" => $SessionToken,
            $types[$type] => $payementObj
        ];

        return $this->tibCrypto->performCall($methodNames[$type], $data);
    }

    /**
     * get Payment Method by identifier
     * @param string $paymentMethodId
     *
     * @return json
     */
    public function getPaymentMethod($paymentMethodId, $SessionToken)
    {
        $methodName = "/Data/GetPaymentMethod";

        $data = [
            "PaymentMethodId" => $paymentMethodId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get Customer Payment Methods list
     * @param string $customerId
     *
     * @return json
     */
    public function listPaymentMethods($customerId, $SessionToken)
    {
        $methodName = "/Data/ListPaymentMethods";

        $data = [
            "CustomerId" => $customerId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * set default payment method for a customer
     * @param string $paymentMethodId
     * @param string $customerId
     *
     * @return json
     */
    public function setDefaultPaymentMethod($paymentMethodId, $customerId, $SessionToken)
    {
        $methodName = "/Data/SetDefaultPaymentMethod";

        $data = [
            "PaymentMethodId" => $paymentMethodId,
            "CustomerId" => $customerId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * It is not possible to change an existing payment method question and answer because payment maybe be in execution process with the actual payment method information. 
     * However, it is possible to perform a call with new question and answer that will create a new payment method and logically delete the old one.
     */
    public function ChangeInteracPaymentMethodQuestionAndAnswer($interacPaymentMethodId, $interacQuestion, $interacAnswer, $SessionToken)
    {
        $methodName = "/data/ChangeInteracPaymentMethodQuestionAndAnswer";

        $data = [
            "InteracPaymentMethodId" => $interacPaymentMethodId,
            "InteracQuestion" => $interacQuestion,
            "InteracAnswer" => $interacAnswer,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * delete a payment method
     * @param string $paymentMethodId
     *
     * @return json
     */
    public function deletePaymentMethod($paymentMethodId, $SessionToken)
    {
        $methodName = "/Data/deletePaymentMethod";

        $data = [
            "PaymentMethodId" => $paymentMethodId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    // Bills / Payments / Transfers
    /**
     * Create Bill
     * @param boolean $breakIfMerchantNeverBeenAuthorized
     * @param array $billData
     *
     * @return json
     */
    public function createBill($breakIfMerchantNeverBeenAuthorized, $billData, $SessionToken)
    {
        $methodName = "/Data/CreateBill";

        $data = [
            "BreakIfMerchantNeverBeenAuthorized" => $breakIfMerchantNeverBeenAuthorized,
            "BillData" => $billData,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get a list of Bills
     * @param string $merchantId
     * @param datetime $fromDateTime
     * @param datetime $toDateTime
     *
     * @return json
     */
    public function listBills($merchantId, $fromDateTime, $toDateTime, $SessionToken)
    {
        $methodName = "/Data/ListBills";

        $data = [
            "MerchantId" => $merchantId,
            "FromDateTime" => $fromDateTime,
            "ToDateTime" => $toDateTime,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Get a desired Bill by it's unique identifier
     * @param Guid $billId
     *
     * @return json
     */
    public function getBill($billId, $SessionToken)
    {
        $methodName = "/Data/GetBill";

        $data = [
            "BillId" => $billId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Delete a  Bill
     * @param Guid $billId
     *
     * @return json
     */
    public function deleteBill($billId, $SessionToken)
    {
        $methodName = "/Data/DeleteBill";

        $data = [
            "BillId" => $billId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Add a new payment to apply on an existing bill.
     * @param Guid  $billId
     * @param boolean $setPaymentCustomerFromBill
     * @param array $paymentInfo
     *
     * @return json
     */
    public function createPayement($billId, $setPaymentCustomerFromBill, $customerEmail, $paymentInfo, $SessionToken)
    {
        $methodName = "/Data/DeleteBill";

        $data = [
            "BillId" => $billId,
            "SetPaymentCustomerFromBill" => $setPaymentCustomerFromBill,
            "CustomerEmail" => $customerEmail,
            "PaymentInfo" => $paymentInfo,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Direct Deposit (Obsolete (This Method Is Obsolete, Use CreateFreeOperation.))
     * @param Guid $originMerchantId
     * @param array $destinationAccount
     * @param date $depositDueDate
     * @param int $currency
     * @param int $language
     * @param double $amount
     * @param string $referenceNumber
     *
     * @return json
     */
    public function createDirectDeposit(
        $originMerchantId,
        $destinationAccount,
        $depositDueDate,
        $currency,
        $language,
        $amount,
        $referenceNumber,
        $SessionToken
    ) {
        $methodName = "/Data/CreateDirectDeposit";

        $data = [
            "OriginMerchantId" => $originMerchantId,
            "DestinationAccount" => $destinationAccount,
            "DepositDueDate" => $depositDueDate,
            "Currency" => $currency,
            "Language" => $language,
            "Amount" => $amount,
            "ReferenceNumber" => $referenceNumber,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create an Interac transfer to collect or deposit via Interac system.
     * @param Guid $originMerchantId
     * @param array $interacInformation
     * @param date $depositDueDate
     * @param int $currency
     * @param int $language
     * @param double $amount
     * @param string $referenceNumber
     *
     * @return json
     */
    public function createDirectInteracTransaction(
        $originMerchantId,
        $interacInformation,
        $depositDueDate,
        $currency,
        $language,
        $amount,
        $referenceNumber,
        $SessionToken
    ) {
        $methodName = "/Data/CreateDirectInteracTransaction";

        $data = [
            "OriginMerchantId" => $originMerchantId,
            "InteracInformation" => $interacInformation,
            "DepositDueDate" => $depositDueDate,
            "Currency" => $currency,
            "Language" => $language,
            "Amount" => $amount,
            "ReferenceNumber" => $referenceNumber,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create a batch of collection or deposit using the standard ACP file format.
     * @param string $merchantId
     * @param array $rawAcpFileContent
     *
     * @return json
     */
    public function createTransactionFromRaw($merchantId, $rawAcpFileContent, $SessionToken)
    {
        $methodName = "/Data/CreateTransactionFromRaw";

        $data = [
            "MerchantId" => $merchantId,
            "RawAcpFileContent" => $rawAcpFileContent,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create free operation to deposit or collect a customer directly.
     * @param string $merchantId
     * @param string $paymentMethodId
     * @param string $transferType
     * @param string $referenceNumber
     * @param double $amount
     * @param int $language
     * @param datetime $transactionDueDate
     * @param string $groupId
     * @param string transferFrequency
     *
     * @return json
     */
    public function createFreeOperation(
        $merchantId,
        $paymentMethodId,
        $transferType,
        $referenceNumber,
        $amount,
        $language,
        $transactionDueDate,
        $groupId,
        $transferFrequency,
        $stopSameIdentifications,
        $SessionToken
    ) {
        $methodName = "/Data/CreateFreeOperation";

        $data = [
            "MerchantId" => $merchantId,
            "PaymentMethodId" => $paymentMethodId,
            "TransferType" => $transferType,
            "ReferenceNumber" => $referenceNumber,
            "Amount" => $amount,
            "Language" => $language,
            "TransactionDueDate" => $transactionDueDate,
            "GroupId" => $groupId,
            "TransferFrequency" => $transferFrequency,
            "StopSameIdentifications" => $stopSameIdentifications,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     *Remove a free operation or payment from the system.
     * @param string $paymentId
     *
     * @return json
     */
    public function deletePayment($paymentId, $SessionToken)
    {
        $methodName = "/Data/DeletePayment";

        $data = [
            "PaymentId" => $paymentId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Allows to revert a payment or a free operation. 
     * @param string $transferId
     *
     * @return json
     */
    public function revertTransfer($transferId, $SessionToken)
    {
        $methodName = "/Data/RevertTransfer";

        $data = [
            "TransferId" => $transferId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * When payment or free operation is created using “TransferFrequency”, 
     * the API will automatically create next payment after the first is created. 
     * This method allows to list the transfer having “active” recuring activated.
     * 
     * @param string $serviceId
     *
     * @return json
     */
    public function getRecuringTransfers($serviceId, $SessionToken)
    {
        $methodName = "/Data/GetRecuringTransfers";

        $data = [
            "ServiceId" => $serviceId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Delete recuring process added when using “TransferFrequency” whilw creating payment. 
     * The recuring identification can be known using the List Recuring method.
     * @param string $recuringTransferId
     *
     * @return json
     */
    public function deleteRecuringTransfer($recuringTransferId, $SessionToken)
    {
        $methodName = "/Data/DeleteRecuringTransfer";

        $data = ["RecuringTransferId" => $recuringTransferId];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * List Executed Operation
     * @param date $fromDate
     * @param date $toDate
     * @param string $transferType
     * @param string $transferGroupId
     * @param booles $onlyWithErrors
     * @param string $merchantId
     * @param date $dateType
     *
     * @return json
     */
    public function listExecutedOperations(
        $fromDate,
        $toDate,
        $transferType,
        $transferGroupId,
        $onlyWithErrors,
        $merchantId,
        $dateType,
        $SessionToken
    ) {
        $methodName = "/Data/ListExecutedOperations";

        $data = [
            "FromDate" => $fromDate,
            "ToDate" => $toDate,
            "TransferType" => $transferType,
            "TransferGroupId" => $transferGroupId,
            "OnlyWithErrors" => $onlyWithErrors,
            "MerchantId" => $merchantId,
            "DateType" => $dateType,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /// Whitelabelings 

    /**
     * Set WhiteLabeling for an entity (client, service or a merchant).
     * @param Guid $Id
     * @param int $level Range from 1 to 3
     * @param array $whiteLabelingData
     * @return json
     */
    public function SetwhiteLabeling($id, $level, $whiteLabelingData, $SessionToken)
    {
        $methodName = "/Data/SetWhiteLabeling";

        $data = [
            "Id" => $id,
            "WhiteLabelingLevel" => $level,
            "WhiteLabelingData" => $whiteLabelingData,
            "SessionToken" => $SessionToken
        ];


        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Set WhiteLabeling for an entity.
     * @param Guid $Id entity Id that will have the whitelabeling.
     * @param int $level Range from 1 to 3 the whitelabeling level that will have the white labeling
     * @param array $whiteLabelingData the whitelabeling data values.
     * @return json
     */
    public function GetWhiteLabelingData($id, $level, $SessionToken)
    {
        $methodName = "/Data/GetWhiteLabelingData";

        $data = [
            "Id" => $id,
            "WhiteLabelingLevel" => $level,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * update WhiteLabeling data for an entity.
     * @param Guid $Id
     * @param int $level Range from 1 to 3
     * @param array $whiteLabelingData
     * @return json
     */
    public function DeleteWhiteLabeling($id, $level, $whiteLabelingData, $SessionToken)
    {
        $methodName = "/Data/UpdateWhiteLabelingData";

        $data = [
            "Id" => $id,
            "WhiteLabelingLevel" => $level,
            "UpdatedWhiteLabelingData" => $whiteLabelingData,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Delete a WhiteLabeling for an entity.
     * @param Guid $Id
     * @param int $level Range from 1 to 3
     * @param array $whiteLabelingData
     * @return json
     */
    public function DeleteWhiteLabelingData($id, $level, $SessionToken)
    {
        $methodName = "/Data/DeleteWhiteLabeling";

        $data = [
            "Id" => $id,
            "Level" => $level,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data, $SessionToken);
    }

    /**
     * get a list of WhiteLabeling for each entity type.
     * @return json
     */
    public function GetListWhiteLabelingData($SessionToken)
    {
        $methodName = "/Data/GetListWhiteLabelingData";

        $data = [
            // "Id" => "",
            // "WhiteLabelingLevel" => ""
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /// SubClients
    /**
     * Set a client default service Fee settings 
     * @param Guid $clientId
     * @param array $ServiceFeeSettings
     * @return json
     */
    public function SetClientDefaultServiceFeeSettings($clientId, $ServiceFeeSettings, $SessionToken)
    {
        $methodName = "/Data/SetClientDefaultServiceFeeSettings";

        $data = [
            "ClientId" => $clientId,
            "ServiceFeeSettings" => $ServiceFeeSettings,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create a new sub client
     * @param string $name 
     * @param int $language
     * @return json  
     */
    public function CreateSubClient($name, $language, $SessionToken)
    {
        $methodName = "/Data/CreateSubClient";

        $data = [
            "Name" => $name,
            "Language" => $language,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * set setting for a single client.
     * @param Guid $clientId
     * @param array $clientSettings
     * @return json
     */
    public function SetClientSettings($clientId, $clientSettings, $SessionToken)
    {
        $methodName = "/Data/SetClientSettings";

        $data = [
            "CLientId" => $clientId,
            "ClientSettings" => $clientSettings,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get the settings of a single client.
     * @param Guid ClientId
     * @return Json
     */
    public function GetClientSettings($clientId, $SessionToken)
    {

        $methodName = "/Data/GetClientSettings";

        $data = [
            "ClientId" => $clientId,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Marks a payment as resolved
     * @param Array listOfPayment
     * @param Guid sessionToken
     */
    public function MarkPaymentResolved($listOfPayment, $sessionToken)
    {
        $methodName = "/Data/MarkPaymentResolved";

        $data = [
            "ListOfPayment" => $listOfPayment,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * gets a specific Merchant by it's External identification
     * @param Guid externalSystemId 
     * @param Guid externalSystemGroupId 
     * @param Guid sessionToken
     */
    public function GetMerchantsByExternalId($externalSystemId, $externalSystemGroupId, $sessionToken)
    {
        $methodName = "/Data/GetMerchantsByExternalId";

        $data = [
            "ExternalSystemId" => $externalSystemId,
            "ExternalSystemGroupId" => $externalSystemGroupId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Force a payment proccess 
     * @param Guid paymentId 
     * @param Guid sessionToken
     */
    public function ForcePaymentProcess($paymentId, $sessionToken)
    {
        $methodName = "/Data/ForcePaymentProcess";

        $data = [
            "PaymentId" => $paymentId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Login using a client id 
     * @param Guid clientId 
     * @param Guid loginsUserRelationsId, 
     * @param String username
     * @param String password 
     * @param Guid sessionToken
     */
    public function Login($clientId, $loginsUserRelationsId, $username, $password, $sessionToken)
    {
        $methodName = "/Data/Login";

        $data = [
            "ClientIdUsername" => $clientId,
            "LoginsUserRelationsId" => $loginsUserRelationsId,
            "Username" => $username,
            "Password" => $password,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Gets a list of login access.
     * @param Guid clientId 
     * @param String username
     * @param String password 
     * @param Guid sessionId   
     */
    public function GetLoginAccessList($clientId, $username, $password, $sessionToken)
    {
        $methodName = "/Data/GetLoginAccessList";

        $data = [
            "ClientId" => $clientId,
            "Username" => $username,
            "Password" => $password,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get's a public droin dropin token 
     * @param Guid ClientId
     * @param Guid billId
     * @param double amount
     * @param int transferType
     * @param int dropInAuthorizedPaymentMethod
     * @param String externalReferenceNumber
     * @param Bool showCustomerExistingPaymentMethods
     * @param int language
     * @param int expirationDate
     * @param String Title
     * @param String description
     * @param DateTime paymentDueDate
     * @param Guid merchantId
     * @param Guid sessionToken
     * 
     */
    public function GetDropInPublicToken(
        $clientId,
        $billId,
        $amount,
        $transferType,
        $dropInAuthorizedPaymentMethod,
        $externalReferenceNumber,
        $showCustomerExistingPaymentMethods,
        $language,
        $expirationDays,
        $title,
        $description,
        $paymentDueDate,
        $merchantId,
        $sessionToken
    ) {
        $methodName = "/Data/GetDropInPublicToken";

        $data = [
            "CustomerId" => $clientId,
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
            "MerchantId" => $merchantId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }
    /**
     * Add new DAS provider for a merchant
     * @param Guid merchantId
     * @param int DasProviderType
     * @param Array DasProvicerQuebec
     * @param Array DasProvicerCanada
     * @param Guid sessionToken
     */
    public function AddNewDasProvider($merchantId, $DasProviderType, $DasProviderQuebec, $DasProviderCanada, $sessionToken)
    {
        $methodName = "/Data/AddNewDasProvider";

        $data = [
            "MerchantId" => $merchantId,
            "DasProviderType" => $DasProviderType,
            "DasProviderQuebec" => $DasProviderQuebec,
            "DasProviderCanada" => $DasProviderCanada,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Add new DAS payment to a DAS provider
     * @param Guid merchantId
     * @param Guid DasProviderId
     * @param int DasProviderType
     * @param Array DasProvicerQuebec
     * @param Array DasProvicerCanada
     * @param Guid sessionToken
     */
    public function AddNewDasPayment($merchantId, $DasProviderId, $DasPaymentProviderType, $DasPaymentCanada, $DasPaymentQuebec, $sessionToken)
    {
        $methodName = "/Data/AddNewDasPayment";

        $data = [
            "MerchantId" => $merchantId,
            "DasProviderId" => $DasProviderId,
            "DasPaymentProviderType" => $DasPaymentProviderType,
            "DasPaymentCanada" => $DasPaymentCanada,
            "DasPaymentQuebec" => $DasPaymentQuebec,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }
    /**
     * List all DAS providers for a merchant
     * List all merchant DAS providers
     * @param Guid merchantId 
     * @param Guid sessionToken
     */
    public function ListDasProviders($merchantId, $sessionToken)
    {
        $methodName = "/Data/ListDasProviders";

        $data = [
            "MerchantId" => $merchantId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * List all DAS payment for a DAS provider
     * @param Guid merchantId 
     * @param Guid DasProviderId
     * @param Guid sessionToken
     */
    public function ListDasPayments($merchantId, $DasProviderId, $sessionToken)
    {
        $methodName = "/Data/ListDasPayments";

        $data = [
            "MerchantId" => $merchantId,
            "DasProviderId" => $DasProviderId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * get's a list of Services 
     * @param Guid MerchantId
     * @param Guid sessionToken
     */
    public function ListServices($merchantId, $sessionToken)
    {
        $methodName = "/Data/ListServices";

        $data = [
            "MerchantId" => $merchantId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * gets a sepecific Service detail
     * @param Guid ServiceId 
     * @param Guid sessionToken
     */
    public function GetService($serviceId, $sessionToken)
    {
        $methodName = "/Data/GetService";

        $data = [
            "ServiceId" => $serviceId,
            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Creates a payment for a bill
     * @param Guid billId The Bill to Create the payment for.
     *  @param bool setPaymentCustomerFromBill 
     *  @param String CustomerEmail
     *  @param Array paymentInfo
     *  @param String externalReferenceId
     *  @param bool askForCustomerConsent
     *  @param Bool safetyToBreakIfOverRemainingBillAmount
     *  @param int autorizedPaymentMethod
     *  @param Bool doNotSendEmail
     *  @param String statementDescription
     *  @param Guid sessionToken 
     */
    public function CreatePayment($billId, $setPaymentCustomerFromBill, $CustomerEmail, $paymentInfo, $externalReferenceId, $askForCustomerConsent, $safetyToBreakIfOverRemainingBillAmount, $autorizedPaymentMethod, $doNotSendEmail, $statementDescription, $sessionToken)
    {
        $methodName = "/Data/CreatePayment";

        $data = [
            "BillId" => $billId,
            "SetPaymentCustomerFromBill" => $setPaymentCustomerFromBill,
            "CustomerEmail" => $CustomerEmail,
            "PaymentInfo" => $paymentInfo,
            "ExternalReferenceId" => $externalReferenceId,
            "AskForCustomerConsent" => $askForCustomerConsent,
            "SafetyToBreakIfOverRemainingBillAmount" => $safetyToBreakIfOverRemainingBillAmount,
            "AutorizedPaymentMethod" => $autorizedPaymentMethod,
            "DoNotSendEmail" => $doNotSendEmail,
            "StatementDescription" => $statementDescription,

            "SessionToken" => $sessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }
}
