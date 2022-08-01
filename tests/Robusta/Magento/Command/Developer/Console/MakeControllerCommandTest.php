<?php

namespace Robusta\Magento\Command\Developer\Console;

class MakeControllerCommandTest extends TestCase
{
    /**
     * @test
     */
    public function testOutput()
    {
        $command = new MakeControllerCommand();

        $commandTester = $this->createCommandTester($command);
        $command->setCurrentModuleName('Robusta_Dummy');

        $writerMock = $this->mockWriterFileCWriteFileAssertion('bazController');

        $command->setCurrentModuleDirectoryWriter($writerMock);

        $commandTester->execute([
            'classpath' => 'foo.bar.bazController',
        ]);
    }
}
