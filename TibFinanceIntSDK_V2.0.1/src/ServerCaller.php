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
    public function createCustomer($customerName, $customerExternalId, $language, $customerDescription, $serviceId, $SessionToken)
    {
        $methodName = "/Data/CreateCustomer";

        $data = [
            "ServiceId" => $serviceId,
            "SessionToken" => $SessionToken,
            "Customer" => [
                "CustomerName" => $customerName,
                "CustomerExternalId" => $customerExternalId,
                "Language" => $language,
                "CustomerDescription" => $customerDescription
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
    public function saveCustomer($customerId, $customerName, $customerExternalId, $language, $customerDescription, $SessionToken)
    {
        $methodName = "/Data/SaveCustomer";

        $data = [
            "Customer" => [
                "CustomerId" => $customerId,
                "CustomerName" => $customerName,
                "CustomerExternalId" => $customerExternalId,
                "Language" => $language,
                "CustomerDescription" => $customerDescription
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
    public function createPayement($billId, $setPaymentCustomerFromBill, $paymentInfo, $SessionToken)
    {
        $methodName = "/Data/DeleteBill";

        $data = [
            "BillId" => $billId,
            "SetPaymentCustomerFromBill" => $setPaymentCustomerFromBill,
            "PaymentInfo" => $paymentInfo,
            "SessionToken" => $SessionToken
        ];

        return $this->tibCrypto->performCall($methodName, $data);
    }

    /**
     * Create Direct Deposit
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
    public function GetwhiteLabeling($id, $level, $SessionToken)
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
    public function UpdateWhiteLabelingData($id, $level, $whiteLabelingData, $SessionToken)
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
}
