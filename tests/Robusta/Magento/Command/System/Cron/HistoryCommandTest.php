<?php

namespace Robusta\Magento\Command\System\Cron;

use Robusta\Magento\Command\TestCase;

class HistoryCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('sys:cron:history', 'Last executed jobs');
    }
}
