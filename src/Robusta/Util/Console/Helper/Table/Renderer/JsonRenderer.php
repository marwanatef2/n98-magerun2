<?php

namespace Robusta\Util\Console\Helper\Table\Renderer;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class JsonRenderer
 * @package Robusta\Util\Console\Helper\Table\Renderer
 */
class JsonRenderer implements RendererInterface
{
    /**
     * @param OutputInterface $output
     * @param array           $rows
     */
    public function render(OutputInterface $output, array $rows)
    {
        $options = \JSON_FORCE_OBJECT;
        if (version_compare(\PHP_VERSION, '5.4', '>=')) {
            $options |= \JSON_PRETTY_PRINT;
        }

        $output->writeln(\json_encode($rows, $options));
    }
}
