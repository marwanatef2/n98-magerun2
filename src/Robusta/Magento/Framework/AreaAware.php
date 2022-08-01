<?php

namespace Robusta\Magento\Framework;

/**
 * Interface AreaAware
 * @package Robusta\Magento\Framework
 */
interface AreaAware
{
    /**
     * Area to initialize
     * @return string
     */
    public function getAreaCode();
}
