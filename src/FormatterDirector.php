<?php

namespace Nikitamarakushev\Logpretttier;

use BenMorel\ApacheLogParser\Parser;

/**
 * Basic formatter class director
 *
 * @author Nikita Marakushev
 */
class FormatterDirector
{
    /**
     * @var Formatter
     */
    private Formatter $formatter;

    /**
     * @param Formatter $formatter
     */
    public function setFormatter(Formatter $formatter): void
    {
        $this->formatter = $formatter;
    }

    /**
     * Main function, makes a pipeline of other necessary functions, which are used in building pretty output
     * of apache access log
     * @throws \JsonException
     */
    public function buildFormattedLog(): void
    {
        $parser = new Parser($this->formatter->getLogFormat());
        $formatter = new Formatter($this->formatter->getFileName());
        $lines = $formatter->getViews();
        $connectionsCollection = $formatter->getArrayOfRequestinInfo($lines, $parser);
        $urls = $formatter->getUrls($connectionsCollection);
        $allSize = $formatter->getTrafficSize($connectionsCollection);
        $crawlers = $formatter->getCrawlers($connectionsCollection);
        $statusCodes = $formatter->getStatusCodes($connectionsCollection);

        $outputData = [
            "views" => count($lines),
            "urls" => array_values(array_unique($urls)),
            "traffic" => array_sum($allSize),
            "crawlers" => array_count_values($crawlers),
            "statusCodes" => array_count_values($statusCodes)
        ];

        $this->formatter->printFormattedLog($outputData);
    }
}