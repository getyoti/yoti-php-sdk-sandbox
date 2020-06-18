<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * Override assertMatchesRegularExpression to support older versions of PHPUnit.
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     *
     * @return void
     */
    public static function assertMatchesRegularExpression(string $pattern, string $string, string $message = ''): void
    {
        if (method_exists(parent::class, __FUNCTION__)) {
            parent::{__FUNCTION__}(...\func_get_args());
        } else {
            parent::assertRegExp(...\func_get_args());
        }
    }
}
