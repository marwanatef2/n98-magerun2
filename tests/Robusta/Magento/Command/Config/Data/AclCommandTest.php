<?php

namespace Robusta\Magento\Command\Config\Data;

use Robusta\Magento\Command\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class AclCommandTest extends TestCase
{
    /**
     * @test
     * @outputBuffering off
     */
    public function itShouldLoadGlobalConfig()
    {
        $command = $this->getApplication()->find('config:data:acl');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command' => 'config:data:acl',
            ]
        );

        $this->assertStringContainsString('All Stores', $commandTester->getDisplay());
        $this->assertStringContainsString('Magento_Reports::salesroot_sales', $commandTester->getDisplay());
    }
}
