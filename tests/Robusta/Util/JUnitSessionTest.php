<?php
/*
 * @author Tom Klingenberg <https://github.com/ktomk>
 */

namespace Robusta\Util;

use Robusta\JUnitXml\Document;

/**
 * Class JUnitSessionTest
 *
 * @package Robusta\Util
 * @covers Robusta\Util\JUnitSession
 */
class JUnitSessionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $session = new JUnitSession("name");
        $this->assertInstanceOf(JUnitSession::class, $session);
        $this->assertSame('name', $session->getName());
        $this->assertSame(0, $session->save('foo.xml'));
        $document = $session->getDocument();
        $this->assertInstanceOf(Document::class, $document);
        $this->assertSame($document, $session->getDocument());
        $saveResult = $session->save('foo.xml');
        $this->assertGreaterThan(0, $saveResult);
        $this->assertNotNull($session->addTestSuite());
        usleep(1000);
        $this->assertGreaterThan(0.001, $session->getDuration());
    }

    protected function tearDown(): void
    {
        if (is_file('foo.xml')) {
            unlink('foo.xml');
        }
    }
}
