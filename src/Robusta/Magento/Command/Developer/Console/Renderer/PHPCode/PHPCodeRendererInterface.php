<?php
/**
 * Copyright © 2016 netz98 new media GmbH. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Robusta\Magento\Command\Developer\Console\Renderer\PHPCode;

/**
 * Interface PHPCodeRendererInterface
 * @package Robusta\Magento\Command\Developer\Console\Renderer\PHPCode
 */
interface PHPCodeRendererInterface
{
    /**
     * @return string
     */
    public function render();
}
