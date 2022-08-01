<?php

namespace Robusta\Magento\Command;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            'list',
            sprintf('robusta-magerun2 %s by netz98 GmbH', $this->getApplication()->getVersion())
        );
    }
}
