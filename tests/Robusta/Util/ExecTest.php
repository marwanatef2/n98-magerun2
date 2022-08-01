<?php

namespace Robusta\Util;

use RuntimeException;

/**
 * Class ExecTest
 *
 * @package Robusta\Util
 */
class ExecTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function commandOnly()
    {
        Exec::run('echo test');

        $this->addToAssertionCount(1);
    }

    /**
     * @test
     */
    public function fullParameters()
    {
        Exec::run('echo test', $commandOutput, $returnCode);

        $this->assertEquals(Exec::CODE_CLEAN_EXIT, $returnCode);
        $this->assertStringStartsWith('test', $commandOutput);
    }

    /**
     * @test
     */
    public function exception()
    {
        $this->expectException(RuntimeException::class);
        Exec::run('foobar');
    }
}
