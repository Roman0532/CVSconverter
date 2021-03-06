<?php

use PHPUnit\Framework\TestCase;

use Services\CsvConverter;

class CsvConverterTest extends TestCase
{
    const INPUT_FILE = '../testInput.csv';
    const OUTPUT_FILE = '../testOutput.csv';
    const TEST_OUTPUT_FILE = '../testOutput1.csv';
    const CONFIG_FILE = '../testConf.php';

    public $cvsConverter;

    public function setUp()
    {
        $configFileData = require self::CONFIG_FILE;

        $encodingInputFile = mb_detect_encoding(file_get_contents(self::INPUT_FILE), ['UTF-8', 'Windows-1251']);

        $this->cvsConverter = new CsvConverter(self::INPUT_FILE, self::OUTPUT_FILE, $configFileData, ',', false, false, $encodingInputFile);
    }

    /**
     * Тестирование метода parseCsv()
     */
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

    /**
     * Тестирование метода ChangeDataForConfigData()
     */
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

    /**
     * Тестирование метода ConvertCsv()
     */
    public function testConvertCsv()
    {
        if (file_exists(self::OUTPUT_FILE)) {
            unlink(self::OUTPUT_FILE);
        }

        $this->assertTrue(file_exists(self::INPUT_FILE));

        $this->cvsConverter->convertCsv();

        $this->assertTrue(file_exists(self::OUTPUT_FILE));

        $this->assertEquals(file_get_contents(self::OUTPUT_FILE), file_get_contents(self::TEST_OUTPUT_FILE));
    }
}