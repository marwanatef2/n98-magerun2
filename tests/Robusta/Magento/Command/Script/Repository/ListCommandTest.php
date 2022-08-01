<?php

namespace Robusta\Magento\Command\Script\Repository;

use Robusta\Magento\Command\TestCase;

/**
 * Class ListCommandTest
 * @package Robusta\Magento\Command\Script\Repository
 */
class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = $this->getApplication();
        $config = $application->getConfig();
        $config['script']['folders'][] = __DIR__ . '/_scripts';
        $application->setConfig($config);

        $this->assertDisplayContains('script:repo:list', 'Cache Flush Command Test (Hello World)');
        $this->assertDisplayContains('script:repo:list', 'Foo command');
        $this->assertDisplayContains('script:repo:list', 'Bar command');
    }
}
