<?php

use PHPUnit\Framework\TestCase;

class ExecAppTest extends TestCase
{

    /**
     * @dataProvider additionProviderValidData
     * @param $command
     */
    public function testValidData($command)
    {
        exec($command, $output, $exitCode);
        $this->assertEquals(0, $exitCode);
    }


    /**
     * @dataProvider additionProviderInvalidData
     * @param $command
     */
    public function testInvalidData($command)
    {
        exec($command, $output, $exitCode);
        $this->assertNotEquals(0, $exitCode);
    }

    public function additionProviderValidData()
    {
        return [
            ['php ../../index.php -h'],
            ['php ../../index.php --help'],
            ['php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php'],
            ['php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php -s'],
            ["php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php -s -d ';'"],
            ["php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php -s -d ','"],
            ["php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php -d ',' --strict"],
        ];
    }

    public function additionProviderInvalidData()
    {
        return [
            ['php ../../index.php --helpp'],
            ['php ../../index.php -i ../testInput.csv'],
            ['php ../../index.php -i ../testInput.csv1 -o ../testOutput.csv -c ../testConf.php'],
            ["php ../../index.php -i ../testOutput.csv -c ../testConf.php -d ','"],
        ];
    }

}
