<?php

declare(strict_types=1);

use Nikitamarakushev\Logpretttier\Formatter;

require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;

$logger = new Logger('transactions');

$logstream = new StreamHandler('php://stdout', Logger::INFO);

$logstream->setFormatter(new JsonFormatter());

$logger->pushHandler($logstream);

$logger->info(file_get_contents($argv[1]));
