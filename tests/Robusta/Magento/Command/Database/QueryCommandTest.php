<?php

namespace Robusta\Magento\Command\Database;

use Robusta\Magento\Command\TestCase;

class QueryCommandTest extends TestCase
{
    public function testExecute()
    {
        $input = [
            'command' => 'db:query',
            'query'   => 'SHOW TABLES;',
        ];
        $this->assertDisplayContains($input, 'admin_user');
        $this->assertDisplayContains($input, 'catalog_product_entity');
        $this->assertDisplayContains($input, 'wishlist');
    }
}
