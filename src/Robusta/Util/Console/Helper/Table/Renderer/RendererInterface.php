<?php

namespace Robusta\Util\Console\Helper\Table\Renderer;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface RendererInterface
 * @package Robusta\Util\Console\Helper\Table\Renderer
 */
interface RendererInterface
{
    /**
     * @param OutputInterface $output
     * @param array $rows
     * @return void
     */
    public function render(OutputInterface $output, array $rows);
}
