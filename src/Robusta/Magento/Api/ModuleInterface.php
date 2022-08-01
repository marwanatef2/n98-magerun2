<?php
/*
 * @author Tom Klingenberg <https://github.com/ktomk>
 */

namespace Robusta\Magento\Api;

/**
 * Magento Module
 *
 * @package Robusta\Magento\Api
 */
interface ModuleInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getVersion();
}
