<?php

declare(strict_types=1);

use Nikitamarakushev\Logpretttier\Formatter;

require 'vendor/autoload.php';

//$dataForPrint = json_encode($argv[1]);
/** @var string $dataForPrint */
$dataForPrint = json_encode(file_get_contents($argv[1]), JSON_UNESCAPED_SLASHES);

print_r("<pre>" . Formatter::prettyPrint($dataForPrint) . "</pre>");