<?php

namespace Robusta\Magento\Command\Admin\Token;

use Robusta\Magento\Command\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CreateCommandTest
 * @package Robusta\Magento\Command\Admin\Token
 */
class CreateCommandTest extends TestCase
{
    public function testExecute()
    {
        $command = $this->getApplication()->find('admin:token:create');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'username'     => 'admin',
            '--no-newline' => true,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertNotEmpty($output);
        $this->assertEquals(32, strlen($output));
    }
}
