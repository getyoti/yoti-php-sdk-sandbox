<?php

namespace Yoti\Demo\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Symfony\Component\Dotenv\Dotenv;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendationBuilder;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheckBuilder;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheckBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxResponseConfigBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder;
use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskBuilder;
use Yoti\Sandbox\DocScan\SandboxClient;

class FeatureContext extends RawMinkContext
{
    /**
     * @var SandboxClient
     */
    private $sandboxClient;

    /**
     * @var array
     */
    private $settings;

    /**
     * @BeforeSuite
     */
    public static function prepare(BeforeSuiteScope $scope)
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../.env');
    }

    /**
     * Initializes context.
     */
    public function __construct($settings)
    {
        $this->sandboxClient = new SandboxClient(
            $_ENV['YOTI_SANDBOX_CLIENT_SDK_ID'],
            $_ENV['YOTI_KEY_FILE_PATH']
        );

        $this->settings = $settings;
    }

    /**
     * @BeforeScenario
     */
    public function setTimeouts()
    {
        if (isset($this->settings['timeouts'])) {
            $this->getSession()->getDriver()->setTimeouts($this->settings['timeouts']);
        }
    }

    /**
     * @Given I configure the session response
     */
    public function iConfigureTheSessionResponse()
    {
        $iframeUrl = $this->getSession()->getPage()->find('css', 'iframe')->getAttribute('src');
        parse_str(parse_url($iframeUrl, PHP_URL_QUERY), $queryParams);
        $sessionId = $queryParams['sessionID'];

        $responseConfig = (new SandboxResponseConfigBuilder())
            ->withCheckReports(
                (new SandboxCheckReportsBuilder())
                    ->withAsyncReportDelay(5)
                    ->withDocumentAuthenticityCheck(
                        (new SandboxDocumentAuthenticityCheckBuilder())
                            ->withBreakdown(
                                (new SandboxBreakdownBuilder())
                                    ->withSubCheck('security_features')
                                    ->withResult('NOT_AVAILABLE')
                                    ->withDetail('some_detail', 'some_detail_value')
                                    ->build()
                            )
                            ->withRecommendation(
                                (new SandboxRecommendationBuilder())
                                    ->withValue('NOT_AVAILABLE')
                                    ->withReason('PICTURE_TOO_DARK')
                                    ->withRecoverySuggestion('BETTER_LIGHTING')
                                    ->build()
                            )
                            ->build()
                    )
                    ->withDocumentTextDataCheck(
                        (new SandboxDocumentTextDataCheckBuilder())
                            ->withBreakdown(
                                (new SandboxBreakdownBuilder())
                                    ->withSubCheck('document_in_date')
                                    ->withResult('PASS')
                                    ->build()
                            )
                            ->withRecommendation(
                                (new SandboxRecommendationBuilder())
                                    ->withValue('APPROVE')
                                    ->build()
                            )
                            ->withDocumentFields([
                                'full_name' => 'John Doe',
                                'nationality' => 'GBR',
                                'date_of_birth' => '1986-06-01',
                                'document_number' => '123456789',
                            ])
                            ->build()
                    )
                    ->build()
            )
            ->withTaskResults(
                (new SandboxTaskResultsBuilder())
                    ->withDocumentTextDataExtractionTask(
                        (new SandboxDocumentTextDataExtractionTaskBuilder())
                            ->withDocumentFields([
                                'full_name' => 'John Doe',
                                'nationality' => 'GBR',
                                'date_of_birth' => '1986-06-01',
                                'document_number' => '123456789',
                            ])
                            ->build()
                    )
                    ->build()
            )
            ->build();

        $this->sandboxClient->configureSessionResponse($sessionId, $responseConfig);
    }

    /**
     * @Given I switch to the iframe
     */
    public function iSwitchToTheIframe()
    {
        $this->getSession()->getDriver()->switchToIFrame(0);
    }

    /**
     * @param string $selector
     */
    private function clickOn($selector)
    {
        $this->getSession()->getPage()->find('css', $selector)->click();
    }

    /**
     * @Given I choose :value
     */
    public function iChoose($value)
    {
        $this->clickOn("input[value='{$value}']");
    }

    /**
     * @Given I click on add photo button
     */
    public function iClickOnAddPhotoButton()
    {
        $this->clickOn("*[data-qa='addPhotoButton']");
    }

    /**
     * @Given I upload a document
     */
    public function iUploadADocument()
    {
        $element = $this->getSession()->getPage()->find('css', "input[data-qa='change-photo']");
        $element->attachFile($this->settings['image_path']);
    }

    /**
     * @Given I click on finish button
     */
    public function iClickOnFinishButton()
    {
        $this->clickOn("*[data-qa='finish-button']");
    }

    /**
     * @Given I wait :seconds seconds
     */
    public function iWaitSeconds($seconds)
    {
        sleep($seconds);
    }

    /**
     * @param string $selector
     * @param string $text
     */
    private function assertElementContains($selector, $text)
    {
        $this->assertSession()->elementContains('css', $selector, $text);
    }

    /**
     * @Then the authenticity check breakdown sub check should be :subCheck
     */
    public function theAuthenticityCheckBreakdownSubCheckShouldBe($subCheck)
    {
        $this->assertElementContains("*[data-qa='authenticity-checks'] *[data-qa='sub-check']", $subCheck);
    }

    /**
     * @Then the authenticity check breakdown result should be :result
     */
    public function theAuthenticityCheckBreakdownResultShouldBe($result)
    {
        $this->assertElementContains("*[data-qa='authenticity-checks'] *[data-qa='result']", $result);
    }

    /**
     * @Then the text data check breakdown sub check should be :subCheck
     */
    public function theTextDataCheckBreakdownSubCheckShouldBe($subCheck)
    {
        $this->assertElementContains("*[data-qa='text-data-checks'] *[data-qa='sub-check']", $subCheck);
    }

    /**
     * @Then the text data check breakdown result should be :result
     */
    public function theTextDataCheckBreakdownResultShouldBe($result)
    {
        $this->assertElementContains("*[data-qa='text-data-checks'] *[data-qa='result']", $result);
    }
}
