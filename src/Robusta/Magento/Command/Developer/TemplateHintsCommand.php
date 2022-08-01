<?php

namespace Robusta\Magento\Command\Developer;

use Robusta\Magento\Command\AbstractMagentoStoreConfigCommand;

/**
 * Class TemplateHintsCommand
 * @package Robusta\Magento\Command\Developer
 */
class TemplateHintsCommand extends AbstractMagentoStoreConfigCommand
{
    /**
     * @var string
     */
    protected $commandName = 'dev:template-hints';

    /**
     * @var string
     */
    protected $commandDescription = 'Toggles template hints';

    /**
     * @var string
     */
    protected $toggleComment = 'Template Hints';

    /**
     * @var string
     */
    protected $configPath = 'dev/debug/template_hints_storefront';

    /**
     * @var string
     */
    protected $scope = self::SCOPE_STORE_VIEW;
}
