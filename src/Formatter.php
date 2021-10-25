<?php

namespace Nikitamarakushev\Logpretttier;

use BenMorel\ApacheLogParser\Parser;

/**
 * Basic formatter class
 *
 * @author Nikita Marakushev
 */
class Formatter
{
    /**
     * @var string
     */
    private string $fileName;

    private const LOG_FORMAT = "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-agent}i\"";

    /**
     * @var array|string[]
     */
    private array $crowlersList = [
        'YandexBot', 'YandexAccessibilityBot', 'YandexMobileBot', 'YandexDirectDyn', 'YandexScreenshotBot',
        'YandexImages', 'YandexVideo', 'YandexVideoParser', 'YandexMedia', 'YandexBlogs', 'YandexFavicons',
        'YandexWebmaster', 'YandexPagechecker', 'YandexImageResizer', 'YandexAdNet', 'YandexDirect',
        'YaDirectFetcher', 'YandexCalendar', 'YandexSitelinks', 'YandexMetrika', 'YandexNews',
        'YandexNewslinks', 'YandexCatalog', 'YandexAntivirus', 'YandexMarket', 'AppleWebKit',
        'YandexForDomain', 'YandexSpravBot', 'YandexSearchShop', 'YandexMedianaBot', 'YandexOntoDB',
        'YandexOntoDBAPI', 'YandexTurbo', 'YandexVerticals', 'Googlebot', 'Googlebot-Image', 'Mediapartners-Google', 'AdsBot-Google', 'APIs-Google',
        'AdsBot-Google-Mobile', 'AdsBot-Google-Mobile', 'Googlebot-News', 'Googlebot-Video',
        'AdsBot-Google-Mobile-Apps', 'Mail.RU_Bot', 'bingbot', 'Accoona', 'ia_archiver', 'Ask Jeeves', 'OmniExplorer_Bot', 'W3C_Validator',
        'WebAlta', 'YahooFeedSeeker', 'Yahoo!', 'Ezooms', 'Tourlentabot', 'MJ12bot', 'AhrefsBot',
        'SearchBot', 'SiteStatus', 'Nigma.ru', 'Baiduspider', 'Statsbot', 'SISTRIX', 'AcoonBot', 'findlinks',
        'proximic', 'OpenindexSpider', 'statdom.ru', 'Exabot', 'Spider', 'SeznamBot', 'oBot', 'C-T bot',
        'Updownerbot', 'Snoopy', 'heritrix', 'Yeti', 'DomainVader', 'DCPbot', 'PaperLiBot', 'StackRambler',
        'msnbot', 'msnbot-media', 'msnbot-news', 'Windows NT'
    ];


    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return array
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
     * @param string $userAgent
     * @return string
     */
    public function getBots(string $userAgent): string
    {
        foreach ($this->crowlersList as $certainCraler) {
            if (stripos(strtolower($userAgent), strtolower($certainCraler))) {
                return $certainCraler;
            }
        }
    }

    /**
     * @param array $entry
     * @return array
     */
    public function getCrawlers(array $entry): array
    {
        $crawlers = [];
        foreach ($entry as $entryItem) {
            $userAgent = $this->getBots($entryItem["requestHeader:User-agent"]);
            if (isset($userAgent)) {
                $crawlers[] = $this->getBots($entryItem["requestHeader:User-agent"]);
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
     * @throws \JsonException
     */
    public function printFormattedLog(array $outputData): void
    {
//        print_r(json_decode(json_encode($outputData, JSON_THROW_ON_ERROR), true, JSON_UNESCAPED_SLASHES, JSON_THROW_ON_ERROR));
        echo stripslashes(json_encode($outputData, JSON_PRETTY_PRINT));
    }

    /**
     * @return string
     */
    public function getLogFormat(): string
    {
        return self::LOG_FORMAT;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }
}