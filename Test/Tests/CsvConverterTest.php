<?php

use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/../vendor/autoload.php';
require_once dirname(__DIR__) . '/../Service/CsvConverter.php';

use service\CsvConverter;

class CsvConverterTest extends TestCase
{
    public $cvsConverter;
    const INPUT_FILE = '../testInput.csv';
    const OUTPUT_FILE = '../testOutput.csv';
    const TEST_OUTPUT_FILE = '../testOutput1.csv';
    const CONFIG_FILE = '../testConf.php';

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $configFileData = require self::CONFIG_FILE;
        $this->cvsConverter = new CsvConverter(self::INPUT_FILE, self::OUTPUT_FILE, $configFileData, ',', false, false);
    }

    public function testParseCsv()
    {
        $inputData = [
            0 => [
                0 => "100",
                1 => "Советский 2/7, кв. 23",
                2 => "Иванов Иван Иванович",
                3 => "23"
            ],
            1 =>
                [
                    0 => "101",
                    1 => "Советский 2/6, кв. 26",
                    2 => "Петров Иван Иванович",
                    3 => "35"
                ],
            2 =>
                [
                    0 => "102",
                    1 => "Карболитовская 1, кв. 24",
                    2 => "Сидоров Иван Иванович",
                    3 => "45",
                ]];

        $outputData = $this->cvsConverter->parseCsv();

        $this->assertEquals($inputData, $outputData);
    }

    public function testChangeDataForConfigData()
    {
        $inputData = [
            0 => [
                0 => "100",
                1 => 2,
                2 => NULL,
                3 => 5
            ],
            1 =>
                [
                    0 => "101",
                    1 => 2,
                    2 => NULL,
                    3 => 0
                ],
            2 =>
                [
                    0 => 102,
                    1 => 2,
                    2 => NULL,
                    3 => 2,
                ]];

        $parseData = $this->cvsConverter->parseCsv();
        $convertData = $this->cvsConverter->changeDataForConfigData($parseData);

        $this->assertEquals($inputData, $convertData);
    }


    public function testConvertCsv()
    {
        if (file_exists(self::OUTPUT_FILE)) {
            unlink(self::OUTPUT_FILE);
        }

        $this->assertTrue(file_exists(self::INPUT_FILE));

        $this->cvsConverter->convertCsv();

        $this->assertTrue(file_exists(self::OUTPUT_FILE));

        $this->assertEquals(file_get_contents(self::OUTPUT_FILE), file_get_contents('../../output.csv'));
    }
}