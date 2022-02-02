# Demo

After You're done wwith the Set up where you initialized the Api Url, you would want to try if our Api Works.

This demo is going to walk you though how to create a payment step by step 

By the end of this demo you'll have an understanding of what are `customer`, `Merchant`, `different payment Methods`, `Bills` ...


## Get the session token

First and foremost you'll need to have a session token to be able to make calls to the api via the sdk

*The client ID is required for the session creation call. This identification is provided by TIB during the account opening*
```
	$ClientId = ""; // the Client Id. 
	$userName = ""; // a user name
	$password = ""; /: a password

	$serverCaller->CreateSession($ClientId, $userName, $password) 
```
*'response.SessionId' is required in every SDK method*

## Create merchant account

By default when Opening the Client Account TibFinance Created a primary merchant Account .

But you Can Create a merchant account with the Api, first understand that the Merchant Account has 2 concepts: **Basic Information** and **Account Information**:

The Following Code Show the MerchantModel object

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

```

*NOTE The MerchantModel inherits from MerchantModelBasicInfo so the MerchantModel includes both concepts.*

After filling out the correct information for the merchant creationg you'll need to pass the object to the CreateMerchant Method :

```
$result = $serverCaller->CreateMerchant($merchantInfo, $sessionToken, $serviceId);
```
*Save the merchant Id to use it Later when creating bills*
 

## Create Customer

Customers are the clients of the merchants. They are the one the merchant collect money from, or the one the merchant deposit money to.

The customer is only a container object that identify the entity of a person. This object will then have payment methods attached to it for the account information. The customer ID needs to be used when transmitting payment on the API.


The Following Code Shows the Customer information 
```
$customerName = "Customer 200";
$customerExternalId = "C132-344";
$language = 1;
$customerDescription = "Customer created from new PHP SDK";

```

This code is the args to create a customer
```
$result = $serverCaller->createCustomer($customerName, $customerExternalId, $language, $customerDescription, $serviceId, $sessionToken);
```

## Creating Payment Methods

The payment methods are financial accounts Link it to a customer. A customer can have multiple payment methods. All payment methods have a unique identifier.

This section Explains how to create a payment method and attache it to a customer with the Api.

Currently the TibFinance Supports 3 payment Method Types:

* Credit card
* Bank account
* Interac 

*NOTE Different than the .net SDK qnd the .net core SDK where each payment method creation had it's own signature*
*here all the payment methods are created using the same Method name the key difference here is `$type` variable*
*the `$type` variable can have only one of the 3 values which are the 3 different payment methods suported by Tib Api*
```
$types = [
	"Account" => "Account", 
	"CreditCard" => "CreditCard", 
	"Interac" => "InteracInformation"
];
        
```
#### Credit card

Credit card payment method allow the merchant to collect money from the customer’s credit card.

*NOTE The credit card payment method cannot be used during deposit.*

The Following code is the Arguments for creating Create Credit Card Payment method and the call that Creates the Credit Card paymemnt Method.
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

#### Bank account

Bank account payment method type allow to perform direct deposit and process pre-authorised payment.

The Following code Displays the Arguments to create a BankAccount Payment Method.
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
#### Interac

This payment method type allows to use Interac to collect or deposit money to a customer account.

The following  code displays the Arguments to Create an Interac Payment Method. and the Call to the Api.
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

## Bills and payments.
To begin proccessing payments with the Api you need first to create a bill.

#### Create a bill 
When creating a bill, it will return the created bill ID for further operation on the bill. Save that Id For Further operations on that bill.

*NOTE that the Merchant needs to be authorized to Use the Id to create a bill for.*

The following code displays the information needed for a bill Entitty
```
$breakIfMerchantNeverBeenAuthorized = true;
$billData = [
	"MerchantId" => "",
	"BillTitle" => "",
	"BillDescription" => "",
	"BillAmount" => 1,
	"ExternalSystemBillNumber1" => "",
	"ExternalSystemBillNumber2" => "",
	"ExternalSystemBillNumber3" => "",
	"BillCurrency" => 2,
	"Language" => 1,
	"RelatedCustomerId" => "bf199033-53a1-48cd-8f17-04254d026ecd"
];

$result = $serverCaller->createBill($breakIfMerchantNeverBeenAuthorized, $billData, $sessionToken);
```
*Now that we have the bill we can start creating payments for that bill .*

#### Create Payments 
There is multiple way for the system to process the payment. The most common values used are “Auto select easier” and “Anonymous”. 
The first mode will process the payment using the information provided. 
The second will transmit the payment by email to an unknown customer

The following code show the Arguments needed for Creating a payment

*In this Example We are working with Annonymous Payment*
```
$billId = "3c7792af-f377-48ba-b3f1-0474f6eab127"; // the bill you wanna create the paymemnt for.
$setPaymentCustomerFromBill = false;
$customerEmail = "example@example.ca"; //Set the customer email to send the request by email to the customer. It allows the customer to fill its payment method information by himself. This requires the Payment Flow to be set to Anonymous.
        
$paymentInfo = [
	"PaymentFlow" => 1,
	"RelatedCustomerId" => "", // this field becomes optional when using the anounymous payment flow 
	"DueDate" => "2021-05-10T16:10:19.000Z",
	"PaymentAmount" => 1.22
];

$result = $serverCaller->createPayement($billId, $setPaymentCustomerFromBill,$customerEmail, $paymentInfo,$sessionToken);
```
> PaymentFlow.AnonymousNeedCustomerEmailPropertySet Makes the CustomerEmail Required

By this you now have created a payment for a bill.