<?php

declare(strict_types=1);

const AUTOLOAD_DIR = 'vendor/autoload.php';

require AUTOLOAD_DIR;

use Nikitamarakushev\Logpretttier\Application;
use Nikitamarakushev\Logpretttier\Validator\ArgumentsValidator;

(new ArgumentsValidator())->validate($argv);
(new Application())->initLogger();

