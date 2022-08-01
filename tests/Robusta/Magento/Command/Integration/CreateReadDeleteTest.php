<?php

namespace Robusta\Magento\Command\Integration;

use Robusta\Magento\Command\TestCase;

/**
 * Class ListCommandTest
 * @package Robusta\Magento\Command\Script\Repository
 */
class CreateReadDeleteTest extends TestCase
{
    public function testExecute()
    {
        $generatedEmail = uniqid('', true) . '@example.com';
        $generatedIntegrationName = uniqid('', true);

        $input = [
            'command'   => 'integration:create',
            'name'      => $generatedIntegrationName,
            'email'     => $generatedEmail,
            'endpoint'  => 'https://example.com'
        ];
        $this->assertDisplayContains($input, $generatedIntegrationName);
        $this->assertDisplayContains($input, $generatedEmail);
        $this->assertDisplayContains($input, 'Access Token');
        $this->assertDisplayContains($input, 'Access Token Secret');
        $this->assertDisplayContains($input, 'Consumer Key');

        $input = [
            'command'   => 'integration:show',
            'name'      => $generatedIntegrationName,
        ];
        $this->assertDisplayContains($input, $generatedIntegrationName);

        $input = [
            'command'   => 'integration:delete',
            'name'      => $generatedIntegrationName,
        ];
        $this->assertDisplayContains($input, $generatedIntegrationName);
        $this->assertDisplayContains($input, 'Successfully deleted integration');
    }
}
