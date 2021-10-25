<?php

namespace Nikitamarakushev\Logpretttier;

class Formatter
{
    public static function prettyPrint(&$j, $indentor = "\t", $indent = "") {
        $inString = $escaped = false;
        $result = $indent;

        if(is_string($j)) {
            $bak = $j;
            $j = str_split(trim($j, '"'));
        }

        while(count($j)) {
            $c = array_shift($j);
            if(false !== strpos("{[,]}", $c)) {
                if($inString) {
                    $result .= $c;
                } else if($c == '{' || $c == '[') {
                    $result .= $c."\n";
                    $result .= self::prettyPrint($j, $indentor, $indentor.$indent);
                    $result .= $indent.array_shift($j);
                } else if($c == '}' || $c == ']') {
                    array_unshift($j, $c);
                    $result .= "\n";
                    return $result;
                } else {
                    $result .= $c."\n".$indent;
                }
            } else {
                $result .= $c;
                $c == '"' && !$escaped && $inString = !$inString;
                $escaped = $c == '\\' ? !$escaped : false;
            }
        }

        $j = $bak;
        return $result;
    }
}