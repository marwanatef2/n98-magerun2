<?php

namespace Robusta\Magento\Command\Developer\Console;

class MakeInterfaceCommandTest extends TestCase
{
    /**
     * @test
     */
    public function testOutput()
    {
        $command = new MakeInterfaceCommand();

        $commandTester = $this->createCommandTester($command);
        $command->setCurrentModuleName('Robusta_Dummy');

        $writerMock = $this->mockWriterFileCWriteFileAssertion('bazInterface');

        $command->setCurrentModuleDirectoryWriter($writerMock);
        $commandTester->execute(['classpath' => 'foo.bar.bazInterface']);
    }
}
