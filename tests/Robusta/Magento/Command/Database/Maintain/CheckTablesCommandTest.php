<?php

namespace Robusta\Magento\Command\Database\Maintain;

use Robusta\Magento\Command\TestCase;

/**
 * @see \Robusta\Magento\Command\Database\Maintain\CheckTablesCommand
 */
class CheckTablesCommandTest extends TestCase
{
    public function testExecuteMyIsam()
    {
        $this->markTestSkipped('Currently we have no myisam tables in a magento2 installation');

        $this->assertDisplayContains(
            [
                'command'  => 'db:maintain:check-tables',
                '--format' => 'csv',
                '--type'   => 'quick',
                '--table'  => 'oauth_nonce',
            ],
            'oauth_nonce,check,quick,OK'
        );
    }

    public function testExecuteInnoDb()
    {
        $input = [
            'command'  => 'db:maintain:check-tables',
            '--format' => 'csv',
            '--type'   => 'quick',
            '--table'  => 'catalog_product_entity_media_gallery*',
        ];
        $timeRegex = '"\s+[0-9]+\srows","[0-9\.]+\ssecs"';

        $this->assertDisplayRegExp(
            $input,
            '~catalog_product_entity_media_gallery,"ENGINE InnoDB",' . $timeRegex . '~'
        );
        $this->assertDisplayRegExp(
            $input,
            '~catalog_product_entity_media_gallery_value,"ENGINE InnoDB",' . $timeRegex . '~'
        );
    }
}
