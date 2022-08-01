<?php

namespace Robusta\Magento\Command\System\Check\Settings;

/**
 * Class UnsecureCookieDomainCheck
 * @package Robusta\Magento\Command\System\Check\Settings
 */
class UnsecureCookieDomainCheck extends CookieDomainCheckAbstract
{
    /**
     * @var string
     */
    protected $class = 'unsecure';
}
