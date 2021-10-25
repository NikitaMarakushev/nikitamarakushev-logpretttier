<?php

declare(strict_types=1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Nikitamarakushev\Logpretttier\Formatter;
use Nikitamarakushev\Logpretttier\FormatterDirector;

require 'vendor/autoload.php';

$log = new Logger('main');
$log->pushHandler(new StreamHandler('logs/error.log', Logger::ERROR));


try {
    $formatterDirector = new FormatterDirector();
    $formatterDirector->setFormatter(new Formatter($argv[1]));
    $formatterDirector->buildFormattedLog();
} catch (JsonException $exception) {
    $log->error(sprintf(
        '%s%s', $exception->getMessage(), $exception->getTrace()
    ));
}