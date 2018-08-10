<?php

use GetOpt\ArgumentException;
use service\CommandLineParser;
use service\CsvConverter;

require_once 'vendor/autoload.php';
require_once 'Service/CommandLineParser.php';
require_once 'Service/CsvConverter.php';

$cmd = new CommandLineParser();

try {
    $commandLineData = $cmd->parse();
} catch (ArgumentException $exception) {
    echo $exception->getMessage() . PHP_EOL;
    $cmd->help(244);
}

$inputFile = $commandLineData->getInputFile();
$outputFile = $commandLineData->getOutputFile();
$configFile = $commandLineData->getConfigFile();
$delimiter = $commandLineData->getDelimiter();
$isSkipHeader = $commandLineData->getIsSkipHeader();
$isStrict = $commandLineData->getIsStrict();

if (is_null($inputFile) || is_null($outputFile) || is_null($configFile)) {
    echo 'Пропущен обязательный параметр' . PHP_EOL;
    $cmd->help(1);
}

$encodingInputFile = mb_detect_encoding(file_get_contents($inputFile), ['UTF-8', 'Windows-1251']);

if ($encodingInputFile != 'UTF-8' && $encodingInputFile != 'Windows-1251') {
    echo 'Неверная кодировка входного файла' . PHP_EOL;
    $cmd->help(2);
};

$configFileData = require_once $configFile;

$csvParser = new CsvConverter($inputFile, $outputFile, $configFileData, $delimiter, $isSkipHeader, $isStrict, $encodingInputFile);

$csvParser->convertCsv();
