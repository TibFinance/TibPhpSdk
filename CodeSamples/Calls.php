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
$sessionToken = "33043b6b-6b1f-4e5b-b8dc-1db229c93b1f";

if (isset($_COOKIE["SessionIdToken"])) {
    $sessionToken = $_COOKIE["SessionIdToken"];
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
            if ($responseObj->Messages == "Need an authenticated user to perform this action") {
                header('location: ./Calls.php?action=CreateSession');
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
        if (!$result->HasError) {
            setcookie("SessionIdToken", $result->SessionId);
            header("location: ./");
        }
        break;
    case "CreateCustomer":
        $customerName = "Customer 200";
        $customerExternalId = "C132-344";
        $language = 1;
        $customerDescription = "Customer created from new PHP SDK";
        $customerEmail = "customerEmail@examle.com";

        $result = $serverCaller->createCustomer($customerName, $customerExternalId, $language, $customerEmail, $customerDescription, $serviceId, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListCustomers":
        $result = $serverCaller->listCustomers($serviceId, $sessionToken);
        ResponseHandler($result);
        break;

    case "GetCustomer":
        $customerId = "90cb97a3-6ff1-4df7-8cfe-e4525a12e529";

        $result = $serverCaller->getCustomer($customerId, $sessionToken);
        ResponseHandler($result);
        break;

    case "GetCustomersByExternalId":
        $customerExternalId = "C132-344";

        $result = $serverCaller->getCustomersByExternalId($customerExternalId, $sessionToken);
        ResponseHandler($result);
        break;

    case "SaveCustomer":
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";
        $customerName = "Customer 200 Updated";
        $customerExternalId = "c123-55";
        $language = 1;
        $customerDescription = "Customer updated by new PHP SDK";
        $customerEmail = "customerEmail@examle.com";

        $result = $serverCaller->saveCustomer($customerId, $customerName, $customerExternalId, $language, $customerEmail, $customerDescription, $sessionToken);
        ResponseHandler($result);
        break;

    case "DeleteCustomer":
        $customerId = "dc09fbbf-4067-4b21-af09-81707fd227a6";
        $result = $serverCaller->deleteCustomer($customerId, $sessionToken);
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
        $result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $account, $type, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListTransfers":
        
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
        break;
    case "ListTransfersFast":
        
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
        break;
    case "ListTransfersForBillFast":
        $merchantId = ""; 
        $bill = ""; 
        $result = $serverCaller->ListTransfersForBillFast($sessionToken, $merchantId, $billId);
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
        $result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $creditCard, $type, $sessionToken);
        ResponseHandler($result);
        break;
    case "ChangeInteracPaymentMethodQuestionAndAnswer":
        $id = "";
        $question = "new Question";
        $answer = "new answer ";
        $result = $serverCaller->ChangeInteracPaymentMethodQuestionAndAnswer($id, $question, $answer, $sessionToken);
        ResponseHandler($result);
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

        $result = $serverCaller->createDirectAccountPaymentMethod($customerId, $isCustomerAutomaticPaymentMethod, $InteracInformation, $type, $sessionToken);
        ResponseHandler($result);
        break;

    case "getPaymentMethod":
        $paymentId = "5397c23a-e938-47c5-94f8-c2d821959ec5";

        $result = $serverCaller->getPaymentMethod($paymentId, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListPaymentMethods":
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";

        $result = $serverCaller->listPaymentMethods($customerId, $sessionToken);
        ResponseHandler($result);
        break;

    case "SetDefaultPaymentMethod":
        $paymentMethodId = "5397c23a-e938-47c5-94f8-c2d821959ec5";
        $customerId = "bf199033-53a1-48cd-8f17-04254d026ecd";

        $result = $serverCaller->setDefaultPaymentMethod($paymentMethodId, $customerId, $sessionToken);
        ResponseHandler($result);
        break;

    case "DeletePaymentMethod":
        $paymentMethodId = "5397c23a-e938-47c5-94f8-c2d821959ec5";

        $result = $serverCaller->deletePaymentMethod($paymentMethodId, $sessionToken);
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

        $result = $serverCaller->createBill($breakIfMerchantNeverBeenAuthorized, $billData, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListBills":
        $fromDateTime = "2021-02-16T13:45:00.000Z";
        $toDateTime = "2021-05-16T13:45:00.000Z";

        $result = $serverCaller->listBills($merchantId, $fromDateTime, $toDateTime, $sessionToken);
        ResponseHandler($result);
        break;

    case "GetBill":
        $billId = "b2678654-9eec-4a6e-aeaa-8d0893b2a986";

        $result = $serverCaller->getBill($billId, $sessionToken);
        ResponseHandler($result);
        break;

    case "DeleteBill":
        $billId = "0ec1520e-7f5a-4367-8c7d-0d9684f689fe";

        $result = $serverCaller->deleteBill($billId, $sessionToken);
        ResponseHandler($result);
        break;

    case "CreatePayement":

        $billId = "3c7792af-f377-48ba-b3f1-0474f6eab127";
        $setPaymentCustomerFromBill = false;
        $customerEmail = ""; //Set the customer email to send the request by email to the customer. It allows the customer to fill its payment method information by himself. This requires the Payment Flow to be set to Anonymous.
        $paymentInfo = [
            "PaymentFlow" => 1,
            "RelatedCustomerId" => "d215b447-7746-4865-b9fa-78e72a2f5678",
            "DueDate" => "2021-05-10T16:10:19.000Z",
            "PaymentAmount" => 1.22
        ];

        $result = $serverCaller->createPayement($billId, $setPaymentCustomerFromBill, $customerEmail, $paymentInfo, $sessionToken);
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

        $result = $serverCaller->createDirectDeposit($originMerchantId, $destinationAccount, $depositDueDate, $currency, $language, $amount, $referenceNumber, $sessionToken);
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

        $result = $serverCaller->createDirectDeposit($originMerchantId, $interacInformation, $depositDueDate, $currency, $language, $amount, $referenceNumber, $sessionToken);
        ResponseHandler($result);
        break;
    case "CreateTransactionFromRaw":
        $rawAcpFileContent = "";
        $result = $serverCaller->createTransactionFromRaw($merchantId, $rawAcpFileContent, $sessionToken);
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
        $stopSameIdentifications = null; // a nullable boolean

        $result = $serverCaller->createFreeOperation($merchantId, $paymentMethodId, $transferType, $referenceNumber, $amount, $language, $transactionDueDate, $groupId, $transferFrequency, $stopSameIdentifications, $sessionToken);
        ResponseHandler($result);
        break;

    case "DeletePayement":
        $paymentId = "03c415fd-5f64-4678-a388-39facbb2bee1";

        $result = $serverCaller->deletePayment($paymentId, $sessionToken);
        ResponseHandler($result);
        break;

    case "RevertTransfer":
        $transferId = "c9a521d5-60a1-4398-8f6c-7462797d584c";

        $result = $serverCaller->revertTransfer($transferId, $sessionToken);
        ResponseHandler($result);
        break;

    case "GetRecuringTransfers":
        $result = $serverCaller->getRecuringTransfers($serviceId, $sessionToken);
        ResponseHandler($result);
        break;

    case "DeleteRecuringTransfer":
        $recuringTransferId = "89d720f2-78ae-4816-8fda-0099aa867c38";

        $result = $serverCaller->deleteRecuringTransfer($recuringTransferId, $sessionToken);
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

        $result = $serverCaller->listExecutedOperations($fromDate, $toDate, $transferType, $transferGroupId, $onlyWithErrors, $merchantId, $dateType, $sessionToken);
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
        $result = $serverCaller->SetwhiteLabeling($id, $level, $whiteLabelingData, $sessionToken);
        ResponseHandler($result);
        break;
    case "GetWhiteLabeling":
        $id = $clientId;  // entity Id ; 
        $level = 3; // entity level; 
        $result = $serverCaller->GetwhiteLabeling($id, $level, $sessionToken);
        ResponseHandler($result);
        break;
    case "DeleteWhiteLabeling":
        $id = $clientId;  // entity Id ; 
        $level = 3; // entity level; 
        $result = $serverCaller->DeleteWhiteLabelingData($id, $level, $sessionToken);
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
        $result = $serverCaller->UpdateWhiteLabelingData($id, $level, $updateWhiteLabelingData, $sessionToken);
        ResponseHandler($result);
        break;
    case "GetListWhiteLabeling":
        $result = $serverCaller->GetListWhiteLabelingData($sessionToken);
        ResponseHandler($result);
        break;

    case "CreateSubClient":
        $name = "new sub Client";
        $language = 2;
        $result = $serverCaller->CreateSubClient($name, $language, $sessionToken);
        ResponseHandler($result);
        break;
    case "SetClientDefaultServicefeeSettings":
        $clientId = $clientId;
        $ServiceFeeSettings = [
            "ConvenientFeeDebitAbsoluteFee" => 0,
            "ConvenientFeeCreditAbsoluteFee" => 0,
        ];
        $result = $serverCaller->SetClientDefaultServiceFeeSettings($clientId, $ServiceFeeSettings, $sessionToken);
        ResponseHandler($result);
        break;
    case "SetClientSettings":
        $clientId = $clientId;
        $clientSettings = [
            "CollectionLimitDaily" => 93849,
            "DepositLimitDaily" => 2994949
        ];
        $result = $serverCaller->SetClientSettings($clientId, $clientSettings, $sessionToken);
        ResponseHandler($result);
        break;
    case "GetClientSettings":
        $clientId = $clientId;
        $result = $serverCaller->GetClientSettings($clientId, $sessionToken);
        ResponseHandler($result);
        break;
  
    case "MarkPaymentResolved":
        $listOfPayments = [
            "", "" // list of Guid "Payment Ids"
        ];
        $result = $serverCaller->MarkPaymentResolved($listOfPayments, $sessionToken);
        ResponseHandler($result);
        break;


    case "GetMerchantsByExternalId":
        $externalSystemId = ""; // the merchants External Id
        $externalSystemGroupId = ""; // the merchant's External SystemGroup Id
        $result = $serverCaller->GetMerchantsByExternalId($externalSystemId, $externalSystemGroupId, $sessionToken);
        ResponseHandler($result);
        break;

    case "ForcePaymentProcess":
        $paymentId = "";
        $result = $serverCaller->ForcePaymentProcess($paymentId, $sessionToken);
        ResponseHandler($result);
        break;

    case "Login":
        $clientId = "";
        $loginUserRelationsId = "";
        $username = "";
        $password = "";
        $result = $serverCaller->Login($clientId, $loginUserRelationsId, $username, $password);
        break;

    case "GetLoginAccessList":
        $clientId = "";
        $username = "";
        $password = "";
        $result = $serverCaller->GetLoginAccessList($clientId, $username, $password, $sessionToken);
        break;

    case "GetDropInPublicToken":
        $clientId = "";
        $billId = "";
        $amount = 12;
        $transferType = 1;
        $dropInAutorizedPaymentMethod = 1;
        $externalReferenceNumber = "";
        $showCustomerExistingPaymentMethods = false; // determins if we should show the customers existing Payment Methods or not.
        $language = 1;
        $expirationDate = "";
        $title = "";
        $description = "";
        $paymentDueDate = "";
        $merchantId = "";
        $result = $serverCaller->GetDropInPublicToken(
            $clientId,
            $bill,
            $amount,
            $transferType,
            $dropInAutorizedPaymentMethod,
            $externalReferenceNumber,
            $showCustomerExistingPaymentMethods,
            $language,
            $expirationDate,
            $title,
            $description,
            $paymentDueDate,
            $merchantId,
            $sessionToken
        );
        ResponseHandler($result);
        break;

    case "AddNewDasProvider":
        $merchantId = "";
        $DasProviderType = 1;
        $DasProviderQuebec = [
            "DasProviderType" => 1,
            "IdentificationNumber" => "",
            "FileType" => 1,
            "FileNumber" => "",
            "DeclarationFrequency" => 1,
            "Description" => ""
        ];
        $DasProviderCanada = [
            "DasProviderType" => 1,
            "BusinessName" => "",
            "BusinessOrAccountNumber" => "",
            "FileType" => 1,
            "FileNumber" => "",
            "DeclarationFrequency" => 1,
            "Description" => ""
        ];

        $result = $serverCaller->AddNewDasProvider($merchantId, $DasProviderType, $DasProviderQuebec, $DasProviderCanada, $sessionToken);
        ResponseHandler($result);
        break;

    case "AddNewDasPayment":
        $merchantId = "";
        $DasProviderId = "";
        $DasPaymentProviderType = 1;
        $DasPaymentQuebec = [
            "PeriodStartDate" => [
                "Day" => 2,
                "Month" => 2,
                "Year" => 2000
            ],
            "PeriodEndDate" => [
                "Day" => 2,
                "Month" => 2,
                "Year" => 2000
            ],
            "WithhodingTax" => 1,
            "RetirementPensionPlan" => 405,
            "HealthServiceFund" => 1,
            "ParentalInsurancePlan" => 405,
            "CNESST" => 1
        ];
        $DasPaymentCanada = [
            "PeriodEndDate" => [
                "Month" => 2,
                "Year" => 200,
            ],
            "LastPayPeriodEmployeeCount" => 1,
            "PeriodRawRemuneration" => 1,
            "PaymentAmount" => 0
        ];

        $result = $serverCaller->AddNewDasPayment($merchantId, $DasProviderId, $DasPaymentProviderType, $DasPaymentCanada, $DasPaymentQuebec, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListDasProviders":
        $merchantId = "";
        $result = $serverCaller->ListDasProviders($merchantId, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListDasPayments":
        $merchantId = "";
        $DasProviderId = "";
        $result = $serverCaller->ListDasPayments($merchantId, $DasProviderId, $sessionToken);
        ResponseHandler($result);
        break;
    case "ListServices":
        $merchantId = "";
        $result = $serverCaller->ListServices($merchantId, $sessionToken);
        ResponseHandler($result);
        break;
    case "GetService":
        $serviceId = "";
        $result = $serverCaller->GetService($serviceId, $sessionToken);
        break;
    case "CreatePayment":
        $billId = "";
        $setPaymentCustomerFromBill = false;
        $customerEmail = ""; // required when the ppaymentFlow is set to anonymous.
        $paymentInfo = [
            "PaymentFlow" => 1,
            "Language" => 1, // Nullable
            "RelatedCustomerId" => "", //nullable
            "DueDate" => "", // nullable
            "TransferFrequency" => 1,
            "PaymentAmount" => 12, // nullable
            "ForcedCustomerPaymentMethodId" => "", //nullable
            "GroupId" => "",
            "ExternalReferenceIdentification" => "",
            "AutorizedPaymentMethod" => 1, // nullable
            "AskForCustomerConsent" => "",
        ];
        $externalReferenceId = "";
        $askForConsent = false;
        $safetyToBreakIfOverRemainingBillAmount = false;
        $authorizedPaymentMethod = 1;
        $doNoteSendemail = false;
        $statementDescription = "";
        $result = $serverCaller->CreatePayment(
            $billId,
            $setPaymentCustomerFromBill,
            $customerEmail,
            $paymentInfo,
            $externalReferenceId,
            $askForConsent,
            $safetyToBreakIfOverRemainingBillAmount,
            $authorizedPaymentMethod,
            $doNoteSendemail,
            $statementDescription,
            $sessionToken
        );
        ResponseHandler($result);
        break;

    case "CreateMerchant":
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
        break;

    case "SaveMerchant":
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
        ResponseHandler($result);
        break;

    case "SaveMerchantAccountInfo":
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
        ResponseHandler($result);
        break;

    case "SaveMerchantBasicInfo":
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
        ResponseHandler($result);
        break;

    case "DeleteMerchant":
        $merchantId = "";
        $result = $serverCaller->DeleteMerchant($merchantId, $sessionToken);
        ResponseHandler($result);
        break;

    case "GetMerchant":
        $merchantId = "";
        $result = $serverCaller->GetMerchant($merchantId, $sessionToken);
        ResponseHandler($result);
        break;

    case "ListMerchants":
        $serviceId = "";
        $result = $serverCaller->ListMerchants($serviceId, $sessionToken);
        ResponseHandler($result);
        break;

    case "":
        ResponseHandler("Error => Please, add an action param in http request");
        break;
}
