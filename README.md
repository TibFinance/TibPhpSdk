# TIB Finance PHP SDK

![PHP](https://img.shields.io/badge/php-7.4%2B-purple)

PHP SDK for the TIB Finance payment processing API.

## Installation

Install with Composer from the GitHub repository (this package is not published on Packagist):

```bash
composer config repositories.tib-finance vcs https://github.com/TibFinance/TibPhpSdk
composer require tib-finance/tib-finance-sdk:^2.0
```

**Manual installation** (alternative):

```bash
git clone https://github.com/TibFinance/TibPhpSdk.git
cd TibPhpSdk
composer install
```

## Quick Start

```php
require __DIR__ . '/vendor/autoload.php';
use TibFinanceSDK\ServerCaller;

$caller = new ServerCaller();
$caller->SetUrl("https://sandboxportal.tib.finance");

$response = $caller->createSession("your_client_id", "your_username", "your_password");
if ($response->HasError) {
    echo "Session failed: " . $response->Messages;
} else {
    echo $response->SessionId;
}
```

## Two-step sign-in (merchant- or service-level users)

The Quick Start signs in with `$caller->createSession`, which opens a client-level session. A user whose access is limited to a merchant or a service signs in with two calls instead:

1. Call `$caller->getLoginAccessList` with the client ID, username and password. Each entry in `LoginRelations` is one access the user can open: `InternalReferenceType` gives its level (2 client, 4 merchant, 16 service) and `InternalReferenceId` the ID of that client, merchant or service. `Description` is a label for display only.
2. Call `$caller->login` with the same client ID, username and password, and the `LoginsUserRelationsId` of the chosen entry.

Pass the returned `SessionId` as the `$sessionToken` argument of the following calls, as with `$caller->createSession`. Failed sign-in attempts count toward a temporary lockout, so do not retry in a loop.

```php
$accesses = $caller->getLoginAccessList("your_client_id", "your_username", "your_password");
if ($accesses->HasError) {
    echo "Sign-in failed: " . $accesses->Messages;
} else {
    // Each entry is one access: pick the one to open
    // (InternalReferenceType: 2 client, 4 merchant, 16 service).
    $access = $accesses->LoginRelations[0];
    $response = $caller->login("your_client_id", "your_username", "your_password", $access->LoginsUserRelationsId);
    if ($response->HasError) {
        echo "Sign-in failed: " . $response->Messages;
    } else {
        $services = $caller->listServices($response->SessionId);
    }
}
```

## Documentation

For the complete API reference and guides, visit [doc.tib.finance](https://doc.tib.finance).

This SDK provides access to **67 API methods** for payment processing, merchant management, and financial operations.

## Other TIB Finance SDKs

| SDK | Repository |
|-----|------------|
| Python | [TibPythonSdk](https://github.com/TibFinance/TibPythonSdk) |
| Java | [TibJavaSdk](https://github.com/TibFinance/TibJavaSdk) |
| .NET Core | [TibDotNetCoreSdk](https://github.com/TibFinance/TibDotNetCoreSdk) |
| .NET Framework | [TibDotNetSdk](https://github.com/TibFinance/TibDotNetSdk) |
| JavaScript (Browser) | [TibJavascriptSdk](https://github.com/TibFinance/TibJavascriptSdk) |
| Node.js | [TibNodeJsSdk](https://github.com/TibFinance/TibNodeJsSdk) |

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

- Documentation: [doc.tib.finance](https://doc.tib.finance)
- Email: support@tib.finance
