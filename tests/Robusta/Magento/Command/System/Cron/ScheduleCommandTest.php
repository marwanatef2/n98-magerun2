<?php

namespace Robusta\Magento\Command\System\Cron;

use Robusta\Magento\Command\TestCase;

class ScheduleCommandTest extends TestCase
{
    public function testExecute()
    {
        $input = [
            'command' => 'sys:cron:schedule',
            'job'     => 'backend_clean_cache',
        ];
        $this->assertDisplayContains($input, 'Scheduling Magento\Backend\Cron\CleanCache::execute done');
    }
}
