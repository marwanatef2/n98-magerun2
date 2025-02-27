<?php

namespace Robusta\Util\Unicode;

/**
 * Class Charset
 * @package Robusta\Util\Unicode
 */
class Charset
{
    /**
     * @var int
     */
    const UNICODE_CHECKMARK_CHAR = 10004;

    /**
     * @var int
     */
    const UNICODE_CROSS_CHAR = 10006;

    /**
     * @var int
     */
    const UNICODE_WHITE_SQUARE_CHAR = 9633;

    /**
     * @param int|array $codes
     * @return string
     */
    public static function convertInteger($codes)
    {
        if (is_scalar($codes)) {
            $codes = func_get_args();
        }

        $str = '';
        foreach ($codes as $code) {
            $str .= html_entity_decode('&#' . $code . ';', ENT_NOQUOTES, 'UTF-8');
        }

        return $str;
    }
}
