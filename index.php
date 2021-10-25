<?php

declare(strict_types=1);

use Nikitamarakushev\Logpretttier\Formatter;
use Nikitamarakushev\Logpretttier\FormatterDirector;

require 'vendor/autoload.php';

$formatterDirector = new FormatterDirector();
$formatterDirector->setFormatter(new Formatter($argv[1]));

try {
    $formatterDirector->buildFormattedLog();
} catch (JsonException $e) {
    print_r($e->getMessage());
}