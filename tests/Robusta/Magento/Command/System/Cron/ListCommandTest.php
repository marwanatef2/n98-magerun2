<?php

namespace Robusta\Magento\Command\System\Cron;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('sys:cron:list', 'Cronjob List');
    }
}
