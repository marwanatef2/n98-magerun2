<?php

namespace Robusta\Magento\Command\System\Cron;

use Robusta\Magento\Command\TestCase;

class RunCommandTest extends TestCase
{
    public function testExecute()
    {
        $input = [
            'command' => 'sys:cron:run',
            'job'     => 'backend_clean_cache',
        ];

        $this->assertDisplayContains($input, 'Run Magento\Backend\Cron\CleanCache::execute done');
    }
}
