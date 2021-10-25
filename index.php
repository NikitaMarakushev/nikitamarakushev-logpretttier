<?php

declare(strict_types=1);

use BenMorel\ApacheLogParser\Parser;

require 'vendor/autoload.php';

$logFormat = "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"";
$parser = new Parser($logFormat);
$lines = file($argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);;

foreach ($lines as $line) {
   $entry[] = $parser->parse($line, true);
}

$urls = [];

foreach ($entry as $elem) {
   $urls[] = $elem["requestHeader:Referer"];
}

$allSize = [];

foreach ($entry as $size) {
    $allSize[] = $elem["responseSize"];
}


$entry1 = [
    "views" => count($lines),
    "urls" => array_unique($urls),
    "traffic" => array_sum($allSize),
    "crawlers" => [],
    "statusCodes" => [

    ]
];

print_r(json_decode(json_encode($entry1), true, JSON_UNESCAPED_SLASHES));