<?php

namespace dto;

class OptionData
{
    private $inputFile;
    private $outputFile;
    private $configFile;
    private $delimiter;
    private $isSkipHeader;
    private $isStrict;

    /**
     * OptionData constructor.
     * @param $inputFile
     * @param $outputFile
     * @param $configFile
     * @param $delimiter
     * @param $isSkipHeader
     * @param $isStrict
     */
    public function __construct($inputFile, $outputFile, $configFile, $delimiter, $isSkipHeader, $isStrict)
    {
        $this->inputFile = $inputFile;
        $this->outputFile = $outputFile;
        $this->configFile = $configFile;
        $this->delimiter = $delimiter;
        $this->isSkipHeader = $isSkipHeader;
        $this->isStrict = $isStrict;
    }

    /**
     * @return mixed
     */
    public function getIsSkipHeader()
    {
        return $this->isSkipHeader;
    }

    /**
     * @return mixed
     */
    public function getInputFile()
    {
        return $this->inputFile;
    }

    /**
     * @return mixed
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }

    /**
     * @return mixed
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @return mixed
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @return mixed
     */
    public function getIsStrict()
    {
        return $this->isStrict;
    }
}
