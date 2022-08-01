<?php

namespace Robusta\Magento\Command\Integration;

use Robusta\Magento\Command\TestCase;

/**
 * Class ListCommandTest
 * @package Robusta\Magento\Command\Script\Repository
 */
class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayContains('integration:list', 'email');
        $this->assertDisplayContains('integration:list', 'endpoint');
    }
}
