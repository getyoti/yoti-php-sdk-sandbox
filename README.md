# Yoti PHP Sandbox SDK

[![Unit Tests](https://github.com/getyoti/yoti-php-sdk-sandbox/actions/workflows/tests.yaml/badge.svg)](https://github.com/getyoti/yoti-php-sdk-sandbox/actions/workflows/tests.yaml)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=getyoti%3Aphp-sandbox&metric=coverage)](https://sonarcloud.io/dashboard?id=getyoti%3Aphp-sandbox)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=getyoti%3Aphp-sandbox&metric=bugs)](https://sonarcloud.io/dashboard?id=getyoti%3Aphp-sandbox)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=getyoti%3Aphp-sandbox&metric=code_smells)](https://sonarcloud.io/dashboard?id=getyoti%3Aphp-sandbox)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=getyoti%3Aphp-sandbox&metric=vulnerabilities)](https://sonarcloud.io/dashboard?id=getyoti%3Aphp-sandbox)

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
