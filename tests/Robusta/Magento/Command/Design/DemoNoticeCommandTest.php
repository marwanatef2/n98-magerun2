<?php

namespace Robusta\Magento\Command\Design;

use Robusta\Magento\Command\TestCase;

class DemoNoticeCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            [
                'command'  => 'design:demo-notice',
                '--global' => true,
                '--on'     => true,
            ],
            'Demo Notice enabled'
        );

        $this->assertDisplayContains(
            [
                'command'  => 'design:demo-notice',
                '--global' => true,
                '--off'    => true,
            ],
            'Demo Notice disabled'
        );
    }
}
