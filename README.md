# Yoti PHP Sandbox SDK

This repository contains the tools you need to test your Yoti integration.

## Installing the Sandbox

Add the Yoti SDK dependency:

```console
$ composer require yoti/yoti-php-sdk-sandbox
```

## Configuration

* `SANDBOX_CLIENT_SDK_ID` is the Sandbox SDK identifier generated from the Sandbox section on Yoti Hub.

* `/path/to/your-pem-file.pem` is the path to the Sandbox PEM file. It can be downloaded from the Sandbox section on Yoti Hub.

Please do not open the PEM file, as this might corrupt the key, and you will need to redownload it.

### Profile

#### Profile Sandbox Client
```php
use Yoti\Sandbox\Profile\SandboxClient;

$sandboxClient = new SandboxClient('SANDBOX_CLIENT_SDK_ID', '/path/to/your-pem-file.pem');
```

#### Yoti Client
```php
use Yoti\YotiClient;

$yotiClient = new YotiClient('SANDBOX_CLIENT_SDK_ID', '/path/to/your-pem-file.pem', [
    'api.url' => 'https://api.yoti.com/sandbox/v1'
]);
```

### Doc Scan

#### Doc Scan Sandbox Client
```php
use Yoti\Sandbox\DocScan\SandboxClient;

$sandboxClient = new SandboxClient('SANDBOX_CLIENT_SDK_ID', '/path/to/your-pem-file.pem');
```

#### Doc Scan Client
```php
use Yoti\DocScan\DocScanClient;

$docScanClient = new DocScanClient('SANDBOX_CLIENT_SDK_ID', '/path/to/your-pem-file.pem', [
    'api.url' => 'https://api.yoti.com/sandbox/idverify/v1'
]);
```

## Examples

- [Profile Sandbox](examples/profile)
- [Doc Scan Sandbox](examples/doc-scan)
