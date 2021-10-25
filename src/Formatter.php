<?php

namespace Nikitamarakushev\Logpretttier;

use BenMorel\ApacheLogParser\Parser;

/**
 * Basic formatter class
 */
class Formatter
{
    /**
     * @var string
     */
    private string $fileName;

    /**
     * @var string
     */
    private string $logFormat = "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"";

    /**
     * @var array|string[]
     */
    private array $crowlersList = [
        'rambler', 'googlebot', 'aport', 'yahoo', 'msnbot', 'turtle', 'mail.ru', 'omsktele',
        'yetibot', 'picsearch', 'sape.bot', 'sape_context', 'gigabot', 'snapbot', 'alexa.com',
        'megadownload.net', 'askpeter.info', 'igde.ru', 'ask.com', 'qwartabot', 'yanga.co.uk',
        'scoutjet', 'similarpages', 'oozbot', 'shrinktheweb.com', 'aboutusbot', 'followsite.com',
        'dataparksearch', 'google-sitemaps', 'appEngine-google', 'feedfetcher-google',
        'liveinternet.ru', 'xml-sitemaps.com', 'agama', 'metadatalabs.com', 'h1.hrn.ru',
        'googlealert.com', 'seo-rus.com', 'yaDirectBot', 'yandeG', 'yandex',
        'yandexSomething', 'Copyscape.com', 'AdsBot-Google', 'domaintools.com',
        'Nigma.ru', 'bing.com', 'dotnetdotcom',
        'msnbot', 'msnbot-media', 'msnbot-news'
    ];


    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return array|false
     */
    public function getViews(): array
    {
        return file($this->fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    /**
     * @param array $lines
     * @param Parser $parser
     * @return array
     */
    public function getArrayOfRequestinInfo(array $lines, Parser $parser): array
    {
        foreach ($lines as $line) {
            $entry[] = $parser->parse($line, true);
        }
        /** @var array $entry */
        return $entry;
    }

    /**
     * @param array $entry
     * @return array
     */
    public function getUrls(array $entry): array
    {
        $urls = [];
        foreach ($entry as $elem) {
            $urls[] = $elem["requestHeader:Referer"];
        }

        return $urls;
    }

    /**
     * @param array $entry
     * @return array
     */
    public function getTrafficSize(array $entry): array
    {
        $allSize = [];

        foreach ($entry as $size) {
            $allSize[] = $size["responseSize"];
        }
        return $allSize;
    }

    /**
     * @param $userAgent
     * @return mixed|string|void
     */
    public function getBots($userAgent): string {
        foreach ($this->crowlersList as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                return $bot;
            }
        }
    }

    /**
     * @return array
     */
    public function getCrawlers(): array {
        $crawlers = [];
        foreach ($crawlers as $cr) {
            if (!is_null(getBots($this->crowlersList, $cr))) {
                $cra[] = $this->getBots($cr);
            }
        }
        return $crawlers;
    }


    /**
     * @param array $entry
     * @return array
     */
    public function getStatusCodes(array $entry): array
    {
        $statusCodes = [];
        foreach ($entry as $status) {
            $statusCodes[] = $status["status"];
        }
        return $statusCodes;
    }

    /**
     * @param array $outputData
     */
    public function printFormattedLog(array $outputData): void
    {
        print_r(json_decode(json_encode($outputData), true, JSON_UNESCAPED_SLASHES));
    }

    /**
     * @return string
     */
    public function getLogFormat(): string
    {
        return $this->logFormat;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}