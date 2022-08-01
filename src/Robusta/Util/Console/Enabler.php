<?php
/**
 * this file is part of magerun
 *
 * @author Tom Klingenberg <https://github.com/ktomk>
 */

namespace Robusta\Util\Console;

use Robusta\Util\OperatingSystem;
use RuntimeException;
use Symfony\Component\Console\Command\Command;

/**
 * Class Enabler
 *
 * Utility class to check console command requirements to be "enabled".
 *
 * @see \Robusta\Magento\Command\Database\DumpCommand::execute()
 *
 * @package Robusta\Util\Console
 */
class Enabler
{
    /**
     * @var Command
     */
    private $command;

    /**
     * Enabler constructor.
     * @param \Symfony\Component\Console\Command\Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @param $name
     *
     * @return void
     */
    public function functionExists($name)
    {
        $this->assert(function_exists($name), sprintf('function "%s" is not available', $name));
    }

    /**
     * @return void
     */
    public function operatingSystemIsNotWindows()
    {
        $this->assert(!OperatingSystem::isWindows(), 'operating system is windows');
    }

    /**
     * @param $condition
     * @param $message
     */
    private function assert($condition, $message)
    {
        if ($condition) {
            return;
        }

        throw new RuntimeException(
            sprintf('Command %s is not available because %s.', $this->command->getName(), $message)
        );
    }
}
