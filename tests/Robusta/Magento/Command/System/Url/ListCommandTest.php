<?php

namespace Robusta\Magento\Command\System\Url;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $input = [
            'linetemplate'     => 'prefix {url} suffix',
            'command'          => 'sys:url:list',
            'stores'           => 0, // admin store
            '--add-categories' => true,
            '--add-products'   => true,
            '--add-cmspages'   => true,
        ];

        $this->assertDisplayContains($input, 'prefix');
        $this->assertDisplayContains($input, 'http');
        $this->assertDisplayContains($input, 'suffix');
    }
}
