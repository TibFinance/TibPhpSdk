<?php
require("../TibFinanceIntSDK_V2.0.1/vendor/autoload.php");
require("../TibFinanceIntSDK_V2.0.1/src/ServerCaller.php");

use TibFinanceSDK\ServerCaller;


$serverCaller = new ServerCaller();
$serverCaller->SetUrl("http://sandboxportal.tib.finance");

$userName = "sdkdev";
$password = "Test123!";
$clientId = "4671a4c9-4367-4934-bb23-a8886cebd028";
$serviceId = "038D7171-BF23-4F3C-9E78-CF6342624FC7";
$merchantId = "EA34F2C6-36B2-4513-973E-A2C91E7985D3";
$sesstionToken = "33043b6b-6b1f-4e5b-b8dc-1db229c93b1f";

if(isset($_COOKIE["SessionIdToken"])){
    $sesstionToken = $_COOKIE["SessionIdToken"];
}
function var_dump_pre($mixed = null)
{
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
    return null;
}

/**
 * this Function is resposible for handeling the return of the Api 
 * since the Api response Follow the Same Object structure 
 * the body of the function can be anything you like depending on how you wanna handle the response.
 */
function ResponseHandler($responseObj)
{
    if (isset($responseObj->HasError)) {
        if ($responseObj->HasError) {
            var_dump_pre($responseObj->Messages);
            if( $responseObj->Messages == "Need an authenticated user to perform this action"){
                header('location: ./Calls.php?action=CreateCustomer');
            }
        } else {
            var_dump_pre($responseObj);
        }
    } else {
        var_dump_pre("..");
    }
}

if (!isset($_GET["action"]) || empty($_GET["action"])) {
    ResponseHandler("Error => Please, add an action param in http request");
    exit;
}

