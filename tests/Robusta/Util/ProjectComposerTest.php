<?php
/**
 * @copyright Copyright (c) netz98 GmbH (https://www.netz98.de)
 *
 * @see PROJECT_LICENSE.txt
 */

declare(strict_types=1);

namespace Robusta\Util;

use PHPUnit\Framework\TestCase;

class ProjectComposerTest extends TestCase
{
    /**
     * @var \Robusta\Util\ProjectComposer
     */
    private $sut;

    protected function setUp(): void
    {
        $this->sut = new ProjectComposer(__DIR__ . '/_files/sample-project/composer');
    }

    /**
     * @test
     */
    public function isLockFile()
    {
        $this->assertTrue($this->sut->isLockFile());
    }

    /**
     * @test
     */
    public function isComposerJsonFile()
    {
        $this->assertTrue($this->sut->isComposerJsonFile());
    }

    /**
     * @test
     * @throws \JsonException
     */
    public function itShouldReturnAPackageList()
    {
        $returnedPackages = $this->sut->getComposerLockPackages();

        $this->assertCount(44, $returnedPackages);
    }
}
