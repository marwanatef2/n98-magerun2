<?php

namespace Robusta\View;

/**
 * Class PhpView
 * @package Robusta\View
 */
class PhpView implements View
{
    /**
     * @var array
     */
    protected $vars = [];

    /**
     * @var
     */
    protected $template;

    /**
     * @param string $template
     * @return PhpView
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return PhpView
     */
    public function assign($key, $value)
    {
        $this->vars[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        extract($this->vars);
        ob_start();
        include $this->template;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @return string
     */
    protected function xmlProlog()
    {
        return '<?xml version="1.0"?>' . "\n";
    }
}
