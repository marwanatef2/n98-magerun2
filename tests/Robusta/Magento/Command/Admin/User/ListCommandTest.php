<?php

namespace Robusta\Magento\Command\Admin\User;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    /**
     * @group current
     */
    public function testExecute()
    {
        $this->assertDisplayContains('admin:user:list', 'id');
        $this->assertDisplayContains('admin:user:list', 'user');
        $this->assertDisplayContains('admin:user:list', 'email');
        $this->assertDisplayContains('admin:user:list', 'status');
    }
}
