<?php

namespace Robusta\Magento\Command\System\Website;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('sys:website:list', 'Magento Websites');
        $this->assertDisplayContains('sys:website:list', 'id');
        $this->assertDisplayContains('sys:website:list', 'code');
    }
}
