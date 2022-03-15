
# Tib PHP Sdk 

This is a technical document  on how to use the Tib PHP Sdk .

## Content Table  

[Overview](#overview)

[API Objects Overview](#api-objects-overview)

[Environments](#environments)

[The Set Up](#set-up)

[Methods](#methods)

[Handling Response](#handeling-response)

[General Objects and Enumerations.](#general-objects-and-enumerations)

## Overview 
Before you start Using the Sdk you'll need to know some basic concept the We Use and the Different Objects and Whats their role in the app.

### API Objects Overview

To understand how to use the API, you must understand the Different objects of the application. 

For details See the pdf [Documentation](https://tibfinance.github.io/).

## Environments

Calls to the service are done via a WEB service. There are two URLs for the service:
* Production: https://portal.tib.finance    
* Development: http://sandboxportal.tib.finance

## Set Up 
` Before you using the SDK you need to set the api url up and get a session id. `

Initiat the Server Caller Class  

``` $serverCaller = new ServerCaller(); ```

Then set the api Url 

``` $serverCaller->setUrl($siteUrl) ```  


*the `$siteUrl` can be either the Sandbox or the production Envirement (we are using the sandbox version in this code sample)*

Then Create a session

``` $serverCaller->CreateSession($ClientId, $userName, $password) ```

You will need to create a session in order for you to start making calls to the Api 

The ``` $serverCaller->CreateSession(...) ``` method return an object containing the SessionId that needs to be passed with each Call.

See [Demo](./Documentation/Demo.md) for a step by step from how to Create a session to Creating a payment for a bill.

## Methods 

` after you set up the api url and created a session you can start Using the Other Methods of the Sdk `

*here you see one Example but you'll see more Examples of Using the SDK in the Calls.php File*


Ex :

``` 
    $sessionId = "";  
    $customerName = "";
    $customerExternalId = ""; 
    $language = 1; 
    $customerDescription = ""; 

    $result = $serverCaller->createCustomer($customerName, $customerExternalId, $language, $customerDescription,$serviceId);
```
*For More Methods Visit [Methods](./Documentation/methods.md)*

## Handling Response 

Each Api Call Return a response Object that Follow the same Object structure 

Ex : this is the response gotten back from the previous calls
```
object(stdClass)#43 (7) {
    ["CustomerId"]=> "beb13973-5f04-438d-b008-7be7fd2f3765"
    ["CryptedSelf"]=> NULL
    ["IV"]=> NULL
    ["Errors"] => array(0) {}
    ["HasError"]=> bool(false)
    ["Messages"]=> ""
    ["NodeAnswered"]=> "PortalHost1"
}

```
We can have many ways to handle the response, now we will focus on how to handle errors here:
- the most important properties of the object when it comes to Error Handling are :
    * "HasError" which is a boolean that tells you either the response has an error or not 
    * "Errors" which is an array of Errors
    * "Messages" the message that somes with the Response (eeven if no error is presented).

- so basicaly you can do something like : 
```
    function ResponseHandler($responseObejct){
        if(isset($responseObejct->HasError)){
            if($responseObejct->HasError){
                // Do Something in Case of the Response Object HasError returns True 
            }else{
                // Do something in the Case of the Response Object HasError returns false.
            }
        }
    }
```
- This is a real life Example of a session token refresh after the session token Expires;
```
    function ResponseHandler($responseObj)
    {
        if (isset($responseObj->HasError)) {
            if ($responseObj->HasError) {
                var_dump_pre($responseObj->Messages);
                if( $responseObj->Messages == "Need an authenticated user to perform this action" ){
                    header('location: ./Calls.php?action=CreateSession');
                }
            } else {
                var_dump_pre($responseObj);
            }
        } else {
            var_dump_pre("..");
        }
    }
```
this is a way to handle a response , you can choose your own way to handle the response you get. 
just keep in mind that every response contains the said properties 
 
For more details about mothods visit [here](./Documentation/methods.md)

## General Objects and  Enumerations. 
Enum are not natively implemented in Php but since the Api uses Dot net and relies heavely on the enums it's this section on the documentation is basicaly gonna be used to define the Enums to use and the correct index for each Property you will be Using in the future.

Ex :  Address global object 
In .Net it's defined this way:
```
var address = new AddressModel
{
    AddressCity = "some Desc ", // City Name 
    CountryId = CountryIdEnum.USA, // User the CountryIdEnum Enumerations Available under Tib.Api.Model.Enums
    PostalZipCode = "", // the zip Code
    ProvinceStateId = ProvinceStateIdEnum.US_Alabama, // Use the ProvinceStateIdEnum Available under Tib.Api.Model.Enums
    StreetAddress = ""
}
```
but in Php will be defined the following way :
```
$adress = [
    "AddressCity" => "_________", 
    "CountryId" => 1, // CountryIdEnum.USA
    "PostalZipCode" => "_________", 
    "ProvinceStateId" => 58, // ProvinceStateIdEnum.US_Alabama
    "StreetAddress" => "_________"  
]
```

*NOTE all the following Enums and in c#*

### LanguageEnum
```
public enum LanguageEnum
{
    Unkown = -1,
    NotSet = 0,
    French = 1,
    English = 2
}
```

### CurrencyEnum
```
public enum CurrencyEnum
{
    Unkown = -1,
    NotSet = 0,
    CAD = 1,
    USD = 2
}
```

### PaymentMethodTypeEnum
```
public enum PaymentMethodTypeEnum
{
    Unkown = -1,
    NotSet = 0,
    CreditCard = 1,
    DirectAccount = 2,
    Interac = 3
}
```

### AutorizedPaymentMethodFlags
```
public enum AutorizedPaymentMethodFlags
{
    Unkown = -1,
    NotSet = 0,
    CreditCard = 1,
    DirectAccount = 2,
    CreditCardPPA = 4,
    DirectAccountPPA = 8
}
```

### CountryIdEnum
```
public enum CountryIdEnum
{
    Unkown = -1,
    NotSet = 0,
    Canada = 1,
    USA = 2
}
```

### Provinces / States enumeration
To see the full ProvinceStateIdEnum Go [Here](./Documentation/CountryandStateEnum.md)

### TransferDirectionEnum
```
public enum TransferDirectionEnum
{
    Unkown = -1,
    NotSet = 0,
    Collect = 1,
    Deposit = 2
}
```

### TransferTypeEnum
```
public enum TransferTypeEnum
{
    Unkown = -1,
    NotSet = 0,
    Payment = 1,
    FreeDeposit = 2,
    FreeCollection = 3,
    Fee = 4,
    Revert = 5
}
```

### TransferFrequencyEnum
```
public enum TransferFrequencyEnum
{
    Unkown = -1,
    Once = 0,
    Daily = 1,
    Weekly = 2,
    EveryTwoWeeks = 3,
    Monthly = 4,
    Trimester = 5,
    BiAnnually = 6,
    Annually = 7
}
```

### DateTypeEnum
```
public enum DateTypeEnum
{
    Unkown = -1,
    NotSet = 0,
    CreatedDate = 1,
    LastModifiedDate = 2
}
```

### OperationTargetEnum
```
public enum OperationTargetEnum
{
    Unkown = -1,
    NotSet = 0,
    Customer = 1,
    Merchant = 2,
    TibClient = 3,
    Tib = 100
}
```

### OperationTypeEnum
```
public enum OperationTypeEnum
{
    Unkown = -1,
    NotSet = 0,
    Validation = 1,
    Transmission = 2,
    StatusCheck = 3,
    PaybackCheck = 4
}
```

### WhiteLabeling Levels Enum  
```
public enum WhitelabelingLevelsEnum
{
    Default = -1,
    NotSet = 0,
    Merchant = 1,
    Service = 2,
    Client = 3,
}
```


