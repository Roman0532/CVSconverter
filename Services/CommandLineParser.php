<?php

namespace Services;

use Dto\OptionData;
use GetOpt\ArgumentException;
use GetOpt\ArgumentException\Missing;
use GetOpt\GetOpt as Getopt;
use GetOpt\Option;

class CommandLineParser
{
    private $option;

    /**
     * CommandLineParser constructor.
     */
    public function __construct()
    {
        $this->option = new GetOpt();
    }

    /**
     * Метод обьявления опций парсинга коммандной строки
     */
    private function defineOptions()
    {
        $this->option->addOptions([
            Option::create('h', 'help', GetOpt::NO_ARGUMENT)
                ->setDescription('Показывает справку'),

            Option::create('d', 'delimiter', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription("Указывает разделитель (По умолчанию ','")
                ->setArgumentName('delimiter')
                ->setDefaultValue(',')
                ->setValidation(function ($value) {
                    if (strlen($value) > 1) {
                        echo 'Разделитель должен быть один символ' . PHP_EOL;
                        return false;
                    }
                    return true;
                }),

            Option::create('s', 'skip-first', GetOpt::NO_ARGUMENT)
                ->setDescription('Пропускает модификацию первой строки')
                ->setArgumentName('skip-first')
                ->setDefaultValue(false),

            Option::create(null, 'strict', GetOpt::NO_ARGUMENT)
                ->setDescription('Сравнивает количество столбцов')
                ->setArgumentName('strict')
                ->setDefaultValue(false),

            Option::create('i', 'input', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Входной файл (Обязательный параметр)')
                ->setArgumentName('input file')
                ->setValidation(function ($value) {
                    if (!is_readable($value)) {
                        echo 'Файла не существует либо недостаточно прав для чтения' . PHP_EOL;
                        return false;
                    }

                    if (pathinfo($value, PATHINFO_EXTENSION) != 'csv') {
                        echo 'Неверное расширение файла' . PHP_EOL;
                        return false;
                    }
                    return true;
                }),

            Option::create('o', 'output', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Выходной файл (Обязательный параметр)')
                ->setArgumentName('output file')
                ->setValidation(function ($value) {
                    if (pathinfo($value, PATHINFO_EXTENSION) != 'csv') {
                        echo 'Неверное расширение файла' . PHP_EOL;
                        return false;
                    }

                    if ((!is_writable($value) && is_file($value))) {
                        echo 'Недостаточно прав для записи' . PHP_EOL;
                        return false;
                    }
                    return true;
                }),

            Option::create('c', 'config', GetOpt::REQUIRED_ARGUMENT)
                ->setDescription('Конфигурационный файл (Обязательный параметр)')
                ->setArgumentName('config file')
                ->setValidation(function ($value) {
                    if (!is_readable($value)) {
                        echo 'Файла не существует либо недостаточно прав для чтения' . PHP_EOL;
                        return false;
                    }

                    if (pathinfo($value, PATHINFO_EXTENSION) != 'php') {
                        echo 'Неверное расширение файла' . PHP_EOL;
                        return false;
                    }
                    return true;
                }),
        ]);
    }

    /**
     * Метод парсинга коммандной строки и записи в OptionData
     * @return OptionData
     * @throws ArgumentException
     */
    public function parse()
    {
        try {
            try {
                $this->defineOptions();
                $this->option->process();

                if ($this->option->getOption('h')) {
                    $this->help(0);
                }

                return new OptionData(
                    $this->option->getOption('input'),
                    $this->option->getOption('output'),
                    $this->option->getOption('config'),
                    $this->option->getOption('delimiter'),
                    $this->option->getOption('skip-first'),
                    $this->option->getOption('strict')
                );
            } catch (Missing $exception) {
                throw $exception;
            }
        } catch (ArgumentException $exception) {
            throw $exception;
        }
    }

    /**
     * Метод вызова справки
     * @param $statusCode
     */
    public function help($statusCode)
    {
        echo $this->option->getHelpText();
        exit($statusCode);
    }
}
