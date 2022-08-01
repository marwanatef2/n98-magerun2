<?php

namespace Robusta\Magento\Command\Developer\Console;

class MakeClassCommandTest extends TestCase
{
    /**
     * @test
     */
    public function testOutput()
    {
        $command = new MakeClassCommand();

        $commandTester = $this->createCommandTester($command);
        $command->setCurrentModuleName('Robusta_Dummy');

        $writerMock = $this->mockWriterFileCWriteFileAssertion('bazClass');

        $command->setCurrentModuleDirectoryWriter($writerMock);
        $commandTester->execute(['classpath' => 'foo.bar.bazClass']);
    }
}
