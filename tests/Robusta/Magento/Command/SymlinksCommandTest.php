<?php

namespace Robusta\Magento\Command\Developer;

use Robusta\Magento\Command\TestCase;

class SymlinksCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            [
                'command'  => 'dev:symlinks',
                '--global' => true,
                '--on'     => true,
            ],
            'Symlinks allowed'
        );

        $this->assertDisplayContains(
            [
                'command'  => 'dev:symlinks',
                '--global' => true,
                '--off'    => true,
            ],
            'Symlinks denied'
        );
    }
}
