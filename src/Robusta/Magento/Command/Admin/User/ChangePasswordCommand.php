<?php

namespace Robusta\Magento\Command\Admin\User;

use Exception;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class ChangePasswordCommand
 * @package Robusta\Magento\Command\Admin\User
 */
class ChangePasswordCommand extends AbstractAdminUserCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:user:change-password')
            ->addArgument('username', InputArgument::OPTIONAL, 'Username')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password')
            ->setDescription('Changes the password of a adminhtml user.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws Exception
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output);
        if (!$this->initMagento()) {
            return;
        }

        /** @var $questionHelper QuestionHelper */
        $questionHelper = $this->getHelper('question');

        // Username
        $username = $username = $input->getArgument('username');
        if ($username === null) {
            $question = new Question('<question>Username:</question>');
            $question->setMaxAttempts(20);
            $question->setValidator(function ($value) {
                if (trim($value) === '') {
                    throw new \Exception('Please enter a valid username');
                }

                return $value;
            });

            $username = $questionHelper->ask($input, $output, $question);
        }

        $user = $this->userModel->loadByUsername($username);
        if ($user->getId() <= 0) {
            $output->writeln('<error>User was not found</error>');
            return;
        }

        // Password
        $password = $input->getArgument('password');
        if ($password === null) {
            $question = new Question('<question>Password:</question>');
            $question->setHidden(true);
            $password = $questionHelper->ask($input, $output, $question);
        }

        try {
            // @see \Magento\Framework\Session\SessionManager::isSessionExists Hack to prevent session problems
            @session_start();

            $result = $user->validate();
            if (is_array($result)) {
                throw new Exception(implode(PHP_EOL, $result));
            }
            $user->setPassword($password);
            $user->setForceNewPassword(true);
            $this->userResource->save($user);
            $this->userResource->trackPassword($user, $user->getPassword());
            $output->writeln('<info>Password successfully changed</info>');
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }
}
