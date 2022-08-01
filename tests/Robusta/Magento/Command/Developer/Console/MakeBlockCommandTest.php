<?php

namespace Robusta\Magento\Command\Developer\Console;

class MakeBlockCommandTest extends TestCase
{
    /**
     * @test
     */
    public function testOutput()
    {
        $command = new MakeBlockCommand();

        $commandTester = $this->createCommandTester($command);
        $command->setCurrentModuleName('Robusta_Dummy');

        $writerMock = $this->mockWriterFileCWriteFileAssertion('bazBlock');

        $command->setCurrentModuleDirectoryWriter($writerMock);
        $commandTester->execute(['classpath' => 'foo.bar.bazBlock']);
    }
}
