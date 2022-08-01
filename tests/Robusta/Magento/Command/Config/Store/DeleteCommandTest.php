<?php

namespace Robusta\Magento\Command\Config\Store;

use Robusta\Magento\Command\TestCase;

class DeleteCommandTest extends TestCase
{
    /**
     * @test
     */
    public function deleteOne()
    {
        $input = [
            'command' => 'config:store:set',
            'path'    => 'robusta_magerun/foo/bar',
            'value'   => '1234',
        ];
        $this->assertDisplayContains($input, 'robusta_magerun/foo/bar => 1234');

        $input = [
            'command' => 'config:store:delete',
            'path'    => 'robusta_magerun/foo/bar',
        ];
        $this->assertDisplayContains($input, '| robusta_magerun/foo/bar | default | 0  |');
    }

    /**
     * @test
     */
    public function deleteAll()
    {
        $input = [
            'command'    => 'config:store:set',
            'path'       => 'robusta_magerun/foo/bar',
            '--scope'    => 'stores',
            '--scope-id' => null, # placeholder
            'value'      => 'fake-value',
        ];

        foreach ($this->getStores() as $store) {
            $input['--scope-id'] = $store->getId();
            $this->assertDisplayContains($input, "robusta_magerun/foo/bar => fake-value");
        }

        $input = [
            'command' => 'config:store:delete',
            'path'    => 'robusta_magerun/foo/bar',
            '--all'   => true,
        ];
        $this->assertDisplayContains($input, '| robusta_magerun/foo/bar | stores   |');
    }

    /**
     * @return array|\Magento\Store\Api\Data\StoreInterface[]
     */
    private function getStores()
    {
        $application = $this->getApplication();

        /* @var $storeManager \Magento\Store\Model\StoreManager */
        $storeManager = $application->getObjectManager()->get('Magento\Store\Model\StoreManager');

        return $storeManager->getStores();
    }
}
