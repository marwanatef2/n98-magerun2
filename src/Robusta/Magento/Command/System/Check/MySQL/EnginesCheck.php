<?php

namespace Robusta\Magento\Command\System\Check\MySQL;

use Magento\Framework\App\ResourceConnection;
use Robusta\Magento\Command\System\Check\Result;
use Robusta\Magento\Command\System\Check\ResultCollection;
use Robusta\Magento\Command\System\Check\SimpleCheck;

/**
 * Class EnginesCheck
 * @package Robusta\Magento\Command\System\Check\MySQL
 */
class EnginesCheck implements SimpleCheck
{
    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * @param ResourceConnection $resource
     */
    public function __construct(ResourceConnection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param ResultCollection $results
     */
    public function check(ResultCollection $results)
    {
        $result = $results->createResult();

        $dbAdapter = $this->resource->getConnection();

        $engines = $dbAdapter->fetchAll('SHOW ENGINES');
        $innodbFound = false;
        foreach ($engines as $engine) {
            if (strtolower($engine['Engine']) == 'innodb') {
                $innodbFound = true;
                break;
            }
        }

        $result->setStatus($innodbFound ? Result::STATUS_OK : Result::STATUS_ERROR);

        if ($innodbFound) {
            $result->setMessage('<info>Required MySQL Storage Engine <comment>InnoDB</comment> found.</info>');
        } else {
            $result->setMessage('<error>Required MySQL Storage Engine "InnoDB" not found!</error>');
        }
    }
}
