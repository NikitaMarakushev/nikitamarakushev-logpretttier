<?php

declare(strict_types=1);

use BenMorel\ApacheLogParser\Parser;
use Nikitamarakushev\Logpretttier\Formatter;

require 'vendor/autoload.php';

$logFormat = "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"";
$parser = new Parser($logFormat);

$formatter = new Formatter();
$formatter->setFileName($argv[1]);
$lines = $formatter->getViews();
$entry = $formatter->getArrayOfRequestinInfo($lines, $parser);
$urls = $formatter->getUrls($entry);
$allSize = $formatter->getTrafficSize($entry);
$crawlers = $formatter->getCrawlers();
$statusCodes = $formatter->getStatusCodes($entry);

$outputData = [
    "views" => count($lines),
    "urls" => array_unique($urls),
    "traffic" => array_sum($allSize),
    "crawlers" => [
        'Google' => count($crawlers)
    ],
    "statusCodes" => [
        200 => array_count_values($statusCodes)["200"],
        301 => array_count_values($statusCodes)["301"]
    ]
];

$formatter->printFormattedLog($outputData);