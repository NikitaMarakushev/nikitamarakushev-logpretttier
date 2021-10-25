<?php

namespace Nikitamarakushev\Logpretttier;

/**
 * Basic formatter class
 */
class Formatter
{
    /**
     * String template
     */
    private const template = '#(([0-9]{1,3}\.){3}[0-9]{1,3}).{1,}GET ([0-9a-z/\_\.\-]{1,})#i';

    /**
     * printer
     */
    public static function prettyPrint() {}
}