<?php

namespace Robusta\Magento\Command\Cache;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    /**
     * @var $command ListCommand
     */
    protected $command = null;

    protected function setUp(): void
    {
        $application = $this->getApplication();
        $application->add(new ListCommand());

        $this->command = $this->getApplication()->find('cache:list');
    }

    /**
     * Test whether the $cacheTypes property is getting filled
     */
    public function testTypesIsNotEmpty()
    {
        /* @var $command ListCommand */
        $command = $this->assertExecute('cache:list')->getCommand();
        $this->assertNotEmpty($command->getTypes());
    }

    /**
     * Test whether only enabled cache types are taken into account when --enabled=1
     */
    public function testEnabledFilter()
    {
        /* @var $command ListCommand */
        $command = $this->assertExecute(['command' => 'cache:list', '--enabled' => 1])->getCommand();

        $cacheTypes = $command->getTypes();
        $disabledCacheTypes = 0;

        foreach ($cacheTypes as $cacheType) {
            if (!$cacheType->getStatus()) {
                $disabledCacheTypes++;
            }
        }

        $this->assertEquals(0, $disabledCacheTypes);
    }
}
