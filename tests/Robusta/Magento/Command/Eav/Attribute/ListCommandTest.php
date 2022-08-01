<?php

namespace Robusta\Magento\Command\Eav\Attribute;

use Robusta\Magento\Command\TestCase;

class ListCommandTest extends TestCase
{
    public function testExecute()
    {
        $this->assertDisplayRegExp(
            [
                'command'      => 'eav:attribute:list',
                '--add-source' => true,
            ],
            '~\\| code.*\\| id.*\\| entity_type.*\\| label.*\\| source.*\\|$~m'
        );

        $this->assertDisplayContains(
            [
                'command'       => 'eav:attribute:list',
                '--filter-type' => 'catalog_product',
            ],
            'sku'
        );
    }
}
