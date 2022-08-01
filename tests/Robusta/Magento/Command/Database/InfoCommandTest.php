<?php

namespace Robusta\Magento\Command\Database;

use Robusta\Magento\Command\TestCase;

class InfoCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('db:info', 'PDO-Connection-String');
    }

    public function testExecuteWithSettingArgument()
    {
        $input = [
            'command' => 'db:info',
            'setting' => 'MySQL-Cli-String',
        ];

        $this->assertDisplayNotContains($input, 'MySQL-Cli-String');
        $this->assertDisplayContains($input, 'mysql -h');
    }
}
