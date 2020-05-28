# Profile Sandbox Example

General example of how to use the Sandbox in your tests.

[ProfileTest](tests/ProfileTest.php) demonstrates how to create a token and retrieve a user profile.

## Setup

Copy the [.env.example](.env.example) file and rename it to be `.env`, then
  modify the `YOTI_SANDBOX_CLIENT_SDK_ID` and `YOTI_KEY_FILE_PATH` environment variables.

## Installing dependencies

1. `docker-compose up composer`

## Running the test

1. `docker-compose up test`

## Stopping services

1. `docker-compose down`
