<?php

namespace Robusta\Magento\Command\System\Store;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('sys:store:list', 'id');
        $this->assertDisplayContains('sys:store:list', 'code');
    }
}
