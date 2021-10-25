<?php

declare(strict_types=1);

use Nikitamarakushev\Logpretttier\Formatter;

require 'vendor/autoload.php';

$dataForPrint = json_encode([
    "a" => 1,
    'b' => 1,
    'c' => [
        'd' => 1
    ]
]);

echo Formatter::prettyPrint($dataForPrint);