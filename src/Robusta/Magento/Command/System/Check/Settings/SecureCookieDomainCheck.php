<?php

namespace Robusta\Magento\Command\System\Check\Settings;

/**
 * Class SecureCookieDomainCheck
 * @package Robusta\Magento\Command\System\Check\Settings
 */
class SecureCookieDomainCheck extends CookieDomainCheckAbstract
{
    /**
     * @var string
     */
    protected $class = 'secure';
}
