<?php

namespace Robusta\Util;

class StringTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @param string $string
     * @param string $delimiter
     * @param array  $expected
     * @dataProvider trimExplodeEmptyProvider
     */
    public function trimExplodeEmpty($delimiter, $string, $expected)
    {
        $this->assertEqualsCanonicalizing($expected, BinaryString::trimExplodeEmpty($delimiter, $string));
    }

    /**
     * @return array
     */
    public static function trimExplodeEmptyProvider()
    {
        return [
            [
                ',',
                'Foo,Bar',
                ['Foo', 'Bar'],
            ],
            [
                '#',
                ' Foo# Bar',
                ['Foo', 'Bar'],
            ],
            [
                ',',
                ',,Foo, Bar,,',
                ['Foo', 'Bar'],
            ],
        ];
    }

    /**
     * @test
     */
    public function startsWith()
    {
        $this->assertTrue(BinaryString::startsWith('Foo', 'Foo'));
        $this->assertTrue(BinaryString::startsWith('Foo123', 'Foo'));
        $this->assertFalse(BinaryString::startsWith(' Foo123', 'Foo'));
    }

    /**
     * @test
     */
    public function endsWith()
    {
        $this->assertTrue(BinaryString::endsWith('Foo', 'Foo'));
        $this->assertTrue(BinaryString::endsWith('Foo123', '123'));
        $this->assertFalse(BinaryString::endsWith(' Foo123 ', '123'));
    }
}
