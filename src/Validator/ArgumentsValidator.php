<?php

namespace Nikitamarakushev\Logpretttier\Validator;

/**
 * Validate class for file script arguments
 *
 * @author Nikita Marakushev
 */
class ArgumentsValidator
{
    /**
     * @param array $argv
     */
    public static function validate(array $argv) {
        if (!file_exists($argv[0])) {
            print_r("No execution script found!\n");
            die;
        }

        if (!file_exists($argv[1])) {
            print_r("No log file found!\n");
            die;
        }

        $array = explode('.', $argv[1]);
        $inputFileExtension = end($array);

        if ($inputFileExtension !== $argv[1]) {
            print_r("Invalid extension, please, check your syntax, you can use only apache logs\n");
            die;
        }

        if (count($argv) > 2) {
            print_r("Too much arguments passed, run prettier: php index.php 'filename'\n");
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

    }
}