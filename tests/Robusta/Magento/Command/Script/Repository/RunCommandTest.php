<?php

namespace Robusta\Magento\Command\Script\Repository;

use Robusta\Magento\Command\TestCase;

/**
 * Class RunCommandTest
 * @package Robusta\Magento\Command\Script\Repository
 */
class RunCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = $this->getApplication();
        $config = $application->getConfig();
        $config['script']['folders'][] = __DIR__ . '/_scripts';
        $application->setConfig($config);

        $input = [
            'command' => 'script:repo:run',
            'script'  => 'hello-world',
        ];

        // Runs sys:info -> Check for any output
        $this->assertDisplayContains($input, 'Vendors');
        $this->assertDisplayContains($input, 'Magento');
        $this->assertDisplayContains($input, __DIR__ . '/_scripts/hello-world.magerun');
    }
}
