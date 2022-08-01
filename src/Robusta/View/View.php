<?php

namespace Robusta\View;

/**
 * Interface View
 * @package Robusta\View
 */
interface View
{
    /**
     * @param string $key
     * @param mixed $value
     * @return View
     */
    public function assign($key, $value);

    /**
     * @return string
     */
    public function render();
}
