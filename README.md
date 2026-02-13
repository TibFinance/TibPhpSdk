# TIB Finance PHP SDK

![PHP](https://img.shields.io/badge/php-7.4%2B-purple)

PHP SDK for the TIB Finance payment processing API.

## Installation

```bash
git clone https://github.com/TibFinance/TibPhpSdk.git
cd TibPhpSdk
composer install
```

Then include the SDK in your project:

```php
require_once 'path/to/TibFinanceIntSDK_V2.0.1/src/ServerCaller.php';
```

## Quick Start

```php
require_once __DIR__ . '/TibFinanceIntSDK_V2.0.1/src/ServerCaller.php';
use TibFinanceSDK\ServerCaller;

$caller = new ServerCaller();
$caller->SetUrl("https://sandboxportal.tib.finance");

$response = $caller->createSession("your_client_id", "your_username", "your_password");
echo $response['SessionId'];
```

## Documentation

For the complete API reference and guides, visit [doc.tib.finance](https://doc.tib.finance).

This SDK provides access to **56 API methods** for payment processing, merchant management, and financial operations.

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
