<?php

namespace Robusta\Magento\Command\Developer\Console;

use Magento\Framework\Component\ComponentRegistrar;
use Robusta\Magento\Command\Developer\Console\Util\Config\DiFileWriter;

class MakeCommandCommandTest extends TestCase
{
    public function testOutput()
    {
        // fake path because Magento checks every path...
        ComponentRegistrar::register(
            ComponentRegistrar::MODULE,
            'Robusta_Dummy',
            __DIR__
        );

        $diFileWriterMock = $this->getMockBuilder(DiFileWriter::class)
            ->setMethods(['save'])
            ->getMock();
        $diFileWriterMock->loadXml('<config />');

        $command = $this->getMockBuilder(MakeCommandCommand::class)
            ->setMethods(['createDiFileWriter'])
            ->getMock();

        $command
            ->expects($this->once())
            ->method('createDiFileWriter')
            ->will($this->returnValue($diFileWriterMock));

        $commandTester = $this->createCommandTester($command);
        $command->setCurrentModuleName('Robusta_Dummy');

        $writerMock = $this->mockWriterFileCWriteFileAssertion('bazCommand');

        $command->setCurrentModuleDirectoryWriter($writerMock);
        $commandTester->execute(['classpath' => 'foo.bar.baz']);
    }
}
