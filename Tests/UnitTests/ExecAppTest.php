<?php

use PHPUnit\Framework\TestCase;

class ExecAppTest extends TestCase
{
    /**
     * Тестирование валидных данных
     * @dataProvider additionProviderValidData
     * @param $command
     */
    public function testValidData($command)
    {
        exec($command, $output, $exitCode);
        $this->assertEquals(0, $exitCode);
    }

    /**
     * Тестирование невалидных данных
     * @dataProvider additionProviderInvalidData
     * @param $command
     */
    public function testInvalidData($command)
    {
        exec($command, $output, $exitCode);
        $this->assertNotEquals(0, $exitCode);
    }

    /**
     * @return array
     */
    public function additionProviderValidData()
    {
        return [
            ['php ../../index.php -h'],
            ['php ../../index.php --help'],
            ['php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php'],
            ['php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php --skip-first'],
            ["php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php --skip-first -d ';'"],
            ["php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php --skip-first -d ','"],
            ["php ../../index.php -i ../testInput.csv -o ../testOutput.csv -c ../testConf.php -d ',' --strict"],
        ];
    }

    /**
     * @return array
     */
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
