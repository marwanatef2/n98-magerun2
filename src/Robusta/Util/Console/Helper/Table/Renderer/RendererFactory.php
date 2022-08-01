<?php

namespace Robusta\Util\Console\Helper\Table\Renderer;

/**
 * Class RendererFactory
 * @package Robusta\Util\Console\Helper\Table\Renderer
 */
class RendererFactory
{
    protected static $formats = [
        'csv'  => 'Robusta\Util\Console\Helper\Table\Renderer\CsvRenderer',
        'json' => 'Robusta\Util\Console\Helper\Table\Renderer\JsonRenderer',
        'json_array' => 'Robusta\Util\Console\Helper\Table\Renderer\JsonArrayRenderer',
        'yaml'  => 'Robusta\Util\Console\Helper\Table\Renderer\YamlRenderer',
        'xml'  => 'Robusta\Util\Console\Helper\Table\Renderer\XmlRenderer',
    ];

    /**
     * @param string $format
     *
     * @return bool|RendererInterface
     */
    public function create($format)
    {
        $format = strtolower($format ?? '');
        if (isset(self::$formats[$format])) {
            $rendererClass = self::$formats[$format];
            return new $rendererClass();
        }

        return false;
    }

    /**
     * @return array
     */
    public static function getFormats()
    {
        return array_keys(self::$formats);
    }
}
