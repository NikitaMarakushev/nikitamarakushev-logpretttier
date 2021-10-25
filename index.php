<?php

declare(strict_types=1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Nikitamarakushev\Logpretttier\Formatter;
use Nikitamarakushev\Logpretttier\FormatterDirector;

require 'vendor/autoload.php';

$log = new Logger('main');
$log->pushHandler(new StreamHandler('logs/error.log', Logger::ERROR));

$formatterDirector = new FormatterDirector();
$formatterDirector->setFormatter(new Formatter($argv[1]));

try {
    $formatterDirector->buildFormattedLog();
} catch (JsonException $e) {
    $log->error(sprintf(
        '%s%s', $e->getMessage(), $e->getTrace()
    ));
}