<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Nikitamarakushev\Logpretttier\Application;
use Nikitamarakushev\Logpretttier\Validator\ArgumentsValidator;

(new ArgumentsValidator())->validate($argv);
(new Application())->initLogger();

