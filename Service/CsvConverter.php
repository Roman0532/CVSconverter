<?php

namespace service;

use Exception;
use Faker\Factory;
use SplFileObject;

class CsvConverter
{
    private $inputFile;
    private $outputFile;
    private $configFileData;
    private $delimiter;
    private $isSkipHeader;
    private $faker;
    private $isStrict;

    /**
     * CsvConverter constructor.
     * @param $inputFile
     * @param $outputFile
     * @param $configFileData
     * @param string $delimiter
     * @param bool $isSkipHeader
     * @param bool $isStrict
     */
    public function __construct($inputFile, $outputFile, $configFileData, $delimiter, $isSkipHeader, $isStrict)
    {
        $this->isStrict = $isStrict;
        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;
        $this->delimiter = $delimiter;
        $this->isSkipHeader = $isSkipHeader;
        $this->configFileData = $configFileData;
        $this->faker = Factory::create();
    }

    public function convertCsv()
    {
        $csvFileContent = $this->parseCsv();

        if ($this->isStrict && $this->isStrict($csvFileContent, $this->configFileData)) {
            echo 'Несоответствие столбцов' . PHP_EOL;
            exit(3);
        }

        $convertibleFileContent = $this->changeDataForConfigData($csvFileContent);

        $this->arrayToCsv($convertibleFileContent);
    }

    /**
     * @return array
     */
    public function parseCsv()
    {
        $csvFileContent = [];
        $inputFile = new SplFileObject($this->inputFile);

        while (!$inputFile->eof()) {
            $lineData = $inputFile->fgetcsv($this->delimiter);

            if ($inputFile->key() == 0) {
                $countColumn = sizeof($lineData);
            }

            /** @var integer $countColumn */
            if (sizeof($lineData) != $countColumn) {
                echo 'Количество стобцов в файле не совпадает, результат может быть некорректен';
                exit(1);
            }

            $csvFileContent[] = $lineData;
        }

        return $csvFileContent;
    }

    /**
     * @param $csvFileContent
     * @return array
     */
    public function changeDataForConfigData($csvFileContent)
    {
        $convertibleFileContent = [];
        foreach ($csvFileContent as $rowIndex => $rowData) {

            if ($this->isSkipHeader) {
                $this->isSkipHeader = false;
                $convertibleFileContent[$rowIndex] = $rowData;
                continue;
            }

            $convertibleFileContent[$rowIndex] = array_map(function ($columnIndex, $value) use ($rowIndex, $rowData) {

                if (!array_key_exists($columnIndex, $this->configFileData)) {
                    return $value;
                }

                if (is_callable($this->configFileData[$columnIndex])) {
                    return $this->configFileData[$columnIndex]($value, $rowData, $rowIndex, $this->faker);
                }

                $property = $this->configFileData[$columnIndex];

                try {
                    return $this->faker->$property;
                } catch (Exception $exception) {
                    return $property;
                }
            }, array_keys($rowData), $rowData);
        }

        return $convertibleFileContent;
    }

    /**
     * @param $data
     */
    public function arrayToCsv($data)
    {
        $fp = fopen($this->outputFile, 'w');

        foreach ($data as $fields) {
            fputcsv($fp, $fields, $this->delimiter);
        }

        $stat = fstat($fp);
        ftruncate($fp, $stat['size'] - 1);
        fclose($fp);
    }

    /**
     * @param $csvFileContent
     * @param $configFileData
     * @return bool
     */
    private function isStrict($csvFileContent, $configFileData)
    {
        return max(array_keys($configFileData)) + 1 > count($csvFileContent[0]);
    }
}
