<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Nikitamarakushev\Logpretttier\Formatter;
use Nikitamarakushev\Logpretttier\Director\FormatterDirector;
use Nikitamarakushev\Logpretttier\Validator\ArgumentsValidator;

(new ArgumentsValidator())->validate($argv);

const ERROR_LOG_PATH = 'logs/error.log';

$log = new Logger('main');
$log->pushHandler(new StreamHandler(ERROR_LOG_PATH, Logger::ERROR));

try {
    $formatterDirector = new FormatterDirector();
    $formatterDirector->setFormatter(new Formatter($argv[1]));
    $formatterDirector->buildFormattedLog();
} catch (JsonException $exception) {
    $log->error(sprintf(
        '%s%s', $exception->getMessage(), $exception->getTrace()
    ));
}
