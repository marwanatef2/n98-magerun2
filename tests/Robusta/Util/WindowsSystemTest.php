<?php
/*
 * @author Tom Klingenberg <mot@fsfe.org>
 */

namespace Robusta\Util;

/**
 * Class WindowsSystemTest
 *
 * @package Robusta\Util
 * @requires OS WIN32|WINNT
 */
class WindowsSystemTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function isProgramInstalled()
    {
        $this->assertTrue(WindowsSystem::isProgramInstalled("notepad"));

        $this->assertFalse(WindowsSystem::isProgramInstalled("notepad-that-never-made-it-into-windows-kernel"));

        $this->assertFalse(WindowsSystem::isProgramInstalled("invalid\\command*name|thisis"));
    }

    /**
     * @see isExecutableName
     * @return array
     */
    public function provideExecutableNames()
    {
        return [
            ["notepad", false],
            ["notepad.com", true],
            ["notepad.exe", true],
            ["notepad.exe.exe", true],
            ["notepad.eXe", true],
            ["notepad.EXE", true],
            ["notepad.bat", true],
            ["notepad.txt", false],
        ];
    }

    /**
     * @test
     *
     * @param string $name
     * @param bool $expected
     * @dataProvider provideExecutableNames
     */
    public function isExecutableName($name, $expected)
    {
        $this->assertSame($expected, WindowsSystem::isExecutableName($name), $name);
    }
}
