<?php

namespace Robusta\Magento\Command\Admin\User;

use Robusta\Util\Console\Helper\Table\Renderer\RendererFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends AbstractAdminUserCommand
{
    protected function configure()
    {
        $this
            ->setName('admin:user:list')
            ->setDescription('List admin users.')
            ->addOption(
                'format',
                null,
                InputOption::VALUE_OPTIONAL,
                'Output Format. One of [' . implode(',', RendererFactory::getFormats()) . ']'
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectMagento($output, true);
        if (!$this->initMagento()) {
            return;
        }

        $userList = $this->userModel->getCollection();
        $table = [];
        foreach ($userList as $user) {
            $table[] = [
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getIsActive() ? 'active' : 'inactive',
            ];
        }
        $this->getHelper('table')
            ->setHeaders(['id', 'username', 'email', 'status'])
            ->renderByFormat($output, $table, $input->getOption('format'));
    }
}