switch ($_GET["action"]) {
    case "CreateSession":
        $result = $serverCaller->CreateSession($clientId, $userName, $password);
        ResponseHandler($result);
        if(!$result->HasError)
        {
            setcookie("SessionIdToken", $result->SessionId);
        }
        break;
    case "CreateCustomer":
        $customerName = "Customer 200";
        $customerExternalId = "C132-344";
        $language = 1;
        $customerDescription = "Customer created from new PHP SDK";

        $result = $serverCaller->createCustomer($customerName, $customerExternalId, $language, $customerDescription, $serviceId, $sesstionToken);
        ResponseHandler($result);
        break;

    case "ListCustomers":
        $result = $serverCaller->listCustomers($serviceId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "GetCustomer":
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";

        $result = $serverCaller->getCustomer($customerId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "GetCustomersByExternalId":
        $customerExternalId = "C132-344";

        $result = $serverCaller->getCustomersByExternalId($customerExternalId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "SaveCustomer":
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
        $customerName = "Customer 200 Updated";
        $customerExternalId = "c123-55";
        $language = 1;
        $customerDescription = "Customer updated by new PHP SDK";

        $result = $serverCaller->saveCustomer($customerId, $customerName, $customerExternalId, $language, $customerDescription,$sesstionToken);
        ResponseHandler($result);
        break;

    case "DeleteCustomer":
        $customerId = "dc09fbbf-4067-4b21-af09-81707fd227a6";
        $result = $serverCaller->deleteCustomer($customerId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateDirectAccountPaymentMethod":
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
        $result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $account, $type,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateCreditCardPaymentMethod":
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
        $result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $creditCard, $type,$sesstionToken);
        ResponseHandler($result);
        break;
    case "ChangeInteracPaymentMethodQuestionAndAnswer":
        $id = "";
        $question = "new Question";
        $answer = "new answer ";
        $result = $serverCaller->ChangeInteracPaymentMethodQuestionAndAnswer($id, $question, $answer,$sesstionToken);
        ResponseHandler($result);
        break;
        break;
    case "CreateInteracPaymentMethod":
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

        $result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $InteracInformation, $type,$sesstionToken);
        ResponseHandler($result);
        break;

    case "getPaymentMethod":
        $paymentId = "5397c23a-e938-47c5-94f8-c2d821959ec5";

        $result = $serverCaller->getPaymentMethod($paymentId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "ListPaymentMethods":
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";

        $result = $serverCaller->listPaymentMethods($customerId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "SetDefaultPaymentMethod":
        $paymentMethodId = "5397c23a-e938-47c5-94f8-c2d821959ec5";
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";

        $result = $serverCaller->setDefaultPaymentMethod($paymentMethodId, $customerId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "DeletePaymentMethod":
        $paymentMethodId = "5397c23a-e938-47c5-94f8-c2d821959ec5";

        $result = $serverCaller->deletePaymentMethod($paymentMethodId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateBill":
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

        $result = $serverCaller->createBill($breakIfMerchantNeverBeenAuthorized, $billData,$sesstionToken);
        ResponseHandler($result);
        break;

    case "ListBills":
        $fromDateTime = "2021-02-16T13:45:00.000Z";
        $toDateTime = "2021-05-16T13:45:00.000Z";

        $result = $serverCaller->listBills($merchantId, $fromDateTime, $toDateTime,$sesstionToken);
        ResponseHandler($result);
        break;

    case "GetBill":
        $billId = "b2678654-9eec-4a6e-aeaa-8d0893b2a986";

        $result = $serverCaller->getBill($billId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "DeleteBill":
        $billId = "0ec1520e-7f5a-4367-8c7d-0d9684f689fe";

        $result = $serverCaller->deleteBill($billId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreatePayement":
        $billId = "3c7792af-f377-48ba-b3f1-0474f6eab127";
        $setPaymentCustomerFromBill = false;
        $paymentInfo = [
            "PaymentFlow" => 6,
            "RelatedCustomerId" => "d215b447-7746-4865-b9fa-78e72a2f5678",
            "DueDate" => "2021-05-10T16:10:19.000Z",
            "PaymentAmount" => 1.22
        ];

        $result = $serverCaller->createPayement($billId, $setPaymentCustomerFromBill, $paymentInfo,$sesstionToken,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateDirectDeposit":
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

        $result = $serverCaller->createDirectDeposit($originMerchantId, $destinationAccount, $depositDueDate, $currency, $language, $amount, $referenceNumber,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateDirectInteracTransaction":
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

        $result = $serverCaller->createDirectDeposit($originMerchantId, $interacInformation, $depositDueDate, $currency, $language, $amount, $referenceNumber,$sesstionToken);
        ResponseHandler($result);
        break;
    case "CreateTransactionFromRaw":
        $rawAcpFileContent = "";
        $result = $serverCaller->createTransactionFromRaw($merchantId, $rawAcpFileContent,$sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateFreeOperation":
        $paymentMethodId = "03c415fd-5f64-4678-a388-39facbb2bee1";
        $transferType = 1;
        $referenceNumber = "C123-01312";
        $amount = 1.22;
        $language = 1;
        $transactionDueDate = "2021-05-12T16:10:19.000Z";
        $groupId = "HT123123";
        $transferFrequency = 0;

        $result = $serverCaller->createFreeOperation($merchantId, $paymentMethodId, $transferType, $referenceNumber, $amount, $language, $transactionDueDate, $groupId, $transferFrequency,$sesstionToken);
        ResponseHandler($result);
        break;

    case "DeletePayement":
        $paymentId = "03c415fd-5f64-4678-a388-39facbb2bee1";

        $result = $serverCaller->deletePayment($paymentId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "RevertTransfer":
        $transferId = "c9a521d5-60a1-4398-8f6c-7462797d584c";

        $result = $serverCaller->revertTransfer($transferId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "GetRecuringTransfers":
        $result = $serverCaller->getRecuringTransfers($serviceId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "DeleteRecuringTransfer":
        $recuringTransferId = "89d720f2-78ae-4816-8fda-0099aa867c38";

        $result = $serverCaller->deleteRecuringTransfer($recuringTransferId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "ListExecutedOperations":
        $fromDate = "";
        $toDate = "";
        $transferType = "";
        $transferGroupId = "";
        $onlyWithErrors = "";
        $merchantId = "";
        $dateType = "";

        $result = $serverCaller->listExecutedOperations($fromDate, $toDate, $transferType, $transferGroupId, $onlyWithErrors, $merchantId, $dateType, $sesstionToken);
        ResponseHandler($result);
        break;

    case "SetWhiteLabeling":
        $id = $clientId;  // entity Id ; 
        $level = 3; // entity level; 
        $whiteLabelingData = [
            [
                "CssPropery" => "background-color",
                "CssValue" => "black"
            ],
            [
                "CssPropery" => "button-color",
                "CssValue" => "red"
            ],
        ];
        $result = $serverCaller->SetwhiteLabeling($id, $level, $whiteLabelingData,$sesstionToken);
        ResponseHandler($result);
        break;
    case "GetWhiteLabeling":
        $id = $clientId;  // entity Id ; 
        $level = 3; // entity level; 
        $result = $serverCaller->GetwhiteLabeling($id, $level,$sesstionToken);
        ResponseHandler($result);
        break;
    case "DeleteWhiteLabeling":
        $id = $clientId;  // entity Id ; 
        $level = 3; // entity level; 
        $result = $serverCaller->DeleteWhiteLabelingData($id, $level,$sesstionToken);
        ResponseHandler($result);
        break;
    case "UpdateWhiteLabeling":
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
        $result = $serverCaller->UpdateWhiteLabelingData($id, $level, $updateWhiteLabelingData,$sesstionToken);
        ResponseHandler($result);
        break;
    case "GetListWhiteLabeling":
        $result = $serverCaller->GetListWhiteLabelingData($sesstionToken);
        ResponseHandler($result);
        break;

    case "CreateSubClient":
        $name = "new sub Client";
        $language = 2;
        $result = $serverCaller->CreateSubClient($name, $language,$sesstionToken);
        ResponseHandler($result);
        break;
    case "SetClientDefaultServicefeeSettings":
        $clientId = $clientId;
        $ServiceFeeSettings = [
            "ConvenientFeeDebitAbsoluteFee" => 0,
            "ConvenientFeeCreditAbsoluteFee" => 0,
        ];
        $result = $serverCaller->SetClientDefaultServiceFeeSettings($clientId, $ServiceFeeSettings,$sesstionToken);
        ResponseHandler($result);
        break;
    case "SetClientSettings":
        $clientId = $clientId;
        $clientSettings = [
            "CollectionLimitDaily" => 93849,
            "DepositLimitDaily" => 2994949
        ];
        $result = $serverCaller->SetClientSettings($clientId, $clientSettings,$sesstionToken);
        ResponseHandler($result);
        break;
    case "GetClientSettings":
        $clientId = $clientId;
        $result = $serverCaller->GetClientSettings($clientId,$sesstionToken);
        ResponseHandler($result);
        break;

    case "":
        ResponseHandler("Error => Please, add an action param in http request");
}
