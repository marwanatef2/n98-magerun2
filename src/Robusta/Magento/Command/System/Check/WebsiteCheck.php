<?php

namespace Robusta\Magento\Command\System\Check;

use Magento\Store\Api\Data\WebsiteInterface;

/**
 * Interface WebsiteCheck
 *
 * @package Robusta\Magento\Command\System\Check
 */
interface WebsiteCheck
{
    /**
     * @param ResultCollection         $results
     * @param WebsiteInterface $website
     *
     * @return void
     */
    public function check(ResultCollection $results, WebsiteInterface $website);
}
