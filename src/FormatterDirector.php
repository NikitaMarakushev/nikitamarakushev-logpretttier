<?php

namespace Nikitamarakushev\Logpretttier;

use BenMorel\ApacheLogParser\Parser;

class FormatterDirector
{
    /**
     * @var Formatter
     */
    private Formatter $formatter;

    /**
     * @param Formatter $formatter
     */
    public function setFormatter(Formatter $formatter): void {
        $this->formatter = $formatter;
    }

    public function buildFormattedLog(): void
    {
        $parser = new Parser($this->formatter->getLogFormat());
        $formatter = new Formatter($this->formatter->getFileName());
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

        $this->formatter->printFormattedLog($outputData);
    }
}