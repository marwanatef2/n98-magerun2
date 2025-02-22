<?php
/*
 * @author Tom Klingenberg <https://github.com/ktomk>
 */

namespace Robusta\Magento\Application;

use Composer\Autoload\ClassLoader;
use ErrorException;
use Robusta\Magento\Application;
use Robusta\Magento\Command\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class ConfigTest
 *
 * @covers  Robusta\Magento\Application\Config
 * @package Robusta\Magento\Application
 */
class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $config = new Config();
        $this->assertInstanceOf(__NAMESPACE__ . '\\Config', $config);
    }

    /**
     * @test
     */
    public function loader()
    {
        $config = new Config();

        try {
            $config->load();
            $this->fail('An expected exception was not thrown');
        } catch (ErrorException $e) {
            $this->assertEquals('Configuration not yet fully loaded', $e->getMessage());
        }

        $this->assertEquals([], $config->getConfig());

        $loader = $config->getLoader();
        $this->assertInstanceOf(__NAMESPACE__ . '\\ConfigurationLoader', $loader);
        $this->assertSame($loader, $config->getLoader());

        $loader->loadStageTwo("");
        $config->load();

        $this->assertIsArray($config->getConfig());
        $this->assertGreaterThan(4, count($config->getConfig()));

        $config->setLoader($loader);
    }

    /**
     * config array setter is used in some tests on @see \Robusta\Magento\Application::setConfig()
     *
     * @test
     */
    public function setConfig()
    {
        $config = new Config();
        $config->setConfig([0, 1, 2]);
        $actual = $config->getConfig();
        $this->assertSame($actual[1], 1);
    }

    /**
     * @test
     */
    public function configCommandAlias()
    {
        $config = new Config();
        $input = new ArgvInput();
        $actual = $config->checkConfigCommandAlias($input);
        $this->assertInstanceOf('Symfony\Component\Console\Input\InputInterface', $actual);

        $saved = $_SERVER['argv'];
        {
            $config->setConfig(['commands' => ['aliases' => [['list-help' => 'list --help']]]]);
            $definition = new InputDefinition();
            $definition->addArgument(new InputArgument('command'));

            $argv = ['/path/to/command', 'list-help'];
            $_SERVER['argv'] = $argv;
            $input = new ArgvInput($argv, $definition);
            $this->assertSame('list-help', (string) $input);
            $actual = $config->checkConfigCommandAlias($input);
            $this->assertSame('list-help', $actual->getFirstArgument());
            $this->assertSame('list-help --help', (string) $actual);
        }
        $_SERVER['argv'] = $saved;

        $command = new Command('list');

        $config->registerConfigCommandAlias($command);

        $this->assertSame(['list-help'], $command->getAliases());
    }

    /**
     * @test
     */
    public function customCommands()
    {
        $array = [
            'commands' => [
                'customCommands' => [
                    'Robusta\Magento\Command\Config\Store\GetCommand',
                    ['name' => 'Robusta\Magento\Command\Config\Store\GetCommand'],
                ],
            ],
        ];

        $output = new BufferedOutput();
        $output->setVerbosity($output::VERBOSITY_DEBUG);

        $config = new Config([], false, $output);
        $config->setConfig($array);

        /** @var Application $application */
        $application = $this->createMock('Robusta\Magento\Application');
        $config->registerCustomCommands($application);
    }

    /**
     * @test
     */
    public function registerCustomAutoloaders()
    {
        $array = [
            'autoloaders'      => ['$prefix' => '$path'],
            'autoloaders_psr4' => ['$prefix\\' => '$path'],
        ];

        $output = new BufferedOutput();

        $config = new Config([], false, $output);
        $config->setConfig($array);

        $autloader = new ClassLoader();
        $config->registerCustomAutoloaders($autloader);

        $output->setVerbosity($output::VERBOSITY_DEBUG);
        $config->registerCustomAutoloaders($autloader);
    }

    /**
     * @test
     */
    public function loadPartialConfig()
    {
        $config = new Config();
        $this->assertEquals([], $config->getDetectSubFolders());
        $config->loadPartialConfig(false);
        $actual = $config->getDetectSubFolders();
        $this->assertIsArray($actual);
        $this->assertNotEquals([], $actual);
    }
}
