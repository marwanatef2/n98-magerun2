<?php

namespace Robusta\Magento\Command;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Robusta\Magento\Application;
use Robusta\Magento\MagerunCommandTester;
use Robusta\Magento\TestApplication;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class TestCase
 *
 * @codeCoverageIgnore
 * @package Robusta\Magento\Command\PHPUnit
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TestApplication
     */
    private $testApplication;

    /**
     * @var array
     */
    private $testers = [];

    /**
     * getter for the magento root directory of the test-suite
     *
     * @see ApplicationTest::testExecute
     *
     * @return string
     */
    public function getTestMagentoRoot()
    {
        return $this->getTestApplication()->getTestMagentoRoot();
    }

    /**
     * @return Application|MockObject
     * @throws \Exception
     */
    public function getApplication()
    {
        return $this->getTestApplication()->getApplication();
    }

    /**
     * @return AdapterInterface
     */
    public function getDatabaseConnection()
    {
        $resource = $this->getApplication()->getObjectManager()->get(ResourceConnection::class);

        return $resource->getConnection('write');
    }

    /**
     * @return TestApplication
     */
    private function getTestApplication()
    {
        if (null === $this->testApplication) {
            $this->testApplication = new TestApplication();
        }

        return $this->testApplication;
    }

    /**
     * @param string|array $command name or input
     * @return MagerunCommandTester
     */
    private function getMagerunTester($command)
    {
        if (is_string($command)) {
            $input = [
                'command' => $command,
            ];
        } else {
            $input = $command;
        }

        $hash = md5(json_encode($input));
        if (!isset($this->testers[$hash])) {
            $this->testers[$hash] = new MagerunCommandTester($this, $input);
        }

        return $this->testers[$hash];
    }

    /**
     * @param string|array $command actual command to execute and obtain the display (output) from
     * @param string $needle string within the display
     * @param string $message [optional]
     */
    protected function assertDisplayContains($command, $needle, $message = "")
    {
        $display = $this->getMagerunTester($command)->getDisplay();

        $this->assertStringContainsString($needle, $display, $message);
    }

    /**
     * @param string|array $command actual command to execute and obtain the display (output) from
     * @param string $needle string within the display
     * @param string $message [optional]
     */
    protected function assertDisplayNotContains($command, $needle, $message = "")
    {
        $display = $this->getMagerunTester($command)->getDisplay();

        $this->assertStringNotContainsString($needle, $display, $message);
    }

    /**
     * @param string|array $command
     * @param string $pattern
     * @param string $message [optional]
     */
    protected function assertDisplayRegExp($command, $pattern, $message = "")
    {
        $display = $this->getMagerunTester($command)->getDisplay();

        $this->assertMatchesRegularExpression($pattern, $display, $message);
    }

    /**
     * Command executes with a status code of zero
     *
     * @param string|array $command
     * @param string $message
     * @return MagerunCommandTester
     */
    protected function assertExecute($command, $message = "")
    {
        $tester = $this->getMagerunTester($command);
        $status = $tester->getStatus();

        if (strlen($message)) {
            $message .= "\n";
        }

        $message .= "Command executes with a status code of zero";

        $this->assertSame(0, $status, $message);

        return $tester;
    }

    protected function registerCoreCommands()
    {
        $this->getApplication()->registerMagentoCoreCommands(new NullOutput());
    }
}
