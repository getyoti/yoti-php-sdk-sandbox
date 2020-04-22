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

```php
use Yoti\Sandbox\Profile\SandboxClient;
use Yoti\YotiClient;

$sandboxClient = new SandboxClient('SANDBOX_CLIENT_SDK_ID', '/path/to/your-pem-file.pem');

$yotiClient = new YotiClient('SANDBOX_CLIENT_SDK_ID', '/path/to/your-pem-file.pem', [
    'api.url' => 'https://api.yoti.com/sandbox/v1'
]);
```

## Examples

- See [examples/profile](examples/profile) for a general example of how to use the Profile Sandbox in your tests.
