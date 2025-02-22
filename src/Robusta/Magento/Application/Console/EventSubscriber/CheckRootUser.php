<?php

namespace Robusta\Magento\Application\Console\EventSubscriber;

use Robusta\Magento\Application;
use Robusta\Magento\Application\ApplicationAwareInterface;
use Robusta\Magento\Application\Console\Event;
use Robusta\Magento\Application\Console\Events;
use Robusta\Util\OperatingSystem;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckRootUser implements EventSubscriberInterface, ApplicationAwareInterface
{
    /**
     * @var string
     */
    const WARNING_ROOT_USER = '<error>It\'s not recommended to run robusta-magerun as root user</error>';

    /**
     * @var Application
     */
    private $application;

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::RUN_BEFORE => 'checkRunningAsRootUser',
        ];
    }

    /**
     * Display a warning if a running robusta-magerun as root user
     *
     * @param ConsoleEvent $event
     * @return void
     */
    public function checkRunningAsRootUser(ConsoleEvent $event)
    {
        $skipRootCheck = $this->_isSkipRootCheck($event->getInput());

        if ($skipRootCheck) {
            $this->debugWriteln($event, "Skipping root-check by '--skip-root-check' option ");
            return;
        }

        $config = $this->application->getConfig();
        if (!$config['application']['check-root-user']) {
            return;
        }

        if (OperatingSystem::isRoot()) {
            $output = $event->getOutput();
            $output->writeln([
                '',
                self::WARNING_ROOT_USER,
                '',
            ]);
        }
    }

    /**
     * @return bool
     */
    protected function _isSkipRootCheck(InputInterface $input)
    {
        return $input->hasParameterOption('--skip-root-check');
    }

    /**
     * @param Event $event
     * @param string $message
     */
    private function debugWriteln(ConsoleEvent $event, $message)
    {
        $output = $event->getOutput();
        if (OutputInterface::VERBOSITY_DEBUG <= $output->getVerbosity()) {
            $output->writeln($message);
        }
    }

    public function setApplication($application)
    {
        $this->application = $application;
    }
}
