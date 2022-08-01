<?php

namespace Robusta\Magento\Command\Developer;

use Robusta\Magento\Command\TestCase;

class TemplateHintsCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            [
                'command' => 'dev:template-hints',
                '--on'    => true,
                'store'   => 'admin',
            ],
            'Template Hints enabled'
        );

        $this->assertDisplayContains(
            [
                'command' => 'dev:template-hints',
                '--off'   => true,
                'store'   => 'admin',
            ],
            'Template Hints disabled'
        );
    }
}
