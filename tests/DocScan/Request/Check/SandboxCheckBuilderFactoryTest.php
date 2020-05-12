<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\Check\SandboxCheckBuilderFactory;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheckBuilder;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentFaceMatchCheckBuilder;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheckBuilder;
use Yoti\Sandbox\DocScan\Request\Check\SandboxZoomLivenessCheckBuilder;
use Yoti\Sandbox\Test\TestCase;

class SandboxCheckBuilderFactoryTest extends TestCase
{

    /**
     * @var SandboxCheckBuilderFactory
     */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new SandboxCheckBuilderFactory();
    }

    /**
     * @test
     */
    public function shouldReturnDocumentAuthenticityCheckBuilder()
    {
        $this->assertInstanceOf(
            SandboxDocumentAuthenticityCheckBuilder::class,
            $this->factory->createDocumentAuthenticityCheckBuilder()
        );
    }

    /**
     * @test
     */
    public function shouldReturnLivenessCheckBuilder()
    {
        $this->assertInstanceOf(
            SandboxZoomLivenessCheckBuilder::class,
            $this->factory->createZoomLivenessCheckBuilder()
        );
    }

    /**
     * @test
     */
    public function shouldReturnDocumentFaceMatchCheckBuilder()
    {
        $this->assertInstanceOf(
            SandboxDocumentFaceMatchCheckBuilder::class,
            $this->factory->createDocumentFaceMatchCheckBuilder()
        );
    }

    /**
     * @test
     */
    public function shouldReturnDocumentTextDataCheckBuilder()
    {
        $this->assertInstanceOf(
            SandboxDocumentTextDataCheckBuilder::class,
            $this->factory->createDocumentTextDataCheckBuilder()
        );
    }
}
