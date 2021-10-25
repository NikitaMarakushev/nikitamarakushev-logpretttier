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
    private const template = '$pattern = "/(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) (\".*?\") (\".*?\")/"';

    /**
     * printer
     */
    public static function prettyPrint(&$file) {
        for ($i = 0, $iMax = count(file($file)); $i < $iMax; $i++) {
            preg_match (self::template, $file, $result);
        }
    }
}