<?php

namespace Robusta\Magento\Command\Developer\Module\Create\SubCommand;

use Robusta\Magento\Command\SubCommand\AbstractSubCommand;

/**
 * Class CreateGitlabIssuesAndMRsTemplatesFiles
 * @package Robusta\Magento\Command\Developer\Module\Create\SubCommand
 */
class CreateGitlabIssuesAndMRsTemplatesFiles extends AbstractSubCommand
{
    /**
     * @return void
     */
    public function execute()
    {
        $templates = [
            'issue' => [
                'Bug',
                'Feature Proposal'
            ],
            'merge_request' => [
                'default'
            ]
        ];

        foreach ($templates as $key => $value) {
            foreach ($value as $template) {
                $this->createTemplateFile($key, $template);
            }
        }
    }

    protected function createTemplateFile($type, $name)
    {
        $outFile = $this->config->getString('moduleDirectory') . "/.gitlab/${type}_templates/$name.md";

        \file_put_contents(
            $outFile,
            $this->getCommand()->getHelper('twig')->render(
                "dev/module/create/.gitlab/${type}_templates/$name.md.twig",
                $this->config->getArray('twigVars')
            )
        );

        $this->output->writeln('<info>Created file: <comment>' . $outFile . '<comment></info>');
    }
}
