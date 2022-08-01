<?php

namespace Robusta\Magento\Command\System\Check;

/**
 * Interface SimpleCheck
 *
 * @package Robusta\Magento\Command\System\Check
 */
interface SimpleCheck
{
    /**
     * @param ResultCollection $results
     *
     * @return void
     */
    public function check(ResultCollection $results);
}
