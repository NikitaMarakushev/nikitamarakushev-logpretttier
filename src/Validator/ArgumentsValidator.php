<?php

namespace Nikitamarakushev\Logpretttier\Validator;

/**
 * Validate class for file script arguments
 *
 * @author Nikita Marakushev
 */
class ArgumentsValidator
{
    //Index of argv, identifies an executor php script
    private const SCRIPT_INDEX = 0;

    //Index of argv, identifies an access log
    private const LOG_INDEX = 1;

    //Max count of argv argument
    private const MAX_ARGV_COUNT = 2;

    /**
     * A pipeline for checking the execution of a script,
     * from checking for existence to logging useful information
     * @param array $argv
     */
    public  function validate(array $argv): void
    {
        $this->checkExistingAll($argv);
        $this->checkExecutorFile($argv);
        $this->checkLogFile($argv);
        $this->checkFileExtension($argv);
        $this->checkCountOfArguments($argv);
        $this->logHelpInfo($argv);
        $this->logVersion($argv);
    }

    /**
     * @param array $argv
     */
    public function checkExistingAll(array $argv): void
    {
        if (count($argv) === 0) {
            print_r("No execution script found!\n");
            die;
        }
    }

    /**
     * @param array $argv
     */
    public function checkExecutorFile(array $argv): void
    {
        if (!file_exists($argv[self::SCRIPT_INDEX])) {
            print_r("No execution script found!\n");
            die;
        }
    }

    /**
     * @param array $argv
     */
    public function checkLogFile(array $argv) {
        if (!file_exists($argv[self::LOG_INDEX])) {
            print_r("No log file found!\n");
            die;
        }
    }

    /**
     * @param array $argv
     */
    public function checkFileExtension(array $argv) {
        $array = explode('.', $argv[self::LOG_INDEX]);
        $inputFileExtension = end($array);

        if ($inputFileExtension !== $argv[self::LOG_INDEX]) {
            print_r("Invalid extension, please, check your syntax, you can use only apache logs\n");
            die;
        }
    }

    /**
     * @param array $argv
     */
    public function checkCountOfArguments(array $argv) {
        if (count($argv) > self::MAX_ARGV_COUNT) {
            print_r("Too much arguments passed, run prettier: php index.php 'filename'\n");
            die;
        }
    }

    /**
     * @param array $argv
     */
    public function logHelpInfo(array $argv) {
        if ($argv[self::LOG_INDEX] === '-h') {
            print_r("Usage: php index.php [FILENAME] COMMAND \n\nOptions: \n" .
                "-h \t Help information about script usage" .
                "FILENAME \t name of file, you would like to format \n" .
                "-v \t shows current version of script \n"
            );
            die;
        }
    }

    /**
     * @param array $argv
     */
    public function logVersion(array $argv) {
        if ($argv[self::LOG_INDEX] === '-v') {
            print_r("logpretttier verstion 0.0.1 \n");
            die;
        }
    }
}