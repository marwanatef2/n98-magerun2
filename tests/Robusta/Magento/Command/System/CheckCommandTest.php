<?php

namespace Robusta\Magento\Command\System;

use Robusta\Magento\Command\TestCase;

class CheckCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('sys:check', 'SETTINGS');
        $this->assertDisplayContains('sys:check', 'FILESYSTEM');
        $this->assertDisplayContains('sys:check', 'PHP');
        $this->assertDisplayContains('sys:check', 'MYSQL');
    }
}
