<?php

namespace Nikitamarakushev\Logpretttier;

use JsonException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Nikitamarakushev\Logpretttier\Stream\StreamConfig;
use Nikitamarakushev\Logpretttier\Director\FormatterDirector;

/**
 * Application class
 *
 * @author Nikita Marakushev
 */
class Application
{
    /**
     * @var Logger
     */
    private Logger $log;

    /**
     * @return $this
     */
    public function initLogger() {
        $this->log = new Logger('main');
        $this->log->pushHandler(new StreamHandler(StreamConfig::ERROR_LOG_PATH, Logger::ERROR));

        return $this;
    }

    /**
     * @param array $argv
     * @return void
     */
    public function runValidate(array $argv) {
        try {
            $formatterDirector = new FormatterDirector();
            $formatterDirector->setFormatter(new Formatter($argv[1]));
            $formatterDirector->buildFormattedLog();
        } catch (JsonException $exception) {
            $this->log->error(sprintf(
                '%s%s', $exception->getMessage(), $exception->getTrace()
            ));
        }
    }
}