# Profile Sandbox Example

General example of how to use the Sandbox in your tests

## Setup

Copy the [.env.example](.env.example) file and rename it to be `.env`, then
  modify the `YOTI_SANDBOX_CLIENT_SDK_ID` and `YOTI_KEY_FILE_PATH` environment variables.

## Profile Token Creation

[ProfileTest](tests/ProfileTest.php) demonstrates how to create a token and retrieve a user profile

Run `composer test` inside this directory
