<?php

namespace Robusta\Util\Faker\Provider;

/**
 * Class Internet
 * @package Robusta\Util\Faker\Provider
 */
class Internet extends \Faker\Provider\Internet
{
    /**
     * Reduce the chance of conflicts.
     *
     * @var array
     */
    protected static $userNameFormats = [
        '{{lastName}}.{{firstName}}.######',
        '{{firstName}}.{{lastName}}.######',
        '{{firstName}}.######',
        '?{{lastName}}.######',
    ];
}
