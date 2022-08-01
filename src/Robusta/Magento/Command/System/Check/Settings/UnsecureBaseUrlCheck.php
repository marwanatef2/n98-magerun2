<?php

namespace Robusta\Magento\Command\System\Check\Settings;

/**
 * Class UnsecureBaseUrlCheck
 *
 * @package Robusta\Magento\Command\System\Check\Settings
 */
class UnsecureBaseUrlCheck extends BaseUrlCheckAbstract
{
    /**
     * @var string
     */
    protected $class = 'unsecure';
}
