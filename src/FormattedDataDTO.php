<?php

namespace Nikitamarakushev\Logpretttier\Director;

use BenMorel\ApacheLogParser\Parser;
use Nikitamarakushev\Logpretttier\Formatter;

/**
 * Class for storing and returning formatted data to pring
 *
 * @author Nikita Marakushev
 */
class FormattedDataDTO {

    /**
     * int $views
     * Count of all views
     */
    private int $views;

    /**
     * int $views
     * Count of all url
     */
    private int $urls;

    /**
     * int $views
     * Count of all traffic in bytes
     */
    private int $traffic;

    /**
     * @array $views
     * array of crawlers and searching bots
     */
    private array $crawlers;

    /**
     * @array $views
     * array of http status codes
     */
    private array $statusCodes;
}