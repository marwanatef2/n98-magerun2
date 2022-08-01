<?php

namespace Robusta\Magento\Command\Design;

use Robusta\Magento\Command\AbstractMagentoStoreConfigCommand;

/**
 * Class DemoNoticeCommand
 * @package Robusta\Magento\Command\Design
 */
class DemoNoticeCommand extends AbstractMagentoStoreConfigCommand
{
    /**
     * @var string
     */
    protected $commandName = 'design:demo-notice';

    /**
     * @var string
     */
    protected $commandDescription = 'Toggles demo store notice for a store view';

    /**
     * @var string
     */
    protected $toggleComment = 'Demo Notice';

    /**
     * @var string
     */
    protected $configPath = 'design/head/demonotice';

    /**
     * @var string
     */
    protected $scope = self::SCOPE_STORE_VIEW_GLOBAL;
}
