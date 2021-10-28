<?php

namespace Nikitamarakushev\Logpretttier\Director;

use BenMorel\ApacheLogParser\Parser;
use Nikitamarakushev\Logpretttier\Formatter;

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
     * @return array
     */
    public function initOutputLogData(): array {

        $parser = new Parser($this->formatter->getLogFormat());
        $formatter = new Formatter($this->formatter->getFileName());
        $lines = $formatter->getViews();
        $connectionsCollection = $formatter->getArrayOfRequestinInfo($lines, $parser);
        $urls = array_unique($formatter->getUrls($connectionsCollection));
        $allSize = $formatter->getTrafficSize($connectionsCollection);
        $crawlers = $formatter->getCrawlers($connectionsCollection);
        $statusCodes = $formatter->getStatusCodes($connectionsCollection);

        return [
            new Parser($this->formatter->getLogFormat()),
            new Formatter($this->formatter->getFileName()),
            $formatter->getViews(),
            $formatter->getArrayOfRequestinInfo($lines, $parser),
            array_unique($formatter->getUrls($connectionsCollection)),
            $formatter->getTrafficSize($connectionsCollection),
            $formatter->getCrawlers($connectionsCollection),
            $formatter->getStatusCodes($connectionsCollection)
        ];
    }

    /**
     * Main function, makes a pipeline of other necessary functions, which are used in building pretty output
     * of apache access log
     * @throws \JsonException
     */
    public function buildFormattedLog(): void
    {
        $outputData = [
            "views" => count($this->initOutputLogData()[2]),
            "urls" => count($this->initOutputLogData()[4]),
            "traffic" => array_sum($this->initOutputLogData()[5]),
            "crawlers" => array_count_values($this->initOutputLogData()[6]),
            "statusCodes" => array_count_values($this->initOutputLogData()[7])
        ];

        $this->formatter->printFormattedLog($outputData);
    }
}