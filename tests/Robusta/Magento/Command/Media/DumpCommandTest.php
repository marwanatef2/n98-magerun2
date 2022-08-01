<?php

namespace Robusta\Magento\Command\Media;

use Robusta\Magento\Command\TestCase;

class DumpCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains(
            'media:dump',
            sprintf('media/theme/preview', $this->getApplication()->getVersion())
        );
    }
}
