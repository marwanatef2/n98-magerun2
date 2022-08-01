<?php

namespace Robusta\Magento\Command\Admin;

use Robusta\Magento\Command\AbstractMagentoStoreConfigCommand;

class NotificationsCommand extends AbstractMagentoStoreConfigCommand
{
    /**
     * @var string
     */
    protected $commandName = 'admin:notifications';

    /**
     * @var string
     */
    protected $commandDescription = 'Toggles admin notifications';

    /**
     * @var string
     */
    protected $toggleComment = 'Admin Notifications';

    /**
     * @var string
     */
    protected $configPath = 'advanced/modules_disable_output/Magento_AdminNotification';

    /**
     * @var string
     */
    protected $trueName = 'hidden';

    /**
     * @var string
     */
    protected $falseName = 'visible';

    /**
     * @var string
     */
    protected $scope = self::SCOPE_GLOBAL;
}
