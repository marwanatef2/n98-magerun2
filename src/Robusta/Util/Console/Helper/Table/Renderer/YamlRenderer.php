<?php

namespace Robusta\Util\Console\Helper\Table\Renderer;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlRenderer
 * @package Robusta\Util\Console\Helper\Table\Renderer
 */
class YamlRenderer implements RendererInterface
{
    /**
     * @param OutputInterface $output
     * @param array           $rows
     */
    public function render(OutputInterface $output, array $rows)
    {
        $output->writeln(Yaml::dump($rows));
    }
}
