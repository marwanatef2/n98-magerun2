<?php
/*
 * this file is part of magerun
 *
 * @author Tom Klingenberg <https://github.com/ktomk>
 */

namespace Robusta\Magento\Application;

use Robusta\Magento\Command\TestCase;

/**
 * Class ConfigFileTest
 *
 * @covers  Robusta\Magento\Application\ConfigFile
 * @package Robusta\Magento\Application
 */
class ConfigFileTest extends TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $configFile = new ConfigFile();
        $this->assertInstanceOf('\Robusta\Magento\Application\ConfigFile', $configFile);

        $configFile = ConfigFile::createFromFile(__FILE__);
        $this->assertInstanceOf('\Robusta\Magento\Application\ConfigFile', $configFile);
    }

    /**
     * @test
     */
    public function applyVariables()
    {
        $configFile = new ConfigFile();
        $configFile->loadFile('data://,- %root%');
        $configFile->applyVariables("root-folder");

        $this->assertSame(['root-folder'], $configFile->toArray());
    }

    /**
     * @test
     */
    public function mergeArray()
    {
        $configFile = new ConfigFile();
        $configFile->loadFile('data://,- bar');
        $result = $configFile->mergeArray(['foo']);

        $this->assertSame(['foo', 'bar'], $result);
    }

    /**
     * @test
     */
    public function parseEmptyFile()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectDeprecationMessage("Failed to parse config-file 'data://,'");
        $configFile = new ConfigFile();
        $configFile->loadFile('data://,');
        $this->addToAssertionCount(1);
        $configFile->toArray();
        $this->fail('An expected exception has not been thrown.');
    }

    /**
     * @test
     */
    public function invalidFileThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        @ConfigFile::createFromFile(":");
    }
}
