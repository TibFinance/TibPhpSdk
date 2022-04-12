
# Methods

## List Of Methods

* #### Customers
	* [Create a customer](#create-customer).
	* [List all service customers](#list-all-service-customers).
	* [Get a customer detail](#get-a-customer-detail).
	* [List the customers based on external identification](#list-the-customers-based-on-external-identification).
	* [Modify an existing customer](#modify-an-existing-customer).
	* [Delete a customer](#delete-a-customer).

* #### Payment methods
	* [Create bank account payment method](#create-bank-account-payment-method).
	* [Create credit card payment method](#create-credit-card-payment-method).
	* [Create Interac payment method](#create-Interac-payment-method).
	* [Change Interac Payment Method Question and Answer](#change-Interac-Payment-Method-Question-and-Answer)
	* [Get a specific payment method](#get-a-specific-payment-method).
	* [List payment methods](#list-payment-methods)
	* [Change the default payment method of a customer](#change-the-default-payment-method-of-a-customer).
	* [Delete payment method](#delete-payment-method).
	
* #### Payments / Transfers
	* [Create Bill](#create-bill).
	* [List Bill](#list-bill).
	* [Get Bill](#get-bill).
	* [Delete Bill](#delete-bill).
	* [Create Payment](#create-payment).
	* [Create Direct Deposit](#create-direct-deposit).
	* [Create Interac Transfer](#create-interac-transfer).
	* [Create from ACP File](#create-from-acp-file).
	* [Create Free Operation](#create-free-operation).
	* [Delete Transfer](#delete-transfer).
	* [Revert Transfer](#revert-transfer).
	* [List Recuring](#list-recuring).
	* [Delete Recuring process](#delete-recuring-process).
	* [Reporting of Operation](#reporting-of-operation)
	* [List Executed Operations](#list-executed-operations).
	* [List Transfers](#list-transfers).
	* [List Transfers Fast](#list-transfers-fast)
	* [List transfers For Bill Fast](#list-transfers-for-bill-fast).

* #### Merchants
	* [Merchant basic information object](#merchant-basic-information-object).
	* [Create new merchant](#create-new-merchant).
	* [Get merchant info ](#get-merchant-info)
	* [Update merchant](#update-merchant).
	* [Delete merchant](#delete-merchant).
	* [Update merchant basic info](#update-merchant-basic-info).
	* [Update merchant account info](#update-Merchant-Account-Info).

* #### Whitelabeling (UI Looks)
	* [Set WhiteLabeling](#set-whiteLabeling)
	* [Delete WhiteLabeling](#delete-whiteLabeling)
	* [Get WhiteLabeling](#get-whiteLabeling)
	* [Update WhiteLabeling Values](#update-whiteLabeling-alues)
	* [Get List of WhiteLabeling (related Services/Merchants)](#get-list-of-whiteLabeling)
	
* #### Clients
	* [sub-client](#sub-client)
	* [Set client default service fee settings](#set-client-default-service-fee-settings)
	* [Set client settings](#set-client-settings)
	* [Get client settings](#get-client-settings)
  
## Usage

In this document you'll see `$sessionToken`  passed to every call for the sake of this document consider that the variable is declared Globaly and contains a fresh SessionToken.
Also For the context of this documentation `$serviceId` contains an Id of an active service. and also declared Globaly.

## Customers Methods
` after you set up the api url and created a session you can start Using the Other Methods of the Sdk `

### Create customer
```
$customerName = ""; // customer Name
$customerExternalId = ""; //
$language = 1; // language Index From the language Enum
$customerDescription = ""; // customer description.

$result = $serverCaller->createCustomer($customerName, $customerExternalId, $language, $customerDescription, $serviceId, $sessionToken);
        
```

### List all service customers
```
$serviceId = "";  // the service to get the list from 
$result = $serverCaller->listCustomers($serviceId,$sessionToken);
```

### Get a customer detail
```
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
$result = $serverCaller->getCustomer($customerId,$sessionToken);
```

### List the customers based on external identification
``` 
$customerExternalId = "C132-344"; // customer ExternalId
$result = $serverCaller->getCustomersByExternalId($customerExternalId,$sessionToken);     
```

### Modify an existing customer
```
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd"; // customer Id to update.
$customerName = "new value";
$customerExternalId = "new Value";
$language = 1;
$customerDescription = "new Value";

$result = $serverCaller->saveCustomer($customerId, $customerName, $customerExternalId, $language, $customerDescription,$sessionToken);
        
```

### Delete a customer
```
$customerId = "dc09fbbf-4067-4b21-af09-81707fd227a6"; 

$result = $serverCaller->deleteCustomer($customerId,$sessionToken);
```

## Payment methods

### Create bank account payment method

```
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
$isCustomerAutomaticPaymentMethod = true;
$type = "Account";
$account = [
	"Owner" => "Customer 200",
	"AccountName" => "Personal bank account",
	"BankNumber" => "003",
	"InstitutionNumber" => "12345",
	"AccountNumber" => "9876543"
];
$result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $account, $type,$sessionToken);

```

### Create credit card payment method
```
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
$isCustomerAutomaticPaymentMethod = true;
$type = "CreditCard";
$creditCard = [
	"Pan" => "4242424242424242",
	"Cvd" => "123",
	"ExpirationMonth" => "12",
	"ExpirationYear" => "24",
	"CreditCardDescription" => "Test card",
	"CardOwner" => "Johny Cardholder",
	"CreditCardRegisteredAddress" => [
		"StreetAddress" => "1 Testing road",
		"AddressCity" => "Testcity",
		"ProvinceStateId" => "10",
		"CountryId" => 1,
		"PostalZipCode" => "H1H1H1"
	]
];
$result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $creditCard, $type,$sessionToken);
        
```


### Create Interac payment method

``` 
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
$isCustomerAutomaticPaymentMethod = true;
$type = "Interac";
$InteracInformation = [
	"Description" => "Interac Test",
	"Owner" => "Kelly Interac",
	"TargetEmailAddress" => "kinterac@dummytest.com",
	"TargetMobilePhoneNumber" => "8881234567",
	"InteracQuestion" => "Remember the fruit",
	"InteracAnswer" => "Orange"
];

$result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $InteracInformation, $type,$sessionToken);
```

### Change Interac Payment Method Question and Answer
``` 
$id = "";
$question = "new Question";
$answer = "new answer ";
$result = $serverCaller->ChangeInteracPaymentMethodQuestionAndAnswer($id, $question, $answer,$sessionToken);
           
```

### Get a specific payment method
```
$paymentId = "5397c23a-e938-47c5-94f8-c2d821959ec5";

$result = $serverCaller->getPaymentMethod($paymentId,$sessionToken);
```

### List payment methods
```
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
$result = $serverCaller->listPaymentMethods($customerId,$sessionToken);
```

### Change the default payment method of a customer
```
$paymentMethodId = "5397c23a-e938-47c5-94f8-c2d821959ec5";
$customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";

$result = $serverCaller->setDefaultPaymentMethod($paymentMethodId, $customerId,$sessionToken);
```

### Delete payment method
```
$paymentMethodId = "5397c23a-e938-47c5-94f8-c2d821959ec5";

$result = $serverCaller->deletePaymentMethod($paymentMethodId,$sessionToken);
```

## Bills / Payments / Transfers

### Create Bill
```
$breakIfMerchantNeverBeenAuthorized = true;
$billData = [
	"MerchantId" => $merchantId,
	"BillTitle" => "test interac",
	"BillDescription" => "test interac",
	"BillAmount" => 1,
	"ExternalSystemBillNumber1" => "",
	"ExternalSystemBillNumber2" => "",
	"ExternalSystemBillNumber3" => "",
	"BillCurrency" => 2,
	"Language" => 1,
	"RelatedCustomerId" => "bf199033-53a1-48cd-8f17-04254d026ecd"
];

$result = $serverCaller->createBill($breakIfMerchantNeverBeenAuthorized, $billData,$sessionToken);
```

### List Bills

```
$fromDateTime = "2021-02-16T13:45:00.000Z";
$toDateTime = "2021-05-16T13:45:00.000Z";

$result = $serverCaller->listBills($merchantId, $fromDateTime, $toDateTime,$sessionToken);

```

### Get Bill

```
$billId = "b2678654-9eec-4a6e-aeaa-8d0893b2a986";

$result = $serverCaller->getBill($billId,$sessionToken);
```

### Delete Bill
```
$billId = "0ec1520e-7f5a-4367-8c7d-0d9684f689fe";

$result = $serverCaller->deleteBill($billId,$sessionToken);
```
*Keep in mind that you'll have to implement your own verification logic to avoid deleting a bill by mistake*

### Create Payment

```
$billId = "3c7792af-f377-48ba-b3f1-0474f6eab127";
$setPaymentCustomerFromBill = false;
$paymentInfo = [
	"PaymentFlow" => 6,
	"RelatedCustomerId" => "d215b447-7746-4865-b9fa-78e72a2f5678",
	"DueDate" => "2021-05-10T16:10:19.000Z",
	"PaymentAmount" => 1.22
];

$result = $serverCaller->createPayement($billId, $setPaymentCustomerFromBill, $paymentInfo,$sessionToken,$sessionToken);
```

### Create Direct Deposit (this Methods is obsolete, Use CreateFreeOperation) 
```
$originMerchantId = $merchantId;
$destinationAccount = [
	"Owner" => "Jeff Testing",
	"AccountName" => "Personal bank account",
	"BankNumber" => "003",
	"InstitutionNumber" => "12345",
	"AccountNumber" => "9876543"
];
$depositDueDate = "2021-02-16T16:10:19.000Z";
$currency = 1;
$language = 1;
$amount = 1.22;
$referenceNumber = "C12343-324";

$result = $serverCaller->createDirectDeposit($originMerchantId, $destinationAccount, $depositDueDate, $currency, $language, $amount, $referenceNumber,$sessionToken);
```

### Create Interac Transfer

```
$originMerchantId = $merchantId;
$interacInformation = [
	"Owner" => "Jeff Testing",
	"AccountName" => "Personal bank account",
	"BankNumber" => "003",
	"InstitutionNumber" => "12345",
	"AccountNumber" => "9876543"
];
$depositDueDate = "2021-02-16T16:10:19.000Z";
$currency = 1;
$language = 1;
$amount = 1.22;
$referenceNumber = "C12343-324";

$result = $serverCaller->createDirectDeposit($originMerchantId, $interacInformation, $depositDueDate, $currency, $language, $amount, $referenceNumber,$sessionToken);
```
### Create from ACP file
```
$rawAcpFileContent = "";
$result = $serverCaller->createTransactionFromRaw($merchantId, $rawAcpFileContent,$sessionToken);
```
### Create Free Operation
```
$paymentMethodId = "03c415fd-5f64-4678-a388-39facbb2bee1";
$transferType = 1;
$referenceNumber = "C123-01312";
$amount = 1.22;
$language = 1;
$transactionDueDate = "2021-05-12T16:10:19.000Z";
$groupId = "HT123123";
$transferFrequency = 0;

$result = $serverCaller->createFreeOperation($merchantId, $paymentMethodId, $transferType, $referenceNumber, $amount, $language, $transactionDueDate, $groupId, $transferFrequency,$sessionToken);
```
### Delete Transfer
```
$paymentId = "03c415fd-5f64-4678-a388-39facbb2bee1";

$result = $serverCaller->deletePayment($paymentId,$sessionToken);
```
### Revert Transfer
```
$transferId = "c9a521d5-60a1-4398-8f6c-7462797d584c";

$result = $serverCaller->revertTransfer($transferId,$sessionToken);
```
### List Recuring
```
$result = $serverCaller->getRecuringTransfers($serviceId,$sessionToken);
```

### Delete Recuring process
```
$recuringTransferId = "89d720f2-78ae-4816-8fda-0099aa867c38";

$result = $serverCaller->deleteRecuringTransfer($recuringTransferId,$sessionToken);
```

## Reporting of Operation

### List Executed Operations
```
$fromDate = "";
$toDate = "";
$transferType = "";
$transferGroupId = "";
$onlyWithErrors = "";
$merchantId = "";
$dateType = "";

$result = $serverCaller->listExecutedOperations($fromDate, $toDate, $transferType, $transferGroupId, $onlyWithErrors, $merchantId, $dateType, $sessionToken);

```
### List Transfers
```
 	$from = new DateTime(""); 
	$to = new DateTime(""); 
	$exGroupId = ""; 
	$lvlFilterId = ""; 
	$markResolvedOnly = false;
	$paymentFilterLvl = 2 ;// this Ranges from 1 to ...
	$transferType = 1 ;// this Ranges from 1 to 7
	$transferGroupId  = "" ; 
	$onlywithErrors = false;
	$result = $serverCaller->ListTransfers($sessionToken, $from, $to, $exGroupId, $lvlFilterId, $markResolvedOnly,$paymentFilterLvl, $transferType, $transferGroupId, $onlywithErrors);
	ResponseHandler($result);
```

### List Transfers Fast
```
	$from = new DateTime(""); 
	$to = new DateTime(""); 
	$exGroupId = ""; 
	$merchantId = ""; 
	$markResolvedOnly = false;
	$transferType = 1 ;// this Ranges from 1 to 6 and is different From the Enum used in ListTransfers (List Transfers Uses TransferTypeFlags and This Uses TransferTypeEnum.)
	$transferGroupId  = "" ; 
	$onlywithErrors = false;
	$result = $serverCaller->ListTransfersFast($sessionToken, $merchantId, $from, $to, $exGroupId, $markResolvedOnly, $transferType, $transferGroupId, $onlywithErrors);
	ResponseHandler($result);

```

### List transfers For Bill Fast
```
	$merchantId = ""; 
	$bill = ""; 
	$result = $serverCaller->ListTransfersForBillFast($sessionToken, $merchantId, $billId);
```


## Merchant Methods

### Create new merchant
```
$merchantInfo = [
	"EmailCopyTo" => "",
	"ExternalSystemId" => "",
	"Email" => "",
	"FavoriteProvider" => 0,
	"Language" => 0,
	"MerchantCurrency" => 0,
	"MerchantDescription" => "",
	"MerchantName" => "",
	"PhoneNumber" => "",
	"ExternalSystemGroupId" => "",
	"Address" => [
		"AddressCity" => "",
		"CountryId" => 0,
		"PostalZipCode" => "",
		"ProvinceStateId" => 0,
		"StreetAddress" => ""
	],
	"Account" => [
		"AccountName" => "",
		"AccountNumber" => "",
		"BankNumber" => "",
		"CheckDigit" => "",
		"InstitutionNumber" => "",
		"Owner" => ""
	],
]; 
$result = $serverCaller->CreateMerchant($merchantInfo, $sessionToken, $serviceId);
```
### Get merchant info
``` 
$merchantId = ""; 
$result = $serverCaller->GetMerchant($merchantId, $sessionToken);
```
### Update merchant
``` 
$merchantId = ""; 
$merchantInfo = [
	"MerchantName" => "",
	"ExternalSystemId" => "",
	"ExternalSystemGroupId" => "",
	"MerchantCurrency" => "",
	"Language" => "",
	"Email" => "",
	"EmailCopyTo" => "",
	"PhoneNumber" => "",
	"MerchantDescription" => "",
	"Address" => [    
		"StreetAddress" => "",
		"AddressCity" => "",
		"ProvinceStateId" => 1,
		"CountryId" => 1,
		"PostalZipCode" => "",
	],
	"FavoriteProvider" => "",
	"Account" => [
		"AccountName" => "",
		"Owner" => "",
		"BankNumber" => "",
		"InstitutionNumber" => "",
		"AccountNumber" => "",
		"CheckDigit" => "",
		"FullAccountNumber" => "",
		"AccountNumberWithCheckDigit" => "",
		"PreviewString" => "",
	],
]; 
$result  = $serverCaller->SaveMerchant($merchantId, $merchantInfo, $sessionToken);
```
### Delete merchant
```
var deleteMerchantArgs = new Tib.Api.Model.Merchant.DeleteMerchantArgs
{
	SessionToken = _session,
	MerchantId = _merchant
};
var result = TibInvoker.Portal.DeleteMerchant(deleteMerchantArgs);
```
### Update merchant basic info 
```
$merchantId = ""; 
$merchantInfo = [
	"MerchantName" => "",
	"ExternalSystemId" => "",
	"ExternalSystemGroupId" => "",
	"MerchantCurrency" => "",
	"Language" => "",
	"Email" => "",
	"EmailCopyTo" => "",
	"PhoneNumber" => "",
	"MerchantDescription" => "",
	"Address" => [    
		"StreetAddress" => "",
		"AddressCity" => "",
		"ProvinceStateId" => 1,
		"CountryId" => 1,
		"PostalZipCode" => "",
	],
	"FavoriteProvider" => ""
];
$result  = $serverCaller->SaveMerchantBasicInfo($merchantId, $merchantInfo, $sessionToken);
```
### Update merchant account info

```
$merchantId = ""; 
$merchantInfo = [
	"Account" => [
		"AccountName" => "",
		"Owner" => "",
		"BankNumber" => "",
		"InstitutionNumber" => "",
		"AccountNumber" => "",
		"CheckDigit" => "",
		"FullAccountNumber" => "",
		"AccountNumberWithCheckDigit" => "",
		"PreviewString" => "",
	],
];
$result  = $serverCaller->SaveMerchantAccountInfo($merchantId, $merchantInfo, $sessionToken);
```

## Whitelabeling (UI Looks)

The Whitelabeling can be set on multiple levels 

* Client
* Service
* Merchant

please See [whitelabeling levels enums](../README.md#WhiteLabeling-levels-enum)

The WhiteLabeling Use 2 main Objects `WhiteLabelingModel` and `WhiteLabelingDataModel`

The first is a container of white labeling Values for a single entity (client, service, merchant) and have a list of `WhiteLabelingDataModel`.

The Second one represents the values that a single whitelabeling cssProperty going to have.

*Note: To Chenge the logo the api accepts images as a base64 string so you will need to implement your own imageToBase64 and the pass the string to the api.*

The WhiteLabeling only support a number of parameters 

This is the list o f the properties that you can customize 
```
"company-name"
"logo-secound-part-color"
"logo-first-Part-color"
"logo-background"
"radio-button-color"
"checbox-color"
"sidenav-item-active-color"
"sidenav-button-trigger-color"
"button-color"
"logo"
"accepte-button-color"
"reject-button-color"
"navbar-backgournd-color"
"icon-size"
"title-font-family"
"title-font-size"
"subtitle-font-family"
"subtitle-font-size"
"subtitle-text-color"
```
you pass one of those to the cssProperty and pass the value you want it to be.

### Set WhiteLabeling
```
$id = $clientId;  // entity Id ; 
$level = 3; // entity level; 
$whiteLabelingData = [
	[
		"CssPropery" => "logo",
		"CssValue" => "base64string"
	],
	[
		"CssPropery" => "button-color",
		"CssValue" => "red"
	],
];
$result = $serverCaller->SetwhiteLabeling($id, $level, $whiteLabelingData,$sessionToken);
```
### Delete WhiteLabeling

```
$id = $clientId;  // entity Id ; 
$level = 3; // entity level; 
$result = $serverCaller->DeleteWhiteLabelingData($id, $level,$sessionToken);
```

### Get WhiteLabeling
```
$id = $clientId;  // entity Id ; 
$level = 3; // entity level; 
$result = $serverCaller->GetwhiteLabeling($id, $level,$sessionToken);
```

### Update WhiteLabeling Values

```
$id = $clientId;  // entity Id ; 
$level = 3; // entity level; 
$updateWhiteLabelingData = [
	[
		"Id" => "", // required for update;
		"CssPropery" => "....",
		"CssValue" => "...."
	],
	[
		"Id" => "",
		"CssPropery" => "....",
		"CssValue" => "...."
	],
	[
		"Id" => "",
		"CssPropery" => "....",
		"CssValue" => "...."
	],
];
$result = $serverCaller->UpdateWhiteLabelingData($id, $level, $updateWhiteLabelingData,$sessionToken);
```

### Get List of WhiteLabeling
```
$result = $serverCaller->GetListWhiteLabelingData($sessionToken);
```

## Clients
### sub-client
```
$name = "new sub Client";
$language = 2;
$result = $serverCaller->CreateSubClient($name, $language,$sessionToken);
```
### Set client default service fee settings
```
$clientId = $clientId;
$ServiceFeeSettings = [
	"ConvenientFeeDebitAbsoluteFee" => 0,
	"ConvenientFeeCreditAbsoluteFee" => 0,
];
$result = $serverCaller->SetClientDefaultServiceFeeSettings($clientId, $ServiceFeeSettings,$sessionToken);
```
### Set client settings
```
$clientId = $clientId;
$clientSettings = [
	"CollectionLimitDaily" => 93849,
	"DepositLimitDaily" => 2994949
];
$result = $serverCaller->SetClientSettings($clientId, $clientSettings,$sessionToken);
```
### Get client settings

```
$clientId = $clientId;
$result = $serverCaller->GetClientSettings($clientId,$sessionToken);
```
