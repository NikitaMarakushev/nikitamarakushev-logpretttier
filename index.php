<?php

declare(strict_types=1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Nikitamarakushev\Logpretttier\Formatter;
use Nikitamarakushev\Logpretttier\FormatterDirector;

/**
 * script params validation
 */
if ($argv[1] === 'index.php' || count($argv) > 2) {
    print_r("logpretttier ERROR: invalid syntax of command, for help run, please 'php index.php -h' \n");
    die;
}

if ($argv[1] === '-h') {
    print_r("Usage: php index.php [FILENAME] COMMAND \n\nOptions: \n" .
        "-h \t Help information about script usage" .
        "FILENAME \t name of file, you would like to format \n" .
        "-v \t shows current version of script \n"
    );
    die;
}

if ($argv[1] === '-v') {
    print_r("logpretttier verstion 0.0.1 \n");
    die;
}

$array = explode('.', $argv[1]);
$inputFileExtension = end($array);

if ($inputFileExtension !== $argv[1] && $inputFileExtension !== 'log') {
    print_r("Invalid extension, please, check your syntax, you can use only apache logs\n");
    die;
}

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