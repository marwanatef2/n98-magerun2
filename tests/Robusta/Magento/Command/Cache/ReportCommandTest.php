<?php

namespace Robusta\Magento\Command\Cache;

use Robusta\Magento\Command\TestCase;

class ReportCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayRegExp(
            [
                'command' => 'cache:report',
            ],
            '~\\| ID.*\\| EXPIRE.*\\|$~m'
        );
    }
}
