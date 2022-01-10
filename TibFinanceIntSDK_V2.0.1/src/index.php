<?php

require("TibCrypto.php");

    // Exapmle d'utilisation de SDK
    $methodName = "/Data/CreateCustomer";
    $userName = "sdkdev";
    $password = "Test123!";
    $clientId = "4671a4c9-4367-4934-bb23-a8886cebd028";
    $serviceId = "038d7171-bf23-4f3c-9e78-cf6342624fc7";
    $data = ["CustomerInfo" => [
                "CustomerName" => "Jackie Tester",
                "CustomerExternalId" => "c123-55",
                "Language" => "1",
                "CustomerDescription" => "VIP Customer"
                ]
            ];

    var_dump(TibCrypto::performCall($methodName, $data, $serviceId, $clientId, $userName, $password));
?>