
# Tib PHP SDK 

This is a technical document on how to use the Tib php SDK.

## Overview 

here you'll find CodeSample to how to use the Tib Php SDk 

## Set Up 
` Before you using the SDK you need to set the api url up and get a session id. `

Initiat the Server Caller Class  

``` $serverCaller = new ServerCaller(); ```

Then set the api Url 

``` $serverCaller->setUrl("theApiUrl") ```  

Then Create a session

``` $serverCaller->CreateSession($ClientId, $userName, $password) ```

You will need to create a session in order for you to start making calls to the Api 

The ``` $serverCaller->CreateSession(...) ``` method return an object containing the SessionId that needs to be passed with each Call.

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
We ca have as many ways to handle the response here be now we will focus on how to handle errors here 
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
                // Do something in the Call of a Successfull operation.
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
                    header('location: ./Calls.php?action=CreateCustomer');
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
 
